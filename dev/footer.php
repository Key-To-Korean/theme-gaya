<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wprig
 */

?>

<footer id="colophon" class="site-footer">

	<?php get_sidebar( 'footer-top' ); ?>
	<?php get_sidebar( 'footer-bottom' ); ?>

	<div class="site-info">
		<div class="copyright">
			<span class="copyright-dates"><?php wprig_dynamic_copyright(); ?></span>
			<span class="copyright-message">All rights reserved.</span>
		</div>
		<div class="credits">
			<?php wprig_footer_credits(); ?>
		</div>
	</div><!-- .site-info -->
</footer><!-- #colophon -->

<!-- <i class="fa fa-chevron-circle-up topbutton"></i> -->
<a class="topbutton" href="#"><i class="fa fa-chevron-up"></i></a>

</div><!-- #page -->

<?php if ( is_active_sidebar( 'widget-ad-fixed-footer' ) ) : ?>
	<!-- Fixed Footer Ad -->
	<div class="adsense adsense-widget fixed-footer">
		<i id="dismiss-footer" class="fa fa-times-circle"></i>
		<?php
			/* Print styles for adsense widgets */
			wp_print_styles( array( 'wprig-adsense' ) ); // Note: If this was already done it will be skipped.
			dynamic_sidebar( 'widget-ad-fixed-footer' );
		?>
	</div>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
