<?php
/**
 * The sidebar containing the top footer widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gaya
 */

if ( ! is_active_sidebar( 'sidebar-footer-1' ) ) {
	return;
}
?>

<?php wp_print_styles( array( 'gaya-sidebar', 'gaya-widgets' ) ); ?>
<aside id="tertiary-1" class="footer-sidebar-1 widget-area">
	<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
</aside><!-- #tertiary-1 -->
