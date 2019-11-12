<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package wprig
 */

get_header();

/*
 * Include the component stylesheet for the content.
 * This call runs only once on index and archive pages.
 * At some point, override functionality should be built in similar to the template part below.
 */
wp_print_styles( array( 'wprig-content' ) ); // Note: If this was already done it will be skipped.
?>

	<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) :

		/* Display the appropriate header when required. */
		wprig_index_header();

		/* Check if the search query has a category by the same name. */
		$search_query         = get_search_query();
		$search_query_as_slug = str_replace( ' ', '-', get_search_query() );

		if ( has_category( $search_query ) ) {
			?>
			<h2 class="category-title">Category: <?php echo esc_attr( $search_query ) . ' (' . esc_html( get_term_by( 'name', $search_query, 'category' )->term_id . ')' ); ?></h2>
			<!-- image -->
			<p class="category-description"><?php echo category_description( get_term_by( 'name', $search_query, 'category' )->term_id ); ?></p>
			<?php
		} elseif ( has_category( $search_query_as_slug ) ) {
			?>
			<h2 class="category-title">Category: <?php echo esc_html( $search_query_as_slug ) . ' (' . esc_html( get_term_by( 'slug', $search_query_as_slug, 'category' )->term_id . ')' ); ?></h2>
			<!-- image -->
			<p class="category-description"><?php echo category_description( get_term_by( 'slug', $search_query_as_slug, 'category' )->term_id ); ?></p>

			<?php
		}

		echo '<ul class="archive-posts-grid">';

		/* Start the Loop */
		$count = 0;
		while ( have_posts() && $count < 8 ) :
			the_post();

			/**
			 * Run the loop for the search to output the results.
			 * If you want to overload this in a child theme then include a file
			 * called content-search.php and that will be used instead.
			 */
			get_template_part( 'template-parts/content', 'archive' );

			$count++;
		endwhile;

		echo '</ul>';

		/* the_posts_navigation(); */
		wprig_paging_nav();

		else :

			get_template_part( 'template-parts/content', 'none' );
			?>

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

			<?php
		endif;
		?>

	</main><!-- #primary -->

<?php
get_footer();
