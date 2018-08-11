<?php

if (!function_exists('_action_wplab_albedo_shortcode_photo_grid_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_photo_grid_enqueue_dynamic_css( $data ) {
		$shortcode = 'photo-grid';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** include LightGallery library styles **/
		wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'lightgallery');

		/** shortcode styles **/
		wp_enqueue_style( 'wplab-albedo-photo-grid-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/photo_grid_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

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

		wp_enqueue_script( 'wplab-albedo-photo-grid', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/photo-grid/static/js/scripts' . $postfix . '.js'), array('jquery', 'justified-grid'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_localize_script( 'wplab-albedo-photo-grid', 'wplabAlbedoPhotoGrid', $js_vars );

		if( isset( $atts['overlay_color'] ) && $atts['overlay_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' figure a:after { background-color: ' . $atts['overlay_color'] . '; } #' . $shortcode_id . ' figure a:hover:after { background-color: transparent; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:photo_grid',
		'_action_wplab_albedo_shortcode_photo_grid_enqueue_dynamic_css'
	);

endif;
