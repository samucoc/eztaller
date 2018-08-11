<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_blog_featured_post_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_blog_featured_post_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'blog_featured_post';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		wp_enqueue_style( 'wplab-albedo-blog-featured-post', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog_featured_post.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-blog-featured-post-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_featured_post_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		// custom Css
		if( isset( $atts['custom_radius'] ) && $atts['custom_radius'] <> '' ) {
			$radius = absint( $atts['custom_radius'] );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { border-radius: ' . $radius . 'px; }' );
			wp_add_inline_style( 'wplab-albedo-style', '
				#' . $shortcode_id . ' .thumb img,
				#' . $shortcode_id . ' .thumb,
				#' . $shortcode_id . ' .overlay {
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
		'fw_ext_shortcodes_enqueue_static:blog_featured_post',
		'_action_wplab_albedo_shortcode_blog_featured_post_enqueue_dynamic_css'
	);

endif;
