<?php
/**
 * Breadcrumbs File
 *
 * @package wprig
 *
 * @return void
 */

if ( ! function_exists( 'wprig_breadcrumbs' ) ) :
	/**
	 * Display Post breadcrumbs when applicable.
	 *
	 * @since wprig 1.0
	 *
	 * @link: https://www.branded3.com/blog/creating-a-really-simple-breadcrumb-function-for-pages-in-wordpress/
	 */
	function wprig_breadcrumbs() {

		global $post;

		$output           = '';
		$breadcrumbs      = array();
		$separator        = '<span class="breadcrumb-separator">&raquo;</span>';
		$breadcrumb_id    = 'breadcrumbs';
		$breadcrumb_class = 'entry-meta';

		$page_title = '<span class="current">' . get_the_title( $post->ID ) . '</span>';
		$home_link  = '<a aria-label="' . esc_html__( 'Home', 'wprig' ) . '" title="' . esc_html__( 'Home', 'wprig' ) . '" class="breadcrumb-home" href="' . esc_url( home_url() ) . '"><i class="fa fa-home"></i></a>' . $separator;

		$output .= "<div aria-label='" . esc_html__( 'You are here:', 'wprig' ) . "' id='$breadcrumb_id' class='$breadcrumb_class'>";
		$output .= $home_link;

		if ( $post->post_parent ) {
			$parent_id = $post->post_parent;

			while ( $parent_id ) {
				$page          = get_page( $parent_id );
				$breadcrumbs[] = '<a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . get_the_title( $page->ID ) . '</a>';
				$parent_id     = $page->post_parent;
			}

			$breadcrumbs     = array_reverse( $breadcrumbs );
			$breadcrumbs_str = implode( $separator, $breadcrumbs );
			$output         .= $breadcrumbs_str . $separator;
		}

		$output .= $page_title;
		$output .= '</div>';

		echo wp_kses_post( $output );

	}

	endif;

/*
Old (Deprecated)
if ( ! function_exists( 'wprig_breadcrumbs' ) ) :
	/**
	 * Display Post breadcrumbs when applicable.
	 *
	 * @since wprig 1.0
	 *
	 * @link: https://www.thewebtaylor.com/articles/wordpress-creating-breadcrumbs-without-a-plugin

	function wprig_breadcrumbs() {

			if (!is_home()) {

					// Settings
					$separator          = '<span class="breadcrumb-separator">&raquo;</span>';
					$breadcrumb_id      = 'breadcrumbs';
					$breadcrumb_class   = 'breadcrumbs';
					$post               = get_post();

					if( is_category() || is_single() || ( is_page() && $post->post_parent ) ) {
					// Build the breadcrumbs
					echo "<div aria-label='You are here:' id='$breadcrumb_id' class='$breadcrumb_class'>";
			echo '<a aria-label="Home" title="Home" class="breadcrumb-home" href="';
			echo esc_url( home_url() );
			echo '"><span class="screen-reader-text">';
			bloginfo('name');
			echo "</span></a>$separator";

									$categories = get_the_category();
									$categories = array_slice( $categories, 0, 5 );

									foreach ( $categories as $category ) {
											printf( '<a href="%1$s">%2$s</a>',
													esc_url( get_category_link( $category->term_id ) ),
													esc_html( $category->name )
											);
											echo $separator;
									}

					echo '</div>';
					}
			}

	}
	endif;
*/
