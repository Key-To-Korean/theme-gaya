<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package wprig
 */

get_header();
wp_print_styles( array( 'wprig-content' ) ); // Note: If this was already done it will be skipped.
$image_404 = get_theme_mod( 'image_404' );
?>

	<main id="primary" class="site-main">

		<?php
		if ( ! empty( $image_404 ) ) {
			echo '<img class="error-404-image not-found-image" src="' . esc_attr( $image_404 ) . '">';
		}
		?>

		<section class="error-404 not-found">

			<?php wprig_index_header(); ?>

			<div class="page-content">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'wprig' ); ?></p>

				<?php get_search_form(); ?>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

		<section class="error-404-widgets not-found-widgets">
			<?php the_widget( 'better_recent_posts' ); ?>

			<div class="widgets-404">
				<div class="widget widget_categories">
					<h2 class="widgettitle"><?php esc_html_e( 'Most Used Categories', 'wprig' ); ?></h2>
					<ul>
					<?php
					wp_list_categories(
						array(
							'orderby'    => 'count',
							'order'      => 'DESC',
							'show_count' => 1,
							'title_li'   => '',
							'number'     => 6,
							'depth'      => 1,
						)
					);
					?>
					</ul>
				</div><!-- .widget -->

				<?php

					/* translators: %1$s: smiley */
					$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'wprig' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

					// the_widget( 'better_archives' );.

					the_widget( 'WP_Widget_Tag_Cloud' );
				?>
			</div><!-- .widgets-404 -->
		</section><!-- .error-404-widgets -->

	</main><!-- #primary -->

<?php
get_footer();
