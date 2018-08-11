<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_facts_in_diits_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_facts_in_diits_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'facts-in-digits';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** load stylesheet **/
		wp_enqueue_style( 'wplab-albedo-facts-in-digits', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/facts_in_digits.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-facts-in-digits-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/facts_in_digits_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		if( $atts['animation_type']['type'] == 'numinate' ) {
			wp_enqueue_script( 'numinate' );
		} elseif( $atts['animation_type']['type'] == 'typing' ) {
			wp_enqueue_script( 'typed' );
		} elseif( $atts['animation_type']['type'] == 'odometer' ) {
			wp_enqueue_script( 'odometer' );
			wp_enqueue_style( 'odometer', get_template_directory_uri() . '/css/libs/odometer.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		}

		/** Custom colors **/

		if( $atts['icon_color'] <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .icon { color: ' . $atts['icon_color'] . '; }' );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' svg path, #' . $shortcode_id . ' svg rect, #' . $shortcode_id . ' svg polygon, #' . $shortcode_id . ' svg circle { fill: ' . $atts['icon_color'] . '; }' );
		}

		if( $atts['number_color'] <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .number { color: ' . $atts['number_color'] . '; }' );
		}

		if( $atts['text_color'] <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .text { color: ' . $atts['text_color'] . '; }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:facts_in_digits',
		'_action_wplab_albedo_shortcode_facts_in_diits_enqueue_dynamic_css'
	);

endif;
