<?php
/**
 * Plugin Name: Vestis Elites Frontend
 * Description: Custom-coded frontend for Vestis Elites.
 * Version: 1.1.2
 * Author: Vestis Elites
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * =========================================================
 * VESTIS ELITES — GLOBAL SOCIAL SHARING IMAGE
 * =========================================================
 */

function vestis_elites_get_social_sharing_image( $image_url ) {

    if ( is_admin() || ! is_singular() ) {
        return $image_url;
    }

    $page_id = get_queried_object_id();

    if ( ! $page_id ) {
        return $image_url;
    }

    /*
     * 1. PAGE HERO IMAGES
     */

    $hero_images = array(
        'manicure-pedicure' => 'https://vestiselites.com.ng/wp-content/uploads/2026/11/vestis-elites-mens-manicure-pedicure-lagos-1.webp',

        'alterations' => 'https://vestiselites.com.ng/wp-content/uploads/2026/11/vestis-elites-clothing-alterations-tailoring-atelier.webp',
    );

    $page_slug = get_post_field( 'post_name', $page_id );

    if ( isset( $hero_images[ $page_slug ] ) ) {
        return $hero_images[ $page_slug ];
    }

    /*
     * 2. CODED HOMEPAGE HERO
     */

    $page_content = get_post_field( 'post_content', $page_id );

    if (
        $page_content &&
        has_shortcode( $page_content, 'vestis_frontend' )
    ) {

        $homepage_image = get_posts(
            array(
                'post_type'      => 'attachment',
                'post_status'    => 'inherit',
                'posts_per_page' => 1,
                'meta_query'     => array(
                    array(
                        'key'     => '_wp_attached_file',
                        'value'   => 'vestis-elite-about-hero-premium-2.webp',
                        'compare' => 'LIKE',
                    ),
                ),
            )
        );

        if ( ! empty( $homepage_image ) ) {
            $hero_url = wp_get_attachment_image_url(
                $homepage_image[0]->ID,
                'full'
            );

            if ( $hero_url ) {
                return $hero_url;
            }
        }
    }

    /*
     * 3. WORDPRESS FEATURED IMAGE
     */

    $featured_image = get_the_post_thumbnail_url(
        $page_id,
        'full'
    );

    if ( $featured_image ) {
        return $featured_image;
    }

    /*
     * 4. VESTIS ELITES FALLBACK IMAGE
     * Use the homepage editorial hero.
     */

    $fallback_image = get_posts(
        array(
            'post_type'      => 'attachment',
            'post_status'    => 'inherit',
            'posts_per_page' => 1,
            'meta_query'     => array(
                array(
                    'key'     => '_wp_attached_file',
                    'value'   => 'vestis-elite-about-hero-premium-2.webp',
                    'compare' => 'LIKE',
                ),
            ),
        )
    );

    if ( ! empty( $fallback_image ) ) {
        $fallback_url = wp_get_attachment_image_url(
            $fallback_image[0]->ID,
            'full'
        );

        if ( $fallback_url ) {
            return $fallback_url;
        }
    }

    return $image_url;
}

add_filter(
    'rank_math/opengraph/facebook/image',
    'vestis_elites_get_social_sharing_image',
    99
);

add_filter(
    'rank_math/opengraph/twitter/image',
    'vestis_elites_get_social_sharing_image',
    99
);

/**
 * =========================================================
 * VESTIS ELITES — ATELIER CART / PURCHASE AJAX
 * =========================================================
 */

function vestis_elites_atelier_cart_action() {

    if ( ! function_exists( 'WC' ) ) {

        wp_send_json_error(
            array(
                'message' => 'WooCommerce is not available.',
            ),
            500
        );
    }


    check_ajax_referer(
        've_atelier_cart',
        'nonce'
    );


    $product_id = isset( $_POST['product_id'] )
        ? absint( $_POST['product_id'] )
        : 0;


    $variation_id = isset( $_POST['variation_id'] )
        ? absint( $_POST['variation_id'] )
        : 0;


    $variation_attributes = array();


    if ( isset( $_POST['variation_attributes'] ) ) {

        $variation_attributes = json_decode(
            wp_unslash( $_POST['variation_attributes'] ),
            true
        );


        if ( ! is_array( $variation_attributes ) ) {
            $variation_attributes = array();
        }
    }


    $cart_action = isset( $_POST['cart_action'] )
        ? sanitize_key( $_POST['cart_action'] )
        : 'add_to_cart';


    /*
     * ---------------------------------------------------------
     * VALIDATE PRODUCT
     * ---------------------------------------------------------
     */

    $product = wc_get_product( $product_id );


    if ( ! $product ) {

        wp_send_json_error(
            array(
                'message' => 'This product could not be found.',
            ),
            404
        );
    }


    if ( 'publish' !== get_post_status( $product_id ) ) {

        wp_send_json_error(
            array(
                'message' => 'This product is no longer available.',
            ),
            400
        );
    }


    if ( ! $product->is_purchasable() ) {

        wp_send_json_error(
            array(
                'message' => 'This product cannot currently be purchased.',
            ),
            400
        );
    }


    /*
     * ---------------------------------------------------------
     * VARIABLE PRODUCT
     * ---------------------------------------------------------
     */

    if ( $product->is_type( 'variable' ) ) {

        if ( ! $variation_id ) {

            wp_send_json_error(
                array(
                    'message' => 'Please select a size.',
                ),
                400
            );
        }


        $variation = wc_get_product( $variation_id );


        if (
            ! $variation ||
            ! $variation->is_type( 'variation' ) ||
            (int) $variation->get_parent_id() !== $product_id
        ) {

            wp_send_json_error(
                array(
                    'message' => 'The selected option is invalid.',
                ),
                400
            );
        }


        if ( ! $variation->is_purchasable() ) {

            wp_send_json_error(
                array(
                    'message' => 'This variation cannot currently be purchased.',
                ),
                400
            );
        }


        if ( ! $variation->is_in_stock() ) {

            wp_send_json_error(
                array(
                    'message' => 'The selected size is currently unavailable.',
                ),
                400
            );
        }
    }


    /*
     * ---------------------------------------------------------
     * ENSURE CART EXISTS
     * ---------------------------------------------------------
     */

    if ( ! WC()->cart ) {
        wc_load_cart();
    }


    /*
     * ---------------------------------------------------------
     * ADD TO CART
     * ---------------------------------------------------------
     */

    $cart_item_key = WC()->cart->add_to_cart(
        $product_id,
        1,
        $variation_id,
        $variation_attributes
    );


    if ( ! $cart_item_key ) {

        wp_send_json_error(
            array(
                'message' => 'We could not add this item to your cart. Please try again.',
            ),
            400
        );
    }


    /*
     * ---------------------------------------------------------
     * RETURN SUCCESS
     * ---------------------------------------------------------
     */

    $cart_count = WC()->cart->get_cart_contents_count();

    $checkout_url = wc_get_checkout_url();

    $cart_url = wc_get_cart_url();


    if ( 'purchase' === $cart_action ) {

        wp_send_json_success(
            array(
                'message'      => 'Added to your order.',
                'cart_count'   => $cart_count,
                'checkout_url' => $checkout_url,
                'cart_url'     => $cart_url,
            )
        );
    }


    wp_send_json_success(
        array(
            'message'    => 'Added to your cart.',
            'cart_count' => $cart_count,
            'cart_url'   => $cart_url,
        )
    );
}


/*
 * AJAX — LOGGED-IN USERS
 */

add_action(
    'wp_ajax_ve_atelier_cart_action',
    'vestis_elites_atelier_cart_action'
);


/*
 * AJAX — LOGGED-OUT USERS
 */

add_action(
    'wp_ajax_nopriv_ve_atelier_cart_action',
    'vestis_elites_atelier_cart_action'
);


/**
 * =========================================================
 * VESTIS ELITES — CODED HOMEPAGE
 * =========================================================
 */

require_once __DIR__ . '/pages/homepage.php';

add_shortcode(
    'vestis_frontend',
    'vestis_elites_homepage'
);


/**
 * =========================================================
 * VESTIS ELITES — ALTERATIONS PAGE
 * =========================================================
 */

require_once __DIR__ . '/pages/alterations.php';

add_shortcode(
    'vestis_alterations',
    'vestis_elites_alterations_page'
);
/**
 * =========================================================
 * VESTIS ELITES — MANICURE & PEDICURE PAGE
 * =========================================================
 */

require_once __DIR__ . '/pages/mens-grooming.php';

add_shortcode(
    'vestis_mens_grooming',
    'vestis_elites_mens_grooming_page'
);
/**
 * =========================================================
 * VESTIS ELITES — HAIR SERVICES PAGE
 * =========================================================
 */

require_once __DIR__ . '/pages/hair-services.php';

add_shortcode(
    'vestis_hair_services',
    'vestis_elites_hair_services_page'
);
// Corporate Uniforms page temporarily disabled during recovery.
// require_once __DIR__ . '/pages/corporate-uniforms.php';

// add_shortcode(
//     'vestis_corporate_uniforms',
//     'vestis_elites_corporate_uniforms_page'
// );
