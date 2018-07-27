<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_portfolio_wall_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_portfolio_wall_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'portfolio_wall';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		wp_enqueue_style( 'wplab-albedo-portfolio-wall', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/portfolio_wall.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-portfolio-wall-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/portfolio_wall_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/** include lightbox **/
		$js_vars = array();
		if( filter_var( $atts['display_zoom_icon'], FILTER_VALIDATE_BOOLEAN ) ) {

			/** include LightGallery library styles **/
			wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_script( 'lightgallery');

			$js_vars = array(
				'lightboxEffect' => fw_get_db_settings_option( 'lightbox_effect' ),
				'lightboxEasing' => fw_get_db_settings_option( 'lightbox_easing' ),
				'lightboxThumbs' => filter_var( fw_get_db_settings_option( 'lightbox_thumbnails' ), FILTER_VALIDATE_BOOLEAN ),
				'lightboxCaptions' => filter_var( fw_get_db_settings_option( 'lightbox_captions' ), FILTER_VALIDATE_BOOLEAN ),
				'lightboxFullscreen' => filter_var( fw_get_db_settings_option( 'lightbox_fullscreen' ), FILTER_VALIDATE_BOOLEAN ),
				'lightboxZoom' => filter_var( fw_get_db_settings_option( 'lightbox_zoom' ), FILTER_VALIDATE_BOOLEAN ),
				'lightboxDownload' => filter_var( fw_get_db_settings_option( 'lightbox_download' ), FILTER_VALIDATE_BOOLEAN ),
				'lightboxAutoplay' => filter_var( fw_get_db_settings_option( 'lightbox_autoplay/enabled' ), FILTER_VALIDATE_BOOLEAN ),
				'lightboxAutoplaySpeed' => absint( fw_get_db_settings_option( 'lightbox_autoplay/yes/speed' ) ),
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

		}

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-portfolio-wall', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/portfolio-wall/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_localize_script( 'wplab-albedo-portfolio-wall', 'wplabAlbedoPortfolioWall', $js_vars );

		// custom CSS settings
		if( isset( $atts['grid_row_height'] ) && $atts['grid_row_height'] <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .col { height: ' . absint( $atts['grid_row_height'] ) . 'px; }' );
		}

		if( isset( $atts['grid_row_height_mobile'] ) && $atts['grid_row_height_mobile'] <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', '@media screen and (max-width: 992px) { #' . $shortcode_id . ' .col { height: ' . absint( $atts['grid_row_height_mobile'] ) . 'px; } }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:portfolio_wall',
		'_action_wplab_albedo_shortcode_portfolio_wall_enqueue_dynamic_css'
	);

endif;
