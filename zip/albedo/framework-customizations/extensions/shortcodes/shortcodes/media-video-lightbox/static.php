<?php

if (!function_exists('_action_wplab_albedo_shortcode_video_lightbox_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_video_lightbox_enqueue_dynamic_css( $data ) {
		$shortcode = 'media-video-lightbox';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** include LightGallery library styles **/
		wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'lightgallery');
		//wp_enqueue_script( 'mousewheel');

		$js_vars = array();

		$js_vars['lightboxEffect'] = fw_get_db_customizer_option( 'lightbox_effect' );
		$js_vars['lightboxEasing'] = fw_get_db_customizer_option( 'lightbox_easing' );
		$js_vars['lightboxThumbs'] = filter_var( fw_get_db_customizer_option( 'lightbox_thumbnails' ), FILTER_VALIDATE_BOOLEAN );
		$js_vars['lightboxCaptions'] = filter_var( fw_get_db_customizer_option( 'lightbox_captions' ), FILTER_VALIDATE_BOOLEAN );
		$js_vars['lightboxFullscreen'] = false;
		$js_vars['lightboxZoom'] = false;
		$js_vars['lightboxDownload'] = false;
		$js_vars['lightboxAutoplay'] = filter_var( fw_get_db_customizer_option( 'lightbox_autoplay/enabled' ), FILTER_VALIDATE_BOOLEAN );
		$js_vars['lightboxAutoplaySpeed'] = fw_get_db_customizer_option( 'lightbox_autoplay/yes/speed' );

		if( $js_vars['lightboxThumbs'] == true ) {
			wp_enqueue_script( 'lightgallery-thumb');
		}
		if( $js_vars['lightboxAutoplay'] == true ) {
			wp_enqueue_script( 'lightgallery-autoplay');
		}

		wp_enqueue_script( 'lightgallery-video');
		wp_enqueue_script( 'wplab-albedo-video', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/media-video-lightbox/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		wp_localize_script( 'wplab-albedo-video', 'wplabAlbedoVideoLightbox', $js_vars );

		$inline_css = '';

		/**
		 * Custom margins, paddings and borders
		 **/

		if( isset( $atts['margins'] ) && is_array( $atts['margins'] ) && count( array_filter( $atts['margins'] ) ) > 0 ) {
			$inline_css .= wplab_albedo_utils::get_styles( array(
				'top_margin' 			=> $atts['margins']['top'],
				'right_margin' 		=> $atts['margins']['right'],
				'bottom_margin' 	=> $atts['margins']['bottom'],
				'left_margin' 		=> $atts['margins']['left'],
			), '' );
		}

		if( isset( $atts['paddings'] ) && is_array( $atts['paddings'] ) && count( array_filter( $atts['paddings'] ) ) > 0 ) {
			$inline_css .= wplab_albedo_utils::get_styles( array(
				'top_padding' 		=> $atts['paddings']['top'],
				'right_padding' 	=> $atts['paddings']['right'],
				'bottom_padding' 	=> $atts['paddings']['bottom'],
				'left_padding' 		=> $atts['paddings']['left'],
			), '' );
		}

		if( isset( $atts['border_width'] ) && is_array( $atts['border_width'] ) && count( array_filter( $atts['border_width'] ) ) > 0 ) {
			$border_css = wplab_albedo_utils::get_styles( array(
				'top_border' 			=> $atts['border_width']['top'],
				'right_border' 		=> $atts['border_width']['right'],
				'bottom_border' 	=> $atts['border_width']['bottom'],
				'left_border' 		=> $atts['border_width']['left'],
			), '' );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' img { ' . $border_css . '}' );
		}

		if( isset( $atts['border_color'] ) && $atts['border_color'] <> '' ) {
			$border_css = 'border-color: ' . $atts['border_color'] . ';';
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' img { ' . $border_css . '}' );
		}

		if( isset( $atts['border_style'] ) && $atts['border_style'] <> '' ) {
			$border_css = 'border-style: ' . $atts['border_style'] . ';';
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' img { ' . $border_css . '}' );
		}

		if( isset( $atts['border_radius'] ) && !empty( $atts['border_radius'] ) ) {

			$radius_styles = wplab_albedo_utils::get_styles( array(
				'top_border_radius' 		=> $atts['border_radius']['top'],
				'right_border_radius' 	=> $atts['border_radius']['right'],
				'bottom_border_radius' 	=> $atts['border_radius']['bottom'],
				'left_border_radius' 		=> $atts['border_radius']['left'],
			), '' );

			$inline_css .= $radius_styles;

			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' img { ' . $radius_styles . '}' );

		}

		if( isset( $atts['css_shadow']['enabled'] ) && filter_var( $atts['css_shadow']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
			$shadow_type = isset( $atts['css_shadow']['yes']['shadow_type'] ) && $atts['css_shadow']['yes']['shadow_type'] == 'inside' ? 'inset' : '';
			$inline_css .= 'box-shadow: ' . $shadow_type . ' ' . $atts['css_shadow']['yes']['shadow_horizontal_length'] . 'px ' . $atts['css_shadow']['yes']['shadow_vertical_length'] . 'px ' . $atts['css_shadow']['yes']['shadow_blur_radius'] . 'px ' . $atts['css_shadow']['yes']['shadow_spread_radius'] . 'px ' . $atts['css_shadow']['yes']['shadow_color'] . ';';
		}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { ' . $inline_css . '}' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:media_video_lightbox',
		'_action_wplab_albedo_shortcode_video_lightbox_enqueue_dynamic_css'
	);

endif;
