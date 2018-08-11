<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_benefits_numeric_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_benefits_numeric_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'benefits-numeric';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		fw()->backend->option_type('icon-v2')->packs_loader->enqueue_frontend_css();

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** load stylesheet **/
		wp_enqueue_style( 'wplab-albedo-benefits-numeric', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/benefits_numeric.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-benefits-numeric-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/benefits_numeric_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Custom colors
		 **/
		if( isset( $atts['number_color'] ) && $atts['number_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .number { color: ' . $atts['number_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['number_hover_color'] ) && $atts['number_hover_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .number { color: ' . $atts['number_hover_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['header_color'] ) && $atts['header_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' h4 { color: ' . $atts['header_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['header_hover_color'] ) && $atts['header_hover_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .item:hover h4 { color: ' . $atts['header_hover_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['text_color'] ) && $atts['text_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .desc { color: ' . $atts['text_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:benefits_numeric',
		'_action_wplab_albedo_shortcode_benefits_numeric_enqueue_dynamic_css'
	);

endif;
