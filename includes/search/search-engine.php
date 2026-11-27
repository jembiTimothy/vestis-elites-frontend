
<?php
/**
 * Vestis Elites Search - indexed search engine.
 *
 * Searches the dedicated search index and returns grouped results.
 * Does not register routes, process HTTP requests, or modify index data.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Validate and normalise a search query.
 *
 * @param string $query Search query.
 * @return string|WP_Error
 */
if ( ! function_exists( 've_search_normalize_query' ) ) {
    function ve_search_normalize_query( $query ) {

        if ( ! is_string( $query ) ) {
            return new WP_Error(
                've_search_query_invalid',
                'The search query must be text.'
            );
        }

        $query = sanitize_text_field( wp_unslash( $query ) );
        $query = trim( preg_replace( '/\s+/u', ' ', $query ) );

        $config = ve_search_get_config();

        $minimum = absint(
            $config['system']['minimum_term_length'] ?? 2
        );

        $maximum = absint(
            $config['system']['maximum_term_length'] ?? 80
        );

        $length = function_exists( 'mb_strlen' )
            ? mb_strlen( $query )
            : strlen( $query );

        if ( $length < $minimum ) {
            return new WP_Error(
                've_search_query_too_short',
                'Enter at least ' . $minimum . ' characters to search.'
            );
        }

        if ( $length > $maximum ) {
            return new WP_Error(
                've_search_query_too_long',
                'The search query exceeds the permitted length.'
            );
        }

        return $query;
    }
}

/**
 * Get the configured search index table.
 *
 * @return string|WP_Error
 */
if ( ! function_exists( 've_search_engine_get_table' ) ) {
    function ve_search_engine_get_table() {

        if (
            ! function_exists( 've_search_get_database_tables' ) ||
            ! function_exists( 've_search_database_table_exists' )
        ) {
            return new WP_Error(
                've_search_engine_database_missing',
                'The search database module is unavailable.'
            );
        }

        $tables = ve_search_get_database_tables();

        if ( is_wp_error( $tables ) ) {
            return $tables;
        }

        $table = $tables['index_table'] ?? '';

        if (
            ! is_string( $table ) ||
            '' === $table ||
            ! ve_search_database_table_exists( $table )
        ) {
            return new WP_Error(
                've_search_engine_index_missing',
                'The search index table is not installed.'
            );
        }

        return $table;
    }
}

/**
 * Search one configured group.
 *
 * @param string $query     Search query.
 * @param string $group_key Search group key.
 * @param int    $limit     Maximum results.
 * @param int    $page      Result page.
 * @return array|WP_Error
 */
if ( ! function_exists( 've_search_engine_search_group' ) ) {
    function ve_search_engine_search_group(
        $query,
        $group_key,
        $limit,
        $page = 1
    ) {
        global $wpdb;

        $table = ve_search_engine_get_table();

        if ( is_wp_error( $table ) ) {
            return $table;
        }

        $group_key = sanitize_key( $group_key );
        $limit     = absint( $limit );
        $page      = max( 1, absint( $page ) );

        if (
            '' === $group_key ||
            $limit < 1 ||
            $limit > 50
        ) {
            return new WP_Error(
                've_search_engine_arguments_invalid',
                'The search group or result limit is invalid.'
            );
        }

        $escaped = $wpdb->esc_like( $query );

        $pattern = '%' . $escaped . '%';
        $prefix  = $escaped . '%';

        $where = "
            group_key = %s
            AND status = 'published'
            AND visibility = 'public'
            AND (
                title LIKE %s
                OR description LIKE %s
                OR keywords LIKE %s
                OR sku LIKE %s
            )
        ";

        $count_sql = "
            SELECT COUNT(*)
            FROM {$table}
            WHERE {$where}
        ";

        $total = $wpdb->get_var(
            $wpdb->prepare(
                $count_sql,
                $group_key,
                $pattern,
                $pattern,
                $pattern,
                $pattern
            )
        );

        if ( null === $total || ! empty( $wpdb->last_error ) ) {
            return new WP_Error(
                've_search_engine_count_failed',
                'The search result count could not be retrieved.'
            );
        }

        $total  = absint( $total );
        $offset = ( $page - 1 ) * $limit;

        if ( 0 === $total || $offset >= $total ) {
            return array(
                'items'       => array(),
                'total'       => $total,
                'page'        => $page,
                'per_page'    => $limit,
                'total_pages' => (int) ceil( $total / $limit ),
            );
        }

        $sql = "
            SELECT
                object_id,
                object_type,
                group_key,
                title,
                description,
                url,
                image_url,
                sku,
                price,
                currency,
                stock_status
            FROM {$table}
            WHERE {$where}
            ORDER BY
                CASE
                    WHEN title = %s THEN 0
                    WHEN title LIKE %s THEN 1
                    WHEN sku = %s THEN 2
                    ELSE 3
                END ASC,
                title ASC
            LIMIT %d OFFSET %d
        ";

        $results = $wpdb->get_results(
            $wpdb->prepare(
                $sql,
                $group_key,
                $pattern,
                $pattern,
                $pattern,
                $pattern,
                $query,
                $prefix,
                $query,
                $limit,
                $offset
            ),
            ARRAY_A
        );

        if ( ! is_array( $results ) || ! empty( $wpdb->last_error ) ) {
            return new WP_Error(
                've_search_engine_query_failed',
                'The search results could not be retrieved.'
            );
        }

        $items = array();

        foreach ( $results as $result ) {

            $items[] = array(
                'object_id'   => absint( $result['object_id'] ),
                'object_type' => sanitize_key( $result['object_type'] ),
                'group_key'   => sanitize_key( $result['group_key'] ),
                'title'       => sanitize_text_field( $result['title'] ),
                'description' => sanitize_text_field(
                    $result['description'] ?? ''
                ),
                'url'         => esc_url_raw( $result['url'] ),
                'image_url'   => ! empty( $result['image_url'] )
                    ? esc_url_raw( $result['image_url'] )
                    : null,
                'sku'         => isset( $result['sku'] )
                    ? sanitize_text_field( $result['sku'] )
                    : null,
                'price'       => isset( $result['price'] )
                    ? (string) $result['price']
                    : null,
                'currency'    => isset( $result['currency'] )
                    ? sanitize_text_field( $result['currency'] )
                    : null,
                'stock_status' => isset( $result['stock_status'] )
                    ? sanitize_key( $result['stock_status'] )
                    : null,
            );
        }

        return array(
            'items'       => $items,
            'total'       => $total,
            'page'        => $page,
            'per_page'    => $limit,
            'total_pages' => (int) ceil( $total / $limit ),
        );
    }
}

/**
 * Search across configured groups.
 *
 * Predictive mode returns a limited number of results per group.
 * Full-results mode supports group filtering and pagination.
 *
 * @param string $raw_query Search query.
 * @param array  $options   Search options.
 * @return array|WP_Error
 */
if ( ! function_exists( 've_search_execute_query' ) ) {
    function ve_search_execute_query( $raw_query, $options = array() ) {

        if ( ! function_exists( 've_search_get_config' ) ) {
            return new WP_Error(
                've_search_config_missing',
                'The search configuration module is unavailable.'
            );
        }

        $config = ve_search_get_config();

        if ( empty( $config['predictive']['enabled'] ) ) {
            return new WP_Error(
                've_search_disabled',
                'Search is currently disabled.'
            );
        }

        $query = ve_search_normalize_query( $raw_query );

        if ( is_wp_error( $query ) ) {
            return $query;
        }

        if ( ! is_array( $options ) ) {
            $options = array();
        }

        $predictive = ! empty( $options['predictive'] );

        $group_filter = isset( $options['group'] )
            ? sanitize_key( $options['group'] )
            : '';

        $page = isset( $options['page'] )
            ? absint( $options['page'] )
            : 1;

        $page = max( 1, $page );

        $configured_groups = $config['groups'] ?? array();

        if ( ! is_array( $configured_groups ) || empty( $configured_groups ) ) {
            return new WP_Error(
                've_search_groups_missing',
                'No search groups are configured.'
            );
        }

        if (
            '' !== $group_filter &&
            ! array_key_exists( $group_filter, $configured_groups )
        ) {
            return new WP_Error(
                've_search_group_invalid',
                'The requested search group is not recognised.'
            );
        }

        if ( $predictive ) {

            $maximum_groups = min(
                9,
                max(
                    1,
                    absint(
                        $config['predictive']['maximum_groups'] ?? 9
                    )
                )
            );

            $per_group = min(
                10,
                max(
                    1,
                    absint(
                        $config['predictive']['maximum_results_per_group'] ?? 5
                    )
                )
            );

        } else {

            $maximum_groups = count( $configured_groups );

            $per_group = min(
                50,
                max(
                    1,
                    absint(
                        $options['per_page'] ??
                        $config['results']['per_page'] ??
                        20
                    )
                )
            );

            $maximum_per_page = absint(
                $config['results']['maximum_per_page'] ?? 50
            );

            $per_group = min(
                $per_group,
                max( 1, $maximum_per_page )
            );
        }

        $groups = array();
        $group_count = 0;
        $total_results = 0;

        foreach ( $configured_groups as $group_key => $group_label ) {

            if (
                '' !== $group_filter &&
                $group_key !== $group_filter
            ) {
                continue;
            }

            if ( $group_count >= $maximum_groups ) {
                break;
            }

            $result_page = $predictive ? 1 : $page;

            $group_results = ve_search_engine_search_group(
                $query,
                $group_key,
                $per_group,
                $result_page
            );

            if ( is_wp_error( $group_results ) ) {
                return $group_results;
            }

            $groups[] = array(
                'key'         => sanitize_key( $group_key ),
                'label'       => sanitize_text_field( $group_label ),
                'items'       => $group_results['items'],
                'total'       => $group_results['total'],
                'page'        => $group_results['page'],
                'per_page'    => $group_results['per_page'],
                'total_pages' => $group_results['total_pages'],
            );

            $total_results += $group_results['total'];
            $group_count++;
        }

        return array(
            'query'         => $query,
            'predictive'    => $predictive,
            'group_filter'  => $group_filter,
            'groups'        => $groups,
            'total_results' => $total_results,
            'group_count'   => count( $groups ),
        );
    }
}
￼Enter
