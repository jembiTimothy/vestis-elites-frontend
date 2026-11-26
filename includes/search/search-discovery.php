<?php
/**
 * Vestis Elites Search - content discovery layer.
 * Returns eligible content identities in independently paginated batches.
 * Does not write to the database, enqueue jobs, or run customer searches.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 've_search_get_discovery_sources' ) ) {
    function ve_search_get_discovery_sources() {
        return array( 'product', 'post', 'page', 'product_cat', 'product_brand', 'product_tag' );
    }
}

if ( ! function_exists( 've_search_validate_discovery_config' ) ) {
    function ve_search_validate_discovery_config() {
        if ( ! function_exists( 've_search_get_config' ) ) {
            return new WP_Error( 've_search_config_missing', 'The search configuration module has not been loaded.' );
        }

        $config = ve_search_get_config();
        if (
            ! is_array( $config ) ||
            empty( $config['content']['post_types'] ) || ! is_array( $config['content']['post_types'] ) ||
            empty( $config['content']['taxonomies'] ) || ! is_array( $config['content']['taxonomies'] ) ||
            empty( $config['groups'] ) || ! is_array( $config['groups'] ) ||
            empty( $config['indexing']['batch_size'] )
        ) {
            return new WP_Error( 've_search_discovery_config_invalid', 'The search discovery configuration is incomplete or invalid.' );
        }

        $batch_size = absint( $config['indexing']['batch_size'] );
        if ( $batch_size < 1 || $batch_size > 100 ) {
            return new WP_Error( 've_search_discovery_batch_invalid', 'The configured discovery batch size is invalid.' );
        }

        return $config;
    }
}

if ( ! function_exists( 've_search_is_valid_discovery_source' ) ) {
    function ve_search_is_valid_discovery_source( $source, $config ) {
        if ( ! is_string( $source ) || ! in_array( $source, ve_search_get_discovery_sources(), true ) ) {
            return false;
        }

        if ( in_array( $source, array( 'product', 'post', 'page' ), true ) ) {
            return in_array( $source, $config['content']['post_types'], true );
        }

        return array_key_exists( $source, $config['content']['taxonomies'] );
    }
}

if ( ! function_exists( 've_search_get_taxonomy_group' ) ) {
    function ve_search_get_taxonomy_group( $taxonomy ) {
        $mapping = array(
            'product_cat'   => 'categories',
            'product_brand' => 'brands',
            'product_tag'   => 'product-tags',
        );
        return isset( $mapping[ $taxonomy ] ) ? $mapping[ $taxonomy ] : false;
    }
}

if ( ! function_exists( 've_search_create_discovery_identity' ) ) {
    function ve_search_create_discovery_identity( $object_id, $object_type, $group_key ) {
        $object_id = absint( $object_id );
        if ( $object_id < 1 || ! is_string( $object_type ) || '' === $object_type || ! is_string( $group_key ) || '' === $group_key ) {
            return false;
        }
        return array(
            'object_id'   => $object_id,
            'object_type' => $object_type,
            'group_key'   => $group_key,
        );
    }
}

if ( ! function_exists( 've_search_get_page_group' ) ) {
    function ve_search_get_page_group( $page_id, $config ) {
        if ( empty( $config['classification']['taxonomy'] ) || empty( $config['classification']['terms'] ) || ! is_array( $config['classification']['terms'] ) ) {
            return false;
        }

        $taxonomy = $config['classification']['taxonomy'];
        if ( ! taxonomy_exists( $taxonomy ) ) {
            return false;
        }

        $terms = get_the_terms( $page_id, $taxonomy );
        if ( empty( $terms ) || is_wp_error( $terms ) ) {
            return false;
        }

        $recognised = array();
        foreach ( $terms as $term ) {
            if ( isset( $term->slug ) && array_key_exists( $term->slug, $config['classification']['terms'] ) ) {
                $recognised[] = $term->slug;
            }
        }

        // Skip unclassified, excluded, and conflicting pages.
        if ( 1 !== count( $recognised ) ) {
            return false;
        }

        $mapping = array(
            'services'            => 'services',
            'opportunities'       => 'opportunities',
            'general-information' => 'pages',
        );
        $classification = $recognised[0];
        if ( ! isset( $mapping[ $classification ] ) ) {
            return false;
        }

        $group_key = $mapping[ $classification ];
        return array_key_exists( $group_key, $config['groups'] ) ? $group_key : false;
    }
}
if ( ! function_exists( 've_search_is_digital_product' ) ) {
    function ve_search_is_digital_product( $product ) {
        if ( ! is_object( $product ) || ! is_a( $product, 'WC_Product' ) ) {
            return false;
        }
        if ( $product->is_downloadable() ) {
            return true;
        }

        $product_id = $product->get_id();
        if ( taxonomy_exists( 'product_cat' ) && has_term( array( 'grooming-ebooks', 'the-personal-presentation-system' ), 'product_cat', $product_id ) ) {
            return true;
        }
        if ( taxonomy_exists( 'product_tag' ) && has_term( 'digital-ebook', 'product_tag', $product_id ) ) {
            return true;
        }
        return false;
    }
}

if ( ! function_exists( 've_search_discover_products' ) ) {
    function ve_search_discover_products( $page, $limit, $config ) {
        if ( ! function_exists( 'wc_get_products' ) || ! class_exists( 'WC_Product' ) ) {
            return new WP_Error( 've_search_woocommerce_unavailable', 'WooCommerce product discovery is unavailable.' );
        }
        if ( ! isset( $config['groups']['products'], $config['groups']['digital-products'] ) ) {
            return new WP_Error( 've_search_product_groups_missing', 'The Products or Digital Products search group is not configured.' );
        }

        $results = wc_get_products( array(
            'status'   => 'publish',
            'limit'    => $limit,
            'page'     => $page,
            'paginate' => true,
            'orderby'  => 'ID',
            'order'    => 'ASC',
            'return'   => 'objects',
        ) );

        if ( is_wp_error( $results ) || ! is_object( $results ) || ! isset( $results->products, $results->max_num_pages ) || ! is_array( $results->products ) ) {
            return new WP_Error( 've_search_product_query_failed', 'WooCommerce did not return a valid paginated product result.' );
        }

        $items = array();
        foreach ( $results->products as $product ) {
            if ( ! is_object( $product ) || ! is_a( $product, 'WC_Product' ) || ! $product->is_visible() ) {
                continue;
            }
            $group_key = ve_search_is_digital_product( $product ) ? 'digital-products' : 'products';
            $identity = ve_search_create_discovery_identity( $product->get_id(), 'product', $group_key );
            if ( false !== $identity ) {
                $items[] = $identity;
            }
        }

        $max_pages = absint( $results->max_num_pages );
        $has_more  = $page < $max_pages;
        return array(
            'items'     => $items,
            'page'      => $page,
            'next_page' => $has_more ? $page + 1 : null,
            'has_more'  => $has_more,
        );
    }
}

if ( ! function_exists( 've_search_discover_posts' ) ) {
    function ve_search_discover_posts( $post_type, $page, $limit, $config ) {
        if ( ! in_array( $post_type, array( 'post', 'page' ), true ) ) {
            return new WP_Error( 've_search_invalid_post_source', 'The requested WordPress post source is not supported.' );
        }

        if ( 'post' === $post_type && ! isset( $config['groups']['journal'] ) ) {
            return new WP_Error( 've_search_journal_group_missing', 'The Journal search group is not configured.' );
        }

        $query = new WP_Query( array(
            'post_type'              => $post_type,
            'post_status'            => 'publish',
            'posts_per_page'         => $limit,
            'paged'                  => $page,
            'orderby'                => 'ID',
            'order'                  => 'ASC',
            'fields'                 => 'ids',
            'has_password'           => false,
            'ignore_sticky_posts'    => true,
            'no_found_rows'          => false,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => true,
            'lazy_load_term_meta'    => false,
        ) );

        $items = array();
        foreach ( $query->posts as $post_id ) {
            $post_id = absint( $post_id );
            if ( $post_id < 1 || post_password_required( $post_id ) ) {
                continue;
            }

            $group_key = 'post' === $post_type ? 'journal' : ve_search_get_page_group( $post_id, $config );
            if ( false === $group_key ) {
                continue;
            }
            $identity = ve_search_create_discovery_identity( $post_id, $post_type, $group_key );
            if ( false !== $identity ) {
                $items[] = $identity;
            }
        }

        $max_pages = absint( $query->max_num_pages );
        $has_more  = $page < $max_pages;
        return array(
            'items'     => $items,
            'page'      => $page,
            'next_page' => $has_more ? $page + 1 : null,
            'has_more'  => $has_more,
        );
    }
}
if ( ! function_exists( 've_search_discover_terms' ) ) {
    function ve_search_discover_terms( $taxonomy, $page, $limit, $config ) {
        if ( ! taxonomy_exists( $taxonomy ) ) {
            return array( 'items' => array(), 'page' => $page, 'next_page' => null, 'has_more' => false );
        }

        $group_key = ve_search_get_taxonomy_group( $taxonomy );
        if ( false === $group_key || ! isset( $config['groups'][ $group_key ] ) ) {
            return new WP_Error( 've_search_taxonomy_group_invalid', 'The taxonomy does not have a valid configured search group.' );
        }

        $terms = get_terms( array(
            'taxonomy'   => $taxonomy,
            'hide_empty' => true,
            'number'     => $limit,
            'offset'     => ( $page - 1 ) * $limit,
            'orderby'    => 'term_id',
            'order'      => 'ASC',
        ) );
        if ( is_wp_error( $terms ) ) {
            return $terms;
        }

        $items = array();
        foreach ( $terms as $term ) {
            if ( ! isset( $term->term_id, $term->taxonomy ) || $term->taxonomy !== $taxonomy ) {
                continue;
            }
            $identity = ve_search_create_discovery_identity( $term->term_id, $taxonomy, $group_key );
            if ( false !== $identity ) {
                $items[] = $identity;
            }
        }

        $has_more = count( $terms ) === $limit;
        return array(
            'items'     => $items,
            'page'      => $page,
            'next_page' => $has_more ? $page + 1 : null,
            'has_more'  => $has_more,
        );
    }
}

if ( ! function_exists( 've_search_discover_batch' ) ) {
    function ve_search_discover_batch( $source, $page = 1, $limit = null ) {
        $config = ve_search_validate_discovery_config();
        if ( is_wp_error( $config ) ) {
            return $config;
        }
        if ( ! ve_search_is_valid_discovery_source( $source, $config ) ) {
            return new WP_Error( 've_search_discovery_source_invalid', 'The requested discovery source is not configured or supported.' );
        }

        $page = absint( $page );
        if ( $page < 1 ) {
            return new WP_Error( 've_search_discovery_page_invalid', 'The discovery page number must be greater than zero.' );
        }

        $maximum_batch_size = absint( $config['indexing']['batch_size'] );
        $limit = null === $limit ? $maximum_batch_size : absint( $limit );
        if ( $limit < 1 || $limit > $maximum_batch_size ) {
            return new WP_Error( 've_search_discovery_limit_invalid', 'The requested batch size is outside the permitted range.' );
        }

        if ( 'product' === $source ) {
            return ve_search_discover_products( $page, $limit, $config );
        }
        if ( in_array( $source, array( 'post', 'page' ), true ) ) {
            return ve_search_discover_posts( $source, $page, $limit, $config );
        }
        return ve_search_discover_terms( $source, $page, $limit, $config );
    }
}
