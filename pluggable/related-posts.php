<?php
/**
 * Related Posts File
 *
 * @package gaya
 */

/**
 * Related Posts Module - shows up to 3 posts from the current post's first category.
 */
function gaya_jp_related_posts() {
	$categories = get_the_category();

	// Make sure we have categories.
	if ( empty( $categories ) ) {
		return;
	}

	// WP_Query arguments.
	$args = array(
		'post_status'         => array( 'publish' ),
		'posts_per_page'      => '3',
		'ignore_sticky_posts' => true,
		'category_name'       => $categories[0]->name,
	);

	// The Query.
	$query = new WP_Query( $args );

	// The Loop.
	if ( $query->have_posts() ) :
		?>
		<div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">
			<h3 class="jp-relatedposts-headline"><em>Related</em></h3>

			<div class="jp-relatedposts-items jp-relatedposts-items-visual jp-relatedposts-grid">
			<?php
			while ( $query->have_posts() ) :
				$query->the_post();
				$count = 0;
				?>
				<div class="jp-relatedposts-post jp-relatedposts-post<?php echo esc_attr( $count ); ?> jp-relatedposts-post-thumbs" data-post-id="<?php the_ID(); ?>" data-post-format="false">
					<a class="jp-relatedposts-post-a" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="nofollow" data-origin="<?php the_ID(); ?>" data-position="<?php echo esc_attr( $count ); ?>">
						<?php
						if ( has_post_thumbnail( get_the_ID() ) ) :
							?>
							<div class="post-thumbnail" style="background-image: url(<?php echo esc_url( get_the_post_thumbnail_url() ); ?>), -webkit-gradient(linear,left top,left bottom,from(#00bfa5),to(#00897b)), linear-gradient(180deg,#00bfa5,#00897b);"></div>
							<?php
						else :
							?>
							<div class="post-thumbnail" style="background-image: url(<?php echo esc_url( gaya_placeholder_image_url() ); ?>), -webkit-gradient(linear,left top,left bottom,from(#00bfa5),to(#00897b)), linear-gradient(180deg,#00bfa5,#00897b);"></div>
							<?php
						endif;
						?>
					</a>
					<h4 class="jp-relatedposts-post-title"><?php the_title(); ?></h4>
					<p class="jp-relatedposts-post-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
					<!-- <p class="jp-relatedposts-post-date" style="display: block;"><?php /* gaya_posted_on(); */ ?></p> -->
					<!-- <p class="jp-relatedposts-post-context"><?php /* gaya_post_categories(); */ ?></p> -->
				</div>
				<?php
				$count++;
			endwhile;
			?>
			</div>

		</div>
		<?php
		endif;

		// Restore original Post Data.
		wp_reset_postdata();
}
