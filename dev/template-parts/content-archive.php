<?php
/**
 * Template part for displaying posts
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
		<?php
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		?>
	</header><!-- .entry-header -->

	<!-- <div class="entry-content"> -->
		<?php
		// wprig_fancy_excerpt();
		?>
	<!-- </div>.entry-content -->

	<footer class="entry-footer">
		<?php
		wprig_edit_post_link();
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
</li>

<?php

