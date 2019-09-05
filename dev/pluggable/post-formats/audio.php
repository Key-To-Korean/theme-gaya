<?php
/**
 * Post Format: Audio
 *
 * @package wprig
 */

/**
 * Post Format: Audio
 *
 * Get audio from an Audio
 * Find the audio and make sure it shows up on the index page
 *
 * @link https://www.youtube.com/watch?v=HXLviEusCyE WP Theme Dev - Audio Post Format
 */
function wprig_get_the_audio() {

	$output = '';
	if ( 'audio' === get_post_format() ) {
			$content           = apply_filters( 'the_content', get_the_content() );
			$shortcode_content = do_shortcode( $content );
			$embed             = get_media_embedded_in_content( $shortcode_content, array( 'audio', 'iframe' ) );

			$output = $embed[0];
	}
	echo esc_html( $output );

}
