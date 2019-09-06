<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wprig
 */

?>
<li>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="placeholder" style="background-image: url(<?php has_post_thumbnail() ? the_post_thumbnail_url() : ''; ?>)">
	</div>

	<header class="entry-header">
		<?php /* wprig_post_thumbnail(); */ ?>

		<?php wprig_post_categories(); ?>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</header><!-- .entry-header -->

	<footer class="entry-footer">
		<?php
			wprig_posted_on();
			wprig_edit_post_link();
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
</li>
