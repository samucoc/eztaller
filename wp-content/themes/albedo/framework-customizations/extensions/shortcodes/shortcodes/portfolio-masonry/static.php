<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_portfolio_masonry_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_portfolio_masonry_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'portfolio_masonry';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** load stylesheet **/
		if( filter_var( $atts['filters']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
			wp_enqueue_style( 'wplab-albedo-filters-variable', wplab_albedo_utils::locate_uri( '/css/front/less/filters.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		}

		/** include Masonry Grid **/
		wp_enqueue_style( 'masonry', get_template_directory_uri() . '/css/libs/masonry.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'masonry-effects', get_template_directory_uri() . '/css/libs/masonry_effects.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'isotope');
		wp_enqueue_script( 'anim-on-scroll' );

		wp_enqueue_style( 'wplab-albedo-portfolio-masonry', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/portfolio_masonry.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-portfolio-masonry-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/portfolio_masonry_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-portfolio-masonry', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/portfolio-masonry/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		/**
		 * Custom style settings
		 **/
		if( isset( $atts['custom_radius'] ) && $atts['custom_radius'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' img, #' . $shortcode_id . ' .overlay, #' . $shortcode_id . ' .item, #' . $shortcode_id . ' .grid-item { border-radius: ' . $atts['custom_radius'] . 'px; }';
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

		if( isset( $atts['bg_layer1_color'] ) && $atts['bg_layer1_color'] <> '' ) {
			$inline_css = '#' . $shortcode_id . ' .bg-layer-1 { background-color: ' . $atts['bg_layer1_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['bg_layer2_color'] ) && $atts['bg_layer2_color'] <> '' ) {
			$inline_css = '#' . $shortcode_id . ' .bg-layer-2 { background-color: ' . $atts['bg_layer2_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:portfolio_masonry',
		'_action_wplab_albedo_shortcode_portfolio_masonry_enqueue_dynamic_css'
	);

endif;
