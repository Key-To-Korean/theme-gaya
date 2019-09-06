<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package wprig
 */

get_header(); ?>

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

			/*
			 * Include the component stylesheet for the content.
			 * This call runs only once on index and archive pages.
			 * At some point, override functionality should be built in similar to the template part below.
			 */
			wp_print_styles( array( 'wprig-content' ) ); // Note: If this was already done it will be skipped.

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

		endif;
		?>

	</main><!-- #primary -->

<?php
get_footer();
