<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_benefits_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_benefits_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'benefits';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		fw()->backend->option_type('icon-v2')->packs_loader->enqueue_frontend_css();

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** load stylesheet **/
		wp_enqueue_style( 'wplab-albedo-benefits', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/benefits.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-benefits-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/benefits_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-benefits', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/benefits/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

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

		if( isset( $atts['border_color'] ) && $atts['border_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .item:after { background: ' . $atts['border_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['margin_bottom'] ) && $atts['margin_bottom'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .item { margin-bottom: ' . absint( $atts['margin_bottom'] ) . 'px; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:benefits',
		'_action_wplab_albedo_shortcode_benefits_enqueue_dynamic_css'
	);

endif;
