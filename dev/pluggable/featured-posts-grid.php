<?php
/**
 * Featured Posts File
 *
 * @package wprig
 */

/**
 * Get Stickies as "Featured Posts"
 *
 * @param array $stickies The sticky posts.
 *
 * @source: http://blog.josemcastaneda.com/2013/05/10/creating-a-sticky-post-slider/
 */
function wprig_featured_posts_grid( $stickies ) {

	$count = count( $stickies );
	if ( $count < 1 ) {
		return;
	}

	// Create a set of arguments to pass.
	$args = array(
		'post__in'       => $stickies,
		'posts_per_page' => 4,
		'post_type'      => 'post',
		'nopaging'       => true,
	);

	$featured = new WP_Query( $args );

	// If there is one or more sticky posts, we create our slider.
	if ( $featured->have_posts() ) {
		$count = 0;
		?>

		<h2 class="blog-title">Featured Articles</h2>
		<section id="featured-grid" class="featured-posts">

			<?php
			while ( $featured->have_posts() && $count < 4 ) :
				$featured->the_post();

				get_template_part( 'template-parts/content', 'front' );

				$count++;

			endwhile;
			wp_reset_postdata();
			?>

		</section><!-- section .featured -->

		<h2 class="blog-title">Latest Articles</h2>

		<?php
	} // end of the featured posts.
}
