<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_blog_post_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_blog_post_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'blog_post';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style( 'wplab-albedo-shortcode-blog-post', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog_post.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-shortcode-blog-post-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_post_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-shortcode-blog-post', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/blog-post/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		// custom Css
		if( isset( $atts['custom_radius'] ) && $atts['custom_radius'] <> '' ) {
			$radius = absint( $atts['custom_radius'] );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ', #' . $shortcode_id . ' .inside, #' . $shortcode_id . ' .overlay { border-radius: ' . $radius . 'px; }' );
		}

		if( isset( $atts['custom_paddings'] ) && $atts['custom_paddings'] <> '' ) {
			$paddings = absint( $atts['custom_paddings'] );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .inside { padding: ' . $paddings . 'px; }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:blog_post',
		'_action_wplab_albedo_shortcode_blog_post_enqueue_dynamic_css'
	);

endif;
