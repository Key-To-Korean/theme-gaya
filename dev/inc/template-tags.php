<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wprig
 */

/**
 * Determine whether this is an AMP response.
 *
 * Note that this must only be called after the parse_query action.
 *
 * @link https://github.com/Automattic/amp-wp
 * @return bool Is AMP endpoint (and AMP plugin is active).
 */
function wprig_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

/**
 * Determine whether amp-live-list should be used for the comment list.
 *
 * @return bool Whether to use amp-live-list.
 */
function wprig_using_amp_live_list_comments() {
	if ( ! wprig_is_amp() ) {
		return false;
	}
	$amp_theme_support = get_theme_support( 'amp' );
	return ! empty( $amp_theme_support[0]['comments_live_list'] );
}

/**
 * Add pagination reference point attribute for amp-live-list when theme supports AMP.
 *
 * This is used by the navigation_markup_template filter in the comments template.
 *
 * @link https://www.ampproject.org/docs/reference/components/amp-live-list#pagination
 *
 * @param string $markup Navigation markup.
 * @return string Markup.
 */
function wprig_add_amp_live_list_pagination_attribute( $markup ) {
	return preg_replace( '/(\s*<[a-z0-9_-]+)/i', '$1 pagination ', $markup, 1 );
}

/**
 * Prints the header of the current displayed page based on its contents.
 */
function wprig_index_header() {
	if ( is_home() && ! is_front_page() ) {
		?>
		<header>
			<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
		</header>
		<?php
	} elseif ( is_date() ) {
		$year     = get_query_var( 'year' );
		$monthnum = get_query_var( 'monthnum' );
		$day      = get_query_var( 'day' );

		if ( is_day() ) {
			?>
			<header class="page-header">
				<h1 class="page-title">
					<?php esc_html_e( 'Published on this day:', 'wprig' ); ?>
					<span><?php echo esc_html( $GLOBALS['wp_locale']->get_month( $monthnum ) . ' ' . $day . ', ' . $year ); ?></span>
				</h1>
			</header>
			<?php
		} elseif ( is_month() ) {
			?>
			<header class="page-header">
				<h1 class="page-title">
					<?php esc_html_e( 'Published in this month:', 'wprig' ); ?>
					<span><?php echo esc_html( $GLOBALS['wp_locale']->get_month( $monthnum ) . ' ' . $year ); ?></span>
				</h1>
			</header>
			<?php
		} elseif ( is_year() ) {
			?>
			<header class="page-header">
				<h1 class="page-title">
					<?php esc_html_e( 'Published this year:', 'wprig' ); ?>
					<span><?php echo esc_html( $year ); ?></span>
				</h1>
			</header>
			<?php
		}
	} elseif ( is_search() ) {
		?>
		<header class="page-header">
			<h1 class="page-title">
			<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'wprig' ), '<span>' . get_search_query() . '</span>' );
			?>
			</h1>
		</header><!-- .page-header -->
		<?php
	} elseif ( is_author() ) {
		?>
		<header class="page-header">
			<?php
			$first_name = get_the_author_meta( 'first_name' );
			$last_name  = get_the_author_meta( 'last_name' );
			if ( empty( $first_name ) ) {
				$first_name = get_the_author_meta( 'display_name' );
			}

			if ( ! empty( $first_name ) ) {
				echo '<h1 class="page-title">Author:<span>' . esc_attr( $first_name ) . ' ' . esc_attr( $last_name ) . '</span></h1>';
			} else {
				?>
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Author: %s', 'wprig' ), '<span>' . esc_attr( the_archive_title() ) . '</span>' );
					?>
				</h1>
				<?php
			}
			?>
		</header><!-- .page-header -->
		<?php
	} elseif ( is_category() ) {
		?>
		<header class="page-header">
			<h1 class="page-title">
				<?php esc_attr_e( 'Category: ', 'wprig' ); ?>
				<span><?php the_archive_title(); ?></span>
			</h1>
			<?php
				the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->
		<?php
	} elseif ( is_tag() || is_tax() ) {
		?>
		<header class="page-header">
			<h1 class="page-title">
				<?php esc_attr_e( 'Keyword: ', 'wprig' ); ?>
				<span>#<?php the_archive_title(); ?></span>
			</h1>
			<?php
				the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->
		<?php
	} elseif ( is_404() ) {
		?>
		<header class="page-header">
			<h1 class="page-title">
				Whoops O_o
				<span>Nothing found</span>
			</h1>
		</header>
		<?php
	}
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
function wprig_posted_on() {

	// If updated.
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$updated = 'Updated: <time class="updated" datetime="%1$s">%2$s</time>';

		$updated = sprintf(
			$updated,
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date( 'M n, Y' ) )
		);

		$updated_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $updated . '</a>';

		echo '<span class="updated-on">' . $updated_on . ' </span>'; // WPCS: XSS OK.
	}

	$time_string = 'Published: <time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'M n, Y' ) )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	echo '<span class="posted-on">' . $posted_on . ' </span>'; // WPCS: XSS OK.

}

/**
 * Prints HTML with meta information for the current author.
 */
function wprig_posted_by() {
	$byline = '<a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>';

	echo '<span class="byline author vcard"> ' . $byline . ' </span>'; // WPCS: XSS OK.
}

/**
 * Prints a link list of the current categories for the post.
 *
 * If additional post types should display categories, add them to the conditional statement at the top.
 */
function wprig_post_categories() {
	// Only show categories on post types that have categories.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the bullet point */
		$categories_list = get_the_category_list( esc_html__( ' &bull; ', 'wprig' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			echo '<span class="cat-links">' . wp_kses_post( $categories_list ) . ' </span>';
		}
	}
}

/**
 * Prints a link list of the current tags for the post.
 *
 * If additional post types should display tags, add them to the conditional statement at the top.
 */
function wprig_post_tags() {
	// Only show tags on post types that have categories.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '' );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			echo '<span class="tags-links">' . wp_kses_post( $tags_list ) . ' </span>';
		}
	}
}

/**
 * Prints comments link when comments are enabled.
 */
function wprig_comments_link() {
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'wprig' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo ' </span>';
	}
}

/**
 * Prints edit post/page link when a user with sufficient priveleges is logged in.
 */
function wprig_edit_post_link() {
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'wprig' ),
				array(
					'span' => array(
						'class' => array( 'btn' ),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>',
		get_the_ID(),
		'btn post-edit-link'
	);
}

/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function wprig_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>

		<div class="post-thumbnail">
			<?php the_post_thumbnail( 'full', array( 'class' => 'skip-lazy' ) ); ?>
		</div><!-- .post-thumbnail -->

		<?php
	else :
		?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
			global $wp_query;
			if ( 0 === $wp_query->current_post ) {
				the_post_thumbnail(
					'full',
					array(
						'class' => 'skip-lazy',
						'alt'   => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
			} else {
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
			}
			?>
		</a>

		<?php
	endif; // End is_singular().
}

/**
 * Prints HTML with title and link to original post where attachment was added.
 *
 * @param object $post object.
 */
function wprig_attachment_in( $post ) {
	if ( ! empty( $post->post_parent ) ) :
		$postlink = sprintf(
			/* translators: %s: original post where attachment was added. */
			esc_html_x( 'in %s', 'original post', 'wprig' ),
			'<a href="' . esc_url( get_permalink( $post->post_parent ) ) . '">' . esc_html( get_the_title( $post->post_parent ) ) . '</a>'
		);

		echo '<span class="attachment-in"> ' . $postlink . ' </span>'; // WPCS: XSS OK.

	endif;

}

/**
 * Prints HTML with for navigation to previous and next attachment if available.
 */
function wprig_the_attachment_navigation() {
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php echo esc_html__( 'Post navigation', 'wprig' ); ?></h2>
		<div class="nav-links">
			<div class="nav-previous">
				<div class="post-navigation-sub">
					<?php echo esc_html__( 'Previous attachment:', 'wprig' ); ?>
				</div>
				<?php previous_image_link( false ); ?>
			</div><!-- .nav-previous -->
			<div class="nav-next">
				<div class="post-navigation-sub">
					<?php echo esc_html__( 'Next attachment:', 'wprig' ); ?>
				</div>
				<?php next_image_link( false ); ?>
			</div><!-- .nav-next -->
		</div><!-- .nav-links -->
	</nav><!-- .navigation .attachment-navigation -->
	<?php
}

/**
 * Get the Excerpt for Post Navigation
 *
 * Needs to use setup_postdata(); for Posts without defined Excerpts
 *
 * @param int $post_id The ID of the Post.
 *
 * @link https://developer.wordpress.org/reference/functions/get_the_excerpt/
 */
function wprig_get_the_excerpt( $post_id = null ) {
	if ( empty( $post_id ) ) {
		$excerpt = '';
	} else {
		setup_postdata( $post_id );
		$excerpt = get_the_excerpt( $post_id );
		wp_reset_postdata();
	}
	return $excerpt;
}

/**
 * Create a Child Pages menu for a Parent Page.
 *
 * @source
 */
function wprig_child_pages() {
	global $post;

	if ( is_page() && $post->post_parent ) {
		$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
	} else {
		$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
	}

	if ( $childpages ) {
		echo '<ul class="child-page-menu">' . wp_kses_post( $childpages ) . '</ul>';
	}
}

/**
 * Custom function to get the post thumbnail, or AN image and set it for archive pages
 */
function wprig_archive_thumbnails() {
	/* Grab AN img URL to set as the background of the section */
	if ( has_post_thumbnail() ) {
		$img_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
	} elseif ( '' !== wprig_get_the_first_image_url( 'large-thumb' ) ) {
		$img_url = wprig_get_the_first_image_url( 'large-thumb' );

		/*
		Header Image
		elseif ( has_header_image() )
		$img_url = get_header_image();
		*/
	} else {
		$img_url = wprig_placeholder_image_url();
	}
	?>

	<div class="post-thumbnail" style="background-image: url( <?php echo esc_url( $img_url ); ?> ), -webkit-gradient(linear,left top,left bottom,from(#00bfa5),to(#00897b)), linear-gradient(180deg,#00bfa5,#00897b);">
		<a class="post-thumbnail-link" href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
		<?php wprig_edit_post_link(); ?>
		</a>
	</div>
	<?php
}

/**
 * Custom function to return a placeholder image URL
 */
function wprig_placeholder_image_url() {
	return get_home_url() . '/wp-content/themes/gaya/images/korean-pattern-lg.svg';
}

/**
 * Header Flash Section
 */
function wprig_header_flash() {
	?>
	<!-- Top "News Flash" type section -->
	<div class="header-flash <?php echo esc_attr( $header_img_class ); ?>">
		<div class="header-contact">
			<?php $wprig_description = get_bloginfo( 'description', 'display' ); ?>
			<?php if ( $wprig_description || is_customize_preview() ) : ?>
				<p class="site-description"><?php echo $wprig_description; /* WPCS: xss ok. */ ?></p>
			<?php endif; ?>

			<?php
				$header_text1 = get_theme_mod( 'header_text1' );
				$header_text2 = get_theme_mod( 'header_text2' );
				$header_text3 = get_theme_mod( 'header_text3' );

			if ( $header_text1 || $header_text2 || $header_text3 ) :
				?>
				<ul class="header-info">
					<?php
						echo wp_kses_post( $header_text1 ? "<li class='header-text-one'>$header_text1</li>" : '' );
						echo wp_kses_post( $header_text2 ? "<li class='header-text-two'>$header_text2</li>" : '' );
						echo wp_kses_post( $header_text3 ? "<li class='header-text-three'>$header_text3</li>" : '' );
					?>
				</ul>
				<?php
				endif;
			?>

			<div class="position-right">
				<?php
				require_once get_template_directory() . '/inc/class-nav-menu-dropdown.php';

				if ( has_nav_menu( 'quicklinks' ) ) :
					wp_nav_menu(
						array(
							'theme_location' => 'quicklinks',
							'menu_id'        => 'quicklinks-menu',
							'walker'         => new Wprig_Nav_Menu_Dropdown(),
							'items_wrap'     => '<div class="mobile-menu"><form><select onchange="if (this.value) window.location.href=this.value">%3$s</select></form></div>',
						)
					);
				endif;
				?>
			</div>

		</div><!-- .header-contact -->
	</div><!-- .header-flash -->
	<?php
}
