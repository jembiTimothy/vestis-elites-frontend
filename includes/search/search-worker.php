
<?php
/**
 * Vestis Elites Search - queue worker.
 *
 * Executes queued index and deletion jobs in bounded batches.
 * Does not schedule cron events or initialise the search system.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Determine the correct search group for a queued object.
 *
 * @param int    $object_id   Object or term ID.
 * @param string $object_type Post type or taxonomy.
 * @return string|false
 */
if ( ! function_exists( 've_search_worker_get_group' ) ) {
    function ve_search_worker_get_group( $object_id, $object_type ) {

        $config = ve_search_get_config();

        if ( 'product' === $object_type ) {
            if ( ! function_exists( 'wc_get_product' ) ) {
                return false;
            }

            $product = wc_get_product( $object_id );

            if (
                ! $product ||
                ! is_a( $product, 'WC_Product' ) ||
                'publish' !== $product->get_status() ||
                ! $product->is_visible()
            ) {
                return false;
            }

            return ve_search_is_digital_product( $product )
                ? 'digital-products'
                : 'products';
        }

        if ( 'post' === $object_type ) {
            $post = get_post( $object_id );

            if (
                ! $post ||
                'post' !== $post->post_type ||
                'publish' !== $post->post_status ||
                post_password_required( $object_id )
            ) {
                return false;
            }

            return 'journal';
        }

        if ( 'page' === $object_type ) {
            $page = get_post( $object_id );

            if (
                ! $page ||
                'page' !== $page->post_type ||
                'publish' !== $page->post_status ||
                post_password_required( $object_id )
            ) {
                return false;
            }

            return ve_search_get_page_group( $object_id, $config );
        }

        $taxonomy_group = ve_search_get_taxonomy_group( $object_type );

        if ( false !== $taxonomy_group ) {
            if ( ! taxonomy_exists( $object_type ) ) {
                return false;
            }

            $term = get_term( $object_id, $object_type );

            if (
                ! $term ||
                is_wp_error( $term ) ||
                (int) $term->count < 1
            ) {
                return false;
            }

            return $taxonomy_group;
        }

        return false;
    }
}

/**
 * Execute one queued job.
 *
 * @param array $job Claimed queue job.
 * @return true|WP_Error
 */
if ( ! function_exists( 've_search_worker_execute_job' ) ) {
    function ve_search_worker_execute_job( $job ) {

        if (
            ! is_array( $job ) ||
            empty( $job['id'] ) ||
            empty( $job['object_id'] ) ||
            empty( $job['object_type'] ) ||
            empty( $job['action'] )
        ) {
            return new WP_Error(
                've_search_worker_invalid_job',
                'The claimed queue job is incomplete.'
            );
        }

        $object_id   = absint( $job['object_id'] );
        $object_type = sanitize_key( $job['object_type'] );
        $action      = sanitize_key( $job['action'] );

        if ( 'delete' === $action ) {
            $deleted = ve_search_delete_index_record(
                $object_id,
                $object_type
            );

            if ( is_wp_error( $deleted ) ) {
                return $deleted;
            }

            return true;
        }

        if ( 'upsert' !== $action ) {
            return new WP_Error(
                've_search_worker_unknown_action',
                'The queued action is not supported.'
            );
        }

        $group_key = ve_search_worker_get_group(
            $object_id,
            $object_type
        );

        /*
         * An object that is no longer eligible should not be retried.
         * Remove any old index entry instead.
         */
        if ( false === $group_key ) {
            $deleted = ve_search_delete_index_record(
                $object_id,
                $object_type
            );

            if ( is_wp_error( $deleted ) ) {
                return $deleted;
            }

            return true;
        }

        $identity = array(
            'object_id'   => $object_id,
            'object_type' => $object_type,
            'group_key'   => $group_key,
        );

        $result = ve_search_upsert_index_record( $identity );

        if ( is_wp_error( $result ) ) {
            return $result;
        }

        return true;
    }
}

/**
 * Run a bounded batch of queued indexing jobs.
 *
 * @param int|null $batch_size Optional batch-size override.
 * @return array|WP_Error Worker statistics.
 */
if ( ! function_exists( 've_search_run_worker' ) ) {
    function ve_search_run_worker( $batch_size = null ) {

        $required_functions = array(
            've_search_get_config',
            've_search_queue_claim_next',
            've_search_queue_complete',
            've_search_queue_retry_or_fail',
            've_search_worker_execute_job',
        );

        foreach ( $required_functions as $required_function ) {
            if ( ! function_exists( $required_function ) ) {
                return new WP_Error(
                    've_search_worker_dependency_missing',
                    'A required search module is not loaded: ' . $required_function
                );
            }
        }

        $config = ve_search_get_config();

        if (
            empty( $config['indexing']['enabled'] ) ||
            empty( $config['indexing']['batch_size'] )
        ) {
            return new WP_Error(
                've_search_worker_disabled',
                'Background search indexing is disabled or incorrectly configured.'
            );
        }

        $configured_batch = absint(
            $config['indexing']['batch_size']
        );

        $maximum_execution_time = isset(
            $config['indexing']['maximum_execution_time']
        )
            ? absint( $config['indexing']['maximum_execution_time'] )
            : 20;

        $maximum_execution_time = max(
            1,
            min( 60, $maximum_execution_time )
        );

        $batch_size = null === $batch_size
            ? $configured_batch
            : absint( $batch_size );

        $batch_size = max(
            1,
            min( $configured_batch, $batch_size )
        );

        $started_at = microtime( true );

        $stats = array(
            'processed'  => 0,
            'succeeded'  => 0,
            'requeued'   => 0,
            'failed'     => 0,
            'errors'     => array(),
            'empty'      => false,
            'time_limit' => false,
        );

        while ( $stats['processed'] < $batch_size ) {

            $elapsed = microtime( true ) - $started_at;

            if ( $elapsed >= $maximum_execution_time ) {
                $stats['time_limit'] = true;
                break;
            }

            $job = ve_search_queue_claim_next();

            if ( is_wp_error( $job ) ) {
                $stats['errors'][] = $job->get_error_message();
                break;
            }

            if ( null === $job ) {
                $stats['empty'] = true;
                break;
            }

            $stats['processed']++;

            $execution = ve_search_worker_execute_job( $job );

            if ( is_wp_error( $execution ) ) {

                $retry_result = ve_search_queue_retry_or_fail(
                    $job['id'],
                    $execution->get_error_message()
                );

                $stats['errors'][] = array(
                    'queue_id' => absint( $job['id'] ),
                    'message'  => $execution->get_error_message(),
                );

                if ( is_wp_error( $retry_result ) ) {
                    $stats['errors'][] = array(
                        'queue_id' => absint( $job['id'] ),
                        'message'  => $retry_result->get_error_message(),
                    );

                    $stats['failed']++;
                    continue;
                }

                if ( 'failed' === $retry_result ) {
                    $stats['failed']++;
                } else {
                    $stats['requeued']++;
                }

                continue;
            }

            $completed = ve_search_queue_complete(
                $job['id']
            );

            if ( is_wp_error( $completed ) ) {
                $stats['errors'][] = array(
                    'queue_id' => absint( $job['id'] ),
                    'message'  => $completed->get_error_message(),
                );

                $stats['failed']++;
                continue;
            }

            $stats['succeeded']++;
        }

        $stats['duration_seconds'] = round(
            microtime( true ) - $started_at,
            4
        );

        return $stats;
    }
}
￼Enter
