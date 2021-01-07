<?php
/**
 * Author Box File
 *
 * @package wprig
 */

/**
 * Add an author box below posts
 *
 * @link http://www.wpbeginner.com/wp-tutorials/how-to-add-an-author-info-box-in-wordpress-posts/
 */
function wprig_author_box() {
	global $post;

	if ( ! is_singular() ) {
		return;
	}

	// Detect if a post author is set.
	if ( isset( $post->post_author ) ) {
		/*
		* Get Author info
		*/
		$display_name = get_the_author_meta( 'display_name', $post->post_author ); // Get the author's display name.
		if ( empty( $display_name ) ) {
			$display_name = get_the_author_meta( 'nickname', $post->post_author ); // If display name is not available, use nickname.
		}
		$user_desc  = get_the_author_meta( 'user_description', $post->post_author );          // Get bio info.
		$user_site  = get_the_author_meta( 'url', $post->post_author );                       // Website URL.
		$user_posts = get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) ); // Link to author archive page.

		$first_name = get_the_author_meta( 'first_name', $post->post_author );
		$last_name  = get_the_author_meta( 'last_name', $post->post_author );
		$full_name  = ! empty( $last_name ) ? $first_name . ' ' . $last_name : $first_name;

		$author_details = '<h3 class="author-name">' . get_the_author() . '</h3>';

		/*
		 * Create the Author box
		 */
		$author_details .= '<aside class="author_bio_section">';

		/*
		Old version.
		// $author_details .= '<h3 class="author-title"><span>' . esc_html__( 'About ', 'wprig' );
		// if ( ! empty ( $display_name ) ) $author_details .= $display_name;				// If an author archive, just show the author name
		// else $author_details .= esc_html__( 'the Author', 'wprig' ); // If a regular page, show "About the Author"
		// $author_details .= '</span></h3>';
		*/

		/*
		Don't have two author names.
		// if ( ! empty( $full_name ) && ! is_author() ) { // Don't show this name on an author archive page.
		// 	$author_details .= '<h3 class="author-name">';
		// 	$author_details .= '<a class="fn" href="' . esc_url( $user_posts ) . '">' . $full_name . '</a>';
		// 	$author_details .= '</h3>';
		// }
		*/

		$author_details .= '<div class="author-box">';

		$author_details .= '<section class="author-avatar">';
		$author_details .= get_avatar(
			get_the_author_meta( 'ID' ),
			array(
				'height' => 120,
				'width'  => 360,
			)
		);
		$author_details .= '</section>';

		$author_details .= '<section class="author-info">';

		if ( ! empty( $user_desc ) ) {
			$author_details .= '<p class="author-description">' . $user_desc . '</p>';
		}

		if ( ! is_author() ) { // Don't show the meta info on an author archive page.
			$author_details .= '<p class="author-links entry-meta"><span class="vcard">' . esc_html__( 'Read more posts by ', 'wprig' ) . '<a class="fn" href="' . esc_url( $user_posts ) . '">' . $display_name . '</a></span>';

			// Check if author has a website in their profile.
			if ( ! empty( $user_site ) ) {
				$author_details .= '<a class="author-site" href="' . esc_url( $user_site ) . '" target="_blank" rel="nofollow"><i class="fa fa-globe"></i><span class="screen-reader-text">' . esc_html__( 'Website', 'wprig' ) . '</span></a></p>';
			} else {
				$author_details .= '</p>';
			}
		}

		$author_details .= '</section>';
		$author_details .= '</div>';
		$author_details .= '</aside>';
		$author_details .= '<p class="show-hide-author label btn"><i class="fa fa-minus-circle"></i> ' . esc_html__( 'Hide', 'wprig' ) . '</p>';

		echo wp_kses_post( $author_details );

	}
}
