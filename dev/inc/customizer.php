<?php
/**
 * WP Rig Theme Customizer
 *
 * @package wprig
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wprig_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'wprig_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'wprig_customize_partial_blogdescription',
			)
		);
	}

	/**
	 * Theme options.
	 */
	$wp_customize->add_section(
		'theme_options',
		array(
			'title'    => __( 'Theme Options', 'wprig' ),
			'priority' => 130, // Before Additional CSS.
		)
	);

	if ( function_exists( 'wprig_lazyload_images' ) ) {
		$wp_customize->add_setting(
			'lazy_load_media',
			array(
				'default'           => 'lazyload',
				'sanitize_callback' => 'wprig_sanitize_lazy_load_media',
				'transport'         => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'lazy_load_media',
			array(
				'label'       => __( 'Lazy-load images', 'wprig' ),
				'section'     => 'theme_options',
				'type'        => 'radio',
				'description' => __( 'Lazy-loading images means images are loaded only when they are in view. Improves performance, but can result in content jumping around on slower connections.', 'wprig' ),
				'choices'     => array(
					'lazyload'    => __( 'Lazy-load on (default)', 'wprig' ),
					'no-lazyload' => __( 'Lazy-load off', 'wprig' ),
				),
			)
		);
	}

	/**
	 * Custom Customizer functions
	 */
	$wp_customize->get_section( 'header_image' )->title     = __( 'Header and Footer', 'wprig' );
	$wp_customize->get_section( 'background_image' )->title = __( 'Site Images', 'wprig' );

				/*
				 * Custom Customizer Customizations
				 * #1: Settings, #2: Controls
				 */

				/**
				 * Default Post Thumbnail
				 */
				$wp_customize->add_setting(
					'default_post_thumbnail',
					array(
						'priority'          => 10,
						'sanitize_callback' => 'wprig_sanitize_upload',
					)
				);

				$wp_customize->add_control(
					new WP_Customize_Image_Control(
						$wp_customize,
						'default_post_thumbnail',
						array(
							'section'     => 'background_image',
							'label'       => __( 'Default Post Thumbnail', 'wprig' ),
							'description' => __( 'If set, this image will be set as the Featured Image for any Post without one (it will appear only on Category and Archive pages).', 'wprig' ),
						)
					)
				);

				/**
				 * 404 Image
				 */
				$wp_customize->add_setting(
					'image_404',
					array(
						'priority'          => 10,
						'sanitize_callback' => 'wprig_sanitize_upload',
					)
				);

				$wp_customize->add_control(
					new WP_Customize_Image_Control(
						$wp_customize,
						'image_404',
						array(
							'section'     => 'background_image',
							'label'       => __( '404 Error Image', 'wprig' ),
							'description' => __( 'This image will be displayed at the top of any 404 Error pages.', 'wprig' ),
						)
					)
				);

				/**
				 * Dark Logo
				 */
				$wp_customize->add_setting(
					'dark_logo',
					array(
						'priority'          => 10,
						'sanitize_callback' => 'wprig_sanitize_upload',
					)
				);

				$wp_customize->add_control(
					new WP_Customize_Image_Control(
						$wp_customize,
						'dark_logo',
						array(
							'section'     => 'title_tagline',
							'label'       => __( '(Optional) Dark Logo', 'wprig' ),
							'description' => __( 'Add a darker version of your logo that will look good on a light background.', 'wprig' ),
						)
					)
				);

				/**
				 * Extended Blog Description
				 */
				$wp_customize->add_setting(
					'blogdescription_xl',
					array(
						'default'           => '',
						'sanitize_callback' => 'wprig_sanitize_html',
						'priority'          => 20,
					)
				);

				$wp_customize->add_control(
					'blogdescription_xl',
					array(
						'type'        => 'text',
						'section'     => 'title_tagline',
						'label'       => __( 'Extended Blog Description', 'wprig' ),
						'description' => __( 'You can put a descriptive paragraph here (HTML links are OK).', 'wprig' ),
					)
				);

				/* ///////////////// HEADER TEXT AREAS ////////////////// */
				/**
				 * Header Text 1
				 */
				$wp_customize->add_setting(
					'header_text1',
					array(
						'default'           => '',
						'sanitize_callback' => 'wprig_sanitize_html',
					)
				);

				$wp_customize->add_control(
					'header_text1',
					array(
						'type'        => 'text',
						'section'     => 'header_image',
						'label'       => __( 'Header Text 1', 'wprig' ),
						'description' => __( 'A good place to put your address (or tagline/motto).', 'wprig' ),
					)
				);

				/**
				 * Header Text 2
				 */
				$wp_customize->add_setting(
					'header_text2',
					array(
						'default'           => '',
						'sanitize_callback' => 'wprig_sanitize_html',
					)
				);

				$wp_customize->add_control(
					'header_text2',
					array(
						'type'        => 'text',
						'section'     => 'header_image',
						'label'       => __( 'Header Text 2', 'wprig' ),
						'description' => __( 'A good place to put your phone number.', 'wprig' ),
					)
				);

				/**
				 * Header Text 3
				 */
				$wp_customize->add_setting(
					'header_text3',
					array(
						'default'           => '',
						'sanitize_callback' => 'wprig_sanitize_html',
					)
				);

				$wp_customize->add_control(
					'header_text3',
					array(
						'type'        => 'text',
						'section'     => 'header_image',
						'label'       => __( 'Header Text 3', 'wprig' ),
						'description' => __( 'A good place to put your contact email (HTML links are OK).', 'wprig' ),
					)
				);

				/*
				///////////////// GRADIENT //////////////////
				*/

				/*
				 * Gradient Color #1
				 * (Interactive Color #1)
				 */
				$wp_customize->add_setting(
					'grad1_color',
					array(
						'default'           => 'rgba(81, 207, 102, 0.8)', // wprig green.
						'type'              => 'theme_mod',
						'sanitize_callback' => 'wprig_sanitize_rgba_color',
						'transport'         => 'postMessage',
					)
				);

				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						'grad1_color',
						array(
							'label'       => __( 'Interactive Color #1', 'wprig' ),
							'description' => __( 'Set the first interactive color. This color controls the LEFT gradient, links, and sidebar borders.', 'wprig' ),
							'section'     => 'colors',
						)
					)
				);

				/*
				 * Gradient Color #2
				 * (Interactive Color #2)
				 */

				$wp_customize->add_setting(
					'grad2_color',
					array(
						'default'           => 'rgba(50, 154, 240, 0.8)', // wprig blue.
						'type'              => 'theme_mod',
						'sanitize_callback' => 'wprig_sanitize_rgba_color',
						'transport'         => 'postMessage',
					)
				);

				$wp_customize->add_control(
					new WP_Customize_Color_Control(
						$wp_customize,
						'grad2_color',
						array(
							'label'       => __( 'Interactive Color #2', 'wprig' ),
							'description' => __( 'Set the second interactive color. This color controls the RIGHT gradient, footer background, and search and sidebar buttons.', 'wprig' ),
							'section'     => 'colors',
						)
					)
				);

				/**
				 * Show Post Word Count / Reading Time
				 */
				$wp_customize->add_setting(
					'wprig_display_reading_time',
					array(
						'default'           => 1,
						'sanitize_callback' => 'wprig_sanitize_checkbox',
					)
				);

				$wp_customize->add_control(
					'wprig_display_reading_time',
					array(
						'label'   => esc_html__( 'Display estimated reading time on posts', 'wprig' ),
						'section' => 'theme_options',
						'type'    => 'checkbox',
					)
				);

				/**
				 * Show Theme Info
				 */
				$wp_customize->add_setting(
					'show_theme_info',
					array(
						'default'           => 1,
						'sanitize_callback' => 'wprig_sanitize_checkbox',
					)
				);

				$wp_customize->add_control(
					'show_theme_info',
					array(
						'label'   => __( 'Show theme info in Footer?', 'wprig' ),
						'type'    => 'checkbox',
						'section' => 'theme_options',
					)
				);

				/**
				 * Show Copyright Date
				 */
				$wp_customize->add_setting(
					'show_copyright',
					array(
						'default'           => 1,
						'sanitize_callback' => 'wprig_sanitize_checkbox',
					)
				);

				$wp_customize->add_control(
					'show_copyright',
					array(
						'label'   => __( 'Show copyright dates in Footer?', 'wprig' ),
						'type'    => 'checkbox',
						'section' => 'theme_options',
					)
				);

	/**
	 * Login Section options
	$wp_customize->add_section(
		'login_options',
		array(
			'title' => __( 'Login Options', 'marsxi' ),
		)
	);
	*/

	$wp_customize->add_setting(
		'show_login_button',
		array(
			'default'           => true,
			'sanitize_callback' => 'marsxi_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'show_login_button',
		array(
			'type'    => 'checkbox',
			'section' => 'theme_options',
			'label'   => __( 'Show Login button in Top Menu?', 'marsxi' ),
		)
	);
}
add_action( 'customize_register', 'wprig_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function wprig_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function wprig_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wprig_customize_preview_js() {
	wp_enqueue_script( 'wprig-customizer', get_theme_file_uri( '/js/customizer.js' ), array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'wprig_customize_preview_js' );

/**
 * Sanitize the lazy-load media options.
 *
 * @param string $input Lazy-load setting.
 */
function wprig_sanitize_lazy_load_media( $input ) {
	$valid = array(
		'lazyload' => __( 'Lazy-load images', 'wprig' ),
		'no-lazyload' => __( 'Load images immediately', 'wprig' ),
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	}

	return '';
}

/**
 * Sanitize HTML
 *
 * @param string $input The HTML to sanitize.
 */
function wprig_sanitize_html( $input ) {
	return wp_kses_post( force_balance_tags( $input ), array( 'a' => array( 'href' => array() ) ) );
}

/**
 * Sanitize the checkbox.
 *
 * @param int $input The checkbox to sanitize.
 * @return boolean|string
 */
function wprig_sanitize_checkbox( $input ) {
	return ( 1 === $input ) ? 1 : '';
}
