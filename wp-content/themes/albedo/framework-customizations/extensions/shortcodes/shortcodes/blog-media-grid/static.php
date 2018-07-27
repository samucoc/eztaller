<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_blog_media_grid_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_blog_media_grid_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'blog_media_grid';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_style( 'wplab-albedo-blog-media-grid', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog_media_grid.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-blog-media-grid-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_media_grid_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'fitvids' );
		wp_enqueue_script( 'wplab-albedo-blog-media-grid', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/blog-media-grid/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		if( isset( $atts['height'] ) && $atts['height'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' article { height: ' . absint( $atts['height'] ) . 'px; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['overlay_color'] ) && $atts['overlay_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' article.with-thumb .overlay { background-color: ' . $atts['overlay_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:blog_media_grid',
		'_action_wplab_albedo_shortcode_blog_media_grid_enqueue_dynamic_css'
	);

endif;
