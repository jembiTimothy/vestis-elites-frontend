
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

if ( ! function_exists( 've_search_register_classification' ) ) {

    /**
     * Register the search classification taxonomy.
     */
    function ve_search_register_classification() {

        if ( ! function_exists( 've_search_get_config' ) ) {
            return;
        }

        $config = ve_search_get_config();

        $classification = $config['classification'];

        $taxonomy = $classification['taxonomy'];

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
                'labels'            => $labels,
                'public'            => false,
                'publicly_queryable'=> false,
                'show_ui'           => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => false,
                'show_tagcloud'     => false,
                'show_in_rest'      => true,
                'hierarchical'      => $classification['hierarchical'],
                'query_var'         => false,
                'rewrite'           => false,
                'capabilities'      => array(
                    'manage_terms' => 'manage_categories',
                    'edit_terms'   => 'manage_categories',
                    'delete_terms' => 'manage_categories',
                    'assign_terms' => 'edit_posts',
                ),
            )
        );
    }
}


if ( ! function_exists( 've_search_create_classification_terms' ) ) {

    /**
     * Ensure the standard classification terms exist.
     */
    function ve_search_create_classification_terms() {

        if ( ! taxonomy_exists( 've_search_classification' ) ) {
            return;
        }

        $config = ve_search_get_config();

        $terms = $config['classification']['terms'];

        foreach ( $terms as $slug => $name ) {

            if ( term_exists( $slug, 've_search_classification' ) ) {
                continue;
            }

            wp_insert_term(
                $name,
                've_search_classification',
                array(
                    'slug' => $slug,
                )
            );
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
