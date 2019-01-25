<?php
/**
 * WP Rig functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wprig
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wprig_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on wprig, use a find and replace
		* to change 'wprig' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'wprig', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	/*
	 * Add Excerpts to Pages
	 */
	add_post_type_support( 'page', 'excerpt' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary', 'wprig' ),
			'quicklinks' => esc_html__( 'Quicklinks', 'wprig' ),
			'social'  => esc_html__( 'Social', 'wprig' ),
			'footer'  => esc_html__( 'Footer', 'wprig' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',    // style needed
		'status',   // style needed
		'quote',    // style needed
		'link',     // style needed
		'image',    // style needed
		'gallery',  // style needed
		'video',    // style needed
		'audio',    // style needed
		'chat',     // style needed	
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background', apply_filters(
			'wprig_custom_background_args', array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo', array(
			'height'      => 80,
			'width'       => 240,
			'flex-width'  => true,
			'flex-height' => false,
		)
	);

	/**
	 * Add support for wide aligments.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
	 */
	add_theme_support( 'align-wide' );

	/**
	 * Add support for block color palettes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
	 */
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Dusty orange', 'wprig' ),
			'slug'  => 'dusty-orange',
			'color' => '#ed8f5b',
		),
		array(
			'name'  => __( 'Dusty red', 'wprig' ),
			'slug'  => 'dusty-red',
			'color' => '#e36d60',
		),
		array(
			'name'  => __( 'Dusty wine', 'wprig' ),
			'slug'  => 'dusty-wine',
			'color' => '#9c4368',
		),
		array(
			'name'  => __( 'Dark sunset', 'wprig' ),
			'slug'  => 'dark-sunset',
			'color' => '#33223b',
		),
		array(
			'name'  => __( 'Almost black', 'wprig' ),
			'slug'  => 'almost-black',
			'color' => '#0a1c28',
		),
		array(
			'name'  => __( 'Dusty water', 'wprig' ),
			'slug'  => 'dusty-water',
			'color' => '#41848f',
		),
		array(
			'name'  => __( 'Dusty sky', 'wprig' ),
			'slug'  => 'dusty-sky',
			'color' => '#72a7a3',
		),
		array(
			'name'  => __( 'Dusty daylight', 'wprig' ),
			'slug'  => 'dusty-daylight',
			'color' => '#97c0b7',
		),
		array(
			'name'  => __( 'Dusty sun', 'wprig' ),
			'slug'  => 'dusty-sun',
			'color' => '#eee9d1',
		),
	) );

	/**
	 * Optional: Disable custom colors in block color palettes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
	 *
	 * add_theme_support( 'disable-custom-colors' );
	 */

	/**
	 * Add support for font sizes.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
	 */
	add_theme_support( 'editor-font-sizes', array(
		array(
			'name'      => __( 'small', 'wprig' ),
			'shortName' => __( 'S', 'wprig' ),
			'size'      => 16,
			'slug'      => 'small',
		),
		array(
			'name'      => __( 'regular', 'wprig' ),
			'shortName' => __( 'M', 'wprig' ),
			'size'      => 20,
			'slug'      => 'regular',
		),
		array(
			'name'      => __( 'large', 'wprig' ),
			'shortName' => __( 'L', 'wprig' ),
			'size'      => 36,
			'slug'      => 'large',
		),
		array(
			'name'      => __( 'larger', 'wprig' ),
			'shortName' => __( 'XL', 'wprig' ),
			'size'      => 48,
			'slug'      => 'larger',
		),
	) );

	/**
	 * Optional: Add AMP support.
	 *
	 * Add built-in support for the AMP plugin and specific AMP features.
	 * Control how the plugin, when activated, impacts the theme.
	 *
	 * @link https://wordpress.org/plugins/amp/
	 */
	add_theme_support( 'amp', array(
		'comments_live_list' => true,
	) );

}
add_action( 'after_setup_theme', 'wprig_setup' );

/**
 * Set the embed width in pixels, based on the theme's design and stylesheet.
 *
 * @param array $dimensions An array of embed width and height values in pixels (in that order).
 * @return array
 */
function wprig_embed_dimensions( array $dimensions ) {
	$dimensions['width'] = 720;
	return $dimensions;
}
add_filter( 'embed_defaults', 'wprig_embed_dimensions' );

/**
 * Register Google Fonts
 */
function wprig_fonts_url() {
	$fonts_url = '';

	/**
	 * Translator: If Noto Sans does not support characters in your language, translate this to 'off'.
	 */
	$noto_sans = esc_html_x( 'on', 'Noto Sans font: on or off', 'wprig' );
	/**
	 * Translator: If Nanum Gothic does not support characters in your language, translate this to 'off'.
	 */
	$nanum_gothic = esc_html_x( 'on', 'Nanum Gothic font: on or off', 'wprig' );
	/**
	 * Translator: If Satisfy does not support characters in your language, translate this to 'off'.
	 */
	$satisfy = esc_html_x( 'on', 'Satisfy font: on or off', 'wprig' );
	

	$font_families = array();

	if ( 'off' !== $noto_sans ) {
		$font_families[] = 'Noto Sans:400,400i,700,700i';
	}

	if ( 'off' !== $nanum_gothic ) {
		$font_families[] = 'Nanum Gothic:400,700,800';
	}

	if ( 'off' !== $satisfy ) {
		$font_families[] = 'Satisfy';
	}


	if ( in_array( 'on', array( $noto_sans, $nanum_gothic, $satisfy ) ) ) {
		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext,korean' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );

}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function wprig_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'wprig-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'wprig_resource_hints', 10, 2 );

/**
 * Enqueue WordPress theme styles within Gutenberg.
 */
function wprig_gutenberg_styles() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'wprig-fonts', wprig_fonts_url(), array(), null );

	// Enqueue main stylesheet.
	wp_enqueue_style( 'wprig-base-style', get_theme_file_uri( '/css/editor-styles.css' ), array(), '20180514' );
}
add_action( 'enqueue_block_editor_assets', 'wprig_gutenberg_styles' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wprig_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wprig' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'wprig' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets Top', 'wprig' ),
		'description'   => esc_html__( 'Widgets appearing in the top of the footer of the site.', 'wprig' ),
		'id'            => 'sidebar-footer-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets Bottom', 'wprig' ),
		'description'   => esc_html__( 'Widgets appearing in the bottom of the footer of the site.', 'wprig' ),
		'id'            => 'sidebar-footer-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Ad Above Header', 'wprig' ),
		'description'   => esc_html__( 'Space for an ad above the header.', 'wprig' ),
		'id'            => 'widget-ad-header',
		'before_widget' => '<aside id="%1$s" class="widget %2$s widget-over-header">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="section-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Ad Above Post', 'wprig' ),
		'description'   => esc_html__( 'Space for an ad above the Post or Page content.', 'wprig' ),
		'id'            => 'widget-ad-pre-post',
		'before_widget' => '<aside id="%1$s" class="widget %2$s widget-pre-post">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="section-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Ad After Post', 'wprig' ),
		'description'   => esc_html__( 'Space for an ad after the Post or Page content.', 'wprig' ),
		'id'            => 'widget-ad-post-post',
		'before_widget' => '<aside id="%1$s" class="widget %2$s widget-post-post">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="section-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Ad Post Bottom', 'wprig' ),
		'description'   => esc_html__( 'Space for an ad at the bottom of the Post or Page.', 'wprig' ),
		'id'            => 'widget-ad-post-bottom',
		'before_widget' => '<aside id="%1$s" class="widget %2$s widget-post-bottom">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="section-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Ad Fixed Footer', 'wprig' ),
		'description'   => esc_html__( 'Space for an an in a fixed (disappearing) footer at the bottom of the Post or Page.', 'wprig' ),
		'id'            => 'widget-ad-fixed-footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s widget-fixed-bottom">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="section-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'wprig_widgets_init' );

/**
 * Enqueue styles.
 */
function wprig_styles() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'wprig-fonts', wprig_fonts_url(), array(), null );
	wp_enqueue_style( 'wprig-noto-sans-kr', 'https://fonts.googleapis.com/earlyaccess/notosanskr.css', array(), '20180810' );
	wp_enqueue_style( 'wprig-fa', 'https://use.fontawesome.com/releases/v5.2.0/css/all.css' );

	// Enqueue main stylesheet.
	wp_enqueue_style( 'wprig-base-style', get_stylesheet_uri(), array(), '20180514' );

	// Register component styles that are printed as needed.
	wp_register_style( 'wprig-comments', get_theme_file_uri( '/css/comments.css' ), array(), '20180514' );
	wp_register_style( 'wprig-content', get_theme_file_uri( '/css/content.css' ), array(), '20180514' );
	wp_register_style( 'wprig-sidebar', get_theme_file_uri( '/css/sidebar.css' ), array(), '20180514' );
	wp_register_style( 'wprig-widgets', get_theme_file_uri( '/css/widgets.css' ), array(), '20180514' );
	wp_register_style( 'wprig-front-page', get_theme_file_uri( '/css/front-page.css' ), array(), '20180514' );
	wp_register_style( 'wprig-adsense', get_theme_file_uri( '/css/adsense.css' ), array(), '20180822' );

	// Enqueue Slick slider
	wp_enqueue_style( 'wprig-slick-slider', get_template_directory_uri() . '/slick/slick.css' );
	wp_enqueue_style( 'wprig-slick-theme', get_template_directory_uri() . '/slick/slick-theme.css' );
}
add_action( 'wp_enqueue_scripts', 'wprig_styles' );

/**
 * Enqueue scripts.
 */
function wprig_scripts() {

	// If the AMP plugin is active, return early.
	if ( wprig_is_amp() ) {
		return;
	}

	// Enqueue the main theme JS functions file.
	wp_enqueue_script( 'wprig-functions', get_theme_file_uri( '/js/functions.js' ), array( 'jquery' ), '20180811', false );
	wp_script_add_data( 'wprig-functions', 'async', true );

	// Enqueue the navigation script.
	wp_enqueue_script( 'wprig-navigation', get_theme_file_uri( '/js/navigation.js' ), array(), '20180514', false );
	wp_script_add_data( 'wprig-navigation', 'async', true );
	wp_localize_script( 'wprig-navigation', 'wprigScreenReaderText', array(
		'expand'   => __( 'Expand child menu', 'wprig' ),
		'collapse' => __( 'Collapse child menu', 'wprig' ),
	));

	// Enqueue skip-link-focus script.
	wp_enqueue_script( 'wprig-skip-link-focus-fix', get_theme_file_uri( '/js/skip-link-focus-fix.js' ), array(), '20180514', false );
	wp_script_add_data( 'wprig-skip-link-focus-fix', 'defer', true );

	// Enqueue comment script on singular post/page views only.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Enqueue Slick Slider JS.
	wp_enqueue_script( 'wprig-slick-js', get_template_directory_uri() . '/slick/slick.min.js', array( 'jquery' ), '20150212', true );

}
add_action( 'wp_enqueue_scripts', 'wprig_scripts' );

/**
 * Remove Jetpack Sharedaddy Sharing and Jetpack Likes from post excerpts 
 */
function remove_sharedaddy_excerpt_sharing() {
	 remove_filter( 'the_excerpt', 'sharing_display', 19 );
	 if ( class_exists( 'Jetpack_Likes' ) ) {
			remove_filter( 'the_excerpt', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
		}
}
add_action( 'init', 'remove_sharedaddy_excerpt_sharing', 20 );
add_action( 'loop_start', 'remove_sharedaddy_excerpt_sharing' );

/**
 * Add Custom Logo to Login Screen 
 * @source https://developer.wordpress.org/reference/functions/the_custom_logo/
 */
function wprig_filter_login_head() {
	if ( has_custom_logo() ) :
		$image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' );
		?>
		<style type="text/css">
			.login h1 a {
				background-image: url(<?php echo esc_url( $image[0] ); ?>);
				-webkit-background-size: <?php echo absint( $image[1] )?>px;
				background-size: <?php echo absint( $image[1] ) ?>px;
				height: <?php echo absint( $image[2] ) ?>px;
				width: <?php echo absint( $image[1] ) ?>px;
			}
		</style>
		<?php
	endif;
}
add_action( 'login_head', 'wprig_filter_login_head', 100 );

/**
 * Custom responsive image sizes.
 */
require get_template_directory() . '/inc/image-sizes.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/pluggable/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Load SVG icon functions.
 */
require get_template_directory() . '/inc/icon-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Pluggable: Add theme support for lazyloading images.
 *
 * @link https://developers.google.com/web/fundamentals/performance/lazy-loading-guidance/images-and-video/
 */
require get_template_directory() . '/pluggable/lazyload/lazyload.php';

/**
 * Pluggable: Ad Placeholders
 */
require get_template_directory() . '/pluggable/ad-placeholders.php';

/**
 * Pluggable: Better Widgets
 */
require get_template_directory() . '/pluggable/better-widgets/archives.php';
require get_template_directory() . '/pluggable/better-widgets/recent-comments.php';
require get_template_directory() . '/pluggable/better-widgets/recent-posts.php';
require get_template_directory() . '/pluggable/better-widgets/subscribe.php';

/**
 * Pluggable: Post Format Functions
 */
require get_template_directory() . '/pluggable/post-formats/aside.php';
require get_template_directory() . '/pluggable/post-formats/audio.php';
require get_template_directory() . '/pluggable/post-formats/gallery.php';
require get_template_directory() . '/pluggable/post-formats/link.php';
require get_template_directory() . '/pluggable/post-formats/quote.php';
require get_template_directory() . '/pluggable/post-formats/video.php';

/**
 * Pluggable: Better Excerpts
 */
require get_template_directory() . '/pluggable/better-excerpts.php';

/**
 * Pluggable: Author Box
 */
require get_template_directory() . '/pluggable/author-box.php';

/**
 * Pluggable: Dynamic Footer
 */
require get_template_directory() . '/pluggable/dynamic-footer.php';

/**
 * Pluggable: Breadcrumbs
 */
require get_template_directory() . '/pluggable/breadcrumbs.php';

/**
 * Pluggable: Featured Posts (Stickies on Front Page)
 */
require get_template_directory() . '/pluggable/featured-posts.php';

/**
 * Pluggable: Post Functions (Word Count, etc)
 */
require get_template_directory() . '/pluggable/post-functions.php';

/**
 * Pluggable: Social Menu
 */
require get_template_directory() . '/pluggable/social-menu.php';

/**
 * Pluggable: Pseduo Jetpack Related Posts
 */
require get_template_directory() . '/pluggable/related-posts.php';

/**
 * Optional: Adds Link Section and Links Widget back into WordPress
 */
add_filter( 'pre_option_link_manager_enabled', '__return_true' ); 

/**
 * DEV ONLY!!
 * @TODO remove function & file before production
 */
require get_template_directory() . '/inc/developer-functions.php';