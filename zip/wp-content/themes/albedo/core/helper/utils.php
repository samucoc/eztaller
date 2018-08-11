<?php
	/**
	 * Utils helper
	 **/
	class wplab_albedo_utils {

		/**
		 * Get default value from config
		 **/
		public static function config( $var ) {
			global $wplab_albedo_core;
			return isset( $wplab_albedo_core->default_options[ $var ] ) ? $wplab_albedo_core->default_options[ $var ] : null;
		}

		/**
		 * Parse LESS vars into PHP array
		 **/
		public static function get_less_vars( $file ) {
			global $wplab_albedo_core;
			$less = $wplab_albedo_core->controller->io->read( $file );

			/**
			preg_match_all("/^@([^:]+):[~\s]*(['\"]?)([^;]*)\\2;?$/m", $less, $matches );
			return array_combine($matches[1], $matches[3]);
			**/

			$vars = array();

			// iterate over the lines
			foreach( explode( "\n", $less) as $ln) {
				// ignore lines that don't start with @ as they are not variables
				if( isset( $ln[0] ) && $ln[0] != "@") {
					continue;
				}
				// get the key and value for the css variable
				$bits = explode(":", $ln);
				$key = substr(trim($bits[0]), 1);
				$value = isset( $bits[1] ) ? trim($bits[1]) : '';

				// store the value
				$vars[$key] = str_replace( array('~', '\'', ';'), array('', '', ''), $value );
			}

			return $vars;

		}

		/**
		 * Delete directory and all files in it
		 **/
		public static function delete_dir( $path ) {
			if( is_dir( $path)) {
				$objects = scandir( $path);
				foreach( $objects as $object) {
					if ( $object != "." && $object !="..") {
						if ( filetype( $path . DIRECTORY_SEPARATOR . $object) == "dir") {
								self::delete_dir( $path . DIRECTORY_SEPARATOR . $object);
						} else {
								unlink( $path . DIRECTORY_SEPARATOR . $object);
						}
					}
				}
					reset( $objects);
					rmdir( $path);
			}
		}

		/**
		 * Locate path, child themes support
		 **/
		public static function locate_path( $path ) {

			$base = get_stylesheet_directory();

			if( is_child_theme() ) {
				$full_path = $base . $path;
				if( ! file_exists( $full_path ) ) {
					$base = get_template_directory();
					$full_path = $base . $path;
				}
			} else {
				$full_path = $base . $path;
			}

			return $full_path;

		}

		/**
		 * Locate URI path, child themes support
		 **/
		public static function locate_uri( $path ) {

			if( !self::is_unyson() && strpos( $path, 'less') !== false ) {
				return get_template_directory_uri() . str_replace( 'less', 'css', $path );
			}

			$base = get_stylesheet_directory();
			$base_uri = get_stylesheet_directory_uri();

			if( is_child_theme() ) {
				$full_path = $base_uri . $path;
				if( ! file_exists( $base . $path ) ) {
					$full_path = get_template_directory_uri() . $path;
				}
			} else {
				$full_path = get_template_directory_uri() . $path;
			}


			return $full_path;

		}

		/**
		 * Sanitize font family
		 **/
		public static function sanitize_font_title( $family ) {
			return trim( strtolower( str_replace( ' ', '-', $family ) ) );
		}

		/**
		 * Sanitize link
		 **/
		public static function sanitize_link( $text ) {
			return str_replace( 'http:', '', str_replace( 'https:', '', $text ) );
		}

		/**
		 * Get domain name from URL
		 **/
		public static function get_domain_name( $url ) {
			$url = parse_url( $url );
			return $url['host'];
		}

		/**
		 * Make sure that Unyson is active
		 **/
		public static function is_unyson() {
			return defined('FW') && function_exists('fw_get_db_settings_option');
		}

		/**
		 * Make sure that Visual Composer is active
		 **/
		public static function is_vc() {
			return in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		}

		/**
		 * Make sure that WooCommerce is active
		 **/
		public static function is_woocommerce() {
			return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		}

		/**
		 * Make sure that WeDocs Plugin is active
		 **/
		public static function is_wedocs() {
			return in_array( 'wedocs/wedocs.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		}

		/**
		 * Make sure that bbPress Plugin is active
		 **/
		public static function is_bbpress() {
			return in_array( 'bbpress/bbpress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
		}

		/**
		 * Make a CSS style string from params
		 * @param array
		 **/
		public static function get_styles( $styles, $unit = 'px' ) {

			$css_string = '';

			if( isset( $styles['width'] ) && $styles['width'] <> '' ) {
				$css_string .= is_numeric( $styles['width'] ) ? 'width: ' . $styles['width'] . $unit . '; ' : 'width: ' . $styles['width'] . ';';
			}

			if( isset( $styles['height'] ) && $styles['height'] <> '' ) {
				$css_string .= is_numeric( $styles['height'] ) ? 'height: ' . $styles['height'] . $unit . '; ' : 'height: ' . $styles['height'] . ';';
			}

			if( isset( $styles['top_margin'] ) && $styles['top_margin'] <> '' ) {
				$css_string .= is_numeric( $styles['top_margin'] ) ? 'margin-top: ' . $styles['top_margin'] . $unit . '; ' : 'margin-top: ' . $styles['top_margin'] . ';';
			}

			if( isset( $styles['right_margin'] ) && $styles['right_margin'] <> '' ) {
				$css_string .= is_numeric( $styles['right_margin'] ) ? 'margin-right: ' . $styles['right_margin'] . $unit . '; ' : 'margin-right: ' . $styles['right_margin'] . ';';
			}

			if( isset( $styles['bottom_margin'] ) && $styles['bottom_margin'] <> '' ) {
				$css_string .= is_numeric( $styles['bottom_margin'] ) ? 'margin-bottom: ' . $styles['bottom_margin'] . $unit . '; ' : 'margin-bottom: ' . $styles['bottom_margin'] . ';';
			}

			if( isset( $styles['left_margin'] ) && $styles['left_margin'] <> '' ) {
				$css_string .= is_numeric( $styles['left_margin'] ) ? 'margin-left: ' . $styles['left_margin'] . $unit . '; ' : 'margin-left: ' . $styles['left_margin'] . ';';
			}

			if( isset( $styles['top_padding'] ) && $styles['top_padding'] <> '' ) {
				$css_string .= is_numeric( $styles['top_padding'] ) ? 'padding-top: ' . $styles['top_padding'] . $unit . '; ' : 'padding-top: ' . $styles['top_padding'] . ';';
			}

			if( isset( $styles['right_padding'] ) && $styles['right_padding'] <> '' ) {
				$css_string .= is_numeric( $styles['right_padding'] ) ? 'padding-right: ' . $styles['right_padding'] . $unit . '; ' : 'padding-right: ' . $styles['right_padding'] . ';';
			}

			if( isset( $styles['bottom_padding'] ) && $styles['bottom_padding'] <> '' ) {
				$css_string .= is_numeric( $styles['bottom_padding'] ) ? 'padding-bottom: ' . $styles['bottom_padding'] . $unit . '; ' : 'padding-bottom: ' . $styles['bottom_padding'] . ';';
			}

			if( isset( $styles['left_padding'] ) && $styles['left_padding'] <> '' ) {
				$css_string .= is_numeric( $styles['left_padding'] ) ? 'padding-left: ' . $styles['left_padding'] . $unit . '; ' : 'padding-left: ' . $styles['left_padding'] . ';';
			}

			if( isset( $styles['top_border'] ) && $styles['top_border'] <> '' ) {
				$css_string .= is_numeric( $styles['top_border'] ) ? 'border-top-width: ' . $styles['top_border'] . $unit . '; ' : 'border-top-width: ' . $styles['top_border'] . ';';
			}

			if( isset( $styles['right_border'] ) && $styles['right_border'] <> '' ) {
				$css_string .= is_numeric( $styles['right_border'] ) ? 'border-right-width: ' . $styles['right_border'] . $unit . '; ' : 'border-right-width: ' . $styles['right_border'] . ';';
			}

			if( isset( $styles['bottom_border'] ) && $styles['bottom_border'] <> '' ) {
				$css_string .= is_numeric( $styles['bottom_border'] ) ? 'border-bottom-width: ' . $styles['bottom_border'] . $unit . '; ' : 'border-bottom-width: ' . $styles['bottom_border'] . ';';
			}

			if( isset( $styles['left_border'] ) && $styles['left_border'] <> '' ) {
				$css_string .= is_numeric( $styles['left_border'] ) ? 'border-left-width: ' . $styles['left_border'] . $unit . '; ' : 'border-left-width: ' . $styles['left_border'] . ';';
			}

			if( isset( $styles['top_border_radius'] ) && $styles['top_border_radius'] <> '' ) {
				$css_string .= is_numeric( $styles['top_border_radius'] ) ? 'border-top-left-radius: ' . $styles['top_border_radius'] . $unit . '; ' : 'border-top-left-radius: ' . $styles['top_border_radius'] . ';';
			}

			if( isset( $styles['right_border_radius'] ) && $styles['right_border_radius'] <> '' ) {
				$css_string .= is_numeric( $styles['right_border_radius'] ) ? 'border-top-right-radius: ' . $styles['right_border_radius'] . $unit . '; ' : 'border-top-right-radius: ' . $styles['right_border_radius'] . ';';
			}

			if( isset( $styles['bottom_border_radius'] ) && $styles['bottom_border_radius'] <> '' ) {
				$css_string .= is_numeric( $styles['bottom_border_radius'] ) ? 'border-bottom-right-radius: ' . $styles['bottom_border_radius'] . $unit . '; ' : 'border-bottom-right-radius: ' . $styles['bottom_border_radius'] . ';';
			}

			if( isset( $styles['left_border_radius'] ) && $styles['left_border_radius'] <> '' ) {
				$css_string .= is_numeric( $styles['left_border_radius'] ) ? 'border-bottom-left-radius: ' . $styles['left_border_radius'] . $unit . '; ' : 'border-bottom-left-radius: ' . $styles['left_border_radius'] . ';';
			}

			return $css_string;

		}

		/**
		 * Remove shortcode from string
		 **/
		public static function strip_shortcode( $code, $content ) {
			global $shortcode_tags;

			$stack = $shortcode_tags;
			$shortcode_tags = array( $code => 1 );

			$content = strip_shortcodes( $content );

			$shortcode_tags = $stack;
			return $content;
		}

		/**
		 * String email into link
		 **/
		public static function emailize( $str ) {
			//Detect and create email
			$mail_pattern = "/([\.A-z0-9_-]+\@[A-z0-9_-]+\.)([A-z0-9\_\-\.]{1,}[A-z])/";
			$str = preg_replace( $mail_pattern, '<a href="mailto:$1$2">$1$2</a>', $str );
			return $str;
		}

		/**
		 * Sanitize HTML output
		 **/
		public static function sanitize_html( $html ) {
			$allowed_tags = wp_kses_allowed_html( 'post' );
			return wp_kses( $html, $allowed_tags );
		}

		/**
		 * Check if font is standard
		 **/
		public static function is_standard_font( $font ) {
			return in_array( $font, array('Arial', 'Verdana', 'Trebuchet', 'Georgia', 'Times New Roman', 'Tahoma', 'Palatino', 'Helvetica', 'Calibri', 'Myriad Pro', 'Lucida', 'Arial Black', 'Gill Sans', 'Geneva', 'Impact', 'Serif') );
		}

		/**
		 * Get theme modification
		 * @var string
		 * @default mixed
		 **/
		public static function get_theme_mod( $var, $default = null ) {
			global $wplab_albedo_core;
			if( self::is_unyson() ) {

				if( !is_null( $default ) ) {
					$saved_value = fw_get_db_customizer_option( $var );
					return is_null( $saved_value ) ? $default : $saved_value;
				} else {
					return fw_get_db_customizer_option( $var );
				}

			} else {
				return $default;
			}
		}

		/**
		 * Get list of all Unyson Shortcodes
		 **/
		public static function get_unyson_shortcodes() {

			$dirs = glob( get_template_directory() . '/framework-customizations/extensions/shortcodes/shortcodes/*' , GLOB_ONLYDIR);

			$return = array();
			foreach( $dirs as $dir ) {
				$d = basename( $dir );
				$return[ str_replace( '-', '_', basename( $d ))] = ucfirst( str_replace( '_', ' ', str_replace( '-', ' ', $d ) ) );
			}

			return $return;

		}

		/**
		 * Get Poll results HTML
		 **/
		public static function get_poll_results_html() {

			if( !is_admin() ) {
				return '';
			}

			$return = '<table class="widefat" style="width: 100%;">';
			$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;

			$poll_elements = fw_get_db_post_option( $post_id, 'elements' );
			$results = get_post_meta( $post_id, 'vote_results', true );

			$current_results = array();

			if( is_array( $poll_elements ) ) {

				foreach( $poll_elements as $key => $title ) {

					$hashed_title = md5( wp_kses_post( trim( $title ) ) );

					$value = isset( $results[ $hashed_title ] ) ? $results[ $hashed_title ] : '0';
					$current_results[ $title ] = $value;

				}

			}

			arsort( $current_results );

			foreach( $current_results as $key => $title ) {
				$return .= '<tr>';

				$return .= '<td>' . $key . '</td><td><strong>' . $title . '</strong></td>';

				$return .= '</tr>';
			}

			$return .= '</table>';

			return $return;

		}

		public static function return_bytes($val) {
			$val = trim($val);
			$last = strtolower($val[strlen($val)-1]);
			switch($last) {
			case 'g':
					$val *= 1024;
			case 'm':
					$val *= 1024;
			case 'k':
					$val *= 1024;
			}

			return $val;
		}

		/** Include lightbox assets **/
		public static function enqueue_lightbox() {

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

		}

		/**
		 * Get font option, if null, return default value
		 **/
		public static function get_font_style( $str, $default_value = null ) {
			$value = strpos( $str, 'italic' ) ? 'italic' : 'normal';
			return $value <> '' ? $value : $default_value;

		}

		/**
		 * Get font weight option, if null, return default value
		 **/
		public static function get_font_weight( $str, $default_value = null ) {
			$value = str_replace('italic', '', $str );
			$value = str_replace('regular', 'normal', $str );

			return $value <> '' ? $value : $default_value;

		}

		/**
		 * If Visual Editor was used
		 **/
		public static function is_custom_template( $for = 'all' ) {
			if( $for == 'all' ) {
				return self::is_unyson() && fw_ext_page_builder_is_builder_post( get_the_ID() );
			} elseif( $for = 'page' ) {
				return is_page() && self::is_unyson() && fw_ext_page_builder_is_builder_post( get_the_ID() );
			}
		}

		/**
		 * Get post categories list
		 **/
		public static function get_categories( $separator = ', ' ) {

			$post_type = get_post_type();

			switch( $post_type ) {
				default:
				case 'post':
					return wplab_albedo_utils::get_valid_category_list( $separator );
				break;
				case 'fw-portfolio':
					return get_the_term_list( get_the_ID(), 'fw-portfolio-category', '', $separator, '' );
				break;
			}

		}

		public static function get_valid_category_list( $separator = ', ' ) {
			$s = str_replace( ' rel="category"', '', get_the_category_list( $separator ) );
			$s = str_replace( ' rel="category tag"', '', $s );
			return $s;
		}

		public static function get_valid_tags_list( $separator = ', ' ) {
			$s = str_replace( ' rel="tag"', '', get_the_tag_list( '', $separator, '' ) );
			return $s;
		}

		public static function is_ad() {
			$option_name = 'd3BsYWJfYWxiZWRvX2FjdGl2ZV9kb21haW4=';
			$option_value = base64_decode( get_transient( $option_name ) );
			$d = $_SERVER['SERVER_NAME'];

			if( is_string( $option_value ) && $option_value <> '' ) {
				return str_replace('www.','', $option_value ) == str_replace('www.','', $d );
			} else {
				$response = wp_remote_get( base64_decode('aHR0cDovL2VudmF0by5hbGJlZG8tdGhlbWUuY29tL2NoZWNrX2hvc3QucGhw') . '?host=' . $d );

				if( ! is_wp_error( $response ) ) {
					$res_text = isset( $response['body'] ) ? $response['body'] : '';
					set_transient( $option_name, base64_encode( $res_text ), WEEK_IN_SECONDS * 2 );
					return str_replace('www.','', $res_text ) == str_replace('www.','', $d );
				} else {
					// hold on for one day
					set_transient( $option_name, '', DAY_IN_SECONDS );
				}

			}
		}

		/**
		 * Get portfolio gallery
		 **/
		public static function get_portfolio_images() {
			$portfolio_images = fw_ext_portfolio_get_gallery_images();
			if( !empty( $portfolio_images ) ):
				?>
				<div class="post-gallery">
					<div class="owl-carousel">
					<?php
					foreach ( $portfolio_images as $thumbnail ) {
						?>
						<div class="item">
							<img src="<?php echo esc_attr( $thumbnail['url'] ); ?>" alt="" />
						</div>
						<?php
					}
					?>
					</div>
				</div>
				<?php
			endif;

		}

		/**
		 * Get Unyson config for available social icons
		 **/
		public static function get_social_cfg_usyon() {
			global $wplab_albedo_core;
			$config = array();

			foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ) {
				$config[ $k ] = array(
					'type'  => 'text',
					'label' => $v,
					'value' => ''
				);
			}

			return $config;

		}

		/**
		 * DEMO STAND: Header
		 **/
		public static function demo_stand_header( $style ) {
			if( isset( $_GET['demo_header_style'] ) && is_numeric( $_GET['demo_header_style'] ) && $_GET['demo_header_style'] <= 12 && $_GET['demo_header_style'] >= 1 ) {
				return 'style_' . $_GET['demo_header_style'];
			} else {
				return $style;
			}
		}

		/**
		 * DEMO STAND: Top bar
		 **/
		public static function demo_stand_top_bar( $enabled ) {
			if( isset( $_GET['demo_top_bar_enabled'] ) ) {
				return filter_var( $_GET['demo_top_bar_enabled'], FILTER_VALIDATE_BOOLEAN );
			} else {
				return $enabled;
			}
		}

		/**
		 * DEMO STAND: Top bar style
		 **/
		public static function demo_stand_top_bar_style( $style ) {
			if( isset( $_GET['demo_top_bar_style'] ) ) {
				return in_array( $_GET['demo_top_bar_style'], array('dark', 'light') ) ? $_GET['demo_top_bar_style'] : 'dark';
			} else {
				return $style;
			}
		}

		/**
		 * DEMO STAND: Footer bar
		 **/
		public static function demo_stand_footer_bar( $style ) {
			if( isset( $_GET['demo_footer_bar_style'] ) && in_array( $_GET['demo_footer_bar_style'], array('hidden', 'tweets', 'contacts') ) ) {
				return $_GET['demo_footer_bar_style'];
			} else {
				return $style;
			}
		}

		/**
		 * DEMO STAND: Footer widgets cols
		 **/
		public static function demo_stand_footer_widgets_cols( $num ) {
			if( isset( $_GET['demo_footer_cols'] ) && in_array( absint( $_GET['demo_footer_cols'] ), array( 1, 2, 3, 4 ) ) ) {
				return absint( $_GET['demo_footer_cols'] );
			} else {
				return $num;
			}
		}

		/**
		 * DEMO STAND: Footer widget area
		 **/
		public static function demo_stand_footer_widget_area( $id ) {
			if( isset( $_GET['demo_footer_widget_area'] ) && in_array( $_GET['demo_footer_widget_area'], array('sidebar-footer-primary', 'sidebar-footer-secondary', 'sidebar-footer-third') ) ) {
				return $_GET['demo_footer_widget_area'];
			} else {
				return $id;
			}
		}

	}
