<?php if (!defined('FW')) die('Forbidden');

if (!function_exists('_action_wplab_albedo_shortcode_icon_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_icon_enqueue_dynamic_css( $data ) {
		$shortcode = 'font_svg_icon';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		if( $atts['icon']['type'] == 'icon-font' ) {
			fw()->backend->option_type('icon-v2')->packs_loader->enqueue_frontend_css();
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:font_svg_icon',
		'_action_wplab_albedo_shortcode_icon_enqueue_dynamic_css'
	);

endif;
