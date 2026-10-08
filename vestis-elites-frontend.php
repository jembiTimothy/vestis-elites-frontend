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
