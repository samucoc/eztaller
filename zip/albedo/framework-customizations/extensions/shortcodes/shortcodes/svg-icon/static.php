<?php

if (!function_exists('_action_wplab_albedo_shortcode_svg_icon_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_svg_icon_enqueue_dynamic_css( $data ) {
		$shortcode = 'svg_icon';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		/** include scripts **/
		if( filter_var( $atts['is_lightbox'], FILTER_VALIDATE_BOOLEAN ) ) {
			wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_script( 'lightgallery');
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
			wp_enqueue_script( 'wplab-image-svg', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/svg-icon/static/js/lightbox.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );
			wp_localize_script( 'wplab-image-svg', 'wplabAlbedoSVGIcon', $js_vars );
		}

		$shortcode_id = 'shortcode-' . $atts['id'];

		$inline_css = ' #' . $shortcode_id . ' svg {';

		$inline_css .= 'display: inline-block; width: ' . $atts['width'] . 'px; max-width: 100%; height: ' . $atts['height'] . 'px;';

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

		$inline_css .= '}';

		if( isset( $atts['color'] ) && $atts['color'] <> '' ) {
			$inline_css .= ' #' . $shortcode_id . ' svg path, #' . $shortcode_id . ' svg circle, #' . $shortcode_id . ' svg rect { fill: ' . $atts['color'] . '; }';
		}

		wp_add_inline_style( 'wplab-albedo-style', $inline_css );

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:svg_icon',
		'_action_wplab_albedo_shortcode_svg_icon_enqueue_dynamic_css'
	);

endif;
