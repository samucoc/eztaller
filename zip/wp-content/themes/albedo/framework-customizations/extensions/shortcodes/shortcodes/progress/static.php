<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_progress_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_progress_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'progress';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** load static stylesheet **/
		wp_enqueue_style( 'wplab-albedo-progress', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/progress.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-progress-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/progress_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );


		/**
		 * Custom colors
		 **/
		if( isset( $atts['bar_bg_color'] ) && $atts['bar_bg_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .progress-bar-value-inner { background-color: ' . $atts['bar_bg_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['bar_accent_color'] ) && $atts['bar_accent_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .value { background-color: ' . $atts['bar_accent_color'] . ' !important; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['text_color'] ) && $atts['text_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .progress-bar-title { color: ' . $atts['text_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['value_color'] ) && $atts['value_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .num { color: ' . $atts['value_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:progress',
		'_action_wplab_albedo_shortcode_progress_enqueue_dynamic_css'
	);

endif;
