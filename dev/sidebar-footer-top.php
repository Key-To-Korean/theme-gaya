<?php
/**
 * The sidebar containing the top footer widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wprig
 */

if ( ! is_active_sidebar( 'sidebar-footer-1' ) ) {
	return;
}
?>

<?php wp_print_styles( array( 'wprig-sidebar', 'wprig-widgets' ) ); ?>
<aside id="tertiary-1" class="footer-sidebar-1 widget-area">
	<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
</aside><!-- #tertiary-1 -->
