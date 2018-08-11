<?php
/**
 *	Skins controller
 **/
class wplab_albedo_skins_controller {

	function __construct() {

		if( !is_admin() ) {
			add_action( 'wp_loaded', array( $this, 'register_less_vars' ) );
		}

	}

	/**
	 * Register customizer vars for WP LESS
	 **/
	function register_less_vars() {
		global $wplab_albedo_core;

		if( ! wplab_albedo_utils::is_unyson() ) {
			return;
		}

		require_once get_template_directory() . '/core/vendor/wp-less/bootstrap-for-theme.php';

		$less = WPLessPlugin::getInstance();

		$less->getCompiler()->setFormatter('compressed');
		$less->dispatch();

		$config = $less->getConfiguration();

		$wp_upload_dir = wp_upload_dir();

		if( is_customize_preview() ) {

			if( !is_dir( $wp_upload_dir['basedir'] . '/temp-compiled-css' ) ) {
				@mkdir( $wp_upload_dir['basedir'] . '/temp-compiled-css' );
			}

			//$config->alwaysRecompile(true);
			$config->setUploadDir( $wp_upload_dir['basedir'] . '/temp-compiled-css');
			$config->setUploadUrl( $wp_upload_dir['baseurl'] . '/temp-compiled-css');
		} else {

			if( !is_dir( $wp_upload_dir['basedir'] . '/compiled-css' ) ) {
				@mkdir( $wp_upload_dir['basedir'] . '/compiled-css' );
			}

			$config->setUploadDir( $wp_upload_dir['basedir'] . '/compiled-css');
			$config->setUploadUrl( $wp_upload_dir['baseurl'] . '/compiled-css');

		}

		WPLessStylesheet::$upload_dir = $config->getUploadDir();
		WPLessStylesheet::$upload_uri = $config->getUploadUrl();

		$_vars_array = array();

		foreach( $wplab_albedo_core->default_styles as $key => $value ) {

			$is_font_key_arr = explode( '_font_', $key );
			$is_img_key_arr = explode( '_image_src', $key );

			if( count( $is_font_key_arr ) > 1 ) {

				$option = wplab_albedo_utils::get_theme_mod( $is_font_key_arr[0] . '_font', $value );

				if( is_array( $option ) && count( $option ) > 0 ) {

					if( $is_font_key_arr[1] == 'family' ) {
						$_vars_array[ $is_font_key_arr[0] . '_font_family' ] = isset( $option['family'] ) ? $option['family'] : $value;
					} elseif( $is_font_key_arr[1] == 'size' ) {
						$_vars_array[ $is_font_key_arr[0] . '_font_size' ] = isset( $option['size'] ) ? $option['size'] : $value;
					} elseif( $is_font_key_arr[1] == 'line_height' ) {
						$_vars_array[ $is_font_key_arr[0] . '_font_line_height' ] = isset( $option['line-height'] ) ? $option['line-height'] : $value;
					} elseif( $is_font_key_arr[1] == 'transform' ) {
						$_transform = wplab_albedo_utils::get_theme_mod( $is_font_key_arr[0] . '_font_transform', $value );
						$_vars_array[ $is_font_key_arr[0] . '_font_transform' ] = isset( $_transform ) ? $_transform : $value;
					} elseif( $is_font_key_arr[1] == 'style' ) {
						$_vars_array[ $is_font_key_arr[0] . '_font_style' ] = wplab_albedo_utils::get_font_style( $option['variation'], $value );
					} elseif( $is_font_key_arr[1] == 'weight' ) {
						$_vars_array[ $is_font_key_arr[0] . '_font_weight' ] = wplab_albedo_utils::get_font_weight( $option['variation'], $value );
					} elseif( $is_font_key_arr[1] == 'size_mobile' ) {
						$_vars_array[ $is_font_key_arr[0] . '_font_size_mobile' ] = isset( $option['size'] ) ? $option['size'] : $value;
					} elseif( $is_font_key_arr[1] == 'line_height_mobile' ) {
						$_vars_array[ $is_font_key_arr[0] . '_font_line_height_mobile' ] = isset( $option['line-height'] ) ? $option['line-height'] : $value;
					} elseif( $is_font_key_arr[1] == 'color' ) {
						$_vars_array[ $is_font_key_arr[0] . '_font_color' ] = isset( $option['color'] ) ? $option['color'] : $value;
					}

				} else {
					$_vars_array[ $key ] = wplab_albedo_utils::get_theme_mod( $key, $value );
				}

			} elseif( count( $is_img_key_arr ) > 1 ) {

				$option = wplab_albedo_utils::get_theme_mod( $is_font_key_arr[0], $value );
				$_vars_array[ $is_img_key_arr[0] . '_image_src' ] = isset( $option['data']['css']['background-image'] ) ? $option['data']['css']['background-image'] : $value;

			} else {

				$v = wplab_albedo_utils::get_theme_mod( $key, $value );

				if( strpos( $key, 'gradient' ) !== false ) {

					if( strpos( '_to', $key ) ) {
						continue;
					}

					$temp_key = str_replace( '_to', '', str_replace( '_from', '', $key ) );
					$option = wplab_albedo_utils::get_theme_mod( $temp_key, $value );

					$_vars_array[ $temp_key . '_from' ] = isset( $option['primary'] ) ? $option['primary'] : '';
					$_vars_array[ $temp_key . '_to' ] = isset( $option['secondary'] ) ? $option['secondary'] : '';

				} elseif( is_string( $v ) ) {

					$_vars_array[ $key ] = $v;

				}


			}

		}

		$less->setVariables( $_vars_array );

	}

}
