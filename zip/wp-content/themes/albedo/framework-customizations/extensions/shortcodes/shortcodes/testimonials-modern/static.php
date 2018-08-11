<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_testimonials_modern_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_testimonials_modern_enqueue_dynamic_css( $data ) {

		$shortcode = 'testimonials-modern';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** include swiper carousel library styles **/
		wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'swiper');

		/** load static stylesheet **/
		wp_enqueue_style( 'wplab-albedo-testimonials-modern', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/testimonials_modern.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-testimonials-modern-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/testimonials_modern_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-testimonials', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/testimonials/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		/**
		 * Custom font family
		 **/
		if( isset( $atts['custom_font_family'] ) && isset( $atts['custom_font_family']['enabled'] ) && $atts['custom_font_family']['enabled'] == 'yes' ) {

			$family = $atts['custom_font_family']['yes']['font_family']['family'];

			// if not a standard font
			if( ! wplab_albedo_utils::is_standard_font( $family ) ) {
				$_family = wplab_albedo_utils::sanitize_font_title( $family );
				wp_enqueue_style( 'google-font-' . $_family, 'https://fonts.googleapis.com/css?family=' . $family );
			}

			wp_add_inline_style( 'wplab-albedo-style', '#' . $shortcode_id . ' .text { font-family: ' . $family . '; }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:testimonials_modern',
		'_action_wplab_albedo_shortcode_testimonials_modern_enqueue_dynamic_css'
	);

endif;
