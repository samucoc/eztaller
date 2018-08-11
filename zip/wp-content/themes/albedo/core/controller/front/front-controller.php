<?php

/**
 * Front side controller
 **/
class wplab_albedo_front_controller {

	// resources
	public $inline_css;

	function __construct() {

		// Preloader script should be included in header
		add_action( 'wp_head', array( $this, 'add_site_icon' ) );

		// Add scripts
		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ) );
		// Add Theme Styles
		add_action( 'wp_enqueue_scripts', array( $this, 'add_styles' ) );
		// Add styles later
		add_action( 'wp_enqueue_scripts', array( $this, 'add_later_styles' ), 99, 1 );
		// Remove some styles
		add_action( 'wp_enqueue_scripts', array( $this, 'remove_styles' ), 99, 1 );

		// Modify a webste title
		add_filter( 'wp_title',  array( $this, 'wp_title' ), 10, 2 );

		// Add BODY classes
		add_filter( 'body_class', array( $this, 'body_classes' ));

		// Custom search form
		add_filter( 'get_search_form', array( $this, 'custom_search_template' ) );

		// customize password protected post form
		add_filter( 'the_password_form', array( $this, 'customize_password_protect' ));

		// Comment reply link custom classes
		add_filter( 'comment_reply_link', array( $this, 'comment_reply_link' ));

		// Move comment content field to the bottom
		add_filter( 'comment_form_fields', array( $this, 'move_comment_field_to_bottom' ) );

		// Custom archive templates
		add_action( 'template_include', array( $this, 'template_redirect' ) );

		// Modify Menu Classes
		add_filter( 'nav_menu_css_class', array( $this, 'modify_nav_classes' ), 10, 2 );

		// Custom CSS code
		add_action( 'wp_head', array( $this, 'print_custom_css' ), 99 );
	}

	/**
	 * Theme header
	 **/
	function add_site_icon() {

		if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
			wp_site_icon();
		} elseif( wplab_albedo_utils::is_unyson() ) {

			$favicon_img = fw_get_db_customizer_option( 'favicon' );

			if( is_array( $favicon_img ) && !empty( $favicon_img ) ) {
				?>
				<!-- Standard favicons -->
				<link rel="shortcut icon" href="<?php echo esc_attr( wplab_albedo_media::img_resize( $favicon_img['url'], 16, 16 ) ); ?>" type="image/x-icon">
				<link rel="icon" href="<?php echo esc_attr( wplab_albedo_media::img_resize( $favicon_img['url'], 16, 16 ) ); ?>" type="image/x-icon">
				<!-- Standard iPhone -->
				<link rel="apple-touch-icon" sizes="57x57" href="<?php echo esc_attr( wplab_albedo_media::img_resize( $favicon_img['url'], 57, 57 ) ); ?>" />
				<!-- Retina iPhone -->
				<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_attr( wplab_albedo_media::img_resize( $favicon_img['url'], 114, 114 ) ); ?>" />
				<!-- Standard iPad -->
				<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_attr( wplab_albedo_media::img_resize( $favicon_img['url'], 72, 72 ) ); ?>" />
				<!-- Retina iPad -->
				<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_attr( wplab_albedo_media::img_resize( $favicon_img['url'], 144, 144 ) ); ?>" />
				<!-- Other sizes -->
				<link rel="icon" href="<?php echo esc_attr( wplab_albedo_media::img_resize( $favicon_img['url'], 32, 32 ) ); ?>" sizes="32x32" />
				<link rel="icon" href="<?php echo esc_attr( wplab_albedo_media::img_resize( $favicon_img['url'], 192, 192 ) ); ?>" sizes="192x192" />
				<link rel="apple-touch-icon-precomposed" href="<?php echo esc_attr( wplab_albedo_media::img_resize( $favicon_img['url'], 180, 180 ) ); ?>" />
				<meta name="msapplication-TileImage" content="<?php echo esc_attr( wplab_albedo_media::img_resize( $favicon_img['url'], 270, 270 ) ); ?>" />
				<?php
			}

		}

	}

	/**
	 * Add admin scripts
	 **/
	function add_scripts() {
		global $wplab_albedo_core, $post;

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		wp_enqueue_script( 'jquery' );

		wp_register_script( 'cookie', wplab_albedo_utils::locate_uri( '/js/libs/jquery.cookie.js' ), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'md5', wplab_albedo_utils::locate_uri( '/js/libs/jquery.md5.js' ), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'blazy', wplab_albedo_utils::locate_uri( '/js/libs/blazy.min.js' ), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'retina-js', wplab_albedo_utils::locate_uri( '/js/libs/retina.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'wow', wplab_albedo_utils::locate_uri( '/js/libs/wow.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'youtube-background', wplab_albedo_utils::locate_uri( '/js/libs/jquery.mb.YTPlayer.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'stellar', wplab_albedo_utils::locate_uri( '/js/libs/jquery.stellar.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'particleground', wplab_albedo_utils::locate_uri( '/js/libs/jquery.particleground.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'particles', wplab_albedo_utils::locate_uri( '/js/libs/particles.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'typed', wplab_albedo_utils::locate_uri( '/js/libs/typed.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'numinate', wplab_albedo_utils::locate_uri( '/js/libs/numinate.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'odometer', wplab_albedo_utils::locate_uri( '/js/libs/odometer.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'fitvids', wplab_albedo_utils::locate_uri( '/js/libs/jquery.fitvids.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		//wp_register_script( 'dlmenu', wplab_albedo_utils::locate_uri( '/js/libs/jquery.dlmenu.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'swiper', wplab_albedo_utils::locate_uri( '/js/libs/swiper.jquery.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'justified-grid', wplab_albedo_utils::locate_uri( '/js/libs/jquery.justifiedGallery.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'lightslider', wplab_albedo_utils::locate_uri( '/js/libs/lightslider.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'skrollr', wplab_albedo_utils::locate_uri( '/js/libs/skrollr.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'chartjs', wplab_albedo_utils::locate_uri( '/js/libs/chart.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'glide', wplab_albedo_utils::locate_uri( '/js/libs/glide.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'waitforimages', wplab_albedo_utils::locate_uri( '/js/libs/jquery.waitforimages.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'jquery-mobile', wplab_albedo_utils::locate_uri( '/js/libs/jquery.mobile.custom.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'modernizr', wplab_albedo_utils::locate_uri( '/js/libs/modernizr.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'sticky-kit', wplab_albedo_utils::locate_uri( '/js/libs/jquery.sticky-kit.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'parallax', wplab_albedo_utils::locate_uri( '/js/libs/jquery.parallax.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'autocomplete', wplab_albedo_utils::locate_uri( '/js/libs/jquery.autocomplete.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );

		wp_register_script( 'lightgallery', wplab_albedo_utils::locate_uri( '/js/libs/lightgallery.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'lightgallery-autoplay', wplab_albedo_utils::locate_uri( '/js/libs/lg-autoplay.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'lightgallery-fullscreen', wplab_albedo_utils::locate_uri( '/js/libs/lg-fullscreen.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'lightgallery-thumb', wplab_albedo_utils::locate_uri( '/js/libs/lg-thumbnail.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'lightgallery-video', wplab_albedo_utils::locate_uri( '/js/libs/lg-video.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'lightgallery-zoom', wplab_albedo_utils::locate_uri( '/js/libs/lg-zoom.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );

		wp_register_script( 'wplab-albedo-lightbox', wplab_albedo_utils::locate_uri( '/js/lightbox.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );

		wp_register_script( 'uiforms', wplab_albedo_utils::locate_uri( '/js/libs/jquery.uiforms.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'masonry', wplab_albedo_utils::locate_uri( '/js/libs/masonry.pkgd.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'isotope', wplab_albedo_utils::locate_uri( '/js/libs/isotope.pkgd.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'anim-on-scroll', wplab_albedo_utils::locate_uri( '/js/libs/AnimOnScroll.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'scrollbox', wplab_albedo_utils::locate_uri( '/js/libs/scrollbox.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'mousewheel', wplab_albedo_utils::locate_uri( '/js/libs/jquery.mousewheel.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'nicescroll', wplab_albedo_utils::locate_uri( '/js/libs/jquery.nicescroll.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'wplab-albedo-front', wplab_albedo_utils::locate_uri( '/js/front.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_register_script( 'vc-rtl-fix', wplab_albedo_utils::locate_uri( '/js/vc_rtl_fix.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );

		if( is_rtl() && wplab_albedo_utils::is_vc() ) {
			wp_enqueue_script( 'vc-rtl-fix' );
		}

		$js_vars = array(
			'ajaxurl' 			=> admin_url( 'admin-ajax.php' ),
			'strSuccess' 		=> esc_html__('Success', 'albedo'),
			'strError' 			=> esc_html__('Error', 'albedo'),
			'strAJAXError' => esc_html__( 'An AJAX error occurred when performing a query. Please contact support if the problem persists.', 'albedo' ),
			'strServerResponseError' => esc_html__( 'The script have received an invalid response from the server. Please contact support if the problem persists.', 'albedo' ),
			'strMenuBack' => esc_html__( 'Back', 'albedo' ),
			'ajaxNoResults' => esc_html__( 'Sorry, no matching results', 'albedo'),
			'scrollLastWidgetOffset' => wplab_albedo_utils::is_unyson() ? fw_get_db_customizer_option( 'scroll_last_widget/yes/scroll_last_widget_offset' ) : $wplab_albedo_core->default_options['scroll_last_widget_offset'],
			'onepageScrollOffeset' => wplab_albedo_utils::is_unyson() ? fw_get_db_settings_option( 'onepage_scroll_offset' ) : $wplab_albedo_core->default_options['onepage_scroll_offset'],
		);

		if ( is_single() ) {
			if( get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			if( get_post_format() == 'gallery' || has_shortcode( $post->post_content, 'gallery') ) {
				wp_enqueue_script( 'swiper');
			}
		}

		if( wplab_albedo_utils::is_unyson() ) {

			/** AJAX Search **/
			if( filter_var( fw_get_db_settings_option( 'ajax_search/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
				wp_enqueue_script( 'autocomplete' );
			}

			/** if SmoothScroll enabled **/
			if( filter_var( fw_get_db_customizer_option('smooth_scrolling' ), FILTER_VALIDATE_BOOLEAN ) ) {
				wp_enqueue_script( 'tweenmax', wplab_albedo_utils::locate_uri( '/js/libs/TweenMax.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
				wp_enqueue_script( 'scrollto', wplab_albedo_utils::locate_uri( '/js/libs/ScrollToPlugin.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
				wp_enqueue_script( 'smooth-scroll', wplab_albedo_utils::locate_uri( '/js/libs/SmoothScroll.min.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
			}

			/** if custom scrollbar enabled **/
			if( filter_var( fw_get_db_customizer_option('custom_scrollbar' ), FILTER_VALIDATE_BOOLEAN ) ) {
				wp_enqueue_script( 'nicescroll' );
				wp_enqueue_script( 'wplab-albedo-nicescroll', wplab_albedo_utils::locate_uri( '/js/custom_scrollbar' . $postfix . '.js'), array( 'jquery' ), _WPLAB_ALBEDO_CACHE_TIME_, true );
			}

			/** scroll last widget **/
			if( filter_var( fw_get_db_customizer_option('scroll_last_widget/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
				wp_enqueue_script( 'sticky-kit');
			}

			/** prev / next post parallax **/
			if( is_single() ) {

				$display_pre_next_posts = wplab_albedo_utils::get_theme_mod( 'blog_single_display_prev_next_posts/enabled', $wplab_albedo_core->default_options['blog_single_display_prev_next_posts'] );
				if( filter_var( $display_pre_next_posts, FILTER_VALIDATE_BOOLEAN ) && wplab_albedo_utils::get_theme_mod( 'blog_single_display_prev_next_posts/yes/blog_single_prev_next_posts_style', $wplab_albedo_core->default_options['blog_single_prev_next_posts_style'] ) == 'thumb_title' ) {
					wp_enqueue_script( 'parallax');
				}

			}

		}
		if( is_404() ) {

			if( filter_var( wplab_albedo_utils::get_theme_mod( 'page_404_bg_img_parallax', $wplab_albedo_core->default_options['page_404_bg_img_parallax'] ), FILTER_VALIDATE_BOOLEAN ) ) {
				wp_enqueue_script( 'parallax');
			}

		/** portfolio archives **/
		} elseif( is_tax( 'fw-portfolio-category') || is_post_type_archive('fw-portfolio') ) {

			wp_enqueue_script( 'waitforimages');
			wp_enqueue_script( 'isotope');
			wp_enqueue_script( 'anim-on-scroll' );
			wp_enqueue_script( 'wplab-albedo-portfolio-masonry', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/portfolio-masonry/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		/** search page styles **/
		} elseif( is_search() ) {

			wp_enqueue_script( 'wplab-albedo-blog-2cols', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/blog-2cols/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		/** blog archives **/
		} elseif( is_home() || is_archive() || is_category() || is_author() || is_tag() ) {
			wp_enqueue_script( 'swiper');
			wp_enqueue_script( 'wplab-albedo-blog', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/blog/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		} elseif( (is_front_page() && is_home()) || is_home() || is_single() && get_post_format() == 'gallery' || ( wplab_albedo_utils::is_unyson() && filter_var( fw_get_db_post_option( get_the_ID(), 'display_gallery_instead_thumb/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) ) {
			if( wplab_albedo_utils::is_unyson() ) {
				wplab_albedo_utils::enqueue_lightbox();
			}
			wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_script( 'swiper');
		}

		wp_enqueue_script( 'waitforimages' );
		wp_enqueue_script( 'blazy' );
		wp_enqueue_script( 'retina-js' );
		//wp_enqueue_script( 'dlmenu' );
		wp_enqueue_script( 'wow' );
		wp_enqueue_script( 'fitvids' );
		wp_enqueue_script( 'cookie' );
		wp_enqueue_script( 'uiforms' );
		wp_enqueue_script( 'wplab-albedo-front' );
		wp_localize_script( 'wplab-albedo-front', 'wprotoEngineVars', $js_vars );

		if( wplab_albedo_utils::is_unyson() ) {
			if( is_singular( 'fw-portfolio') ) {

				$post_id = get_the_ID();
				$single_post_style = fw_get_db_post_option( $post_id, 'single_post_layout/type' ) == 'custom' ? 'default' : fw_get_db_post_option( $post_id, 'single_post_layout/predefined/layout' );

				$_js_vars = array(
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

				if( in_array( $single_post_style, array('default', 'layout_1', 'layout_12') ) ) {
					// gallery part
					/** include LightGallery library styles **/
					wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_script( 'lightgallery');

					if( $_js_vars['lightboxThumbs'] == true ) {
						wp_enqueue_script( 'lightgallery-thumb');
					}
					if( $_js_vars['lightboxFullscreen'] == true ) {
						wp_enqueue_script( 'lightgallery-fullscreen');
					}
					if( $_js_vars['lightboxAutoplay'] == true ) {
						wp_enqueue_script( 'lightgallery-autoplay');
					}
					if( $_js_vars['lightboxZoom'] == true ) {
						wp_enqueue_script( 'lightgallery-zoom');
					}

					/** include Justified Grid **/
					wp_enqueue_style( 'justified-grid', get_template_directory_uri() . '/css/libs/justified.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_script( 'justified-grid');

					wp_enqueue_script( 'wplab-albedo-justified-image-grid', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/media-image-gallery/static/js/scripts.js'), array('jquery', 'justified-grid'), _WPLAB_ALBEDO_CACHE_TIME_, true );
					wp_localize_script( 'wplab-albedo-justified-image-grid', 'wplabAlbedoImageGallery', $_js_vars );

				} else if( in_array( $single_post_style, array( 'layout_3', 'layout_6', 'layout_10') ) ) {
					// carousel part

					/** include swiper carousel2 library styles **/
					wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_script( 'swiper');

					/** include LightGallery library styles **/
					wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_script( 'lightgallery');

					if( $_js_vars['lightboxThumbs'] == true ) {
						wp_enqueue_script( 'lightgallery-thumb');
					}
					if( $_js_vars['lightboxFullscreen'] == true ) {
						wp_enqueue_script( 'lightgallery-fullscreen');
					}
					if( $_js_vars['lightboxAutoplay'] == true ) {
						wp_enqueue_script( 'lightgallery-autoplay');
					}
					if( $_js_vars['lightboxZoom'] == true ) {
						wp_enqueue_script( 'lightgallery-zoom');
					}

					/** load static stylesheet **/
					wp_enqueue_style( 'wplab-albedo-image-carousel2', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/image_carousel2.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_style( 'wplab-albedo-image-carousel2-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/image_carousel2_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

					wp_enqueue_script( 'wplab-albedo-image-carousel2', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/media-image-carousel2/static/js/scripts.js'), array('jquery', 'masonry'), _WPLAB_ALBEDO_CACHE_TIME_, true );
					wp_localize_script( 'wplab-albedo-image-carousel2', 'wplabAlbedoMediaImageCarousel2', $_js_vars );

				} else if( in_array( $single_post_style, array( 'layout_5', 'layout_9', 'layout_13') ) ) {
					// carousel 2 part

					/** include swiper carousel2 library styles **/
					wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_script( 'swiper');

					/** include LightGallery library styles **/
					wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_script( 'lightgallery');

					if( $_js_vars['lightboxThumbs'] == true ) {
						wp_enqueue_script( 'lightgallery-thumb');
					}
					if( $_js_vars['lightboxFullscreen'] == true ) {
						wp_enqueue_script( 'lightgallery-fullscreen');
					}
					if( $_js_vars['lightboxAutoplay'] == true ) {
						wp_enqueue_script( 'lightgallery-autoplay');
					}
					if( $_js_vars['lightboxZoom'] == true ) {
						wp_enqueue_script( 'lightgallery-zoom');
					}

					/** load static stylesheet **/
					wp_enqueue_style( 'wplab-albedo-image-carousel', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/image_carousel.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_style( 'wplab-albedo-image-carousel-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/image_carousel_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

					wp_enqueue_script( 'wplab-albedo-image-carousel', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/media-image-carousel/static/js/scripts.js'), array('jquery', 'masonry'), _WPLAB_ALBEDO_CACHE_TIME_, true );
					wp_localize_script( 'wplab-albedo-image-carousel', 'wplabAlbedoMediaImageCarousel', $_js_vars );

				} else if( in_array( $single_post_style, array( 'layout_8', 'layout_11') ) ) {
					// grid part

					/** include LightGallery library styles **/
					wp_enqueue_style( 'lightgallery', get_template_directory_uri() . '/css/libs/lightgallery.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_style( 'lightgallery-transitions', get_template_directory_uri() . '/css/libs/lg-transitions.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_script( 'lightgallery');

					if( $_js_vars['lightboxThumbs'] == true ) {
						wp_enqueue_script( 'lightgallery-thumb');
					}
					if( $_js_vars['lightboxFullscreen'] == true ) {
						wp_enqueue_script( 'lightgallery-fullscreen');
					}
					if( $_js_vars['lightboxAutoplay'] == true ) {
						wp_enqueue_script( 'lightgallery-autoplay');
					}
					if( $_js_vars['lightboxZoom'] == true ) {
						wp_enqueue_script( 'lightgallery-zoom');
					}

					/** include Justified Grid **/
					wp_enqueue_style( 'justified-grid', get_template_directory_uri() . '/css/libs/justified.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
					wp_enqueue_script( 'justified-grid');

					wp_enqueue_script( 'wplab-albedo-justified-image-grid', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/media-image-gallery/static/js/scripts.js'), array('jquery', 'justified-grid'), _WPLAB_ALBEDO_CACHE_TIME_, true );
					wp_localize_script( 'wplab-albedo-justified-image-grid', 'wplabAlbedoImageGallery', $_js_vars );

				}

				// similar posts
				if( filter_var( fw_get_db_customizer_option( 'portfolio_single_display_similar_posts/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
					$similar_posts_style = fw_get_db_customizer_option( 'portfolio_single_display_similar_posts/yes/portfolio_single_similar_posts_style' );

					if( $similar_posts_style == 'carousel' ) {
						wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
						wp_enqueue_script( 'swiper');
						wp_enqueue_script( 'wplab-albedo-image-carousel', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/media-image-carousel/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );
					}
				}

				// prev / next
				if( filter_var( fw_get_db_customizer_option( 'portfolio_single_display_prev_next_posts/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
					$prev_next_posts_style = fw_get_db_customizer_option( 'portfolio_single_display_prev_next_posts/yes/portfolio_single_prev_next_posts_style' );
					if( $prev_next_posts_style =='thumb_title' ) {
						wp_enqueue_script( 'parallax');
					}
				}

				unset( $_js_vars );

			}

			/** single post video **/
			if( filter_var( fw_get_db_post_option( get_the_ID(), 'display_video_before_content/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
				wplab_albedo_utils::enqueue_lightbox();
				wp_enqueue_script( 'lightgallery-video');
				wp_enqueue_script( 'wplab-albedo-video', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/media-video-lightbox/static/js/scripts.js'), array('jquery', 'wplab-albedo-front'), _WPLAB_ALBEDO_CACHE_TIME_, true );
				wp_localize_script( 'wplab-albedo-video', 'wplabAlbedoVideoLightbox', $js_vars );
			}

			$custom_tpl_page_id = get_query_var('wplab_albedo_custom_tpl_id');
			if( is_numeric( $custom_tpl_page_id ) && function_exists('fw_ext_page_builder_is_builder_post') && fw_ext_page_builder_is_builder_post( $custom_tpl_page_id ) ) {
				fw_ext_shortcodes_enqueue_shortcodes_static( fw_ext_page_builder_get_post_content( $custom_tpl_page_id ) );
			}

			/** Header scripts **/
			$header_parallax = fw_get_db_customizer_option( 'header_parallax_effect', $wplab_albedo_core->default_options['header_parallax_effect']);
			if( $header_parallax['effect'] == 'parallax' ) {
				if( ! wp_is_mobile() ) {
					wp_enqueue_script( 'stellar');
				}
				wp_enqueue_script( 'wplab-albedo-section-stellar', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/stellar.js'), array('stellar'), _WPLAB_ALBEDO_CACHE_TIME_, true );
			} elseif( $header_parallax['effect'] == 'mouse_parallax' ) {
				wp_enqueue_script( 'parallax');
				wp_enqueue_script( 'wplab-albedo-section-parallax', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/mouse_parallax.js'), array('parallax'), _WPLAB_ALBEDO_CACHE_TIME_, true );
			}

			$header_media_effect = fw_get_db_customizer_option( 'header_media_effect', $wplab_albedo_core->default_options['header_media_effect']);
			if( $header_media_effect['effect'] == 'video' ) {
				wp_enqueue_script( 'youtube-background' );
				wp_enqueue_script( 'wplab-albedo-section-ytbg', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/youtube_bg.js'), array('youtube-background'), _WPLAB_ALBEDO_CACHE_TIME_, true );
				$_video_parallax_speed = fw_get_db_customizer_option( 'header_media_effect/video/video_parallax_speed', $wplab_albedo_core->default_options['header_videobg_parallax_speed']);
				if( $_video_parallax_speed <> '' ) {
					if( ! wp_is_mobile() ) {
						wp_enqueue_script( 'stellar');
					}
					wp_enqueue_script( 'wplab-albedo-section-stellar', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/stellar.js'), array('stellar'), _WPLAB_ALBEDO_CACHE_TIME_, true );
				}
			} elseif( $header_media_effect['effect'] == 'particleground' ) {
				wp_enqueue_script( 'particleground');
				wp_enqueue_script( 'wplab-albedo-section-particleground', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/particleground.js'), array('particleground'), _WPLAB_ALBEDO_CACHE_TIME_, true );
			} elseif( $header_media_effect['effect'] == 'particles' ) {
				wp_enqueue_script( 'particles');
			}

			/** Footer scripts **/
			$footer_parallax = fw_get_db_customizer_option( 'footer_parallax_effect', $wplab_albedo_core->default_options['footer_parallax_effect']);
			if( $footer_parallax['effect'] == 'parallax' ) {
				if( ! wp_is_mobile() ) {
					wp_enqueue_script( 'stellar');
				}
					wp_enqueue_script( 'wplab-albedo-section-stellar', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/stellar.js'), array('stellar'), _WPLAB_ALBEDO_CACHE_TIME_, true );
			} elseif( $footer_parallax['effect'] == 'mouse_parallax' ) {
				wp_enqueue_script( 'parallax');
					wp_enqueue_script( 'wplab-albedo-section-parallax', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/mouse_parallax.js'), array('parallax'), _WPLAB_ALBEDO_CACHE_TIME_, true );
			}

			$footer_media_effect = fw_get_db_customizer_option( 'footer_media_effect', $wplab_albedo_core->default_options['footer_media_effect']);
			if( $footer_media_effect['effect'] == 'video' ) {
				wp_enqueue_script( 'youtube-background' );
					wp_enqueue_script( 'wplab-albedo-section-ytbg', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/youtube_bg.js'), array('youtube-background'), _WPLAB_ALBEDO_CACHE_TIME_, true );
				$_video_parallax_speed = fw_get_db_customizer_option( 'footer_media_effect/video/video_parallax_speed', $wplab_albedo_core->default_options['footer_videobg_parallax_speed']);
				if( $_video_parallax_speed <> '' ) {
					if( ! wp_is_mobile() ) {
							wp_enqueue_script( 'stellar');
						}
							wp_enqueue_script( 'wplab-albedo-section-stellar', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/stellar.js'), array('stellar'), _WPLAB_ALBEDO_CACHE_TIME_, true );
				}
			} elseif( $footer_media_effect['effect'] == 'particleground' ) {
				wp_enqueue_script( 'particleground');
				wp_enqueue_script( 'wplab-albedo-section-particleground', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/particleground.js'), array('particleground'), _WPLAB_ALBEDO_CACHE_TIME_, true );
			} elseif( $footer_media_effect['effect'] == 'particles' ) {
				wp_enqueue_script( 'particles');
			}
		}

	}

	/**
	 * Add styles
	 **/
	function add_styles() {
		global $wp_styles, $wplab_albedo_core, $post;

		if( wplab_albedo_utils::is_unyson() && fw_get_db_customizer_option( 'page_preloader/style' ) != 'hidden' ) {
			wp_enqueue_style( 'wplab-albedo-preloaders', wplab_albedo_utils::locate_uri( '/css/front/css/preloader.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		}

		wp_enqueue_style( 'wplab-albedo-animate', wplab_albedo_utils::locate_uri( '/css/libs/animate.min.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'fw-font-awesome', wplab_albedo_utils::locate_uri( '/css/libs/font-awesome.min.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/** top bar styles **/
		if( wplab_albedo_utils::is_unyson() && filter_var( fw_get_db_customizer_option( 'top_bar_enabled/enabled'), FILTER_VALIDATE_BOOLEAN ) ) {
			wp_enqueue_style( 'wplab-albedo-top-bar', wplab_albedo_utils::locate_uri( '/css/front/css/headers/top_bar.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'wplab-albedo-top-bar-variable', wplab_albedo_utils::locate_uri( '/css/front/less/headers/top_bar_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		}

		/** header styles **/
		$header_layout = wplab_albedo_utils::get_theme_mod(
			'header_layout',
			$wplab_albedo_core->default_options['header_layout']
		);

		$menu_style = wplab_albedo_utils::get_theme_mod(
			'menu_style/style',
			$wplab_albedo_core->default_options['menu_style']
		);

		wp_enqueue_style( 'wplab-albedo-header', wplab_albedo_utils::locate_uri( '/css/front/css/headers/head-' . $header_layout . '.css' ), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-header-variable', wplab_albedo_utils::locate_uri( '/css/front/less/headers/head-' . $header_layout . '_variable.less' ), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		wp_enqueue_style( 'wplab-albedo-menu', wplab_albedo_utils::locate_uri( '/css/front/css/headers/menu-' . $menu_style . '.css' ), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-menu-variable', wplab_albedo_utils::locate_uri( '/css/front/less/headers/menu-' . $menu_style . '_variable.less' ), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		if( $menu_style == 'minimal' ) {

			$submenu_style = wplab_albedo_utils::get_theme_mod(
				'menu_style/minimal/submenu_minimal_style',
				$wplab_albedo_core->default_options['submenu_minimal_style']
			);

			wp_enqueue_style( 'wplab-albedo-submenu-minimal', wplab_albedo_utils::locate_uri( '/css/front/less/headers/submenu_minimal_' . $submenu_style . '.less' ), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		} else {

			wp_enqueue_style( 'wplab-albedo-submenu', wplab_albedo_utils::locate_uri( '/css/front/less/headers/submenu.less' ), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		}

		/** header widgets styles **/
		if( wplab_albedo_utils::is_unyson() ) {

			if(
				filter_var( fw_get_db_customizer_option( 'menu_cart' ), FILTER_VALIDATE_BOOLEAN )
				|| filter_var( fw_get_db_customizer_option( 'menu_search' ), FILTER_VALIDATE_BOOLEAN )
				|| filter_var( fw_get_db_customizer_option( 'menu_side_overlay' ), FILTER_VALIDATE_BOOLEAN )
			) {
				wp_enqueue_style( 'wplab-albedo-head-widgets', wplab_albedo_utils::locate_uri( '/css/front/less/headers/header-widgets.less' ), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}

		}

		/** base styles **/
		wp_enqueue_style( 'wplab-albedo-base', wplab_albedo_utils::locate_uri( '/css/front/css/base.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-variable', wplab_albedo_utils::locate_uri( '/css/front/less/variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/** 404 styles **/
		if( is_404() ) {

			wp_enqueue_style( 'wplab-albedo-404', wplab_albedo_utils::locate_uri( '/css/front/css/404.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'wplab-albedo-404-variable', wplab_albedo_utils::locate_uri( '/css/front/less/404_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

			if( wplab_albedo_utils::is_unyson() ) {
				$css404 = 'body.error404, .wrapper404 .layer div {';

				$css404 .= 'background-position: ' . fw_get_db_customizer_option( 'page_404_bg_img_position' ) . ';';
				$css404 .= 'background-repeat: ' . fw_get_db_customizer_option( 'page_404_bg_img_repeat' ) . ';';
				$css404 .= 'background-attachment: ' . fw_get_db_customizer_option( 'page_404_bg_img_attachment' ) . ';';
				$css404 .= 'background-size: ' . fw_get_db_customizer_option( 'page_404_bg_img_cover' ) . ';';

				$img404 = fw_get_db_customizer_option( 'page_404_bg_img' );

				if( isset( $img404['data']['css']['background-image'] ) && $img404['data']['css']['background-image'] <> '' ) {
					$css404 .= 'background-image: ' . $img404['data']['css']['background-image'] . ';';
				}

				$css404 .= '}';

				if( filter_var( fw_get_db_customizer_option( 'page_404_slider_footer_mode' ), FILTER_VALIDATE_BOOLEAN ) ) {
					$this->add_inline_css('#footer { position: fixed; bottom: 0; left: 0; right: 0; z-index: 50; background: none; } #bottom-bar { background: none; } #footer .bottom-bar-content { border: 0; }');
				}

				wp_add_inline_style( 'wplab-albedo-404-variable', $css404 );
			}

		/** we Docs styles **/
	} elseif( wplab_albedo_utils::is_wedocs() && ( (is_single() && get_post_type() == 'docs') || (get_the_ID() == wedocs_get_option( 'docs_home', 'wedocs_settings' )) ) ) {

			wp_enqueue_style( 'wplab-albedo-wedocs', wplab_albedo_utils::locate_uri( '/css/front/less/plugins/wedocs.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

			if( is_search() ) {
				// include blog shortcode styles
				wp_enqueue_style( 'wplab-albedo-blog-2cols', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog_2cols.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
				wp_enqueue_style( 'wplab-albedo-blog-2cols-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_2cols_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}

		/** portfolio archives **/
		} elseif( is_tax( 'fw-portfolio-category') || is_post_type_archive('fw-portfolio') ) {

			wp_enqueue_style( 'masonry', get_template_directory_uri() . '/css/libs/masonry.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'masonry-effects', get_template_directory_uri() . '/css/libs/masonry_effects.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'wplab-albedo-portfolio-masonry', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/portfolio_masonry.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'wplab-albedo-portfolio-masonry-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/portfolio_masonry_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/** search page styles **/
		} elseif( is_search() ) {

			// include blog shortcode styles
			wp_enqueue_style( 'wplab-albedo-blog-2cols', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog_2cols.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'wplab-albedo-blog-2cols-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_2cols_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/** blog styles **/
		} elseif( is_home() || is_archive() || is_category() || is_author() || is_tag() ) {
			wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			// include blog shortcode styles
			wp_enqueue_style( 'wplab-albedo-blog', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/blog.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'wplab-albedo-blog-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/blog_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

			$custom_page_header_bg = array();
			if( is_home() && wplab_albedo_utils::is_unyson() ) {
				$custom_page_header_bg = fw_get_db_post_option( get_option('page_for_posts'), 'page_header_bg' );
			}
			if( isset( $custom_page_header_bg['url'] ) && $custom_page_header_bg['url'] <> '' ) {
				$this->add_inline_css('#header { background-image: url(' . $custom_page_header_bg['url'] . '); }');
			}

		/** single page styles **/
		} elseif( is_page() ) {

			if( wplab_albedo_utils::is_unyson() ) {
				$custom_bg = fw_get_db_post_option( get_the_ID(), 'page_body_bg_color' );
				if( $custom_bg <> '' ) {
					$this->add_inline_css('body { background-color: ' . $custom_bg . '; }');
				}

				$custom_page_header_bg = fw_get_db_post_option( get_the_ID(), 'page_header_bg' );
				if( is_array( $custom_page_header_bg ) && isset( $custom_page_header_bg['url'] ) && $custom_page_header_bg['url'] <> '' ) {
					$this->add_inline_css('#header { background-image: url(' . $custom_page_header_bg['url'] . '); }');
				}

				if( filter_var( fw_get_db_post_option( get_the_ID(), 'slider_footer_mode' ), FILTER_VALIDATE_BOOLEAN ) ) {
					$this->add_inline_css('#footer { position: fixed; bottom: 0; left: 0; right: 0; z-index: 50; background: none; } #bottom-bar { background: none; } #footer .bottom-bar-content { border: 0; }');
				}

			}


		/** single portfolio styles **/
		} elseif( is_singular( 'fw-portfolio') ) {

			wp_enqueue_style( 'wplab-albedo-portfolio-single', wplab_albedo_utils::locate_uri( '/css/front/css/portfolio/single.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'wplab-albedo-portfolio-single-variable', wplab_albedo_utils::locate_uri( '/css/front/less/portfolio/single_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

			$custom_post_header_bg = fw_get_db_post_option( get_the_ID(), 'page_header_bg' );
			if( is_array( $custom_post_header_bg ) && isset( $custom_post_header_bg['url'] ) && $custom_post_header_bg['url'] <> '' ) {
				$this->add_inline_css('#header { background-image: url(' . $custom_post_header_bg['url'] . '); }');
			}

			$display_pre_next_posts = wplab_albedo_utils::get_theme_mod( 'portfolio_single_display_prev_next_posts/enabled', $wplab_albedo_core->default_options['portfolio_single_display_prev_next_posts'] );
			if( $display_pre_next_posts ) {
				$prev_next_style = wplab_albedo_utils::get_theme_mod( 'portfolio_single_display_prev_next_posts/yes/portfolio_single_prev_next_posts_style', $wplab_albedo_core->default_options['portfolio_single_prev_next_posts_style'] );
				wp_enqueue_style( 'wplab-albedo-prev-next-posts', wplab_albedo_utils::locate_uri( '/css/front/css/posts/prev_next_posts_' . $prev_next_style . '.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
				wp_enqueue_style( 'wplab-albedo-prev-next-posts-variable', wplab_albedo_utils::locate_uri( '/css/front/less/posts/prev_next_posts_' . $prev_next_style . '_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}

		/** single blog styles **/
		} elseif( is_single() ) {

			$single_style = wplab_albedo_utils::get_theme_mod( 'blog_single_post_style', $wplab_albedo_core->default_options['blog_single_post_style'] );

			wp_enqueue_style( 'wplab-albedo-blog', wplab_albedo_utils::locate_uri( '/css/front/css/blog/single_' . $single_style . '.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'wplab-albedo-blog-variable', wplab_albedo_utils::locate_uri( '/css/front/less/blog/single_' . $single_style . '_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

			$display_pre_next_posts = wplab_albedo_utils::get_theme_mod( 'blog_single_display_prev_next_posts/enabled', $wplab_albedo_core->default_options['blog_single_display_prev_next_posts'] );
			if( $display_pre_next_posts ) {
				$prev_next_style = wplab_albedo_utils::get_theme_mod( 'blog_single_display_prev_next_posts/yes/blog_single_prev_next_posts_style', $wplab_albedo_core->default_options['blog_single_prev_next_posts_style'] );
				wp_enqueue_style( 'wplab-albedo-prev-next-posts', wplab_albedo_utils::locate_uri( '/css/front/css/posts/prev_next_posts_' . $prev_next_style . '.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
				wp_enqueue_style( 'wplab-albedo-prev-next-posts-variable', wplab_albedo_utils::locate_uri( '/css/front/less/posts/prev_next_posts_' . $prev_next_style . '_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}

			if( wplab_albedo_utils::is_unyson() ) {
				$custom_page_header_bg = fw_get_db_post_option( get_the_ID(), 'page_header_bg' );
				if( is_array( $custom_page_header_bg ) && isset( $custom_page_header_bg['url'] ) && $custom_page_header_bg['url'] <> '' ) {
					$this->add_inline_css('#header { background-image: url(' . $custom_page_header_bg['url'] . '); }');
				}
			}

			if( get_post_format() == 'gallery' || has_shortcode( $post->post_content, 'gallery') ) {
				wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			}

		}

		/** sidebar styles **/
		wp_enqueue_style( 'wplab-albedo-aside', wplab_albedo_utils::locate_uri( '/css/front/css/aside.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-aside-variable', wplab_albedo_utils::locate_uri( '/css/front/less/aside_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/** footer styles **/
		$is_footer_enabled = filter_var( wplab_albedo_utils::get_theme_mod( 'footer_widgets/enabled', $wplab_albedo_core->default_options['footer_widgets'] ) );
		$is_footer_bar_enabled = filter_var( wplab_albedo_utils::get_theme_mod( 'footer_bar/enabled', $wplab_albedo_core->default_options['footer_bar'] ) );

		if( $is_footer_enabled ) {
			wp_enqueue_style( 'wplab-albedo-footer', wplab_albedo_utils::locate_uri( '/css/front/css/footers/footer.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'wplab-albedo-footer-variable', wplab_albedo_utils::locate_uri( '/css/front/less/footers/footer_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		}

		if( $is_footer_bar_enabled ) {
			$footer_bar_style = wplab_albedo_utils::get_theme_mod( 'footer_bar/yes/footer_bar_style', $wplab_albedo_core->default_options['footer_bar_style'] );
			wp_enqueue_style( 'wplab-albedo-footer-bar-variable', wplab_albedo_utils::locate_uri( '/css/front/less/footers/footer_bar_' . $footer_bar_style . '.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		}

		/** default theme style file **/
		wp_enqueue_style( 'wplab-albedo-style', wplab_albedo_utils::locate_uri( '/style.css' ), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		if( wplab_albedo_utils::is_unyson() ) {
			/** custom header paddings **/
			$subheader_top_padding = fw_get_db_customizer_option( 'subheader_custom_top_padding');
			if( $subheader_top_padding <> '' ) {
				wp_add_inline_style( 'wplab-albedo-style', '#header-title-desc{ padding-top: ' . $subheader_top_padding . '; }' );
			}
			$subheader_bottom_padding = fw_get_db_customizer_option( 'subheader_custom_bottom_padding');
			if( $subheader_bottom_padding <> '' ) {
				wp_add_inline_style( 'wplab-albedo-style', '#header-title-desc{ padding-bottom: ' . $subheader_bottom_padding . '; }' );
			}

			/** custom footer paddings **/
			$footer_top_padding = fw_get_db_customizer_option( 'footer_top_padding');
			if( $footer_top_padding <> '' ) {
				wp_add_inline_style( 'wplab-albedo-style', '#footer-widgets { padding-top: ' . $footer_top_padding . '; }' );
			}
			$footer_bottom_padding = fw_get_db_customizer_option( 'footer_bottom_padding');
			if( $footer_bottom_padding <> '' ) {
				wp_add_inline_style( 'wplab-albedo-style', '#footer-widgets { padding-bottom: ' . $footer_bottom_padding . '; }' );
			}

			/** custom header bottom margin **/
			$header_bottom_margin = fw_get_db_customizer_option( 'header_bottom_margin');
			if( $header_bottom_margin <> '' ) {
				wp_add_inline_style( 'wplab-albedo-style', '#header { margin-bottom: ' . $header_bottom_margin . '; }' );
			}

			/** custom menu item margins **/
			$menu_items_right_margin = fw_get_db_customizer_option( 'menu_items_right_margin');
			if( $menu_items_right_margin <> '' ) {
				wp_add_inline_style( 'wplab-albedo-style', '#header .responsive-mode-off .menu-layout-item.item-menu, #header-menu-wrapper-clone .responsive-mode-off .menu-layout-item.item-menu { margin-right: ' . $menu_items_right_margin . 'px; }' );
			}

			$menu_items_left_margin = fw_get_db_customizer_option( 'menu_items_left_margin');
			if( $menu_items_left_margin <> '' ) {
				wp_add_inline_style( 'wplab-albedo-style', '#header .responsive-mode-off .menu-layout-item.item-menu, #header-menu-wrapper-clone .responsive-mode-off .menu-layout-item.item-menu { margin-left: ' . $menu_items_right_margin . 'px; }' );
			}

		}

		if( wplab_albedo_utils::is_woocommerce() ) {
			wp_enqueue_style( 'wplab-albedo-woocommerce', wplab_albedo_utils::locate_uri( '/css/front/css/plugins/woocommerce.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_style( 'wplab-albedo-woocommerce-variable', wplab_albedo_utils::locate_uri( '/css/front/less/plugins/woocommerce_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		}

		/** load theme fonts **/
		$wplab_albedo_core->controller->init->load_theme_fonts();

	}

	/**
	 * Add later styles to override some plugins
	**/
	function add_later_styles() {
		if( wplab_albedo_utils::is_vc() ) {
			wp_enqueue_style( 'wplab-albedo-vc', wplab_albedo_utils::locate_uri( '/css/front/css/plugins/visual_composer.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		}
	}

	/**
	 * Remove some default styles
	 **/
	function remove_styles() {
		wp_dequeue_style( 'fw-ext-breadcrumbs-add-css' );
		if( wplab_albedo_utils::is_wedocs() ) {
			wp_dequeue_style( 'wedocs-styles' );
		}
	}

	/**
	 * Title filter
	 **/
	function wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() )
			return $title;

		if( is_home() || is_front_page() )
			return $title;

		return $title . ' ' . $sep . ' ' . get_bloginfo( 'description' );

	}

	/**
	 * Add custom body classes
	 **/
	function body_classes( $classes ) {
		global $wplab_albedo_core;

		$classes[] = 'anim-on';

		if( wp_is_mobile() ) {
			$classes[] = 'mobile-device';
		}

		if( is_404() ) {
			$classes[] = 'page404-style-' . wplab_albedo_utils::get_theme_mod( 'page_404_style', $wplab_albedo_core->default_options['page_404_style'] );
		}

		if( wplab_albedo_utils::is_unyson() ) {

			/** one page navigation **/
			if( is_page() && filter_var( fw_get_db_post_option( get_the_ID(), 'one_page_menu' ), FILTER_VALIDATE_BOOLEAN ) ) {
				$classes[] = 'one-page-navigation';
			}

			/**
			 * Layout type
			 **/
			$classes[] = 'layout-type-' . fw_get_db_customizer_option( 'layout_type' );

			/**
			 * Preloader
			 **/
			if( fw_get_db_customizer_option( 'page_preloader/style' ) != 'hidden' ) {
				$classes[] = 'preloader';
			}

			/**
			 * Mobile animations
			 **/
			if( filter_var( fw_get_db_customizer_option('css_animations_mobile' ), FILTER_VALIDATE_BOOLEAN ) ) {
				$classes[] = 'anim-mobile-on';
			} else {
				$classes[] = 'anim-mobile-off';
			}

			/**
			 * Custom inputs
			 **/
			if( ! filter_var( fw_get_db_customizer_option( 'custom_inputs' ), FILTER_VALIDATE_BOOLEAN ) ) {
				$classes[] = 'no-custom-input';
			}

			/**
			 * Hide sidebar on mobiles
			 **/
			if( filter_var( fw_get_db_customizer_option( 'hide_sidebar_on_mobiles' ), FILTER_VALIDATE_BOOLEAN ) ) {
				$classes[] = 'hide-side-on-mobiles';
			}

			if( wplab_albedo_utils::is_woocommerce() ) {
				$classes[] = 'woo-products-' . fw_get_db_customizer_option( 'woo_products_style' );
				$classes[] = 'woo-single-' . fw_get_db_customizer_option( 'woo_single_post_style' );
				$classes[] = 'woo-pagination-' . fw_get_db_customizer_option( 'woo_pagination_style' );
			}

		} else {
			$classes[] = 'no-unyson';
			$classes[] = 'woo-products-style_1';
			$classes[] = 'woo-single-style_1';
			$classes[] = 'woo-pagination-style_1';
		}


		/**
		 * Sidebar position
		 **/
		if( function_exists('fw_ext_sidebars_get_current_position') ) {
			$current_sidebar_position = fw_ext_sidebars_get_current_position();
			if( is_null( $current_sidebar_position ) ) {
				$current_sidebar_position = 'right';
			}
			$classes[] = 'sidebar-' . $current_sidebar_position;
		} else {
			$classes[] = 'sidebar-right';
		}

		return $classes;

	}

	/**
	 * Custom search template
	 **/
	function custom_search_template() {
		ob_start();
		include wplab_albedo_utils::locate_path( '/template-parts/search-form.php' );
		return ob_get_clean();
	}

	/**
	 * Customize password form
	 **/
	function customize_password_protect() {
			global $post;
			$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
			$o = '<form class="post-password-form" action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
			<p>' . esc_html__( "To view this protected post, enter the password below:", 'albedo' ) . '</p>
			<p><input class="pass" placeholder="' . esc_attr__( "Type here post password", 'albedo' ) . '" name="post_password" id="' . $label . '" type="password" maxlength="20" /></p><p><input type="submit" name="Submit" value="' . esc_attr__( "Submit", 'albedo' ) . '" /></p>
			</form>
			';
			return $o;
	}

	/**
	 * Add inline CSS styles
	 **/
	function add_inline_css( $content ) {
		$this->inline_css = $this->inline_css . "\r\n" . $content;
	}

	/**
	 * Add custom CSS classes to the comment reply link
	 **/
	function comment_reply_link( $class ) {
		$class = str_replace("class='comment-reply-link", "class='comment-reply-link button size-small style-white", $class);
		return $class;
	}

	/**
	 * Move comment field to bottom
	 **/
	function move_comment_field_to_bottom( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}

	/**
	 * Custom archive templates
	 **/
	function template_redirect( $template ) {

		if( wplab_albedo_utils::is_unyson() ) {

			$custom_tpl = array();

			if( is_author() ) {
				$custom_tpl = fw_get_db_settings_option( 'tpl_author' );
			} elseif( is_post_type_archive( 'fw-portfolio' ) ) {
				$custom_tpl = fw_get_db_settings_option( 'tpl_archive_portfolio' );
			} elseif( is_tax( 'fw-portfolio-category') ) {
				$custom_tpl = fw_get_db_settings_option( 'tpl_portfolio_category' );
			} elseif( is_tag() ) {
				$custom_tpl = fw_get_db_settings_option( 'tpl_tag' );
			} elseif( is_category() ) {
				$custom_tpl = fw_get_db_settings_option( 'tpl_category' );
			} elseif( is_post_type_archive( 'post' ) || is_home() ) {
				$custom_tpl = fw_get_db_settings_option( 'tpl_archive_blog' );
			}

			if( is_array( $custom_tpl ) && count( $custom_tpl ) > 0 ) {
				set_query_var( 'wplab_albedo_custom_tpl_id', absint( $custom_tpl[0] ) );
				return locate_template( 'page-custom-tpl.php');
			}

		}

		return $template;

	}

	/**
	 * Modify nav menu classes
	**/
	function modify_nav_classes( $classes, $item ) {
		if( ( is_singular( 'fw-portfolio' ) && $item->object_id == get_option('page_for_posts') )
				|| (is_post_type_archive() && $item->object_id == get_option('page_for_posts'))
				|| is_singular( 'docs' )
				|| is_singular( 'benefits' )
		){
					$classes = array_diff( $classes, array( 'current_page_parent' ) );
			}
			return $classes;
	}

	/**
	 * Print custom CSS code
	**/
	function print_custom_css() {
		$customizer_css = function_exists( 'fw_get_db_customizer_option') ? fw_get_db_customizer_option( 'custom_css_code', '') : '';
		?>
		<style type="text/css">
			<?php echo $this->inline_css . ' ' . $customizer_css; ?>
		</style>
		<?php

	}

}
