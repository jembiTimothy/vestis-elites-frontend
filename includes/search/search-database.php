
<?php
/**
 * Vestis Elites Search
 *
 * Database schema and installation routines.
 *
 * This module does not install tables automatically.
 * Installation must be explicitly invoked by the search bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 've_search_get_database_tables' ) ) {

    /**
     * Return the fully prefixed search database table names.
     *
     * @return array|WP_Error
     */
    function ve_search_get_database_tables() {

        global $wpdb;

        if ( ! function_exists( 've_search_get_config' ) ) {
            return new WP_Error(
                've_search_config_missing',
                'The search configuration module has not been loaded.'
            );
        }

        $config = ve_search_get_config();

        $definitions = $config['database'];

        $tables = array();

        foreach ( $definitions as $key => $suffix ) {

            if ( ! preg_match( '/^[a-zA-Z0-9_]+$/', $suffix ) ) {
                return new WP_Error(
                    've_search_invalid_table_name',
                    'An invalid search database table name was supplied.'
                );
            }

            $tables[ $key ] = $wpdb->prefix . $suffix;
        }

        return $tables;
    }
}


if ( ! function_exists( 've_search_install_database' ) ) {

    /**
     * Create or update the search database tables.
     *
     * This function must be explicitly called.
     *
     * @return true|WP_Error
     */
    function ve_search_install_database() {

        global $wpdb;

        if ( ! function_exists( 've_search_get_config' ) ) {
            return new WP_Error(
                've_search_config_missing',
                'The search configuration module has not been loaded.'
            );
        }

        $tables = ve_search_get_database_tables();

        if ( is_wp_error( $tables ) ) {
            return $tables;
        }

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $charset_collate = $wpdb->get_charset_collate();

        /*
         * TABLE 1: SEARCH INDEX
         *
         * Stores the searchable representation of each content item.
         */
        $index_table = $tables['index_table'];

        $index_sql = "CREATE TABLE {$index_table} (
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

        /*
         * TABLE 2: INDEXING QUEUE
         *
         * Tracks content that must be indexed, updated or removed.
         */
        $queue_table = $tables['queue_table'];

        $queue_sql = "CREATE TABLE {$queue_table} (
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

        /*
         * TABLE 3: SEARCH ANALYTICS
         *
         * Stores query and interaction events.
         * No visitor IP address is stored.
         */
        $analytics_table = $tables['analytics_table'];

        $analytics_sql = "CREATE TABLE {$analytics_table} (
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

        /*
         * Run WordPress database schema updates.
         *
         * dbDelta is designed to create missing tables and
         * apply supported schema changes on future upgrades.
         */
        dbDelta( $index_sql );
        dbDelta( $queue_sql );
        dbDelta( $analytics_sql );

        /*
         * Verify that all three tables exist before
         * recording the installed schema version.
         */
        foreach ( $tables as $table ) {

            $found_table = $wpdb->get_var(
                $wpdb->prepare(
                    'SHOW TABLES LIKE %s',
                    $table
                )
            );

            if ( $found_table !== $table ) {

                return new WP_Error(
                    've_search_database_install_failed',
                    'The search database installation could not verify all required tables.'
                );
            }
        }

        /*
         * Save the schema version only after verification.
         */
        $config = ve_search_get_config();

        update_option(
            've_search_schema_version',
            $config['system']['schema_version'],
            false
        );

        return true;
    }
}
