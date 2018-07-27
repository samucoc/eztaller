<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_portfolio_featured_carousel_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_portfolio_featured_carousel_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'portfolio_featured_carousel';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** include swiper carousel2 library styles **/
		wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'swiper');

		wp_enqueue_style( 'wplab-albedo-portfolio-featured-carousel', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/portfolio_featured_carousel.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-portfolio-featured-carousel-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/portfolio_featured_carousel_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		wp_enqueue_script( 'wplab-albedo-portfolio-featured-carousel', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/portfolio-featured-carousel/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		if( isset( $atts['pagination_color'] ) && $atts['pagination_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .swiper-pagination-bullet { background-color: ' . $atts['pagination_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['pagination_active_color'] ) && $atts['pagination_active_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .swiper-pagination-bullet-active { background-color: ' . $atts['pagination_active_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:portfolio_featured_carousel',
		'_action_wplab_albedo_shortcode_portfolio_featured_carousel_enqueue_dynamic_css'
	);

endif;
