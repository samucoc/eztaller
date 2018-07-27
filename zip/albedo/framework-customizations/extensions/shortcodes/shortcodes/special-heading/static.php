<?php

if (!function_exists('_action_wplab_albedo_shortcode_header_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_header_enqueue_dynamic_css( $data ) {
		$shortcode = 'special_heading';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$inline_css = '';

		/**
		 * Auto CSS styles
		 **/
		if( isset( $atts['text_align'] ) && $atts['text_align'] <> '' ) {
			$inline_css .= 'text-align: ' . $atts['text_align'] . '; ';
		}

		if( isset( $atts['text_transform'] ) && $atts['text_transform'] <> '' ) {
			$inline_css .= 'text-transform: ' . $atts['text_transform'] . ';';
		}

		if( isset( $atts['font_style'] ) && $atts['font_style'] <> '' ) {
			$inline_css .= 'font-style: ' . $atts['font_style'] . ';';
		}

		if( isset( $atts['font_variant'] ) && $atts['font_variant'] <> '' ) {
			$inline_css .= 'font-variant: ' . $atts['font_variant'] . ';';
		}

		if( isset( $atts['font_weight'] ) && $atts['font_weight'] <> '' ) {
			$inline_css .= 'font-weight: ' . $atts['font_weight'] . ';';
		}

		if( isset( $atts['font_size'] ) && $atts['font_size'] <> '' ) {
			$inline_css .= 'font-size: ' . $atts['font_size'] . 'px;';
		}

		if( isset( $atts['line_height'] ) && $atts['line_height'] <> '' ) {
			$inline_css .= 'line-height: ' . $atts['line_height'] . 'px;';
		}

		if( isset( $atts['letter_spacing'] ) && $atts['letter_spacing'] <> '' ) {
			$inline_css .= 'letter-spacing: ' . $atts['letter_spacing'] . 'px;';
		}

		if( isset( $atts['header_color'] ) && $atts['header_color'] <> '' ) {
			$inline_css .= 'color: ' . $atts['header_color'] . ';';
		}

		if( isset( $atts['custom_font_family'] ) && isset( $atts['custom_font_family']['enabled'] ) && $atts['custom_font_family']['enabled'] == 'yes' ) {

			$family = $atts['custom_font_family']['yes']['font_family']['family'];

			// if not a standard font
			if( ! wplab_albedo_utils::is_standard_font( $family ) ) {
				$_family = wplab_albedo_utils::sanitize_font_title( $family );
				wp_enqueue_style( 'google-font-' . $_family, 'https://fonts.googleapis.com/css?family=' . $family );
			}

			$inline_css .= 'font-family: "' . $family . '";';
		}

		/**
		 * Custom margins, paddings
		 **/

		if( isset( $atts['margins'] ) && is_array( $atts['margins'] ) && count( array_filter( $atts['margins'] ) ) > 0 ) {
			$inline_css .= wplab_albedo_utils::get_styles( array(
				'top_margin' 			=> $atts['margins']['top'],
				'right_margin' 		=> $atts['margins']['right'],
				'bottom_margin' 	=> $atts['margins']['bottom'],
				'left_margin' 		=> $atts['margins']['left'],
			), '' );
		}

		if( isset( $atts['paddings'] ) && is_array( $atts['paddings'] ) && count( array_filter( $atts['paddings'] ) ) > 0 ) {
			$inline_css .= wplab_albedo_utils::get_styles( array(
				'top_padding' 		=> $atts['paddings']['top'],
				'right_padding' 	=> $atts['paddings']['right'],
				'bottom_padding' 	=> $atts['paddings']['bottom'],
				'left_padding' 		=> $atts['paddings']['left'],
			), '' );
		}

		if( isset( $atts['custom_css'] ) && $atts['custom_css'] <> '' ) {
			$inline_css .= $atts['custom_css'];
		}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' {' . $inline_css . '}' );
		}

		/**
		 * Responsive settings
		 **/
		$inline_css = '';

		if( isset( $atts['font_size_mobile'] ) && $atts['font_size_mobile'] <> '' ) {
			$inline_css .= 'font-size: ' . $atts['font_size_mobile'] . 'px;';
		}

		if( isset( $atts['line_height_mobile'] ) && $atts['line_height_mobile'] <> '' ) {
			$inline_css .= 'line-height: ' . $atts['line_height_mobile'] . 'px;';
		}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' @media screen and (max-width: 992px) { #' . $shortcode_id . ' { ' . $inline_css . '} }' );
		}

		/**
		 * Typed animation
		 **/
		if( isset( $atts['typed_animation']['enabled'] ) && filter_var( $atts['typed_animation']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
			wp_enqueue_script( 'typed');
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:special_heading',
		'_action_wplab_albedo_shortcode_header_enqueue_dynamic_css'
	);

endif;
