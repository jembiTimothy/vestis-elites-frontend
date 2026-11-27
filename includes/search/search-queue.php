
<?php
/**
 * Vestis Elites Search - indexing queue management.
 *
 * Adds and coalesces indexing jobs, claims jobs safely, and records
 * completion, retry and terminal failure states.
 * Actual indexing execution belongs to the worker module.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get the configured queue table.
 *
 * @return string|WP_Error
 */
function ve_search_queue_get_table() {
    if (
        ! function_exists( 've_search_get_database_tables' ) ||
        ! function_exists( 've_search_database_table_exists' )
    ) {
        return new WP_Error(
            've_search_queue_database_module_missing',
            'The search database module is not loaded.'
        );
    }

    $tables = ve_search_get_database_tables();

    if ( is_wp_error( $tables ) ) {
        return $tables;
    }

    if (
        empty( $tables['queue_table'] ) ||
        ! ve_search_database_table_exists( $tables['queue_table'] )
    ) {
        return new WP_Error(
            've_search_queue_table_missing',
            'The search queue table is not installed.'
        );
    }

    return $tables['queue_table'];
}

/**
 * Validate a queue object identity.
 *
 * @param int    $object_id   Object or term ID.
 * @param string $object_type Post type or taxonomy.
 * @return array|WP_Error
 */
function ve_search_queue_normalize_identity( $object_id, $object_type ) {
    $object_id   = absint( $object_id );
    $object_type = is_string( $object_type )
        ? sanitize_key( $object_type )
        : '';

    if (
        $object_id < 1 ||
        '' === $object_type ||
        strlen( $object_type ) > 32
    ) {
        return new WP_Error(
            've_search_queue_identity_invalid',
            'The search queue object identity is invalid.'
        );
    }

    return array(
        'object_id'   => $object_id,
        'object_type' => $object_type,
    );
}

/**
 * Add or refresh an indexing job.
 *
 * Existing jobs for the same object are updated rather than duplicated.
 *
 * @param int    $object_id   Object or term ID.
 * @param string $object_type Post type or taxonomy.
 * @param string $action      upsert or delete.
 * @param int    $delay       Optional delay in seconds.
 * @return int|WP_Error Queue row ID.
 */
function ve_search_queue_enqueue( $object_id, $object_type, $action = 'upsert', $delay = 0 ) {
    global $wpdb;

    $identity = ve_search_queue_normalize_identity(
        $object_id,
        $object_type
    );

    if ( is_wp_error( $identity ) ) {
        return $identity;
    }

    $action = is_string( $action ) ? sanitize_key( $action ) : '';

    if ( ! in_array( $action, array( 'upsert', 'delete' ), true ) ) {
        return new WP_Error(
            've_search_queue_action_invalid',
            'The queue action must be upsert or delete.'
        );
    }

    $table = ve_search_queue_get_table();

    if ( is_wp_error( $table ) ) {
        return $table;
    }

    $delay       = min( 86400, absint( $delay ) );
    $now         = current_time( 'mysql', true );
    $available   = gmdate( 'Y-m-d H:i:s', time() + $delay );
    $object_id   = $identity['object_id'];
    $object_type = $identity['object_type'];

    $sql = $wpdb->prepare(
        "INSERT INTO {$table}
            (
                object_id,
                object_type,
                action,
                status,
                attempts,
                available_at,
                locked_at,
                last_error,
                created_at,
                updated_at
            )
         VALUES (
            %d, %s, %s, 'pending', 0, %s, NULL, NULL, %s, %s
         )
         ON DUPLICATE KEY UPDATE
            action = VALUES(action),
            status = 'pending',
            attempts = 0,
            available_at = VALUES(available_at),
            locked_at = NULL,
            last_error = NULL,
            updated_at = VALUES(updated_at)",
        $object_id,
        $object_type,
        $action,
        $available,
        $now,
        $now
    );

    $result = $wpdb->query( $sql );

    if ( false === $result ) {
        return new WP_Error(
            've_search_queue_enqueue_failed',
            'The indexing job could not be added to the queue.'
        );
    }

    $row_id = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT id FROM {$table}
             WHERE object_type = %s
             AND object_id = %d
             LIMIT 1",
            $object_type,
            $object_id
        )
    );

    if ( ! $row_id ) {
        return new WP_Error(
            've_search_queue_row_unavailable',
            'The indexing job was saved but its queue ID could not be retrieved.'
        );
    }

    return absint( $row_id );
}

/**
 * Recover jobs whose processing locks have expired.
 *
 * @return int|WP_Error Number of recovered jobs.
 */
function ve_search_queue_recover_stale_jobs() {
    global $wpdb;

    $table = ve_search_queue_get_table();

    if ( is_wp_error( $table ) ) {
        return $table;
    }

    $config = ve_search_get_config();

    $lock_duration = isset( $config['indexing']['lock_duration'] )
        ? absint( $config['indexing']['lock_duration'] )
        : 300;

    $lock_duration = max( 60, $lock_duration );

    $cutoff = gmdate(
        'Y-m-d H:i:s',
        time() - $lock_duration
    );

    $now = current_time( 'mysql', true );

    $result = $wpdb->query(
        $wpdb->prepare(
            "UPDATE {$table}
             SET
                status = 'pending',
                locked_at = NULL,
                available_at = %s,
                last_error = %s,
                updated_at = %s
             WHERE status = 'processing'
             AND locked_at IS NOT NULL
             AND locked_at < %s",
            $now,
            'Processing lock expired; job returned to queue.',
            $now,
            $cutoff
        )
    );

    if ( false === $result ) {
        return new WP_Error(
            've_search_queue_recovery_failed',
            'Expired indexing locks could not be recovered.'
        );
    }

    return (int) $result;
}

/**
 * Atomically claim the next available queue job.
 *
 * @return array|null|WP_Error Claimed job, null if queue is empty.
 */
function ve_search_queue_claim_next() {
    global $wpdb;

    $table = ve_search_queue_get_table();

    if ( is_wp_error( $table ) ) {
        return $table;
    }

    $recovered = ve_search_queue_recover_stale_jobs();

    if ( is_wp_error( $recovered ) ) {
        return $recovered;
    }

    $now = current_time( 'mysql', true );

    $wpdb->query( 'START TRANSACTION' );

    $job = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT
                id,
                object_id,
                object_type,
                action,
                attempts
             FROM {$table}
             WHERE status = 'pending'
             AND available_at <= %s
             ORDER BY available_at ASC, id ASC
             LIMIT 1
             FOR UPDATE",
            $now
        ),
        ARRAY_A
    );

    if ( ! empty( $wpdb->last_error ) ) {
        $error = $wpdb->last_error;
        $wpdb->query( 'ROLLBACK' );

        return new WP_Error(
            've_search_queue_claim_read_failed',
            'The next indexing job could not be read: ' . $error
        );
    }

    if ( ! $job ) {
        $wpdb->query( 'COMMIT' );
        return null;
    }

    $updated = $wpdb->query(
        $wpdb->prepare(
            "UPDATE {$table}
             SET
                status = 'processing',
                locked_at = %s,
                attempts = attempts + 1,
                updated_at = %s
             WHERE id = %d
             AND status = 'pending'",
            $now,
            $now,
            absint( $job['id'] )
        )
    );

    if ( false === $updated || 1 !== (int) $updated ) {
        $error = $wpdb->last_error;
        $wpdb->query( 'ROLLBACK' );

        return new WP_Error(
            've_search_queue_claim_failed',
            'The indexing job could not be locked. ' . $error
        );
    }

    $wpdb->query( 'COMMIT' );

    $job['id']        = absint( $job['id'] );
    $job['object_id'] = absint( $job['object_id'] );
    $job['attempts']  = absint( $job['attempts'] ) + 1;

    return $job;
}

/**
 * Remove a successfully processed queue job.
 *
 * @param int $queue_id Queue row ID.
 * @return true|WP_Error
 */
function ve_search_queue_complete( $queue_id ) {
    global $wpdb;

    $queue_id = absint( $queue_id );

    if ( $queue_id < 1 ) {
        return new WP_Error(
            've_search_queue_id_invalid',
            'The queue ID is invalid.'
        );
    }

    $table = ve_search_queue_get_table();

    if ( is_wp_error( $table ) ) {
        return $table;
    }

    $result = $wpdb->delete(
        $table,
        array(
            'id'     => $queue_id,
            'status' => 'processing',
        ),
        array( '%d', '%s' )
    );

    if ( false === $result ) {
        return new WP_Error(
            've_search_queue_complete_failed',
            'The completed indexing job could not be removed.'
        );
    }

    if ( 0 === (int) $result ) {
        return new WP_Error(
            've_search_queue_job_not_processing',
            'The queue job was not found in the processing state.'
        );
    }

    return true;
}

/**
 * Retry a failed job or mark it permanently failed.
 *
 * @param int    $queue_id Queue row ID.
 * @param string $error    Processing error.
 * @return string|WP_Error pending or failed.
 */
function ve_search_queue_retry_or_fail( $queue_id, $error ) {
    global $wpdb;

    $queue_id = absint( $queue_id );

    if ( $queue_id < 1 ) {
        return new WP_Error(
            've_search_queue_id_invalid',
            'The queue ID is invalid.'
        );
    }

    $table = ve_search_queue_get_table();

    if ( is_wp_error( $table ) ) {
        return $table;
    }

    $config = ve_search_get_config();

    $maximum_attempts = isset( $config['indexing']['maximum_attempts'] )
        ? absint( $config['indexing']['maximum_attempts'] )
        : 5;

    $maximum_attempts = max( 1, $maximum_attempts );

    $job = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT attempts
             FROM {$table}
             WHERE id = %d
             AND status = 'processing'
             LIMIT 1",
            $queue_id
        ),
        ARRAY_A
    );

    if ( ! $job ) {
        return new WP_Error(
            've_search_queue_job_not_processing',
            'The queue job was not found in the processing state.'
        );
    }

    $attempts = absint( $job['attempts'] );
    $message  = substr(
        sanitize_textarea_field( (string) $error ),
        0,
        2000
    );

    $now = current_time( 'mysql', true );

    if ( $attempts >= $maximum_attempts ) {
        $result = $wpdb->update(
            $table,
            array(
                'status'     => 'failed',
                'locked_at'  => null,
                'last_error' => $message,
                'updated_at' => $now,
            ),
            array(
                'id'     => $queue_id,
                'status' => 'processing',
            ),
            array( '%s', '%s', '%s', '%s' ),
            array( '%d', '%s' )
        );

        if ( false === $result || 1 !== (int) $result ) {
            return new WP_Error(
                've_search_queue_fail_update_failed',
                'The indexing job could not be marked as failed.'
            );
        }

        return 'failed';
    }

    // Exponential retry delay: 30, 60, 120, 240 seconds, capped at one hour.
    $delay = min(
        HOUR_IN_SECONDS,
        30 * ( 2 ** max( 0, $attempts - 1 ) )
    );

    $available = gmdate(
        'Y-m-d H:i:s',
        time() + $delay
    );

    $result = $wpdb->update(
        $table,
        array(
            'status'       => 'pending',
            'locked_at'    => null,
            'available_at' => $available,
            'last_error'   => $message,
            'updated_at'   => $now,
        ),
        array(
            'id'     => $queue_id,
            'status' => 'processing',
        ),
        array( '%s', '%s', '%s', '%s', '%s' ),
        array( '%d', '%s' )
    );

    if ( false === $result || 1 !== (int) $result ) {
        return new WP_Error(
            've_search_queue_retry_update_failed',
            'The indexing job could not be scheduled for retry.'
        );
    }

    return 'pending';
}

/**
 * Manually return a failed job to the pending queue.
 *
 * @param int $queue_id Queue row ID.
 * @return true|WP_Error
 */
function ve_search_queue_requeue_failed( $queue_id ) {
    global $wpdb;

    $queue_id = absint( $queue_id );

    if ( $queue_id < 1 ) {
        return new WP_Error(
            've_search_queue_id_invalid',
            'The queue ID is invalid.'
        );
    }

    $table = ve_search_queue_get_table();

    if ( is_wp_error( $table ) ) {
        return $table;
    }

    $now = current_time( 'mysql', true );

    $result = $wpdb->update(
        $table,
        array(
            'status'       => 'pending',
            'attempts'     => 0,
            'available_at' => $now,
            'locked_at'    => null,
            'last_error'   => null,
            'updated_at'   => $now,
        ),
        array(
            'id'     => $queue_id,
            'status' => 'failed',
        ),
        array( '%s', '%d', '%s', '%s', '%s', '%s' ),
        array( '%d', '%s' )
    );

    if ( false === $result ) {
        return new WP_Error(
            've_search_queue_requeue_failed',
            'The failed indexing job could not be requeued.'
        );
    }

    if ( 0 === (int) $result ) {
        return new WP_Error(
            've_search_queue_job_not_failed',
            'The queue job does not exist or is not in the failed state.'
        );
    }

    return true;
}
￼Enter
