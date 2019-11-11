<?php
/**
 * WP Rig Theme Customizer
 *
 * @package wprig
 */

/**
 * Add a few extra things for the Customizer - if we want them.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function wprig_customize_register( $wp_customize ) {

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
	 * Login Section options
	$wp_customize->add_section(
		'login_options',
		array(
			'title' => __( 'Login Options', 'wprig' ),
		)
	);
	*/

	$wp_customize->add_setting(
		'show_login_button',
		array(
			'default'           => true,
			'sanitize_callback' => 'wprig_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		'show_login_button',
		array(
			'type'    => 'checkbox',
			'section' => 'theme_options',
			'label'   => __( 'Show Login button in Top Menu?', 'wprig' ),
		)
	);

}
