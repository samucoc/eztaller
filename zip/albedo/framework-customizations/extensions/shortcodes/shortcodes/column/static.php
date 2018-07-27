<?php

if (!function_exists('_action_wplab_albedo_shortcode_column_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_column_enqueue_dynamic_css( $data ) {
		$shortcode = 'column';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		wp_dequeue_style( 'fw-ext-builder-frontend-grid' );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$inline_css = '';

		/**
		 * Auto CSS styles
		 **/
		if( !isset( $atts['section_effects']['effect'] ) || $atts['section_effects']['effect'] != 'parallax' ) {

			if( isset( $atts['bg_css_type']['type'] ) && $atts['bg_css_type']['type'] == 'color' ) {
				if( isset( $atts['bg_css_type']['color']['background_color'] ) && $atts['bg_css_type']['color']['background_color'] <> '' ) {
					$inline_css .= 'background-color: ' . $atts['bg_css_type']['color']['background_color'] . '; ';
				}
			} elseif( $atts['bg_css_type']['type'] == 'gradient' ) {

				if( isset( $atts['bg_css_type']['gradient']['background_gradient'] ) && !empty( $atts['bg_css_type']['gradient']['background_gradient'] ) ) {
					$gradient_start_color = esc_html( $atts['bg_css_type']['gradient']['background_gradient']['primary'] );
					$gradient_end_color = esc_html( $atts['bg_css_type']['gradient']['background_gradient']['secondary'] );
					$gradient_direction = esc_html( $atts['bg_css_type']['gradient']['background_gradient_direction'] );

					if( $gradient_direction == 'top_bottom' ) {

						$inline_css .= 'background: ' . $gradient_start_color . '; background: -moz-linear-gradient(top, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -webkit-gradient(left top, left bottom, color-stop(0%, ' . $gradient_start_color . '), color-stop(100%, ' . $gradient_end_color . ')); background: -webkit-linear-gradient(top, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -o-linear-gradient(top, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -ms-linear-gradient(top, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: linear-gradient(to bottom, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'' . $gradient_start_color . '\', endColorstr=\'' . $gradient_end_color . '\', GradientType=0 ); ';

					} else if( $gradient_direction == 'left_right' ) {

						$inline_css .= 'background: ' . $gradient_start_color . '; background: -moz-linear-gradient(left, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -webkit-gradient(left top, right top, color-stop(0%, ' . $gradient_start_color . '), color-stop(100%, ' . $gradient_end_color . ')); background: -webkit-linear-gradient(left, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -o-linear-gradient(left, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -ms-linear-gradient(left, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: linear-gradient(to right, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'' . $gradient_start_color . '\', endColorstr=\'' . $gradient_end_color . '\', GradientType=1 ); ';

					} else if( $gradient_direction == 'top_left_bottom_right' ) {

						$inline_css .= 'background: ' . $gradient_start_color . '; background: -moz-linear-gradient(-45deg, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -webkit-gradient(left top, right bottom, color-stop(0%, ' . $gradient_start_color . '), color-stop(100%, ' . $gradient_end_color . ')); background: -webkit-linear-gradient(-45deg, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -o-linear-gradient(-45deg, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -ms-linear-gradient(-45deg, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: linear-gradient(135deg, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'' . $gradient_start_color . '\', endColorstr=\'' . $gradient_end_color . '\', GradientType=1 ); ';

					} else if( $gradient_direction == 'bottom_left_top_right' ) {

						$inline_css .= 'background: ' . $gradient_start_color . '; background: -moz-linear-gradient(45deg, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -webkit-gradient(left bottom, right top, color-stop(0%, ' . $gradient_start_color . '), color-stop(100%, ' . $gradient_end_color . ')); background: -webkit-linear-gradient(45deg, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -o-linear-gradient(45deg, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -ms-linear-gradient(45deg, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: linear-gradient(45deg, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'' . $gradient_start_color . '\', endColorstr=\'' . $gradient_end_color . '\', GradientType=1 ); ';

					} else if( $gradient_direction == 'radial' ) {

						$inline_css .= 'background: ' . $gradient_start_color . '; background: -moz-radial-gradient(center, ellipse cover, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, ' . $gradient_start_color . '), color-stop(100%, ' . $gradient_end_color . ')); background: -webkit-radial-gradient(center, ellipse cover, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -o-radial-gradient(center, ellipse cover, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: -ms-radial-gradient(center, ellipse cover, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); background: radial-gradient(ellipse at center, ' . $gradient_start_color . ' 0%, ' . $gradient_end_color . ' 100%); filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'' . $gradient_start_color . '\', endColorstr=\'' . $gradient_end_color . '\', GradientType=1 ); ';

					}

				}


			} elseif( $atts['bg_css_type']['type'] == 'custom_gradient' ) {

				if( isset( $atts['bg_css_type']['custom_gradient']['gradient_color'] ) && !empty( $atts['bg_css_type']['custom_gradient']['gradient_color'] ) ) {

					$gradient_style = esc_html( $atts['bg_css_type']['custom_gradient']['gradient_style']['type'] );

					$gradient_start_color = esc_html( $atts['bg_css_type']['custom_gradient']['gradient_color']['primary'] );
					$gradient_end_color = esc_html( $atts['bg_css_type']['custom_gradient']['gradient_color']['secondary'] );
					$gradient_start = absint( $atts['bg_css_type']['custom_gradient']['gradient_start'] );
					$gradient_end = absint( $atts['bg_css_type']['custom_gradient']['gradient_end'] );

					if( $gradient_style == 'radial' ) {

					$gradient_size = esc_html( $atts['bg_css_type']['custom_gradient']['gradient_style']['radial']['gradient_size'] );
					$gradient_position = esc_html( $atts['bg_css_type']['custom_gradient']['gradient_style']['radial']['gradient_position'] );

					$inline_css .= '
/* IE10+ */
background-image: -ms-radial-gradient(' . $gradient_position . ', ellipse ' . $gradient_size . ', ' . $gradient_start_color . ' ' . $gradient_start . '%, ' . $gradient_end_color . ' ' . $gradient_end . '%);
/* Mozilla Firefox */
background-image: -moz-radial-gradient(' . $gradient_position . ', ellipse ' . $gradient_size . ', ' . $gradient_start_color . ' ' . $gradient_start . '%, ' . $gradient_end_color . ' ' . $gradient_end . '%);
/* Opera */
background-image: -o-radial-gradient(' . $gradient_position . ', ellipse ' . $gradient_size . ', ' . $gradient_start_color . ' ' . $gradient_start . '%, ' . $gradient_end_color . ' ' . $gradient_end . '%);
/* Webkit (Chrome 11+) */
background-image: -webkit-radial-gradient(' . $gradient_position . ', ellipse ' . $gradient_size . ', ' . $gradient_start_color . ' ' . $gradient_start . '%, ' . $gradient_end_color . ' ' . $gradient_end . '%);
					';

					} elseif( $gradient_style == 'linear' ) {

					$gradient_position = esc_html( $atts['bg_css_type']['custom_gradient']['gradient_style']['linear']['gradient_position'] );

						$inline_css .= '
/* IE10+ */
background-image: -ms-linear-gradient(' . $gradient_position . ', ' . $gradient_start_color . ' ' . $gradient_start . '%, ' . $gradient_end_color . ' ' . $gradient_end . '%);
/* Mozilla Firefox */
background-image: -moz-linear-gradient(' . $gradient_position . ', ' . $gradient_start_color . ' ' . $gradient_start . '%, ' . $gradient_end_color . ' ' . $gradient_end . '%);
/* Opera */
background-image: -o-linear-gradient(' . $gradient_position . ', ' . $gradient_start_color . ' ' . $gradient_start . '%, ' . $gradient_end_color . ' ' . $gradient_end . '%);
/* Webkit (Chrome 11+) */
background-image: -webkit-linear-gradient(' . $gradient_position . ', ' . $gradient_start_color . ' ' . $gradient_start . '%, ' . $gradient_end_color . ' ' . $gradient_end . '%);
						';

					}

				}

			}

			if( ! filter_var( $atts['background_lazy'], FILTER_VALIDATE_BOOLEAN ) && ! is_string( $atts['background_image'] ) && isset( $atts['background_image']['data']['css']['background-image'] ) && $atts['background_image']['data']['css']['background-image'] <> '' ) {
				$inline_css .= 'background-image: ' . $atts['background_image']['data']['css']['background-image'] . '; ';
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

		}

		/**
		 * Custom margins, paddings and borders
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

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' {' . $inline_css . '}' );
		}


		/**
		 * Responsiveness - medium screens
		 **/

		$inline_css = '';

			if( isset( $atts['margins_medium'] ) && is_array( $atts['margins_medium'] ) && count( array_filter( $atts['margins_medium'] ) ) > 0 ) {
				$inline_css .= wplab_albedo_utils::get_styles( array(
					'top_margin' 			=> $atts['margins_medium']['top'],
					'right_margin' 		=> $atts['margins_medium']['right'],
					'bottom_margin' 	=> $atts['margins_medium']['bottom'],
					'left_margin' 		=> $atts['margins_medium']['left'],
				), '' );
			}

			if( isset( $atts['paddings_medium'] ) && is_array( $atts['paddings_medium'] ) && count( array_filter( $atts['paddings_medium'] ) ) > 0 ) {
				$inline_css .= wplab_albedo_utils::get_styles( array(
					'top_padding' 		=> $atts['paddings_medium']['top'],
					'right_padding' 	=> $atts['paddings_medium']['right'],
					'bottom_padding' 	=> $atts['paddings_medium']['bottom'],
					'left_padding' 		=> $atts['paddings_medium']['left'],
				), '' );
			}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', '@media screen and (max-width: 1199px) and (min-width: 767px) { #' . $shortcode_id . ' { ' . $inline_css . '} }' );
		}

		/**
		 * Responsiveness - small screens
		 **/

		$inline_css = '';

			if( isset( $atts['margins_mobile'] ) && is_array( $atts['margins_mobile'] ) && count( array_filter( $atts['margins_mobile'] ) ) > 0 ) {
				$inline_css .= wplab_albedo_utils::get_styles( array(
					'top_margin' 			=> $atts['margins_mobile']['top'],
					'right_margin' 		=> $atts['margins_mobile']['right'],
					'bottom_margin' 	=> $atts['margins_mobile']['bottom'],
					'left_margin' 		=> $atts['margins_mobile']['left'],
				), '' );
			}

			if( isset( $atts['paddings_mobile'] ) && is_array( $atts['paddings_mobile'] ) && count( array_filter( $atts['paddings_mobile'] ) ) > 0 ) {
				$inline_css .= wplab_albedo_utils::get_styles( array(
					'top_padding' 		=> $atts['paddings_mobile']['top'],
					'right_padding' 	=> $atts['paddings_mobile']['right'],
					'bottom_padding' 	=> $atts['paddings_mobile']['bottom'],
					'left_padding' 		=> $atts['paddings_mobile']['left'],
				), '' );
			}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', '@media screen and (max-width: 991px) { #' . $shortcode_id . ' { ' . $inline_css . '} }' );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:column',
		'_action_wplab_albedo_shortcode_column_enqueue_dynamic_css'
	);

endif;
