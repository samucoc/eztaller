<?php

if (!function_exists('_action_wplab_albedo_shortcode_social_icons_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_social_icons_enqueue_dynamic_css( $data ) {
		$shortcode = 'social_icons';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		wp_enqueue_style( 'wplab-albedo-social-icons', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/social_icons.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		$shortcode_id = 'shortcode-' . $atts['id'];
		$inline_css = '';

		if( isset( $atts['color'] ) && $atts['color'] <> '' ) {
			$inline_css .= ' #' . $shortcode_id . ' a { color: ' . $atts['color'] . '; }';
		}

		if( isset( $atts['hover_color'] ) && $atts['hover_color'] <> '' ) {
			$inline_css .= ' #' . $shortcode_id . ' a:hover { color: ' . $atts['hover_color'] . '; }';
		}

		if( isset( $atts['font_size'] ) && $atts['font_size'] <> '' ) {
			$inline_css .= ' #' . $shortcode_id . ' a { font-size: ' . $atts['font_size'] . 'px; }';
		}

		wp_add_inline_style( 'wplab-albedo-style', $inline_css );

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:social_icons',
		'_action_wplab_albedo_shortcode_social_icons_enqueue_dynamic_css'
	);

endif;
