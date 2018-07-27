<?php

if (!function_exists('_action_wplab_albedo_shortcode_colorful_link_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_colorful_link_enqueue_dynamic_css( $data ) {
		$shortcode = 'colorful_link';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		wp_enqueue_style( 'wplab-albedo-shortcode-colorful-link', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/colorful_link.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		if( isset( $atts['height'] ) && $atts['height'] <> '' ) {
			$height = absint( $atts['height'] );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { height: ' . $height . 'px; }' );
		}

		if( isset( $atts['paddings'] ) && $atts['paddings'] <> '' ) {
			$paddings = absint( $atts['paddings'] );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { padding: ' . $paddings . 'px; }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:colorful_link',
		'_action_wplab_albedo_shortcode_colorful_link_enqueue_dynamic_css'
	);

endif;
