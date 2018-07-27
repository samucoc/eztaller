<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_services_modern_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_services_modern_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'services-modern';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** load static stylesheet **/
		wp_enqueue_style( 'wplab-albedo-services-modern', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/services_modern.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-services-modern-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/services_modern_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-services-modern', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/services-modern/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:services_modern',
		'_action_wplab_albedo_shortcode_services_modern_enqueue_dynamic_css'
	);

endif;
