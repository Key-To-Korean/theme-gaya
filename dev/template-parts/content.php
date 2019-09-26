<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wprig
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="post-cats">
			<?php wprig_post_categories(); ?>
		</div>

		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;
		?>

		<?php wprig_post_thumbnail(); ?>

		<?php if ( is_singular() && has_excerpt() ) : ?>
		<div class="entry-excerpt">
			<?php the_excerpt(); ?>
		</div>
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php
	/* Ad Above Post */
	if ( is_singular() && is_active_sidebar( 'widget-ad-pre-post' ) ) :
		/* Print styles for adsense widgets */
		wp_print_styles( array( 'wprig-adsense' ) ); // Note: If this was already done it will be skipped.
		dynamic_sidebar( 'widget-ad-pre-post' );
	endif;
	?>

	<?php
	if ( 'post' === get_post_type() && is_singular() ) :
		?>
		<div class="entry-meta">
			<?php
				wprig_posted_by();
				wprig_posted_on();
				wprig_reading_time();
				wprig_comments_link();
				wprig_edit_post_link();
			?>
		</div><!-- .entry-meta -->
		<?php
	endif;
	?>

	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'wprig' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wprig' ),
				'after'  => '</div>',
			)
		);
		?>

		<?php if ( is_singular() ) : ?>
			<footer class="entry-footer">
				<?php
					wprig_post_tags();
					wprig_edit_post_link();
				?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div><!-- .entry-content -->

	<?php if ( is_singular() ) : ?>
		<h3 class="section-title">Written by</h3>
		<div class="author-box">
			<?php wprig_author_box(); ?>
		</div>

		<?php
		/* Above After Post */
		if ( is_active_sidebar( 'widget-ad-post-post' ) ) :
			/* Print styles for adsense widgets */
			wp_print_styles( array( 'wprig-adsense' ) ); // Note: If this was already done it will be skipped.
			dynamic_sidebar( 'widget-ad-post-post' );
		endif;
		?>

		<?php
	endif;

	if ( function_exists( 'wprig_jp_related_posts' ) ) {
		wprig_jp_related_posts();
	}
	?>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
if ( is_singular() ) :
	?>
	<div class="post-navigation-container">
		<?php
		// Previous/next post navigation.
		$next_post = get_next_post();
		$prev_post = get_previous_post();

		wprig_post_nav();
		?>
	</div>

	<?php
	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
endif;
