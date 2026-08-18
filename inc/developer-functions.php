<?php
/**
 * WPrig Theme Customizer
 *
 * @package gaya
 */

/**
 * Edit CSP Header for local BrowserSync preview.
 *
 * @param array $headers The Headers to edit.
 * @return array
 */
function gaya_edit_csp_header( $headers ) {
	$headers['Content-Security-Policy'] = isset( $headers['Content-Security-Policy'] ) ? $headers['Content-Security-Policy'] . ' localhost:8181' : 'localhost:8181';
	return $headers;
}

/**
 * Edit Customizer Headers
 */
function gaya_edit_customizer_headers() {
	add_filter( 'wp_headers', 'gaya_edit_csp_header' );
}
add_action( 'customize_preview_init', 'gaya_edit_customizer_headers' );
