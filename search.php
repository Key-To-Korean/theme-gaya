<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package gaya
 */

get_header();

/*
 * Include the component stylesheet for the content.
 * This call runs only once on index and archive pages.
 * At some point, override functionality should be built in similar to the template part below.
 */
wp_print_styles( array( 'gaya-content' ) ); // Note: If this was already done it will be skipped.
?>

	<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) :

		/* Display the appropriate header when required. */
		gaya_index_header();

		/* Check if the search query has a category by the same name. */
		$search_query         = get_search_query();
		$search_query_as_slug = str_replace( ' ', '-', get_search_query() );

		$matched_category = get_term_by( 'name', $search_query, 'category' );
		if ( ! $matched_category ) {
			$matched_category = get_term_by( 'slug', $search_query_as_slug, 'category' );
		}

		if ( $matched_category ) {
			?>
			<h2 class="category-title">Category: <?php echo esc_html( $matched_category->name ) . ' (' . esc_html( $matched_category->term_id ) . ')'; ?></h2>
			<!-- image -->
			<p class="category-description"><?php echo wp_kses_post( category_description( $matched_category->term_id ) ); ?></p>
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
		gaya_paging_nav();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #primary -->

<?php
get_footer();
