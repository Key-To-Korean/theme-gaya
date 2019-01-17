<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wprig
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	
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

	<?php wprig_child_pages(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wprig' ),
				'after'  => '</div>',
			)
		);
		?>

		<?php if ( get_edit_post_link() ) : ?>
			<footer class="entry-footer">
				<?php
					wprig_edit_post_link();
				?>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
	</div><!-- .entry-content -->

	<?php
		/* Above After Post */
		if ( is_active_sidebar( 'widget-ad-post-post' ) ) : 
			/* Print styles for adsense widgets */
			wp_print_styles( array( 'wprig-adsense' ) ); // Note: If this was already done it will be skipped.
			dynamic_sidebar( 'widget-ad-post-post' ); 
		endif;
		?>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
if ( is_singular() ) :
	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
endif;
