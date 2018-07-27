<?php

if (!function_exists('_action_wplab_albedo_shortcode_link_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_link_enqueue_dynamic_css( $data ) {
		$shortcode = 'link';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$inline_css = '';

		/**
		 * Typed animation
		 **/
		if( isset( $atts['typed_animation']['enabled'] ) && filter_var( $atts['typed_animation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
			wp_enqueue_script( 'typed');
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:link',
		'_action_wplab_albedo_shortcode_link_enqueue_dynamic_css'
	);

endif;
