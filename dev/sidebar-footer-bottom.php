<?php
/**
 * The sidebar containing the footer bottom widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wprig
 */

if ( ! is_active_sidebar( 'sidebar-footer-2' ) ) {
	return;
}
?>

<?php wp_print_styles( array( 'wprig-sidebar', 'wprig-widgets' ) ); ?>
<aside id="tertiary-2" class="footer-sidebar-2 widget-area">
	<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
</aside><!-- #tertiary-2 -->
