<?php

if (!function_exists('_action_wplab_albedo_shortcode_quote_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_quote_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;

		$shortcode = 'quote';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** load static stylesheet **/
		wp_enqueue_style( 'wplab-albedo-quote', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/quote.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-quote-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/quote_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		$inline_css = '';

		/**
		 * Auto CSS styles
		 **/
		if( ! filter_var( $atts['background_lazy'], FILTER_VALIDATE_BOOLEAN ) && isset( $atts['photo']['url'] ) && $atts['photo']['url'] <> '' ) {
			$inline_css .= 'background-image: url(' . $atts['photo']['url'] . '); ';
		}

		if( isset( $atts['background_repeat'] ) && $atts['background_repeat'] <> '' ) {
			$inline_css .= 'background-repeat: ' . $atts['background_repeat'] . '; ';
		}

		if( isset( $atts['background_position'] ) && $atts['background_position'] <> '' ) {
			$inline_css .= 'background-position: ' . $atts['background_position'] . '; ';
		}

		if( isset( $atts['background_cover'] ) && filter_var( $atts['background_cover'], FILTER_VALIDATE_BOOLEAN ) ) {
			$inline_css .= 'background-size: cover; ';
		}

		if( isset( $atts['background_fixed'] ) && filter_var( $atts['background_fixed'], FILTER_VALIDATE_BOOLEAN ) ) {
			$inline_css .= 'background-attachment: fixed; ';
		}

		/**
		 * Custom paddings
		 **/

		if( isset( $atts['paddings'] ) && is_array( $atts['paddings'] ) && count( array_filter( $atts['paddings'] ) ) > 0 ) {
			$inline_css .= wplab_albedo_utils::get_styles( array(
				'top_padding' 		=> $atts['paddings']['top'],
				'right_padding' 	=> $atts['paddings']['right'],
				'bottom_padding' 	=> $atts['paddings']['bottom'],
				'left_padding' 		=> $atts['paddings']['left'],
			), '' );
		}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' {' . $inline_css . '}' );
		}

		/**
		 * Responsiveness, medium screen
		 **/
		$inline_css = '';

			if( isset( $atts['paddings_medium'] ) && is_array( $atts['paddings_medium'] ) && count( array_filter( $atts['paddings_medium'] ) ) > 0 ) {
				$inline_css .= wplab_albedo_utils::get_styles( array(
					'top_padding' 		=> $atts['paddings_medium']['top'],
					'right_padding' 	=> $atts['paddings_medium']['right'],
					'bottom_padding' 	=> $atts['paddings_medium']['bottom'],
					'left_padding' 		=> $atts['paddings_medium']['left'],
				), '' );
			}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', '@media screen and (max-width: 992px) and (min-width: 767px) { #' . $shortcode_id . ' { ' . $inline_css . '} }' );
		}

		/**
		 * Responsiveness, small screen
		 **/
		$inline_css = '';

			if( isset( $atts['paddings_mobile'] ) && is_array( $atts['paddings_mobile'] ) && count( array_filter( $atts['paddings_mobile'] ) ) > 0 ) {
				$inline_css .= wplab_albedo_utils::get_styles( array(
					'top_padding' 		=> $atts['paddings_mobile']['top'],
					'right_padding' 	=> $atts['paddings_mobile']['right'],
					'bottom_padding' 	=> $atts['paddings_mobile']['bottom'],
					'left_padding' 		=> $atts['paddings_mobile']['left'],
				), '' );
			}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', '@media screen and (max-width: 767px) { #' . $shortcode_id . ' { ' . $inline_css . '} }' );
		}

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
		'fw_ext_shortcodes_enqueue_static:quote',
		'_action_wplab_albedo_shortcode_quote_enqueue_dynamic_css'
	);

endif;
