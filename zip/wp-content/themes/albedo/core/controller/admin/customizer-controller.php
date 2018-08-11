<?php

/**
 * Customizer controller
 **/
class wplab_albedo_customizer_controller {

	function __construct() {

		add_action( 'customize_register', array( $this, 'customize_register' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'customize_preview_init' ), 40 );

		add_action( 'customize_controls_print_footer_scripts', array( $this, 'add_scripts' ) );
	}

	/**
	 * Change the setting transport and enqueue the javascript
	 **/
	function customize_register( $wp_customize ) {

		if ( $wp_customize->get_setting( 'fw_options[layout_type]') ) {
			$wp_customize->get_setting( 'fw_options[layout_type]')->transport = 'postMessage';
		}
		if ( $wp_customize->get_setting( 'fw_options[layout_width]') ) {
			$wp_customize->get_setting( 'fw_options[layout_width]')->transport = 'postMessage';
		}
		if ( $wp_customize->get_setting( 'fw_options[layout_column_padding]') ) {
			$wp_customize->get_setting( 'fw_options[layout_column_padding]')->transport = 'postMessage';
		}
		if ( $wp_customize->get_setting( 'fw_options[framed_margins]') ) {
			$wp_customize->get_setting( 'fw_options[framed_margins]')->transport = 'postMessage';
		}
		if ( $wp_customize->get_setting( 'fw_options[framed_corners]') ) {
			$wp_customize->get_setting( 'fw_options[framed_corners]')->transport = 'postMessage';
		}
		if ( $wp_customize->get_setting( 'fw_options[box_top_padding]') ) {
			$wp_customize->get_setting( 'fw_options[box_top_padding]')->transport = 'postMessage';
		}
		if ( $wp_customize->get_setting( 'fw_options[box_bottom_padding]') ) {
			$wp_customize->get_setting( 'fw_options[box_bottom_padding]')->transport = 'postMessage';
		}
		if ( $wp_customize->get_setting( 'fw_options[sidebar_size]') ) {
			$wp_customize->get_setting( 'fw_options[sidebar_size]')->transport = 'postMessage';
		}
		if ( $wp_customize->get_setting( 'fw_options[widgets_style]') ) {
			$wp_customize->get_setting( 'fw_options[widgets_style]')->transport = 'postMessage';
		}
		if ( $wp_customize->get_setting( 'fw_options[hide_sidebar_on_mobiles]') ) {
			$wp_customize->get_setting( 'fw_options[hide_sidebar_on_mobiles]')->transport = 'postMessage';
		}

	}

	/**
	 * Add customizer JS
	 **/
	function customize_preview_init() {

		wp_enqueue_script(
			'wplab-albedo-customizer',
			get_template_directory_uri() .'/js/admin/customizer.js',
			array( 'jquery','customize-preview', 'wplab-albedo-front' ),
			_WPLAB_ALBEDO_CACHE_TIME_,
			true
		);

	}

	/**
	 * Add custom scripts to customizer
	**/
	function add_scripts() {
		wp_register_script( 'wplab-albedo-customizer-widgets', get_template_directory_uri() . '/js/admin/customizer-widgets.js', false, _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_enqueue_script( 'wplab-albedo-customizer-widgets', array( 'jquery' ) );
	}

}
