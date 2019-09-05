<?php
/**
 * Post Format: Video
 *
 * @package wprig
 */

	/**
	 * Video
	 *
	 * Special video related functions
	 *
	 * Filter a Video Post to add an 'entry-meta' <div> around the <iframe> video to
	 * give the video a bit of a darker backdrop for viewing
	 *
	 * @param   string $content  Original post $content.
	 * @return  string $content  Updated $content string with 'entry-meta' <div> surrounding the <iframe> video
	 */
function wprig_video_backdrop( $content ) {
	if ( 'video' === get_post_format() && is_singular() ) {
		$vid_start = strpos( $content, '<iframe>' );
		$vid_end   = strpos( $content, '</iframe>' ) + 9;

		if ( $vid_end > 9 ) { // Be sure that the end of the video is after the beginning.
			$before_video = substr( $content, 0, $vid_start );
			$video        = substr( $content, $vid_start, $vid_end - $vid_start );
			$after_video  = substr( $content, $vid_end );

			$content = $before_video . '<div class="entry-meta video-backdrop">' . $video . '</div>' . $after_video;
		}
	}
	return $content;
}
add_filter( 'the_content', 'wprig_video_backdrop' );

/**
 * Post Format: Video
 *
 * Get video from a Video
 * Only get the first 'video' element from a Post for index and archive pages.
 */
function wprig_get_the_video() {

	$output = '';
	if ( 'video' === get_post_format() ) {
		$content = apply_filters( 'the_content', get_the_content() );

		if ( strpos( $content, '</iframe>' ) === false ) {
			$output = esc_attr__( 'No video found in post.', 'wprig' );
		} else {
			$output = substr( $content, strpos( $content, '<iframe>' ), strpos( $content, '</iframe>' ) + 9 );
		}
	}
	echo wp_kses_post( $output );

}
