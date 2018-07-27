<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_blog_carousel2_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_blog_carousel2_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'blog_carousel2';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** include swiper carousel2 library styles **/
		wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'swiper');

		wp_enqueue_style( 'wplab-albedo-blog-carousel2', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog_carousel2.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-blog-carousel2-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_carousel2_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		wp_enqueue_script( 'wplab-albedo-blog-carousel2-carousel', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/blog-carousel2/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		// custom Css
		if( isset( $atts['custom_radius'] ) && $atts['custom_radius'] <> '' ) {
			$radius = absint( $atts['custom_radius'] );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .thumb img, #' . $shortcode_id . ' .overlay, #' . $shortcode_id . ' .thumb { border-radius: ' . $radius . 'px; }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:blog_carousel2',
		'_action_wplab_albedo_shortcode_blog_carousel2_enqueue_dynamic_css'
	);

endif;
