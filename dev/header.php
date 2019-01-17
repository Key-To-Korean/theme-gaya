<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wprig
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php if ( ! wprig_is_amp() ) : ?>
		<script>document.documentElement.classList.remove("no-js");</script>
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

		<div class="site-search-overlay">
				<i class="fa fa-times-circle close-search"></i>
				<?php get_search_form(); ?>
		</div>

		<div class="drawer">
			<?php get_sidebar(); ?>
		</div>

		<?php if ( has_nav_menu( 'social' ) ) : ?>
			<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'k2k' ); ?>">
				<?php
					wp_nav_menu( array(
									'theme_location' => 'social',
									'menu_class'		 => 'social-links-menu',
									'depth'					=> 1,
									'link_before'		=> '<span class="screen-reader-text">',
									'link_after'		 => '</span>' /* . k2k_get_svg( array( 'icon' => 'chain' ) ),*/
					) );
				?>
			</nav><!-- .social-navigation -->
		<?php endif; ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'wprig' ); ?></a>

	<section class="header-section full-bleed">

		<?php if ( is_active_sidebar( 'widget-ad-header' ) ) : ?>
			<!-- Above Header Ad -->
			<div class="adsense adsense-widget above-header">
				<?php
					/* Print styles for adsense widgets */
					wp_print_styles( array( 'wprig-adsense' ) ); // Note: If this was already done it will be skipped.
					dynamic_sidebar( 'widget-ad-header' );
				?>
			</div>
		<?php endif; ?>

		<!-- Site Search over EVERYTHING else - pushes site down if opened -->
		<div id="site-search-container" class="search-box-wrapper clear" style="display: none;">
			<div class="site-search clear">
				<?php get_search_form(); ?>
			</div><!-- .site-search -->
		</div><!-- #site-search-container -->
		
		<!-- Top "News Flash" type section -->
		<div class="header-flash">
			<div class="header-contact">
				<?php 
					$header_text1 = get_theme_mod( 'header_text1' );
					$header_text2 = get_theme_mod( 'header_text2' );
					$header_text3 = get_theme_mod( 'header_text3' );
					
					if ( $header_text1 || $header_text2 || $header_text3 ) : ?> 
					<ul>
						<?php 
							echo $header_text1 ? "<li class='header-text-one'>$header_text1</li>" : ''; 
							echo $header_text2 ? "<li class='header-text-two'>$header_text2</li>" : '';
							echo $header_text3 ? "<li class='header-text-three'>$header_text3</li>" : '';
						?>
					</ul>
					<?php 
					endif; 
				?>

				<?php $wprig_description = get_bloginfo( 'description', 'display' ); ?>
				<?php if ( $wprig_description || is_customize_preview() ) : ?>
					<p class="site-description"><?php echo $wprig_description; /* WPCS: xss ok. */ ?></p>
				<?php endif; ?>
				
				<div class="position-right">
					<?php 
					if ( has_nav_menu( 'quicklinks' ) ) :
						wp_nav_menu(
							array(
								'theme_location' => 'quicklinks',
								'menu_id'				=> 'quicklinks-menu',
								'container'			=> 'ul',
							)
						);
					endif;
					?>
				</div>
								
			</div><!-- .header-contact -->
		</div><!-- .header-flash -->
		
		<!-- Logo, Site Branding, Menu container -->
		<header id="masthead" class="site-header">

			<!-- <div class="site-header-container"> -->
			<div class="site-branding">
				<?php the_custom_logo(); ?>
				<!-- <div class="site-title-description"> -->
					<?php if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif; ?>
				<!--</div> .site-title-description -->
			</div><!-- .site-branding -->
			<!--</div> .site-header-container -->

			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Main menu', 'wprig' ); ?>"
				<?php if ( wprig_is_amp() ) : ?>
					[class]=" siteNavigationMenu.expanded ? 'main-navigation toggled-on' : 'main-navigation' "
				<?php endif; ?>
			>
				<?php if ( wprig_is_amp() ) : ?>
					<amp-state id="siteNavigationMenu">
						<script type="application/json">
							{
								"expanded": false
							}
						</script>
					</amp-state>
				<?php endif; ?>

				<button class="menu-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'wprig' ); ?>" aria-controls="primary-menu" aria-expanded="false"
					<?php if ( wprig_is_amp() ) : ?>
						on="tap:AMP.setState( { siteNavigationMenu: { expanded: ! siteNavigationMenu.expanded } } )"
						[aria-expanded]="siteNavigationMenu.expanded ? 'true' : 'false'"
					<?php endif; ?>
				>
					<?php esc_html_e( 'Menu', 'wprig' ); ?>
				</button>

				<div class="primary-menu-container">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'				=> 'primary-menu',
							'container'			=> 'ul',
						)
					);
					?>
				</div>
			</nav><!-- #site-navigation -->

			<div class="position-right">
				<div class="search-box">
					<i id="search-toggle" class="fa fa-search search-toggle"></i>
					<a href="#search-container" class="screen-reader-text"><?php esc_html_e( 'Search this site', 'k2k' ); ?></a>
				</div>
				<div class="drawer-box">
					<i id="drawer-toggle" class="fa fa-cog drawer-toggle"></i>
					<a href="#drawer-container" class="screen-reader-text"><?php esc_html_e( 'Open Sidebar', 'k2k' ); ?></a>
				</div>
			</div>
		</header><!-- #masthead -->
	</section><!-- .header-section -->
