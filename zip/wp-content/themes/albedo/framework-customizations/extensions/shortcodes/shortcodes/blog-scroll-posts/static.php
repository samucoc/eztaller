<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_blog_scroll_posts_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_blog_scroll_posts_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'blog_scroll_posts';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		wp_enqueue_style( 'wplab-albedo-scrollbox', wplab_albedo_utils::locate_uri( '/css/libs/scrollbox.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-blog-scroll-posts', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog_scroll_posts.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-blog-scroll-posts-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_scroll_posts_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'mousewheel' );
		wp_enqueue_script( 'scrollbox' );
		wp_enqueue_script( 'wplab-albedo-blog-scroll-posts', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/blog-scroll-posts/static/js/scripts.js'), array('jquery', 'scrollbox'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		// custom Css
		if( isset( $atts['custom_radius'] ) && $atts['custom_radius'] <> '' ) {
			$radius = absint( $atts['custom_radius'] );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { border-radius: ' . $radius . 'px; }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:blog_scroll_posts',
		'_action_wplab_albedo_shortcode_blog_scroll_posts_enqueue_dynamic_css'
	);

endif;
