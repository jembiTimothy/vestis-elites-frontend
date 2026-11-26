<?php
/**
 * Vestis Elites Search - index record management.
 *
 * Builds, validates, stores and removes individual search index records.
 * This module does not discover content, enqueue work, install tables,
 * register hooks, or run customer-facing searches.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 've_search_get_index_record_identity' ) ) {
    function ve_search_get_index_record_identity( $identity ) {
        if (
            ! is_array( $identity ) ||
            empty( $identity['object_id'] ) ||
            empty( $identity['object_type'] ) ||
            empty( $identity['group_key'] )
        ) {
            return new WP_Error( 've_search_record_identity_invalid', 'The search record identity is incomplete.' );
        }

        $object_id   = absint( $identity['object_id'] );
        $object_type = sanitize_key( $identity['object_type'] );
        $group_key   = sanitize_key( $identity['group_key'] );

        if ( $object_id < 1 || '' === $object_type || '' === $group_key ) {
            return new WP_Error( 've_search_record_identity_invalid', 'The search record identity is invalid.' );
        }

        return array(
            'object_id'   => $object_id,
            'object_type' => $object_type,
            'group_key'   => $group_key,
        );
    }
}

if ( ! function_exists( 've_search_get_index_record_text' ) ) {
    function ve_search_get_index_record_text( $value ) {
        if ( ! is_scalar( $value ) ) {
            return '';
        }
        return trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( (string) $value ) ) );
    }
}

if ( ! function_exists( 've_search_get_index_record_terms' ) ) {
    function ve_search_get_index_record_terms( $object_id, $object_type ) {
        $taxonomies = get_object_taxonomies( $object_type, 'names' );
        if ( empty( $taxonomies ) || ! is_array( $taxonomies ) ) {
            return array();
        }

        $names = array();
        foreach ( $taxonomies as $taxonomy ) {
            if ( ! taxonomy_exists( $taxonomy ) ) {
                continue;
            }
            $terms = wp_get_object_terms( $object_id, $taxonomy, array( 'fields' => 'names' ) );
            if ( is_wp_error( $terms ) || ! is_array( $terms ) ) {
                continue;
            }
            foreach ( $terms as $name ) {
                $name = ve_search_get_index_record_text( $name );
                if ( '' !== $name ) {
                    $names[] = $name;
                }
            }
        }
        return array_values( array_unique( $names ) );
    }
}

if ( ! function_exists( 've_search_build_post_index_record' ) ) {
    function ve_search_build_post_index_record( $identity ) {
        $post = get_post( $identity['object_id'] );
        if ( ! $post || $post->post_type !== $identity['object_type'] || 'publish' !== $post->post_status || post_password_required( $post ) ) {
            return new WP_Error( 've_search_record_content_ineligible', 'The WordPress content is not publicly eligible for search.' );
        }

        if ( 'post' === $post->post_type ) {
            $expected_group = 'journal';
        } elseif ( 'page' === $post->post_type && function_exists( 've_search_get_page_group' ) && function_exists( 've_search_get_config' ) ) {
            $expected_group = ve_search_get_page_group( $post->ID, ve_search_get_config() );
        } else {
            return new WP_Error( 've_search_record_post_type_unsupported', 'The WordPress content type is not supported by the index.' );
        }

        if ( $expected_group !== $identity['group_key'] ) {
            return new WP_Error( 've_search_record_group_mismatch', 'The WordPress content classification does not match the supplied search group.' );
        }

        $title = ve_search_get_index_record_text( get_the_title( $post ) );
        $url   = get_permalink( $post );
        if ( '' === $title || ! $url ) {
            return new WP_Error( 've_search_record_content_incomplete', 'The WordPress content does not have a valid title and public URL.' );
        }

        $description = ve_search_get_index_record_text( $post->post_excerpt );
        if ( '' === $description ) {
            $description = ve_search_get_index_record_text( $post->post_content );
        }

        $image_url = get_the_post_thumbnail_url( $post, 'full' );
        $keywords  = implode( ' ', ve_search_get_index_record_terms( $post->ID, $post->post_type ) );

        return array(
            'object_id'   => $post->ID,
            'object_type' => $post->post_type,
            'group_key'   => $identity['group_key'],
            'title'       => $title,
            'description' => $description,
            'keywords'    => $keywords,
            'url'         => esc_url_raw( $url ),
            'image_url'   => $image_url ? esc_url_raw( $image_url ) : null,
            'sku'         => null,
            'price'       => null,
            'currency'    => null,
            'stock_status'=> null,
            'visibility'  => 'public',
            'modified_gmt'=> '0000-00-00 00:00:00' !== $post->post_modified_gmt ? $post->post_modified_gmt : null,
            'status'      => 'published',
        );
    }
}
if ( ! function_exists( 've_search_build_product_index_record' ) ) {
    function ve_search_build_product_index_record( $identity ) {
        if ( ! function_exists( 'wc_get_product' ) || ! class_exists( 'WC_Product' ) ) {
            return new WP_Error( 've_search_woocommerce_unavailable', 'WooCommerce is not available to build a product index record.' );
        }

        $product = wc_get_product( $identity['object_id'] );
        if ( ! $product || ! is_a( $product, 'WC_Product' ) || 'publish' !== get_post_status( $product->get_id() ) || ! $product->is_visible() ) {
            return new WP_Error( 've_search_record_product_ineligible', 'The WooCommerce product is not publicly visible.' );
        }

        if ( ! function_exists( 've_search_is_digital_product' ) ) {
            return new WP_Error( 've_search_discovery_missing', 'The content discovery module must be loaded before product records can be built.' );
        }

        $expected_group = ve_search_is_digital_product( $product ) ? 'digital-products' : 'products';
        if ( $identity['group_key'] !== $expected_group ) {
            return new WP_Error( 've_search_record_group_mismatch', 'The product classification does not match the supplied search group.' );
        }

        $title = ve_search_get_index_record_text( $product->get_name() );
        $url   = get_permalink( $product->get_id() );
        if ( '' === $title || ! $url ) {
            return new WP_Error( 've_search_record_product_incomplete', 'The WooCommerce product does not have a valid title and public URL.' );
        }

        $description = ve_search_get_index_record_text( $product->get_short_description() );
        if ( '' === $description ) {
            $description = ve_search_get_index_record_text( $product->get_description() );
        }

        $image_id  = $product->get_image_id();
        $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : false;
        $price     = $product->get_price();

        return array(
            'object_id'    => $product->get_id(),
            'object_type'  => 'product',
            'group_key'    => $expected_group,
            'title'        => $title,
            'description'  => $description,
            'keywords'     => implode( ' ', ve_search_get_index_record_terms( $product->get_id(), 'product' ) ),
            'url'          => esc_url_raw( $url ),
            'image_url'    => $image_url ? esc_url_raw( $image_url ) : null,
            'sku'          => '' !== (string) $product->get_sku() ? sanitize_text_field( $product->get_sku() ) : null,
            'price'        => '' !== (string) $price && is_numeric( $price ) ? (string) wc_format_decimal( $price, 4 ) : null,
            'currency'     => function_exists( 'get_woocommerce_currency' ) ? get_woocommerce_currency() : null,
            'stock_status' => sanitize_key( $product->get_stock_status() ),
            'visibility'   => 'public',
            'modified_gmt' => get_post_field( 'post_modified_gmt', $product->get_id() ) ?: null,
            'status'       => 'published',
        );
    }
}

if ( ! function_exists( 've_search_build_term_index_record' ) ) {
    function ve_search_build_term_index_record( $identity ) {
        $expected_groups = array(
            'product_cat'   => 'categories',
            'product_brand' => 'brands',
            'product_tag'   => 'product-tags',
        );

        if ( ! isset( $expected_groups[ $identity['object_type'] ] ) || $identity['group_key'] !== $expected_groups[ $identity['object_type'] ] ) {
            return new WP_Error( 've_search_record_taxonomy_mismatch', 'The taxonomy and search group do not match.' );
        }
        if ( ! taxonomy_exists( $identity['object_type'] ) ) {
            return new WP_Error( 've_search_record_taxonomy_unavailable', 'The requested product taxonomy is not registered.' );
        }

        $term = get_term( $identity['object_id'], $identity['object_type'] );
        if ( ! $term || is_wp_error( $term ) || (int) $term->count < 1 ) {
            return new WP_Error( 've_search_record_term_ineligible', 'The taxonomy term is missing or has no assigned products.' );
        }

        $url = get_term_link( $term );
        if ( is_wp_error( $url ) ) {
            return new WP_Error( 've_search_record_term_url_invalid', 'The taxonomy term does not have a valid public URL.' );
        }

        $image_url = null;
        if ( 'product_cat' === $identity['object_type'] ) {
            $thumbnail_id = absint( get_term_meta( $term->term_id, 'thumbnail_id', true ) );
            if ( $thumbnail_id ) {
                $candidate = wp_get_attachment_image_url( $thumbnail_id, 'full' );
                $image_url = $candidate ? esc_url_raw( $candidate ) : null;
            }
        }

        return array(
            'object_id'    => (int) $term->term_id,
            'object_type'  => $identity['object_type'],
            'group_key'    => $identity['group_key'],
            'title'        => ve_search_get_index_record_text( $term->name ),
            'description'  => ve_search_get_index_record_text( $term->description ),
            'keywords'     => '',
            'url'          => esc_url_raw( $url ),
            'image_url'    => $image_url,
            'sku'          => null,
            'price'        => null,
            'currency'     => null,
            'stock_status' => null,
            'visibility'   => 'public',
            'modified_gmt' => null,
            'status'       => 'published',
        );
    }
}

if ( ! function_exists( 've_search_build_index_record' ) ) {
    function ve_search_build_index_record( $identity ) {
        $identity = ve_search_get_index_record_identity( $identity );
        if ( is_wp_error( $identity ) ) {
            return $identity;
        }

        if ( ! function_exists( 've_search_get_config' ) ) {
            return new WP_Error( 've_search_config_missing', 'The search configuration module has not been loaded.' );
        }

        if ( 'product' === $identity['object_type'] ) {
            $record = ve_search_build_product_index_record( $identity );
        } elseif ( in_array( $identity['object_type'], array( 'post', 'page' ), true ) ) {
            $record = ve_search_build_post_index_record( $identity );
        } else {
            $record = ve_search_build_term_index_record( $identity );
        }

        if ( is_wp_error( $record ) ) {
            return $record;
        }

        $record['indexed_gmt'] = current_time( 'mysql', true );
        $hash_fields = $record;
        unset( $hash_fields['indexed_gmt'] );
        $record['content_hash'] = hash( 'sha256', wp_json_encode( $hash_fields ) );

        return $record;
    }
}
if ( ! function_exists( 've_search_upsert_index_record' ) ) {
    function ve_search_upsert_index_record( $identity ) {
        global $wpdb;

        if ( ! function_exists( 've_search_get_database_tables' ) || ! function_exists( 've_search_database_table_exists' ) ) {
            return new WP_Error( 've_search_database_module_missing', 'The search database module has not been loaded.' );
        }

        $tables = ve_search_get_database_tables();
        if ( is_wp_error( $tables ) ) {
            return $tables;
        }
        $table = $tables['index_table'];
        if ( ! ve_search_database_table_exists( $table ) ) {
            return new WP_Error( 've_search_index_table_missing', 'The search index table has not been installed.' );
        }

        $record = ve_search_build_index_record( $identity );
        if ( is_wp_error( $record ) ) {
            return $record;
        }

        $formats = array( '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' );
        $result  = $wpdb->replace( $table, $record, $formats );
        if ( false === $result ) {
            return new WP_Error( 've_search_index_write_failed', 'The search index record could not be saved.' );
        }

        return array(
            'object_id'   => $record['object_id'],
            'object_type' => $record['object_type'],
            'group_key'   => $record['group_key'],
            'content_hash'=> $record['content_hash'],
            'rows_affected'=> (int) $result,
        );
    }
}

if ( ! function_exists( 've_search_delete_index_record' ) ) {
    function ve_search_delete_index_record( $object_id, $object_type ) {
        global $wpdb;

        $object_id   = absint( $object_id );
        $object_type = is_string( $object_type ) ? sanitize_key( $object_type ) : '';
        if ( $object_id < 1 || '' === $object_type ) {
            return new WP_Error( 've_search_delete_identity_invalid', 'The search index deletion identity is invalid.' );
        }
        if ( ! function_exists( 've_search_get_database_tables' ) || ! function_exists( 've_search_database_table_exists' ) ) {
            return new WP_Error( 've_search_database_module_missing', 'The search database module has not been loaded.' );
        }

        $tables = ve_search_get_database_tables();
        if ( is_wp_error( $tables ) ) {
            return $tables;
        }
        $table = $tables['index_table'];
        if ( ! ve_search_database_table_exists( $table ) ) {
            return new WP_Error( 've_search_index_table_missing', 'The search index table has not been installed.' );
        }

        $result = $wpdb->delete(
            $table,
            array( 'object_id' => $object_id, 'object_type' => $object_type ),
            array( '%d', '%s' )
        );
        if ( false === $result ) {
            return new WP_Error( 've_search_index_delete_failed', 'The search index record could not be deleted.' );
        }

        return array(
            'object_id'   => $object_id,
            'object_type' => $object_type,
            'deleted'     => (int) $result,
        );
    }
}
