<?php

if (!function_exists('_action_wplab_albedo_shortcode_media_image_gallery_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_media_image_gallery_enqueue_dynamic_css( $data ) {
		$shortcode = 'media-image-gallery';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** include LightGallery library styles **/
		wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'lightgallery');

		/** include Justified Grid **/
		wp_enqueue_style( 'justified-grid', get_template_directory_uri() . '/css/libs/justified.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'justified-grid');

		/** include lightbox **/
		/** shortcode script **/
		$js_vars = array(
			'lightboxEffect' => fw_get_db_customizer_option( 'lightbox_effect' ),
			'lightboxEasing' => fw_get_db_customizer_option( 'lightbox_easing' ),
			'lightboxThumbs' => filter_var( fw_get_db_customizer_option( 'lightbox_thumbnails' ), FILTER_VALIDATE_BOOLEAN ),
			'lightboxCaptions' => filter_var( fw_get_db_customizer_option( 'lightbox_captions' ), FILTER_VALIDATE_BOOLEAN ),
			'lightboxFullscreen' => filter_var( fw_get_db_customizer_option( 'lightbox_fullscreen' ), FILTER_VALIDATE_BOOLEAN ),
			'lightboxZoom' => filter_var( fw_get_db_customizer_option( 'lightbox_zoom' ), FILTER_VALIDATE_BOOLEAN ),
			'lightboxDownload' => filter_var( fw_get_db_customizer_option( 'lightbox_download' ), FILTER_VALIDATE_BOOLEAN ),
			'lightboxAutoplay' => filter_var( fw_get_db_customizer_option( 'lightbox_autoplay/enabled' ), FILTER_VALIDATE_BOOLEAN ),
			'lightboxAutoplaySpeed' => absint( fw_get_db_customizer_option( 'lightbox_autoplay/yes/speed' ) ),
		);

		if( $js_vars['lightboxThumbs'] == true ) {
			wp_enqueue_script( 'lightgallery-thumb');
		}
		if( $js_vars['lightboxFullscreen'] == true ) {
			wp_enqueue_script( 'lightgallery-fullscreen');
		}
		if( $js_vars['lightboxAutoplay'] == true ) {
			wp_enqueue_script( 'lightgallery-autoplay');
		}
		if( $js_vars['lightboxZoom'] == true ) {
			wp_enqueue_script( 'lightgallery-zoom');
		}

		wp_enqueue_script( 'wplab-albedo-justified-image-grid', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/media-image-gallery/static/js/scripts' . $postfix . '.js'), array('jquery', 'justified-grid'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_localize_script( 'wplab-albedo-justified-image-grid', 'wplabAlbedoImageGallery', $js_vars );

		if( is_numeric( $atts['border_radius'] ) ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' figure img, #' . $shortcode_id . ' .caption, #' . $shortcode_id . ' figure:before { border-radius: ' . absint( $atts['border_radius'] ) . 'px; }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:media_image_gallery',
		'_action_wplab_albedo_shortcode_media_image_gallery_enqueue_dynamic_css'
	);

endif;
