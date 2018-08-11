<?php
/**
 * Theme init
 **/
class wplab_albedo_init_controller {

	function __construct() {

		// add theme support
		add_action( 'after_setup_theme', array( $this, 'add_theme_support'));

		// register menus
		add_action( 'init', array( $this, 'register_menus'));

		// register sidebars
		add_action( 'widgets_init', array( $this, 'register_sidebars'));

		// Hide chosen customizer option to make it faster
		add_action( 'customize_register', array( $this, 'optimize_customizer' ), 10 );

		// Change image crop position
		if( wplab_albedo_utils::is_unyson() && fw_get_db_settings_option( 'thumbs_crop_position' ) == 'top' ) {
			add_filter( 'image_resize_dimensions', array( $this, 'change_thumbnails_crop_position' ), 10, 6 );
		}

	}

	/**
	 * Add theme support
	 **/
	function add_theme_support() {
		add_theme_support( 'automatic-feed-links' );
		/**
		if( is_admin() ) {
			add_editor_style();
		}
		**/
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'post-formats', array( 'gallery', 'quote', 'video', 'audio', 'link' ) );
		add_theme_support( 'menus' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		//add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		add_post_type_support( 'fw-portfolio', 'excerpt' );
		remove_post_type_support( 'page', 'comments' );
		remove_post_type_support( 'page', 'thumbnail' );

	}

	/**
	 * Register theme menus
	 **/
	function register_menus() {
		register_nav_menus( array(
			'header_menu' => esc_html__('Header Menu', 'albedo'),
			'header_onepage_menu' => esc_html__('Header One Page Menu', 'albedo'),
			'header_second_menu' => esc_html__('Header Second Menu', 'albedo'),
		));
	}

	/**
	 * Register theme sidebars
	 **/
	function register_sidebars() {

		register_sidebar( array(
			'name'          => esc_html__( 'Left Sidebar', 'albedo' ),
			'id'            => 'sidebar-left',
			'description'   => esc_html__( 'Appears in the left side of the site.', 'albedo' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Right Sidebar', 'albedo' ),
			'id'            => 'sidebar-right',
			'description'   => esc_html__( 'Appears in the right side of the site.', 'albedo' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Menu Sidebar', 'albedo' ),
			'id'            => 'sidebar-menu',
			'description'   => esc_html__( 'Appears on Menu Side on click.', 'albedo' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Shop Sidebar', 'albedo' ),
			'id'            => 'sidebar-shop',
			'description'   => esc_html__( 'Appears on WooCommerce pages.', 'albedo' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

		register_sidebar( array(
			'name'          => esc_html__( 'Footer Widgets Area', 'albedo' ),
			'id'            => 'sidebar-footer',
			'description'   => esc_html__( 'Appears in the footer section of the site.', 'albedo' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  => '<div class="clearfix"></div></div></div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>'
		));

	}

	/**
	 * Load theme fonts
	 **/
	function load_theme_fonts() {
		global $wplab_albedo_core;

		if( ! wplab_albedo_utils::is_unyson() ) {
			require_once get_template_directory() . '/css/front/skins/' . $wplab_albedo_core->current_skin . '/fonts.php';
			return;
		}

		$fonts = array(
			'primary_font' => fw_get_db_customizer_option( 'primary_font' ),
			'secondary_font' => fw_get_db_customizer_option( 'secondary_font' ),
			'small_button_font' => fw_get_db_customizer_option( 'small_button_font' ),
			'medium_button_font' => fw_get_db_customizer_option( 'medium_button_font' ),
			'large_button_font' => fw_get_db_customizer_option( 'large_button_font' ),
			'xlarge_button_font' => fw_get_db_customizer_option( 'xlarge_button_font' ),
			'title_font' => fw_get_db_customizer_option( 'title_font' ),
			'tagline_font' => fw_get_db_customizer_option( 'tagline_font' ),
			'h1_font' => fw_get_db_customizer_option( 'h1_font' ),
			'h2_font' => fw_get_db_customizer_option( 'h2_font' ),
			'h3_font' => fw_get_db_customizer_option( 'h3_font' ),
			'h4_font' => fw_get_db_customizer_option( 'h4_font' ),
			'h5_font' => fw_get_db_customizer_option( 'h5_font' ),
			'h6_font' => fw_get_db_customizer_option( 'h6_font' ),
		);

		$_families = array();
		$_subsets = array();
		$custom_google_fonts_string = '';

		foreach( $fonts as $k=>$font ) {

			if( $font['google_font'] ) {

				if( is_string( $font['variation'] ) || is_numeric( $font['variation'] ) ) {
					$_families[$font['family']][] = $font['variation'];
				} else {
					$_families[$font['family']][] = 'regular';
				}

				if( $font['subset'] != 'latin' ) {
					$_subsets[] = $font['subset'];
				}
			}

		}


		foreach( $_families as $font=>$variation ) {
			if( is_array( $variation ) ) {
				$custom_google_fonts_string .= $font . ':' . implode(',', array_filter( array_unique( $variation ) ) ) . '|';
			} else {
				$custom_google_fonts_string .= $font . '|';
			}
		}

		if( $custom_google_fonts_string <> '' ) {
			$custom_google_fonts_string = substr_replace( $custom_google_fonts_string, "", -1);
			$custom_google_fonts_string .= '&subset=' . implode( ',', array_filter( array_unique( $_subsets ) ) );
			wp_enqueue_style( 'theme-google-fonts', '//fonts.googleapis.com/css?family=' . $custom_google_fonts_string );
		}

	}

	/**
	 * Optimize customizer
	 **/
	function optimize_customizer( $wp_customize ) {
		$hidden_sections = (array)get_option('wplab_albedo_hidden_customizer_sections');

		if( count( $hidden_sections ) > 0 ) {
			foreach( $hidden_sections as $k => $section ) {
				$wp_customize->remove_section( $section );
				$wp_customize->remove_panel( $section );
			}
		}
	}

	/**
	 *	Change thumbnails crop position to top
	 **/
	function change_thumbnails_crop_position( $payload, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
		// Change this to a conditional that decides whether you
		// want to override the defaults for this image or not.
		if( false )
			return $payload;

		if ( $crop ) {
			// crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
			$aspect_ratio = $orig_w / $orig_h;
			$new_w = min($dest_w, $orig_w);
			$new_h = min($dest_h, $orig_h);

			if ( !$new_w ) {
				$new_w = intval($new_h * $aspect_ratio);
			}

			if ( !$new_h ) {
				$new_h = intval($new_w / $aspect_ratio);
			}

			$size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

			$crop_w = round($new_w / $size_ratio);
			$crop_h = round($new_h / $size_ratio);

			$s_x = floor( ($orig_w - $crop_w) / 2 );
			$s_y = 0; // [[ formerly ]] ==> floor( ($orig_h - $crop_h) / 2 );
		} else {
			// don't crop, just resize using $dest_w x $dest_h as a maximum bounding box
			$crop_w = $orig_w;
			$crop_h = $orig_h;

			$s_x = 0;
			$s_y = 0;

			list( $new_w, $new_h ) = wp_constrain_dimensions( $orig_w, $orig_h, $dest_w, $dest_h );
		}

		// if the resulting image would be the same size or larger we don't want to resize it
		if ( $new_w >= $orig_w && $new_h >= $orig_h )
			return false;

		// the return array matches the parameters to imagecopyresampled()
		// int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
	}

}
