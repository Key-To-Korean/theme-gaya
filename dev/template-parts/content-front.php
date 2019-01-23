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
	
	<?php wprig_archive_thumbnails(); ?>

	<header class="entry-header">
		<div class="post-cats">
			<?php wprig_post_categories(); ?>
		</div>
		<?php
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		wprig_fancy_excerpt();
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->

<?php

