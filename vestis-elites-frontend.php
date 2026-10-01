<?php
/**
 * Plugin Name: Vestis Elites Frontend
 * Description: Custom-coded frontend for Vestis Elites.
 * Version: 2.0.0
 * Author: Vestis Elites
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function vestis_elites_test_shortcode() {

	return '<div style="padding:60px 20px;background:#000;color:#fff;text-align:center;">
		Vestis Elites Plugin Test — Working
	</div>';
}

add_shortcode(
	'vestis_frontend',
	'vestis_elites_test_shortcode'
);
