<?php
/**
 * Dynamic Footer File
 *
 * @package wprig
 */

/**
 * Dynamic Copyright
 */
function wprig_dynamic_copyright() {

	global $wpdb;

	$copyright_dates = $wpdb->get_results( "SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish' " );
	$output          = '';
	$blog_name       = get_bloginfo();

	if ( $copyright_dates ) {
		$copyright = '&copy; ' . $copyright_dates[0]->firstdate;
		if ( $copyright_dates[0]->firstdate !== $copyright_dates[0]->lastdate ) {
				$copyright .= ' &ndash; ' . $copyright_dates[0]->lastdate;
		}
		$output = $copyright . ' ' . $blog_name . '.';
	}
	echo wp_kses_post( $output );

}

/**
 * Footer credits for wprig.
 */
function wprig_footer_credits() {
		echo '<a href="' . esc_url( __( 'http://wordpress.org/', 'wprig' ) ) . '" rel="nofollow">';
		/* translators: Copyright */
		printf( esc_attr__( 'Proudly powered by %s', 'wprig' ), 'WordPress' );
		echo '</a>';
		echo '<span class="sep"> | </span>';

		printf(
			/* translators: Theme credit */
			esc_attr__( 'Theme: %2$s by %1$s.', 'wprig' ),
			'<a href="http://www.aaronsnowberger.com" target="_blank" rel="nofollow">Aaron Snowberger</a>',
			wp_kses_post( ucwords( '<a href="https://github.com/jekkilekki/theme-wprig" target="_blank" rel="nofollow">wprig</a>' ) )
		);
}
add_action( 'wprig_child_footer', 'wprig_footer_credits' );
