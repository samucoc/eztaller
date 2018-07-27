<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_blog_masonry_media_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_blog_masonry_media_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'blog_masonry_media';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** include Masonry Grid **/
		wp_enqueue_style( 'masonry', get_template_directory_uri() . '/css/libs/masonry.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'masonry-effects', get_template_directory_uri() . '/css/libs/masonry_effects.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'isotope');
		wp_enqueue_script( 'anim-on-scroll' );

		wp_enqueue_style( 'wplab-albedo-blog-masonry-media', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog_masonry_media.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-blog-masonry-media-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_masonry_media_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'fitvids' );
		wp_enqueue_script( 'wplab-albedo-blog-masonry-media', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/blog-masonry-media/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		// custom styles
		if( isset( $atts['custom_radius'] ) && $atts['custom_radius'] <> '' ) {
			$radius = absint( $atts['custom_radius'] );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .shortcode-blog-masonry-media .item, #' . $shortcode_id . ' .shortcode-blog-masonry-media .overlay { border-radius: ' . $radius . 'px; }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:blog_masonry_media',
		'_action_wplab_albedo_shortcode_blog_masonry_media_enqueue_dynamic_css'
	);

endif;
