<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_portfolio_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_portfolio_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'portfolio';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** load stylesheet **/
		if( filter_var( $atts['filters']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
			wp_enqueue_style( 'wplab-albedo-filters-variable', wplab_albedo_utils::locate_uri( '/css/front/less/filters.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		}

		wp_enqueue_style( 'wplab-albedo-portfolio', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/portfolio.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-portfolio-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/portfolio_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/** include Justified Grid **/
		wp_enqueue_style( 'justified-grid', get_template_directory_uri() . '/css/libs/justified.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'justified-grid');

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-portfolio', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/portfolio/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		/**
		 * Custom style settings
		 **/
		if( isset( $atts['custom_radius'] ) && $atts['custom_radius'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' img, #' . $shortcode_id . ' .overlay, #' . $shortcode_id . ' .item { border-radius: ' . $atts['custom_radius'] . 'px; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['filters_link_color'] ) && $atts['filters_link_color'] <> '' ) {
			$inline_css = '#' . $shortcode_id . ' .posts-filters a { color: ' . $atts['filters_link_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['filters_link_active_color'] ) && $atts['filters_link_active_color'] <> '' ) {
			$inline_css = '#' . $shortcode_id . ' .posts-filters a.active, #' . $shortcode_id . ' .posts-filters a:hover { color: ' . $atts['filters_link_active_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['filters_separator_color'] ) && $atts['filters_separator_color'] <> '' ) {
			$inline_css = '#' . $shortcode_id . ' .posts-filters { color: ' . $atts['filters_separator_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:portfolio',
		'_action_wplab_albedo_shortcode_portfolio_enqueue_dynamic_css'
	);

endif;
