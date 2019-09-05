<?php
/**
 * Post Functions File
 *
 * @package wprig
 */

/**
 * Customize the Home page Post limit
function wprig_homepage_limits( $limits ) {
	if ( is_home() ) {
			return 'LIMIT 0, 30';
	}
	return $limits;
}
add_filter( 'post_limits', 'wprig_homepage_limits' );
 */

/**
 * Customize The Archive Title output
 *
 * @param string $title The Post title.
 */
function wprig_modify_archive_title( $title ) {
	if ( is_page_template( 'archive-jetpack-portfolio.php' ) || is_page_template( 'archive-jetpack-testimonial.php' ) ) {
			return esc_html__( 'All ', 'wprig' ) . $title;
	} else {
			return $title;
	}
}
add_filter( 'get_the_archive_title', 'wprig_modify_archive_title', 10, 1 );

/**
 * Add 'odd' and 'even' post classes
 *
 * @param string $classes The Post classes.
 * @source http://www.goldenapplewebdesign.com/alternating-post-classes-with-odd-even-styling/
 */
function wprig_odd_even_post_classes( $classes ) {
	global $current_class;
	if ( is_archive() || is_search() || is_home() ) :
			$classes[]     = $current_class;
			$current_class = ( 'odd' === $current_class ) ? 'even' : 'odd';
	endif;
	return $classes;
}
add_filter( 'post_class', 'wprig_odd_even_post_classes' );
global $current_class;
$current_class = 'odd';

/**
 * Returns true if the reading time can be displayed in posts.
 *
 * @return bool
 */
function wprig_show_reading_time() {
	$content = get_post_field( 'post_content', get_the_ID() );
	return in_array( get_post_type(), array( 'post' ), true ) && ! empty( $content ) && (bool) 1 === (bool) get_theme_mod( 'wprig_display_reading_time', 1 );
}

if ( ! function_exists( 'wprig_reading_time' ) ) :
	/**
	 * Gets the reading time based on the number of words in the post content.
	 *
	 * @link http://php.net/str_word_count
	 * @link http://php.net/number_format
	 */
	function wprig_reading_time() {
		$content = get_post_field( 'post_content', get_the_ID() );
		$count   = str_word_count( wp_strip_all_tags( $content ) );
		$time    = $count / 250; // Roughly 250 wpm reading time.
			echo '<span class="reading-time">' . number_format( $time ) . ' min read</span>';
	}
endif; // wprig_word_count.

/*
* Validate Gravatar
* @link: original: https://gist.github.com/justinph/5197810
* @link: WP.org: http://codex.wordpress.org/Using_Gravatars#Checking_for_the_Existence_of_a_Gravatar
*/

/**
 * Utility function to check if a gravatar exists for a given email or id
 *
 * @param int|string|object $id_or_email A user ID,  email address, or comment object.
 * @return bool if the gravatar exists or not
 */
function wprig_validate_gravatar( $id_or_email ) {
	// id or email code borrowed from wp-includes/pluggable.php.
	$email = '';
	if ( is_numeric( $id_or_email ) ) {
		$id   = (int) $id_or_email;
		$user = get_userdata( $id );
		if ( $user ) {
			$email = $user->user_email;
		}
	} elseif ( is_object( $id_or_email ) ) {
		// No avatar for pingbacks or trackbacks.
		$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
		if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types, true ) ) {
			return false;
		}

		if ( ! empty( $id_or_email->user_id ) ) {
			$id   = (int) $id_or_email->user_id;
			$user = get_userdata( $id );
			if ( $user ) {
				$email = $user->user_email;
			}
		} elseif ( ! empty( $id_or_email->comment_author_email ) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}

	$hashkey = md5( strtolower( trim( $email ) ) );
	$uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';

	$data = wp_cache_get( $hashkey );
	if ( false === $data ) {
		$response = wp_remote_head( $uri );
		if ( is_wp_error( $response ) ) {
			$data = 'not200';
		} else {
			$data = $response['response']['code'];
		}
			wp_cache_set( $hashkey, $data, $group = '', $expire = 60 * 5 );

	}
	if ( '200' === $data ) {
		return true;
	} else {
		return false;
	}
}



if ( ! function_exists( 'wprig_post_nav' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * Improve the post_nav() with post thumbnails. Help from this
	 *
	 * @link: http://www.measureddesigns.com/adding-previous-next-post-wordpress-post/
	 * @link: http://wpsites.net/web-design/add-featured-images-to-previous-next-post-nav-links/
	 */
	function wprig_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );

		$prev_id = $previous ? $previous->ID : '';
		$next_id = $next ? $next->ID : '';

		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation clear" role="navigation">
			<h2 class="screen-reader-text"><?php esc_attr_e( 'Post navigation', 'wprig' ); ?></h2>

				<div class="nav-links">
						<?php
						// My custom code below FIRST, then _s code.
						// PREVIOUS POST LINK.
						if ( ! empty( $previous ) ) {
							?>
						<div class="nav-previous">
								<a href="<?php echo esc_attr( get_permalink( $prev_id ) ); ?>" rel="prev">

										<?php
										if ( ( has_post_thumbnail( $prev_id ) && has_post_thumbnail( $next_id ) ) /* || ( has_post_thumbnail( $prev_id ) && empty( $next ) )*/ ) {
												$prev_thumb = get_the_post_thumbnail_url( $prev_id, 'medium' );
												$prev_thumb = $prev_thumb ? $prev_thumb : get_header_image();
											?>
											<div class="post-nav-thumb" style="background-image: url( <?php echo esc_attr( $prev_thumb ); ?> )">
													<!-- Placeholder for image -->
											</div>
										<?php } ?>

										<h3 class="meta-nav section-title" aria-hidden="true"><?php esc_attr_e( 'Previously', 'wprig' ); ?></h3>
										<span class="screen-reader-text"><?php esc_attr_e( 'Previous Post', 'wprig' ); ?></span>
										<span class="post-title"><?php echo esc_attr( mb_strimwidth( $previous->post_title, 0, 50, '&hellip;' ) ); ?></span>

								</a>
						</div>
							<?php
						}

						// NEXT POST LINK.
						if ( ! empty( $next ) ) {
							?>
						<div class="nav-next">
								<a href="<?php echo esc_attr( get_permalink( $next_id ) ); ?>" rel="next">

										<?php
										if ( ( has_post_thumbnail( $prev_id ) && has_post_thumbnail( $next_id ) ) ) {
												$next_thumb = get_the_post_thumbnail_url( $next_id, 'medium' );
												$next_thumb = $next_thumb ? $next_thumb : get_header_image();
											?>
											<div class="post-nav-thumb"style="background-image: url( <?php echo esc_attr( $next_thumb ); ?> )">
													<!-- Placeholder for image -->
											</div>
										<?php } ?>

										<h3 class="meta-nav section-title" aria-hidden="true"><?php esc_attr_e( 'Next time', 'wprig' ); ?></h3>
										<span class="screen-reader-text"><?php esc_attr_e( 'Next Post', 'wprig' ); ?></span>
										<span class="post-title"><?php echo esc_attr( mb_strimwidth( $next->post_title, 0, 50, '&hellip;' ) ); ?></span>

								</a>
						</div>
						<?php } ?>

				</div><!-- .nav-links -->

		</nav><!-- .navigation -->
		<?php
	}
endif;

if ( ! function_exists( 'wprig_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @global WP_Query   $wp_query   WordPress Query object.
	 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
	 */
	function wprig_paging_nav() {
		global $wp_query, $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links(
			array(
				'base'      => $pagenum_link,
				'format'    => $format,
				'total'     => $wp_query->max_num_pages,
				'current'   => $paged,
				'mid_size'  => 2,
				'add_args'  => array_map( 'urlencode', $query_args ),
				'prev_text' => __( '<i class="fa fa-chevron-left"></i>', 'wprig' ),
				'next_text' => __( '<i class="fa fa-chevron-right"></i>', 'wprig' ),
				'type'      => 'list',
			)
		);

		if ( $links ) :
			?>
		<nav class="navigation paging-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php esc_attr_e( 'Posts navigation', 'wprig' ); ?></h1>
			<?php echo esc_html( $links ); ?>
		</nav><!-- .navigation -->
			<?php
		endif;
	}
endif;

/**
 * Get the first image of a post if there's no featured image set.
 *
 * @param int|string $size The size of the image.
 *
 * Original @link: http://www.wprecipes.com/how-to-get-the-first-image-from-the-post-and-display-it
 * Better   @link: https://gist.github.com/brajeshwar/1205901
 * Full stop.
 */
function wprig_get_the_first_image_url( $size ) {
	if ( has_post_thumbnail() ) {
			$image_id  = get_post_thumbnail();
			$image_url = wp_get_attachment_image_src( $image_id, $size );
			$image_url = $image_url[0];

			$first_img = $image_url;
	} else {
		global $post, $posts;

		$first_img = '';
		ob_start();
		ob_end_clean();

		$output    = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
		$first_img = ( ! empty( $matches [1] [0] ) ) ? $matches [1] [0] : '';

		// Defines a default image.
		if ( empty( $first_img ) ) {
			$first_img = '';
			// $first_img = get_template_directory_uri() . '/images/contemporary_china.png';
		}
	}
	return $first_img;
}
