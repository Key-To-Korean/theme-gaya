<?php
/**
 * Related Posts File
 *
 * @package wprig
 */

/**
 * Related Posts Module for testing
 */
function wprig_jp_related_posts() {
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
							<div class="post-thumbnail" style="background-image: url(<?php echo esc_url( the_post_thumbnail_url() ); ?>), -webkit-gradient(linear,left top,left bottom,from(#00bfa5),to(#00897b)), linear-gradient(180deg,#00bfa5,#00897b);"></div>
							<?php
						else :
							?>
							<div class="post-thumbnail" style="background-image: url(<?php echo esc_url( wprig_placeholder_image_url() ); ?>), -webkit-gradient(linear,left top,left bottom,from(#00bfa5),to(#00897b)), linear-gradient(180deg,#00bfa5,#00897b);"></div>
							<?php
						endif;
						?>
					</a>
					<h4 class="jp-relatedposts-post-title"><?php the_title(); ?></h4>
					<p class="jp-relatedposts-post-excerpt"><?php echo wp_kses_post( get_the_excerpt() ); ?></p>
					<!-- <p class="jp-relatedposts-post-date" style="display: block;"><?php /* wprig_posted_on(); */ ?></p> -->
					<!-- <p class="jp-relatedposts-post-context"><?php /* wprig_post_categories(); */ ?></p> -->
				</div>
				<?php
				$count++;
			endwhile;
			?>
			</div>

		</div>
		<?php
		else :
			?>
			<div id="jp-relatedposts" class="jp-relatedposts" style="display: block;">
			<h3 class="jp-relatedposts-headline"><em>Default Related</em></h3>

			<div class="jp-relatedposts-items jp-relatedposts-items-visual jp-relatedposts-grid">
			<?php
			for ( $count = 1; $count < 4; $count++ ) :
				?>
				<div class="jp-relatedposts-post jp-relatedposts-post<?php echo esc_attr( $count ); ?> jp-relatedposts-post-thumbs" data-post-id="<?php esc_attr( $count ); ?>" data-post-format="false">
					<a class="jp-relatedposts-post-a" href="<?php the_permalink(); ?>" title="Fake Jetpack Related Post <?php echo esc_attr( $count ); ?>" rel="nofollow" data-origin="<?php esc_attr( $count ); ?>" data-position="<?php esc_attr( $count ); ?>">
					<div style="width: 200px; height: 160px; background: #428bca; color: #fff; line-height: 160px; text-align: center; ">Fake Thumbnail</div>
					</a>
					<h4 class="jp-relatedposts-post-title">Fake JetPack Related Post <?php echo esc_attr( $count ); ?></h4>
					<p class="jp-relatedposts-post-excerpt">Here's a short fake sentence for an excerpt blah blah blah. "I don't say, 'Blah blah blah!'" says Drac.</p>
					<p class="jp-relatedposts-post-date" style="display: block;">August 17, 2018</p>
					<p class="jp-relatedposts-post-context">Uncategorized &bull; JetPack &bull; Testing</p>
				</div>
				<?php
			endfor;
			?>
			</div>

		</div>
			<?php
		endif;

		// Restore original Post Data.
		wp_reset_postdata();
}
