
<?php
/**
 * Vestis Elites Search
 *
 * Content classification taxonomy.
 *
 * Registers a reusable classification system for search content.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


/**
 * Register the search classification taxonomy.
 */
if ( ! function_exists( 've_search_register_classification' ) ) {

    function ve_search_register_classification() {

        if ( ! function_exists( 've_search_get_config' ) ) {
            return;
        }

        $config = ve_search_get_config();

        if (
            ! is_array( $config ) ||
            empty( $config['classification'] ) ||
            ! is_array( $config['classification'] ) ||
            empty( $config['classification']['taxonomy'] ) ||
            ! is_string( $config['classification']['taxonomy'] )
        ) {
            return;
        }

        $classification = $config['classification'];

        $taxonomy = $classification['taxonomy'];

        $hierarchical = isset( $classification['hierarchical'] )
            ? (bool) $classification['hierarchical']
            : false;

        $labels = array(
            'name'              => 'Search Classifications',
            'singular_name'     => 'Search Classification',
            'search_items'      => 'Search Classifications',
            'all_items'         => 'All Classifications',
            'edit_item'         => 'Edit Classification',
            'update_item'       => 'Update Classification',
            'add_new_item'      => 'Add New Classification',
            'new_item_name'     => 'New Classification Name',
            'menu_name'         => 'Search Classification',
        );

        register_taxonomy(
            $taxonomy,
            array(
                'page',
                'post',
                'product',
            ),
            array(
                'labels'             => $labels,
                'public'             => false,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'show_admin_column'  => true,
                'show_in_nav_menus'  => false,
                'show_tagcloud'      => false,
                'show_in_rest'       => true,
                'hierarchical'       => $hierarchical,
                'query_var'          => false,
                'rewrite'            => false,
                'capabilities'       => array(
                    'manage_terms' => 'manage_categories',
                    'edit_terms'   => 'manage_categories',
                    'delete_terms' => 'manage_categories',
                    'assign_terms' => 'edit_posts',
                ),
            )
        );
    }
}


/**
 * Ensure the standard classification terms exist.
 */
if ( ! function_exists( 've_search_create_classification_terms' ) ) {

    function ve_search_create_classification_terms() {

        if ( ! function_exists( 've_search_get_config' ) ) {
            return;
        }

        $config = ve_search_get_config();

        if (
            ! is_array( $config ) ||
            empty( $config['classification'] ) ||
            ! is_array( $config['classification'] )
        ) {
            return;
        }

        $classification = $config['classification'];

        if (
            empty( $classification['taxonomy'] ) ||
            ! is_string( $classification['taxonomy'] ) ||
            empty( $classification['terms'] ) ||
            ! is_array( $classification['terms'] )
        ) {
            return;
        }

        $taxonomy = $classification['taxonomy'];

        /*
         * Do not attempt term creation until WordPress
         * has registered the configured taxonomy.
         */
        if ( ! taxonomy_exists( $taxonomy ) ) {
            return;
        }

        foreach ( $classification['terms'] as $slug => $name ) {

            if (
                ! is_string( $slug ) ||
                ! is_string( $name ) ||
                '' === trim( $slug ) ||
                '' === trim( $name )
            ) {
                continue;
            }

            if ( term_exists( $slug, $taxonomy ) ) {
                continue;
            }

            $result = wp_insert_term(
                $name,
                $taxonomy,
                array(
                    'slug' => $slug,
                )
            );

            /*
             * Do not interrupt WordPress if a term
             * cannot be created. It can be retried
             * on a subsequent initialization.
             */
            if ( is_wp_error( $result ) ) {
                continue;
            }
        }
    }
}


/*
 * Register taxonomy after WordPress has loaded its post types.
 */
add_action(
    'init',
    've_search_register_classification',
    20
);


/*
 * Create standard terms after taxonomy registration.
 */
add_action(
    'init',
    've_search_create_classification_terms',
    21
);
