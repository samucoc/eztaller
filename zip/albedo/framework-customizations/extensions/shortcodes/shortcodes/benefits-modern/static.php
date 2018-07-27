<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_benefits_modern_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_benefits_modern_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'benefits-modern';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		fw()->backend->option_type('icon-v2')->packs_loader->enqueue_frontend_css();

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** load stylesheet **/
		wp_enqueue_style( 'wplab-albedo-benefits-modern', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/benefits_modern.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-benefits-modern-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/benefits_modern_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-benefits', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/benefits/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		/**
		 * Custom colors
		 **/

		if( isset( $atts['icon_color'] ) && $atts['icon_color'] <> '' ) {

			$inline_css = ' #' . $shortcode_id . ' .icon { color: ' . $atts['icon_color'] . '; }';
			$inline_css .= ' #' . $shortcode_id . ' svg path, #' . $shortcode_id . ' svg rect, #' . $shortcode_id . ' svg polygon, #' . $shortcode_id . ' svg circle { fill: ' . $atts['icon_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );

		}

		if( isset( $atts['icon_hover_color'] ) && $atts['icon_hover_color'] <> '' ) {

			$inline_css = ' #' . $shortcode_id . ' .item:hover .icon { color: ' . $atts['icon_hover_color'] . '; }';
			$inline_css .= ' #' . $shortcode_id . ' .item:hover svg path, #' . $shortcode_id . ' .item:hover svg rect, #' . $shortcode_id . ' .item:hover svg polygon, #' . $shortcode_id . ' .item:hover svg circle { fill: ' . $atts['icon_hover_color'] . '; }';
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

		if( isset( $atts['button_color'] ) && $atts['button_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .btn { background-image: ~\'url("data:image/svg+xml;charset=UTF-8,%3Csvg%20version%3D%221.1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%0A%09%20width%3D%22284.935px%22%20height%3D%22284.936px%22%20viewBox%3D%220%200%20284.935%20284.936%22%20style%3D%22enable-background%3Anew%200%200%20284.935%20284.936%3B%22%0A%09%20xml%3Aspace%3D%22preserve%22%3E%0A%3Cg%3E%0A%09%3Cpath%20fill%3D%22' . urlencode( $atts['button_color'] ) . '%22%20d%3D%22M222.701%2C135.9L89.652%2C2.857C87.748%2C0.955%2C85.557%2C0%2C83.084%2C0c-2.474%2C0-4.664%2C0.955-6.567%2C2.857L62.244%2C17.133%0A%09%09c-1.906%2C1.903-2.855%2C4.089-2.855%2C6.567c0%2C2.478%2C0.949%2C4.664%2C2.855%2C6.567l112.204%2C112.204L62.244%2C254.677%0A%09%09c-1.906%2C1.903-2.855%2C4.093-2.855%2C6.564c0%2C2.477%2C0.949%2C4.667%2C2.855%2C6.57l14.274%2C14.271c1.903%2C1.905%2C4.093%2C2.854%2C6.567%2C2.854%0A%09%09c2.473%2C0%2C4.663-0.951%2C6.567-2.854l133.042-133.044c1.902-1.902%2C2.854-4.093%2C2.854-6.567S224.603%2C137.807%2C222.701%2C135.9z%22%2F%3E%0A%3C%2Fg%3E%0A%3C%2Fsvg%3E")\'; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['button_hover_color'] ) && $atts['button_hover_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .btn:hover { background-image: ~\'url("data:image/svg+xml;charset=UTF-8,%3Csvg%20version%3D%221.1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%0A%09%20width%3D%22284.935px%22%20height%3D%22284.936px%22%20viewBox%3D%220%200%20284.935%20284.936%22%20style%3D%22enable-background%3Anew%200%200%20284.935%20284.936%3B%22%0A%09%20xml%3Aspace%3D%22preserve%22%3E%0A%3Cg%3E%0A%09%3Cpath%20fill%3D%22' . urlencode( $atts['button_color'] ) . '%22%20d%3D%22M222.701%2C135.9L89.652%2C2.857C87.748%2C0.955%2C85.557%2C0%2C83.084%2C0c-2.474%2C0-4.664%2C0.955-6.567%2C2.857L62.244%2C17.133%0A%09%09c-1.906%2C1.903-2.855%2C4.089-2.855%2C6.567c0%2C2.478%2C0.949%2C4.664%2C2.855%2C6.567l112.204%2C112.204L62.244%2C254.677%0A%09%09c-1.906%2C1.903-2.855%2C4.093-2.855%2C6.564c0%2C2.477%2C0.949%2C4.667%2C2.855%2C6.57l14.274%2C14.271c1.903%2C1.905%2C4.093%2C2.854%2C6.567%2C2.854%0A%09%09c2.473%2C0%2C4.663-0.951%2C6.567-2.854l133.042-133.044c1.902-1.902%2C2.854-4.093%2C2.854-6.567S224.603%2C137.807%2C222.701%2C135.9z%22%2F%3E%0A%3C%2Fg%3E%0A%3C%2Fsvg%3E")\'; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:benefits_modern',
		'_action_wplab_albedo_shortcode_benefits_modern_enqueue_dynamic_css'
	);

endif;
