<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_blog_masonry_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_blog_masonry_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'blog_masonry';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** include Masonry Grid **/
		wp_enqueue_script( 'swiper');
		wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'masonry', get_template_directory_uri() . '/css/libs/masonry.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'masonry-effects', get_template_directory_uri() . '/css/libs/masonry_effects.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'isotope');
		wp_enqueue_script( 'anim-on-scroll' );

		wp_enqueue_style( 'wplab-albedo-blog-masonry', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog_masonry.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-blog-masonry-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_masonry_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'fitvids' );
		wp_enqueue_script( 'wplab-albedo-blog-masonry', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/blog-masonry/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		// custom styles
		if( isset( $atts['custom_radius'] ) && $atts['custom_radius'] <> '' ) {
			$radius = absint( $atts['custom_radius'] );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .item { border-radius: ' . $radius . 'px; }' );
			wp_add_inline_style( 'wplab-albedo-style', '
				#' . $shortcode_id . ' .item .post-media img,
				#' . $shortcode_id . ' .item .post-media iframe,
				#' . $shortcode_id . ' .item .post-media .overlay {
							-webkit-border-top-left-radius: ' . $radius . 'px;
							-webkit-border-top-right-radius: ' . $radius . 'px;
							-moz-border-radius-topleft: ' . $radius . 'px;
							-moz-border-radius-topright: ' . $radius . 'px;
							border-top-left-radius: ' . $radius . 'px;
							border-top-right-radius: ' . $radius . 'px;
				}' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:blog_masonry',
		'_action_wplab_albedo_shortcode_blog_masonry_enqueue_dynamic_css'
	);

endif;
