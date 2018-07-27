<?php

if (!function_exists('_action_wplab_albedo_shortcode_blockquote_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_blockquote_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;

		$shortcode = 'blockquote';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$inline_css = '';

		/**
		 * Custom colors
		 **/
		if( isset( $atts['background_color'] ) && $atts['background_color'] <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { background-color: ' . $atts['background_color'] . '; }' );
		}

		if( isset( $atts['text_color'] ) && $atts['text_color'] <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' p, #' . $shortcode_id . ' .text { color: ' . $atts['text_color'] . '; }' );
		}

		if( isset( $atts['author_color'] ) && $atts['author_color'] <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .author { color: ' . $atts['author_color'] . '; }' );
		}

		if( isset( $atts['position_color'] ) && $atts['position_color'] <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .position { color: ' . $atts['position_color'] . '; }' );
		}

		if( isset( $atts['quotes_color'] ) && $atts['quotes_color'] <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg%20version%3D%221.1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%20width%3D%2295.333px%22%20height%3D%2295.332px%22%20viewBox%3D%220%200%2095.333%2095.332%22%20style%3D%22enable-background%3Anew%200%200%2095.333%2095.332%3B%22%20xml%3Aspace%3D%22preserve%22%3E%3Cg%3E%3Cg%3E%3Cpath%20fill%3D%22' . urlencode( $atts['quotes_color'] ) . '%22%20d%3D%22M30.512%2C43.939c-2.348-0.676-4.696-1.019-6.98-1.019c-3.527%2C0-6.47%2C0.806-8.752%2C1.793%20c2.2-8.054%2C7.485-21.951%2C18.013-23.516c0.975-0.145%2C1.774-0.85%2C2.04-1.799l2.301-8.23c0.194-0.696%2C0.079-1.441-0.318-2.045%20s-1.035-1.007-1.75-1.105c-0.777-0.106-1.569-0.16-2.354-0.16c-12.637%2C0-25.152%2C13.19-30.433%2C32.076%20c-3.1%2C11.08-4.009%2C27.738%2C3.627%2C38.223c4.273%2C5.867%2C10.507%2C9%2C18.529%2C9.313c0.033%2C0.001%2C0.065%2C0.002%2C0.098%2C0.002%20c9.898%2C0%2C18.675-6.666%2C21.345-16.209c1.595-5.705%2C0.874-11.688-2.032-16.851C40.971%2C49.307%2C36.236%2C45.586%2C30.512%2C43.939z%22%2F%3E%3Cpath%20fill%3D%22' . urlencode( $atts['quotes_color'] ) . '%22%20d%3D%22M92.471%2C54.413c-2.875-5.106-7.61-8.827-13.334-10.474c-2.348-0.676-4.696-1.019-6.979-1.019%20c-3.527%2C0-6.471%2C0.806-8.753%2C1.793c2.2-8.054%2C7.485-21.951%2C18.014-23.516c0.975-0.145%2C1.773-0.85%2C2.04-1.799l2.301-8.23%20c0.194-0.696%2C0.079-1.441-0.318-2.045c-0.396-0.604-1.034-1.007-1.75-1.105c-0.776-0.106-1.568-0.16-2.354-0.16%20c-12.637%2C0-25.152%2C13.19-30.434%2C32.076c-3.099%2C11.08-4.008%2C27.738%2C3.629%2C38.225c4.272%2C5.866%2C10.507%2C9%2C18.528%2C9.312%20c0.033%2C0.001%2C0.065%2C0.002%2C0.099%2C0.002c9.897%2C0%2C18.675-6.666%2C21.345-16.209C96.098%2C65.559%2C95.376%2C59.575%2C92.471%2C54.413z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E"); }' );
		}

		/**
		 * Custom margins
		 **/
		$inline_css = '';
		if( isset( $atts['margins'] ) && is_array( $atts['margins'] ) && count( array_filter( $atts['margins'] ) ) > 0 ) {
			$inline_css .= wplab_albedo_utils::get_styles( array(
				'top_margin' 		=> $atts['margins']['top'],
				'right_margin' 	=> $atts['margins']['right'],
				'bottom_margin' 	=> $atts['margins']['bottom'],
				'left_margin' 		=> $atts['margins']['left'],
			), '' );
		}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' {' . $inline_css . '}' );
		}

		/**
		 * Responsiveness, medium screen
		 **/
		$inline_css = '';

			if( isset( $atts['margins_medium'] ) && is_array( $atts['margins_medium'] ) && count( array_filter( $atts['margins_medium'] ) ) > 0 ) {
				$inline_css .= wplab_albedo_utils::get_styles( array(
					'top_margin' 		=> $atts['margins_medium']['top'],
					'right_margin' 	=> $atts['margins_medium']['right'],
					'bottom_margin' 	=> $atts['margins_medium']['bottom'],
					'left_margin' 		=> $atts['margins_medium']['left'],
				), '' );
			}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', '@media screen and (max-width: 992px) and (min-width: 767px) { #' . $shortcode_id . ' { ' . $inline_css . '} }' );
		}

		/**
		 * Responsiveness, small screen
		 **/
		$inline_css = '';

			if( isset( $atts['margins_mobile'] ) && is_array( $atts['margins_mobile'] ) && count( array_filter( $atts['margins_mobile'] ) ) > 0 ) {
				$inline_css .= wplab_albedo_utils::get_styles( array(
					'top_margin' 		=> $atts['margins_mobile']['top'],
					'right_margin' 	=> $atts['margins_mobile']['right'],
					'bottom_margin' 	=> $atts['margins_mobile']['bottom'],
					'left_margin' 		=> $atts['margins_mobile']['left'],
				), '' );
			}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', '@media screen and (max-width: 767px) { #' . $shortcode_id . ' { ' . $inline_css . '} }' );
		}


		/**
		 * Custom paddings
		 **/
		$inline_css = '';
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

			wp_add_inline_style( 'wplab-albedo-style', '#' . $shortcode_id . ' p, #' . $shortcode_id . ' .text { font-family: ' . $family . '; }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:blockquote',
		'_action_wplab_albedo_shortcode_blockquote_enqueue_dynamic_css'
	);

endif;
