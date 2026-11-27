
<?php
/**
 * Vestis Elites Search
 * Database schema, installation, upgrade and verification routines.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 've_search_get_database_tables' ) ) {
    /**
     * Return the fully prefixed search table names.
     *
     * @return array|WP_Error
     */
    function ve_search_get_database_tables() {
        global $wpdb;

        if ( ! function_exists( 've_search_get_config' ) ) {
            return new WP_Error( 've_search_config_missing', 'The search configuration module has not been loaded.' );
        }

        $config = ve_search_get_config();
        if ( ! is_array( $config ) || empty( $config['database'] ) || ! is_array( $config['database'] ) ) {
            return new WP_Error( 've_search_database_config_invalid', 'The search database configuration is invalid.' );
        }

        $required = array( 'index_table', 'queue_table', 'analytics_table' );
        $tables   = array();

        foreach ( $required as $key ) {
            if ( empty( $config['database'][ $key ] ) || ! is_string( $config['database'][ $key ] ) ) {
                return new WP_Error( 've_search_missing_table_definition', 'A required search database table definition is missing.' );
            }

            $suffix = $config['database'][ $key ];
            if ( ! preg_match( '/^[a-zA-Z0-9_]+$/', $suffix ) ) {
                return new WP_Error( 've_search_invalid_table_name', 'An invalid search database table name was supplied.' );
            }

            $table = $wpdb->prefix . $suffix;
            if ( ! preg_match( '/^[a-zA-Z0-9_]+$/', $table ) ) {
                return new WP_Error( 've_search_invalid_prefixed_table_name', 'The prefixed search database table name is invalid.' );
            }

            $tables[ $key ] = $table;
        }

        return $tables;
    }
}

if ( ! function_exists( 've_search_get_schema_version' ) ) {
    /**
     * Return the configured schema version.
     *
     * @return string|WP_Error
     */
    function ve_search_get_schema_version() {
        if ( ! function_exists( 've_search_get_config' ) ) {
            return new WP_Error( 've_search_config_missing', 'The search configuration module has not been loaded.' );
        }

        $config = ve_search_get_config();
        if ( ! is_array( $config ) || empty( $config['system']['schema_version'] ) || ! is_string( $config['system']['schema_version'] ) ) {
            return new WP_Error( 've_search_schema_version_missing', 'The search database schema version is not configured.' );
        }

        $version = trim( $config['system']['schema_version'] );
        if ( '' === $version ) {
            return new WP_Error( 've_search_schema_version_invalid', 'The search database schema version is invalid.' );
        }

        return $version;
    }
}

if ( ! function_exists( 've_search_database_table_exists' ) ) {
    /**
     * Check whether a search table exists.
     *
     * @param string $table Fully prefixed table name.
     * @return bool
     */
    function ve_search_database_table_exists( $table ) {
        global $wpdb;

        if ( ! is_string( $table ) || ! preg_match( '/^[a-zA-Z0-9_]+$/', $table ) ) {
            return false;
        }

        $found = $wpdb->get_var(
            $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table ) )
        );

        return $found === $table;
    }
}

if ( ! function_exists( 've_search_verify_database_table' ) ) {
    /**
     * Verify required columns and indexes for one search table.
     *
     * @param string $table          Fully prefixed table name.
     * @param array  $required       Required column names.
     * @param array  $required_keys Required index names.
     * @return true|WP_Error
     */
    function ve_search_verify_database_table( $table, $required, $required_keys = array() ) {
        global $wpdb;

        if ( ! ve_search_database_table_exists( $table ) ) {
            return new WP_Error( 've_search_table_missing', sprintf( 'The search table %s does not exist.', $table ) );
        }

        $columns = $wpdb->get_results( "SHOW COLUMNS FROM `{$table}`", ARRAY_A );
        if ( ! is_array( $columns ) || ! empty( $wpdb->last_error ) ) {
            return new WP_Error( 've_search_column_check_failed', sprintf( 'Could not inspect columns for %s: %s', $table, $wpdb->last_error ) );
        }

        $found_columns = array();
        foreach ( $columns as $column ) {
            if ( isset( $column['Field'] ) ) {
                $found_columns[] = $column['Field'];
            }
        }

        $missing_columns = array_diff( $required, $found_columns );
        if ( ! empty( $missing_columns ) ) {
            return new WP_Error(
                've_search_columns_missing',
                sprintf( 'The search table %s is missing required columns: %s.', $table, implode( ', ', $missing_columns ) )
            );
        }

        if ( ! empty( $required_keys ) ) {
            $indexes = $wpdb->get_results( "SHOW INDEX FROM `{$table}`", ARRAY_A );
            if ( ! is_array( $indexes ) || ! empty( $wpdb->last_error ) ) {
                return new WP_Error( 've_search_index_check_failed', sprintf( 'Could not inspect indexes for %s: %s', $table, $wpdb->last_error ) );
            }

            $found_keys = array();
            foreach ( $indexes as $index ) {
                if ( isset( $index['Key_name'] ) ) {
                    $found_keys[] = $index['Key_name'];
                }
            }

            $missing_keys = array_diff( $required_keys, array_unique( $found_keys ) );
            if ( ! empty( $missing_keys ) ) {
                return new WP_Error(
                    've_search_indexes_missing',
                    sprintf( 'The search table %s is missing required indexes: %s.', $table, implode( ', ', $missing_keys ) )
                );
            }
        }

        return true;
    }
}

if ( ! function_exists( 've_search_install_database' ) ) {
    /**
     * Create or upgrade all search tables, then verify their structure.
     * Safe to call more than once. The schema version is saved only after
     * all tables, required columns and required indexes are verified.
     *
     * @return true|WP_Error
     */
    function ve_search_install_database() {
        global $wpdb;

        $schema_version = ve_search_get_schema_version();
        if ( is_wp_error( $schema_version ) ) {
            return $schema_version;
        }

        $tables = ve_search_get_database_tables();
        if ( is_wp_error( $tables ) ) {
            return $tables;
        }

        if ( ! function_exists( 'dbDelta' ) ) {
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        }
        if ( ! function_exists( 'dbDelta' ) ) {
            return new WP_Error( 've_search_dbdelta_unavailable', 'WordPress database upgrade functions could not be loaded.' );
        }

        $charset_collate = $wpdb->get_charset_collate();

        $index_table     = $tables['index_table'];
        $queue_table     = $tables['queue_table'];
        $analytics_table = $tables['analytics_table'];

        $sql = array();

        $sql['index_table'] = "CREATE TABLE {$index_table} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            object_id bigint(20) unsigned NOT NULL,
            object_type varchar(32) NOT NULL,
            group_key varchar(50) NOT NULL,
            title text NOT NULL,
            description longtext NULL,
            keywords longtext NULL,
            url text NOT NULL,
            image_url text NULL,
            sku varchar(100) NULL,
            price decimal(19,4) NULL,
            currency varchar(10) NULL,
            stock_status varchar(30) NULL,
            visibility varchar(20) NOT NULL DEFAULT 'public',
            modified_gmt datetime NULL,
            indexed_gmt datetime NOT NULL,
            content_hash char(64) NOT NULL,
            status varchar(20) NOT NULL DEFAULT 'published',
            PRIMARY KEY  (id),
            UNIQUE KEY object_lookup (object_type,object_id),
            KEY group_status (group_key,status),
            KEY status_modified (status,modified_gmt),
            KEY sku_lookup (sku)
        ) {$charset_collate};";

        $sql['queue_table'] = "CREATE TABLE {$queue_table} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            object_id bigint(20) unsigned NOT NULL,
            object_type varchar(32) NOT NULL,
            action varchar(20) NOT NULL DEFAULT 'upsert',
            status varchar(20) NOT NULL DEFAULT 'pending',
            attempts smallint(5) unsigned NOT NULL DEFAULT 0,
            available_at datetime NOT NULL,
            locked_at datetime NULL,
            last_error text NULL,
            created_at datetime NOT NULL,
            updated_at datetime NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY object_lookup (object_type,object_id),
            KEY queue_ready (status,available_at),
            KEY queue_lock (locked_at)
        ) {$charset_collate};";

        $sql['analytics_table'] = "CREATE TABLE {$analytics_table} (
            id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            event_type varchar(20) NOT NULL DEFAULT 'search',
            search_query varchar(255) NOT NULL,
            result_count int(10) unsigned NOT NULL DEFAULT 0,
            clicked_object_id bigint(20) unsigned NULL,
            clicked_object_type varchar(32) NULL,
            visitor_hash char(64) NULL,
            created_at datetime NOT NULL,
            PRIMARY KEY  (id),
            KEY event_created (event_type,created_at),
            KEY query_lookup (search_query(100)),
            KEY clicked_object (clicked_object_type,clicked_object_id)
        ) {$charset_collate};";

        foreach ( $sql as $table_key => $statement ) {
            $wpdb->last_error = '';
            dbDelta( $statement );

            if ( ! empty( $wpdb->last_error ) ) {
                return new WP_Error(
                    've_search_database_query_failed',
                    sprintf( 'Database installation failed for %s: %s', $table_key, $wpdb->last_error )
                );
            }
        }

        $requirements = array(
            'index_table' => array(
                'columns' => array(
                    'id', 'object_id', 'object_type', 'group_key', 'title', 'description',
                    'keywords', 'url', 'image_url', 'sku', 'price', 'currency',
                    'stock_status', 'visibility', 'modified_gmt', 'indexed_gmt',
                    'content_hash', 'status',
                ),
                'indexes' => array( 'PRIMARY', 'object_lookup', 'group_status', 'status_modified', 'sku_lookup' ),
            ),
            'queue_table' => array(
                'columns' => array(
                    'id', 'object_id', 'object_type', 'action', 'status', 'attempts',
                    'available_at', 'locked_at', 'last_error', 'created_at', 'updated_at',
                ),
                'indexes' => array( 'PRIMARY', 'object_lookup', 'queue_ready', 'queue_lock' ),
            ),
            'analytics_table' => array(
                'columns' => array(
                    'id', 'event_type', 'search_query', 'result_count', 'clicked_object_id',
                    'clicked_object_type', 'visitor_hash', 'created_at',
                ),
                'indexes' => array( 'PRIMARY', 'event_created', 'query_lookup', 'clicked_object' ),
            ),
        );

        foreach ( $requirements as $key => $requirement ) {
            $verified = ve_search_verify_database_table(
                $tables[ $key ],
                $requirement['columns'],
                $requirement['indexes']
            );

            if ( is_wp_error( $verified ) ) {
                return $verified;
            }
        }

        update_option( 've_search_schema_version', $schema_version, false );
        update_option( 've_search_database_ready', 'yes', false );

        return true;
    }
}
