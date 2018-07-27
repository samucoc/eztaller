<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_timeline_h_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_timeline_h_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'timeline-h';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** load static stylesheet **/
		wp_enqueue_style( 'wplab-albedo-timeline-h', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/timeline_h.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-timeline-h-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/timeline_h_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'modernizr' );
		wp_enqueue_script( 'jquery-mobile' );
		wp_enqueue_script( 'wplab-albedo-timeline-h', wplab_albedo_utils::locate_uri('/js/libs/h-timeline.min.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );


	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:timeline_h',
		'_action_wplab_albedo_shortcode_timeline_h_enqueue_dynamic_css'
	);

endif;
