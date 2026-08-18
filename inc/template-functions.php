<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package gaya
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function gaya_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		global $template;
		if ( 'front-page.php' !== basename( $template ) ) {
			$classes[] = 'has-sidebar';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'gaya_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function gaya_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'gaya_pingback_header' );

/**
 * Adds async/defer attributes to enqueued / registered scripts.
 *
 * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
 *
 * @link https://core.trac.wordpress.org/ticket/12009
 * @param string $tag    The script tag.
 * @param string $handle The script handle.
 * @return array
 */
function gaya_filter_script_loader_tag( $tag, $handle ) {

	foreach ( array( 'async', 'defer' ) as $attr ) {
		if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
			continue;
		}

		// Prevent adding attribute when already added in #12009.
		if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
			$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
		}

		// Only allow async or defer, not both.
		break;
	}

	return $tag;
}

add_filter( 'script_loader_tag', 'gaya_filter_script_loader_tag', 10, 2 );

/**
 * Generate preload markup for stylesheets.
 *
 * @param object $wp_styles Registered styles.
 * @param string $handle The style handle.
 */
function gaya_get_preload_stylesheet_uri( $wp_styles, $handle ) {
	$preload_uri = $wp_styles->registered[ $handle ]->src . '?ver=' . $wp_styles->registered[ $handle ]->ver;
	return $preload_uri;
}

/**
 * Adds preload for in-body stylesheets depending on what templates are being used.
 * Disabled when AMP is active as AMP injects the stylesheets inline.
 *
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Preloading_content
 */
function gaya_add_body_style() {

	// If AMP is active, do nothing.
	if ( gaya_is_amp() ) {
		return;
	}

	// Get registered styles.
	$wp_styles = wp_styles();

	$preloads = array();

	// Preload content.css.
	$preloads['gaya-content'] = gaya_get_preload_stylesheet_uri( $wp_styles, 'gaya-content' );

	// Preload sidebar.css and widget.css.
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$preloads['gaya-sidebar'] = gaya_get_preload_stylesheet_uri( $wp_styles, 'gaya-sidebar' );
		$preloads['gaya-widgets'] = gaya_get_preload_stylesheet_uri( $wp_styles, 'gaya-widgets' );
	}

	// Preload comments.css.
	if ( ! post_password_required() && is_singular() && ( comments_open() || get_comments_number() ) ) {
		$preloads['gaya-comments'] = gaya_get_preload_stylesheet_uri( $wp_styles, 'gaya-comments' );
	}

	// Preload front-page.css.
	global $template;
	if ( 'front-page.php' === basename( $template ) ) {
		$preloads['gaya-front-page'] = gaya_get_preload_stylesheet_uri( $wp_styles, 'gaya-front-page' );
	}

	// Output the preload markup in <head>.
	foreach ( $preloads as $handle => $src ) {
		echo '<link rel="preload" id="' . esc_attr( $handle ) . '-preload" href="' . esc_url( $src ) . '" as="style" />';
		echo "\n";
	}

}
add_action( 'wp_head', 'gaya_add_body_style' );

/**
 * Add dropdown symbol to nav menu items with children.
 *
 * Adds the dropdown markup after the menu link element,
 * before the submenu.
 *
 * Javascript converts the symbol to a toggle button.
 *
 * @TODO:
 * - This doesn't work for the page menu because it
 *   doesn't have a similar filter. So the dropdown symbol
 *   is only being added for page menus if JS is enabled.
 *   Create a ticket to add to core?
 *
 * @param string   $item_output The menu item's starting HTML output.
 * @param WP_Post  $item        Menu item data object.
 * @param int      $depth       Depth of menu item. Used for padding.
 * @param stdClass $args        An object of wp_nav_menu() arguments.
 * @return string Modified nav menu HTML.
 */
function gaya_add_primary_menu_dropdown_symbol( $item_output, $item, $depth, $args ) {

	// Only for our primary menu location.
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $item_output;
	}

	// Add the dropdown for items that have children.
	if ( ! empty( $item->classes ) && in_array( 'menu-item-has-children', $item->classes, true ) ) {
		return $item_output . '<span class="dropdown"><i class="dropdown-symbol"></i></span>';
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'gaya_add_primary_menu_dropdown_symbol', 10, 4 );

/**
 * Filters the HTML attributes applied to a menu item's anchor element.
 *
 * Checks if the menu item is the current menu
 * item and adds the aria "current" attribute.
 *
 * @param array   $atts   The HTML attributes applied to the menu item's `<a>` element.
 * @param WP_Post $item  The current menu item.
 * @return array Modified HTML attributes
 */
function gaya_add_nav_menu_aria_current( $atts, $item ) {
	/*
	 * First, check if "current" is set,
	 * which means the item is a nav menu item.
	 *
	 * Otherwise, it's a post item so check
	 * if the item is the current post.
	 */
	if ( isset( $item->current ) ) {
		if ( $item->current ) {
			$atts['aria-current'] = 'page';
		}
	} elseif ( ! empty( $item->ID ) ) {
		global $post;
		if ( ! empty( $post->ID ) && $post->ID === $item->ID ) {
			$atts['aria-current'] = 'page';
		}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'gaya_add_nav_menu_aria_current', 10, 2 );
add_filter( 'page_menu_link_attributes', 'gaya_add_nav_menu_aria_current', 10, 2 );

/**
 * Change how archive titles are displayed in the theme
 *
 * @param  string $title Archive Title.
 * @return string New Title markup
 */
function gaya_archive_title( $title ) {
	if ( is_category() ) {
			$title = single_cat_title( '', false );
	} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
	} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
	} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'gaya_archive_title' );
