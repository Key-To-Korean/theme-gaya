<?php
/**
 * Custom Nav Menu Dropdown
 *
 * @package wprig
 */

/**
 * Nav Menu Dropdown
 */
class Wprig_Nav_Menu_Dropdown extends Walker_Nav_Menu {
	/**
	 * Start Level
	 *
	 * @param [type]  $output The output.
	 * @param integer $depth The depth.
	 * @param [type]  $args The args.
	 * @return void
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth ); // don't output children opening tag (`<ul>`).
	}

	/**
	 * End Level
	 *
	 * @param [type]  $output The output.
	 * @param integer $depth The depth.
	 * @param [type]  $args The args.
	 * @return void
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth ); // don't output children closing tag.
	}

	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int    $depth  Depth of menu item. May be used for padding.
	 * @param  array  $args   Additional strings.
	 * @param  int    $id     Post ID.
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$url = '#' !== $item->url ? $item->url : '';
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$selected = in_array( 'current-menu-item', $classes, true ) ? 'selected="selected"' : '';
		$output .= '<option ' . $selected . ' value="' . $url . '">';
		$output .= $item->title;
	}

	/**
	 * End the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int    $depth  Depth of menu item. May be used for padding.
	 * @param  array  $args   Additional strings.
	 * @param  int    $id     Post ID.
	 * @return void
	 */
	public function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$output .= "</option>\n"; // replace closing </li> with the option tag.
	}
}
