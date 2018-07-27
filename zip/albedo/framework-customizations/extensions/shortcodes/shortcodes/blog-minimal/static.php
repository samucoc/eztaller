<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_blog_minimal_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_blog_minimal_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'blog_minimal';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'youtube-background' );
		wp_enqueue_script( 'wplab-albedo-section-ytbg', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/youtube_bg.js'), array('youtube-background'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_enqueue_style( 'wplab-albedo-blog-minimal', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog_minimal.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-blog-minimal-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_minimal_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-blog-minimal', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/blog-minimal/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:blog_minimal',
		'_action_wplab_albedo_shortcode_blog_minimal_enqueue_dynamic_css'
	);

endif;
