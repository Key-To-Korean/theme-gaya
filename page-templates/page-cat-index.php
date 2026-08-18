<?php
/**
 * Template Name: Category Index
 *
 * A simple index page listing every category on the site.
 *
 * @package gaya
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();
			?>

			<header class="entry-header page-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>

			<div class="entry-content page-content">
				<?php the_content(); ?>
			</div>

			<?php
		endwhile;
		?>

		<section class="page-section all-categories">
			<ul class="blog-categories">
				<?php
				$categories = wp_list_categories(
					array(
						'orderby'          => 'name',
						'title_li'         => '',
						'use_desc_for_title' => 1,
						'echo'             => false,
					)
				);
				echo wp_kses_post( $categories );
				?>
			</ul>
		</section>

	</main><!-- #primary -->

<?php
get_footer();
