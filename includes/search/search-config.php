
<?php
/**
 * Vestis Elites Search
 *
 * Central configuration for the search system.
 *
 * This file does not initialise the search engine.
 * It only defines configuration values.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 've_search_get_config' ) ) {

    function ve_search_get_config() {

        return array(

            /*
             * SYSTEM
             */
            'system' => array(
                'version'        => '1.0.0',
                'schema_version' => '1.0.0',
                'minimum_term_length' => 2,
                'maximum_term_length' => 80,
            ),

            /*
             * DATABASE
             */
            'database' => array(
                'index_table'     => 've_search_index',
                'queue_table'     => 've_search_queue',
                'analytics_table' => 've_search_analytics',
            ),

            /*
             * PAGE CLASSIFICATION
             */
            'classification' => array(
                'taxonomy' => 've_search_classification',

                'terms' => array(
                    'services' => 'Services',
                    'opportunities' => 'Opportunities',
                    'general-information' => 'General Information',
                    'excluded' => 'Excluded',
                ),

                'hierarchical' => false,
            ),

            /*
             * SEARCHABLE CONTENT TYPES
             */
            'content' => array(

                'post_types' => array(
                    'product',
                    'post',
                    'page',
                ),

                'taxonomies' => array(
                    'product_cat'   => 'Categories',
                    'product_brand' => 'Brands',
                    'product_tag'   => 'Product Tags',
                ),

                'default_page_policy' => 'exclude_unclassified',
            ),

            /*
             * SEARCH GROUPS
             */
            'groups' => array(
                'products'         => 'Products',
                'digital-products' => 'Digital Products',
                'categories'       => 'Categories',
                'brands'           => 'Brands',
                'product-tags'     => 'Product Tags',
                'services'         => 'Services',
                'opportunities'    => 'Opportunities',
                'journal'          => 'Journal',
                'pages'            => 'Pages',
            ),

            /*
             * BACKGROUND INDEXING
             */
            'indexing' => array(
                'enabled' => true,

                'batch_size' => 20,

                'maximum_attempts' => 5,

                'worker_interval' => 5,

                'reconciliation_interval' => 'daily',

                'lock_duration' => 300,

                'maximum_execution_time' => 20,
            ),

            /*
             * PREDICTIVE SEARCH
             */
            'predictive' => array(
                'enabled' => true,
                'minimum_characters' => 2,
                'maximum_groups' => 9,
                'maximum_results_per_group' => 5,
            ),

            /*
             * FULL SEARCH RESULTS
             */
            'results' => array(
                'per_page' => 20,
                'maximum_per_page' => 50,
            ),

            /*
             * SEARCH CACHE
             */
            'cache' => array(
                'enabled' => true,
                'expiration' => 300,
            ),

            /*
             * SEARCH ANALYTICS
             */
            'analytics' => array(
                'enabled' => true,
                'record_queries' => true,
                'record_clicks' => true,
                'record_zero_results' => true,
            ),

            /*
             * SECURITY
             */
            'security' => array(
                'maximum_query_requests' => 30,
                'request_window' => 60,
            ),

        );
    }
}
