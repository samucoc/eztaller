<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_timeline_v_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_timeline_v_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'timeline-v';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** load static stylesheet **/
		wp_enqueue_style( 'wplab-albedo-timeline-v', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/timeline_v.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-timeline-v-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/timeline_v_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'sticky-kit');
		wp_enqueue_script( 'wplab-albedo-timeline-v', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/timeline-v/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );


	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:timeline_v',
		'_action_wplab_albedo_shortcode_timeline_v_enqueue_dynamic_css'
	);

endif;
