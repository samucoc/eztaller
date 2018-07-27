<?php

if (!function_exists('_action_wplab_albedo_shortcode_photo_fullscreen_carousel_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_photo_fullscreen_carousel_enqueue_dynamic_css( $data ) {
		$shortcode = 'photo-fullscreen-carousel';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** include swiper carousel library styles **/
		wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'swiper');

		/** include LightGallery library styles **/
		wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'lightgallery');

		/** shortcode styles and scripts **/
		wp_enqueue_style( 'wplab-albedo-photo-fullscreen-carousel', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/photo_fullscreen_carousel.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-photo-fullscreen-carousel-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/photo_fullscreen_carousel_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

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

		wp_enqueue_script( 'wplab-albedo-photo-fullscreen-carousel', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/photo-fullscreen-carousel/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_localize_script( 'wplab-albedo-photo-fullscreen-carousel', 'wplabAlbedoFullScreenPhotoCarousel', $js_vars );

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:photo_fullscreen_carousel',
		'_action_wplab_albedo_shortcode_photo_fullscreen_carousel_enqueue_dynamic_css'
	);

endif;
