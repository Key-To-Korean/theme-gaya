<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wprig
 */

get_header(); ?>

	<main id="primary" class="site-main">

	<?php
	/* Large author photo */

	/* Display the appropriate header (author name). */
	wprig_index_header();
	?>

	<div class="author-page-section">
		<ul class="author-links">
			<?php 
			/* author email, website, SNS section */ 
			$author_site = get_the_author_meta( 'url' );
			if ( ! empty ( $author_site ) ) {
				echo '<li>' . 
					'<a class="author-site" href="' . esc_url( $author_site ) . '" target="_blank" rel="nofollow">' . 
					'<i class="fa fa-home"></i>' . 
					'<span class="screen-reader-text">' . esc_html__( 'Website', 'wprig' ) . '</span>' . 
					'</a></li>'; 
			}
			?>
		</ul>
		<div class="author-description">
			<?php echo wpautop( get_the_author_meta( 'description' ) ); ?>
		</div>
	

		<h3 class="section-title">Published Articles</h3>
			<?php
			if ( have_posts() ) :

				echo '<ul class="author-posts-grid">';

				/* Start the "Official" Loop */
				$count = 0;
				while ( have_posts() && $count < 9 ) :
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

				gaya_paging_nav();

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>
		</div>

	</main><!-- #primary -->

<?php
get_footer();
