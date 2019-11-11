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

	$wp_customize->get_section( 'header_image' )->title     = __( 'Header and Footer', 'wprig' );
	$wp_customize->get_section( 'background_image' )->title = __( 'Site Images', 'wprig' );

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
	 * Dismissable Site Notice.
	 */
	$wp_customize->add_section(
		'wprig_site_notice',
		array(
			'title'    => __( 'Site Notice', 'wprig' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'site_notice_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses_post',
		)
	);

	$wp_customize->add_control(
		'site_notice_text',
		array(
			'type'    => 'text',
			'section' => 'wprig_site_notice',
			'label'   => __( 'Site notice text', 'wprig' ),
		)
	);

	$wp_customize->add_setting(
		'site_notice_bg',
		array(
			'default'           => 'rgba(207, 128, 49, 1)', // wprig green.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_notice_bg',
			array(
				'label'   => __( 'Site Notice background color', 'wprig' ),
				// 'description' => __( 'Set the background color for the site notice.', 'wprig' ),
				'section' => 'wprig_site_notice',
			)
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
			'section' => 'header_image',
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
			'section' => 'header_image',
		)
	);

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
	 ******************** COLORS ********************
	 */

	/**
	 * Interactive Color
	 */
	$wp_customize->add_setting(
		'interactive_color',
		array(
			'default'           => 'rgba(207, 128, 49, 1)', // wprig gold - lower-right.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'interactive_color',
			array(
				'label'       => __( 'Interactive Color', 'wprig' ),
				'description' => __( 'Color for site links and other interactive colors.', 'wprig' ),
				// 'description' => __( 'Set the second interactive color. This color controls the RIGHT gradient, footer background, and search and sidebar buttons.', 'wprig' ),
				'section'     => 'colors',
			)
		)
	);

	/**
	 * Gradient Color #1 (Main Gradient)
	 */
	$wp_customize->add_setting(
		'grad_1a_color',
		array(
			'default'           => 'rgba(0, 191, 165, 1)', // wprig green - upper-left.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_1a_color',
			array(
				'label'       => __( 'Main Gradient', 'wprig' ),
				'description' => __( 'Controls the upper-left to lower-right site gradients (header, footer, etc).', 'wprig' ),
				// 'description' => __( 'Set the first interactive color. This color controls the LEFT gradient, links, and sidebar borders.', 'wprig' ),
				'section'     => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'grad_1b_color',
		array(
			'default'           => 'rgba(0, 137, 123, 1)', // wprig dark green - lower-right.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_1b_color',
			array(
				// 'label'       => __( 'Gradient Color #2', 'wprig' ),
				// 'description' => __( 'The lower-right gradient color.', 'wprig' ),
				// 'description' => __( 'Set the second interactive color. This color controls the RIGHT gradient, footer background, and search and sidebar buttons.', 'wprig' ),
				'section'     => 'colors',
			)
		)
	);

	/**
	 * Gradient Color #2
	 */
	$wp_customize->add_setting(
		'grad_2a_color',
		array(
			'default'           => 'rgba(255, 171, 0, 1)', // wprig amber - upper-left.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_2a_color',
			array(
				'label'       => __( 'Gradient #2', 'wprig' ),
				'description' => __( 'Controls the second gradient.', 'wprig' ),
				'section'     => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'grad_2b_color',
		array(
			'default'           => 'rgba(255, 143, 0, 1)', // wprig dark amber - lower-right.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_2b_color',
			array(
				'section' => 'colors',
			)
		)
	);

	/**
	 * Gradient Color #3
	 */
	$wp_customize->add_setting(
		'grad_3a_color',
		array(
			'default'           => 'rgba(255, 64, 129, 1)', // wprig pink.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_3a_color',
			array(
				'label'       => __( 'Gradient #3', 'wprig' ),
				'description' => __( 'Controls the third gradient.', 'wprig' ),
				'section'     => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'grad_3b_color',
		array(
			'default'           => 'rgba(233, 30, 99, 1)', // wprig dark pink.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_3b_color',
			array(
				'section' => 'colors',
			)
		)
	);

	/**
	 * Gradient Color #4
	 */
	$wp_customize->add_setting(
		'grad_4a_color',
		array(
			'default'           => 'rgba(224, 64, 251, 1)', // wprig purple.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_4a_color',
			array(
				'label'       => __( 'Gradient #4', 'wprig' ),
				'description' => __( 'Controls the fourth gradient.', 'wprig' ),
				'section'     => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'grad_4b_color',
		array(
			'default'           => 'rgba(156, 39, 176, 1)', // wprig dark purple.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_4b_color',
			array(
				'section' => 'colors',
			)
		)
	);

	/**
	 * Gradient Color #5
	 */
	$wp_customize->add_setting(
		'grad_5a_color',
		array(
			'default'           => 'rgba(0, 176, 255, 1)', // wprig blue.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_5a_color',
			array(
				'label'       => __( 'Gradient #5', 'wprig' ),
				'description' => __( 'Controls the fifth gradient.', 'wprig' ),
				'section'     => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'grad_5b_color',
		array(
			'default'           => 'rgba(2, 119, 189, 1)', // wprig dark blue.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_5b_color',
			array(
				'section' => 'colors',
			)
		)
	);

	/**
	 * Gradient Color #6
	 */
	$wp_customize->add_setting(
		'grad_6a_color',
		array(
			'default'           => 'rgba(169, 186, 201, 1)', // wprig silver.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_6a_color',
			array(
				'label'       => __( 'Gradient #6', 'wprig' ),
				'description' => __( 'Controls the sixth gradient.', 'wprig' ),
				'section'     => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'grad_6b_color',
		array(
			'default'           => 'rgba(135, 149, 161, 1)', // wprig dark silver.
			'type'              => 'theme_mod',
			'sanitize_callback' => 'wprig_sanitize_rgba_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'grad_6b_color',
			array(
				'section' => 'colors',
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
			'label'   => esc_html__( 'Display estimated reading time on posts?', 'wprig' ),
			'section' => 'theme_options',
			'type'    => 'checkbox',
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
		'lazyload'    => __( 'Lazy-load images', 'wprig' ),
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
