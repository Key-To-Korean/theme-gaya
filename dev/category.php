<?php
/**
 * The template for displaying category archives.
 *
 * When active, applies to all category archives.
 * To target a specific category, rename file to category-{slug/id}.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#category
 *
 * @package wprig
 */

get_header(); ?>

	<main id="primary" class="site-main">

	<?php
	if ( have_posts() ) :

		/* Display the appropriate header when required. */
		wprig_index_header();

		echo '<ul class="category-posts-grid archive-posts-grid">';

		/* Start the "Official" Loop */
		$count = 0;
		while ( have_posts() && $count < 8 ) :
			the_post();

			/*
			 * Include the component stylesheet for the content.
			 * This call runs only once on index and archive pages.
			 * At some point, override functionality should be built in similar to the template part below.
			 */
			wp_print_styles( array( 'wprig-content' ) ); // Note: If this was already done it will be skipped.

			/*
			 * Include the Post-Type-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', 'archive' );

			$count++;
		endwhile;

		echo '</ul>';

		/* Subcategory Loops */
		$categories    = get_the_category();
		$this_cat_id   = $categories[0]->cat_ID;
		$term_children = get_term_children( $this_cat_id, 'category' );

		/*
		Old code
		// $sub_cat_IDs = array();

		// foreach( $term_children as $cat ) {
		// 	$parent = $cat->category_parent;
		// 	// if ( $parent != 0 ) {
		// 		$sub_cat_ID = $cat->cat_ID;
		// 		$sub_cat_IDs.push( $sub_cat_ID );
		// 	// }
		// }
		*/

		if ( ! empty( $term_children ) ) {
			/*
			Debugging code
			// var_dump($term_children);

			// $trimmed_cat = array_map( function($cat) { return substr($cat, 0, strpos($cat, '(')); }, $this_category );
			// var_dump($trimmed_cat);
			*/

			foreach ( $term_children as $child ) :
				$a_term = get_term_by( 'id', $child, 'category' );

				// WP_Query arguments.
				$args = array(
					'post_status'         => array( 'publish' ),
					'posts_per_page'      => '4',
					'ignore_sticky_posts' => false,
					'category_name'       => $a_term->name,
				);

				// The Query.
				$query = new WP_Query( $args );

				// The Loop.
				if ( $query->have_posts() ) {
					echo '<section class="page-section">';
					echo '<h3 class="category-title">' . esc_attr( ucwords( $a_term->name ) ) . '</h3>';
					echo '<ul class="category-posts-grid archive-posts-grid">';

					while ( $query->have_posts() ) {
						$query->the_post();
						// do something.
						// echo '<li>';.
						get_template_part( 'template-parts/content', 'archive' );
						// echo '</li>';.
					}

					echo '</ul>';
					echo '</section>';
				} else {
					// no posts found.
					esc_attr_e( 'No posts found.', 'wprig' );
				}

				// Restore original Post Data.
				wp_reset_postdata();

			endforeach;
			?>
			<hr />
			<section class="page-section">
				<h3 class="category-title all-categories">All Categories</h3>
				<ul class="blog-categories">
					<?php
					$categories = get_category( get_query_var( 'cat' ) );
						// use $categories->parent and '&child_of' . $categories->parent . if you want only SUB categories.
						$categories = wp_list_categories(
							'orderby=id&depth=1&show_count=0' .
							'&title_li=&use_desc_for_title=1' .
							'&echo=0'
						);
					echo wp_kses_post( $categories );
					?>
				</ul>
			</section>
			<?php
		}

		/* the_posts_navigation(); */
		wprig_paging_nav();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #primary -->

<?php
get_footer();
