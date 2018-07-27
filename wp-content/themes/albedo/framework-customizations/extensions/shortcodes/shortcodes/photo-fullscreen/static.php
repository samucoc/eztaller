<?php

if (!function_exists('_action_wplab_albedo_shortcode_photo_fullscreen_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_photo_fullscreen_enqueue_dynamic_css( $data ) {
		$shortcode = 'photo-fullscreen';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** shortcode styles **/
		wp_enqueue_style( 'wplab-albedo-photo-fullscreen', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/photo_fullscreen.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-photo-fullscreen-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/photo_fullscreen_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		wp_enqueue_script( 'wplab-albedo-modernizr-cssmask', wplab_albedo_utils::locate_uri('/js/libs/checkCSSMask.min.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_enqueue_script( 'wplab-albedo-photo-fullscreen', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/photo-fullscreen/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		if( isset( $atts['overlay_color'] ) && $atts['overlay_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .overlay { background-color: ' . $atts['overlay_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:photo_fullscreen',
		'_action_wplab_albedo_shortcode_photo_fullscreen_enqueue_dynamic_css'
	);

endif;
