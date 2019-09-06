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
function wprig_featured_posts( $stickies ) {

	$count = count( $stickies );
	if ( $count < 1 ) {
		return;
	}

	// Create a set of arguments to pass.
	$args = array(
		'post__in'  => $stickies,
		// 'posts_per_page' => 3, commented out so it displays all
		'post_type' => 'post',
		'nopaging'  => true,
	);

	$featured = new WP_Query( $args );

	// If there is one or more sticky posts, we create our slider.
	if ( $featured->have_posts() && $count > 0 ) : ?>

	<p class="featured-title">Featured</p>
	<section id="featured-slider" class="featured-posts">

		<?php
		while ( $featured->have_posts() ) :
			$featured->the_post();

			/* Grab AN img URL to set as the background of the section */
			if ( has_post_thumbnail() ) {
				$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
			} elseif ( '' !== wprig_get_the_first_image_url( 'large-thumb' ) ) {
				$img_url = wprig_get_the_first_image_url( 'large-thumb' );
			} elseif ( '' !== get_header_image() ) {
				$img_url = get_header_image();
			} else {
				$img_url = wprig_placeholder_image_url();
			}
			?>

			<!-- <article 
			<?php

			/*
			'' === $img_url ? post_class( 'featured' ) : post_class( 'featured', 'placeholder' ); ?>
			id="post-<?php the_ID(); ?>"
			<?php echo '' === $img_url ? 'style="background-image: url(' . esc_url( $img_url ) . ');"' : '';
			*/
			?>
			> -->
			<article <?php post_class( 'featured' ); ?> id="post-<?php the_ID(); ?>"
				<?php echo 'style="background-image: url(' . esc_url( $img_url ) . ');"'; ?>
			>

			<div class="featured-article">
				<!-- <p class="featured-title">Featured</p> -->
				<div class="entry-content">
					<header class="entry-header">
						<?php
						the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
						?>
						<div class="entry-byline-date">
							by <?php wprig_posted_by(); ?> on <?php wprig_posted_on(); ?>
						</div>
					</header><!-- .entry-header -->

					<div class="entry-excerpt"><?php the_excerpt(); ?></div>
				</div><!-- .entry-content -->
			</div><!-- .featured-article -->

			<div class="entry-meta entry-meta-left">
					<?php
					echo '<span class="entry-permalink"><a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr__( 'Read the article ', 'wprig' ) . esc_attr( get_the_title() ) . '" rel="bookmark">Read Article <i class="fa fa-arrow-right"></i></a></span>';
					wprig_reading_time();
					?>
			</div><!-- .entry-meta -->

			<div class="entry-meta entry-meta-right">
					<?php
					wprig_comments_link();
					wprig_edit_post_link();
					?>
			</div><!-- .entry-meta -->

		</article><!-- article -->
			<?php
		endwhile;
		wp_reset_postdata();
		?>

	</section><!-- section .featured -->

	<h2 class="blog-title">Latest Articles</h2>

		<?php
	endif; // end of the featured posts.
}
