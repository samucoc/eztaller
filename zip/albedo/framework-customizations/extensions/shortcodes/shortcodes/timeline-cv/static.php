<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_timeline_cv_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_timeline_cv_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'timeline-cv';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** load static stylesheet **/
		wp_enqueue_style( 'wplab-albedo-timeline-cv', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/timeline_cv.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-timeline-cv-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/timeline_cv_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );


	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:timeline_cv',
		'_action_wplab_albedo_shortcode_timeline_cv_enqueue_dynamic_css'
	);

endif;
