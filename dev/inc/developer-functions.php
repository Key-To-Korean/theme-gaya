<?php
/**
 * WPrig Theme Customizer
 *
 * @package wprig
 */

/**
 * WPRig Edit Customizer Headers
 */
function wprig_edit_customizer_headers() {

	/**
	 * WPRig Edit CSP Header
	 *
	 * @param [type] $headers The Headers to edit.
	 */
	function wprig_edit_csp_header( $headers ) {
		$headers['Content-Security-Policy'] .= ' localhost:8181';
		return $headers;
	}
	add_filter( 'wp_headers', 'wprig_edit_csp_header' );
}
add_action( 'customize_preview_init', 'wprig_edit_customizer_headers' );
