<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_portfolio_posts_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_portfolio_posts_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'portfolio_posts';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** load stylesheet **/
		if( filter_var( $atts['filters']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
			wp_enqueue_style( 'wplab-albedo-filters-variable', wplab_albedo_utils::locate_uri( '/css/front/less/filters.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		}

		/** include Masonry Grid **/
		wp_enqueue_style( 'masonry', get_template_directory_uri() . '/css/libs/masonry.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'masonry-effects', get_template_directory_uri() . '/css/libs/masonry_effects.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'isotope');
		wp_enqueue_script( 'anim-on-scroll' );

		wp_enqueue_style( 'wplab-albedo-portfolio-posts', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/portfolio_posts.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-portfolio-posts-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/portfolio_posts_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		$js_vars = array();

		/** include LightGallery library styles **/
		if( filter_var( $atts['display_lightbox_icon'], FILTER_VALIDATE_BOOLEAN ) ) {
			wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_script( 'lightgallery');

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

		}

		wp_enqueue_script( 'wplab-albedo-portfolio-posts', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/portfolio-posts/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_localize_script( 'wplab-albedo-portfolio-posts', 'wplabAlbedoPortfolioMasonryGrid', $js_vars );

		/**
		 * Custom style settings
		 **/

		if( isset( $atts['filters_link_color'] ) && $atts['filters_link_color'] <> '' ) {
			$inline_css = '#' . $shortcode_id . ' .posts-filters a { color: ' . $atts['filters_link_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['filters_link_active_color'] ) && $atts['filters_link_active_color'] <> '' ) {
			$inline_css = '#' . $shortcode_id . ' .posts-filters a.active, #' . $shortcode_id . ' .posts-filters a:hover { color: ' . $atts['filters_link_active_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['filters_separator_color'] ) && $atts['filters_separator_color'] <> '' ) {
			$inline_css = '#' . $shortcode_id . ' .posts-filters { color: ' . $atts['filters_separator_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:portfolio_posts',
		'_action_wplab_albedo_shortcode_portfolio_posts_enqueue_dynamic_css'
	);

endif;
