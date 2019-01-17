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
	<?php
	/* Grab AN img URL to set as the background of the section */
	if ( has_post_thumbnail() )
		$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	elseif ( '' !== wprig_get_the_first_image_url( 'large-thumb' ) )
		$img_url = wprig_get_the_first_image_url( 'large-thumb' );
	elseif ( '' !== has_header_image() )
		$img_url = get_header_image();
	else
		$img_url = '';
	?>

		<div class="post-thumbnail" style="background-image: url(<?php echo $img_url; ?>)">
		<a class="post-thumbnail-link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
	
		<?php wprig_edit_post_link(); ?>
		</a>
		</div>


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

