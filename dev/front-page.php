<?php
/**
 * Render your site front page, whether the front page displays the blog posts index or a static page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#front-page-display
 *
 * @package gaya
 */

get_header();

/*
* Include the component stylesheet for the content.
* This call runs only once on index and archive pages.
* At some point, override functionality should be built in similar to the template part below.
*/
wp_print_styles( array( 'gaya-content', 'gaya-front-page' ) ); // Note: If this was already done it will be skipped.

?>
	<main id="primary" class="site-main">

	<?php
	// Only show Featured Posts on the FIRST page.
	$stickies    = get_option( 'sticky_posts' );
	$is_it_paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	if ( 1 === $is_it_paged ) {
		/* Load a Stickies Slider - if we have any Stickies */
		gaya_featured_posts_grid( $stickies );
	}

	/* New WP_Query for the front page - deals with pagination */
	$query = array(
		'post__not_in'   => $stickies,
		'posts_per_page' => 30,
		// 'page'          => $paged,
		'paged'          => $is_it_paged,
	);

	$query_object = new WP_Query( $query );

	if ( $query_object->have_posts() ) :

		/* Setup our rows */
		$count         = 1;
		$new_rows      = array( 1, 14, 2, 12, 18, 23, 4, 6, 9, 15, 20, 25, 28 );
		$new_rows_ends = array( 1, 14, 3, 13, 19, 24, 5, 8, 11, 17, 22, 27, 30 );

		while ( $query_object->have_posts() ) :
			$query_object->the_post();

			if ( in_array( $count, $new_rows, true ) ) {
				$output = '<div class="front-page-row';
				switch ( $count ) {
					case 1:
					case 14:
						$output .= ' one-per-row';
						break;
					case 2:
					case 12:
					case 18:
					case 23:
						$output .= ' two-per-row';
						break;
					case 6:
					case 9:
					case 15:
					case 20:
					case 25:
					case 28:
						$output .= ' three-per-row';
						break;
					default:
						$output .= ' one-per-row';
				}
				$output .= '">';
				echo wp_kses_post( $output );
			}

			/**
			 * We're loading 30 posts on the front page
			 * and displaying them differently.
			 */
			switch ( $count ) {

				/* Full width single post */
				case 1:
					echo '<div class="one-per-row">';
					get_template_part( 'template-parts/content', 'front' );
					echo '</div><!-- .one-per-row -->';
					/* Ad Above Post */
					if ( is_active_sidebar( 'widget-ad-pre-post' ) ) :
						/* Print styles for adsense widgets */
						wp_print_styles( array( 'gaya-adsense' ) ); // Note: If this was already done it will be skipped.
						dynamic_sidebar( 'widget-ad-pre-post' );
					endif;
					break;
				case 14:
					echo '<div class="one-per-row">';
					get_template_part( 'template-parts/content', 'front' );
					echo '</div><!-- .one-per-row -->';
					/* Ad Above Post */
					if ( is_active_sidebar( 'widget-ad-post-post' ) ) :
						/* Print styles for adsense widgets */
						wp_print_styles( array( 'gaya-adsense' ) ); // Note: If this was already done it will be skipped.
						dynamic_sidebar( 'widget-ad-post-post' );
					endif;
					break;

				/* Two posts per row */
				case 2:
				case 3:
				case 12:
				case 13:
				case 18:
				case 19:
				case 23:
				case 24:
					echo '<div class="two-per-row">';
					get_template_part( 'template-parts/content', 'front' );
					echo '</div><!-- .two-per-row -->';
					break;

				/* Special two posts per row */
				case 4:
				case 5:
					echo '<div class="two-per-row">';
					get_template_part( 'template-parts/content', 'front' );
					echo '</div><!-- .two-per-row -->';
					break;

				/* Three posts per row */
				case 6:
				case 7:
				case 8:
				case 9:
				case 10:
				case 11:
				case 15:
				case 16:
				case 17:
				case 20:
				case 21:
				case 22:
				case 25:
				case 26:
				case 27:
				case 28:
				case 29:
				case 30:
					echo '<div class="three-per-row">';
					get_template_part( 'template-parts/content', 'front' );
					echo '</div><!-- .three-per-row -->';
					break;
				default:
					echo '<div class="one-per-row">';
					get_template_part( 'template-parts/content', 'front' );
					echo '</div><!-- .one-per-row -->';
			}

			if ( in_array( $count, $new_rows_ends, true ) ) {
				echo '</div><!-- .front-page-row -->';
			}

			$count++;
		endwhile; // End of the loop.

		/* the_posts_navigation(); */
		gaya_paging_nav();

		wp_reset_postdata();

		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #primary -->

<?php
get_footer();
