<?php

if (!function_exists('_action_wplab_albedo_shortcode_section_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_section_enqueue_dynamic_css( $data ) {
		$shortcode = 'section';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		$shortcode_id = 'shortcode-' . $atts['id'];

		/**
		 * Custom ID
		 **/
		if( isset( $atts['section_id'] ) && $atts['section_id'] <> '' ) {
			$shortcode_id = $atts['section_id'];
		}

		wp_dequeue_style( 'fw-ext-builder-frontend-grid' );

		$dependencies = array();

		if( isset( $atts['section_effects']['effect'] ) && $atts['section_effects']['effect'] == 'video' ) {
			if( $atts['section_effects']['video']['video_parallax_speed'] <> '' ) {
				if( ! wp_is_mobile() ) {
					wp_enqueue_script( 'stellar');
				}
				wp_enqueue_script( 'wplab-albedo-section-stellar', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/stellar.js'), array('stellar'), _WPLAB_ALBEDO_CACHE_TIME_, true );
			}
			wp_enqueue_script( 'youtube-background' );
			wp_enqueue_script( 'wplab-albedo-section-ytbg', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/youtube_bg.js'), array('youtube-background'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		} elseif( isset( $atts['section_effects']['effect'] ) && $atts['section_effects']['effect'] == 'particleground' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { position: relative; }' );
			wp_enqueue_script( 'particleground');
			wp_enqueue_script( 'wplab-albedo-section-particleground', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/particleground.js'), array('particleground'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		} elseif( isset( $atts['section_effects']['effect'] ) && $atts['section_effects']['effect'] == 'particles' ) {
			wp_enqueue_script( 'particles');
		}

		if( isset( $atts['parallax_effects']['effect'] ) && $atts['parallax_effects']['effect'] == 'mouse_parallax' ) {
			wp_enqueue_script( 'parallax');
			wp_enqueue_script( 'wplab-albedo-section-parallax', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/mouse_parallax.js'), array('parallax'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		} elseif( isset( $atts['parallax_effects']['effect'] ) && $atts['parallax_effects']['effect'] == 'parallax' ) {
			if( ! wp_is_mobile() ) {
				wp_enqueue_script( 'stellar');
			}
			wp_enqueue_script( 'wplab-albedo-section-stellar', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/stellar.js'), array('stellar'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		} elseif( isset( $atts['parallax_effects']['effect'] ) && $atts['parallax_effects']['effect'] == 'scroll_animation' ) {
			wp_enqueue_script( 'skrollr');
		}

		wp_enqueue_script( 'wplab-albedo-section', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/section/static/js/scripts' . $postfix . '.js'), false, _WPLAB_ALBEDO_CACHE_TIME_, true );

		$inline_css = '';

		/**
		 * Auto CSS styles
		 **/

		if( isset( $atts['bg_css_type']['type'] ) && $atts['bg_css_type']['type'] == 'color' ) {
			if( isset( $atts['bg_css_type']['color']['background_color'] ) && $atts['bg_css_type']['color']['background_color'] <> '' ) {
				$inline_css .= 'background-color: ' . $atts['bg_css_type']['color']['background_color'] . '; ';
			}
		}

		if( !isset( $atts['section_effects']['effect'] ) || !in_array( $atts['parallax_effects']['effect'], array('parallax', 'mouse_parallax') ) ) {

			 if( isset( $atts['bg_css_type']['type'] ) && $atts['bg_css_type']['type'] == 'gradient' ) {

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

			if( isset( $atts['custom_background_position'] ) && $atts['custom_background_position'] <> '' ) {
				$inline_css .= 'background-position: ' . $atts['custom_background_position'] . '; ';
			}

			if( isset( $atts['background_cover'] ) && filter_var( $atts['background_cover'], FILTER_VALIDATE_BOOLEAN ) ) {
				$inline_css .= 'background-size: cover; ';
			}

			if( isset( $atts['background_fixed'] ) && filter_var( $atts['background_fixed'], FILTER_VALIDATE_BOOLEAN ) ) {
				$inline_css .= 'background-attachment: fixed; ';
			}

		}

		if( isset( $atts['parallax_effects']['effect'] ) && $atts['parallax_effects']['effect'] == 'mouse_parallax' ) {

			$parallax_css = '';

			if( ! filter_var( $atts['background_lazy'], FILTER_VALIDATE_BOOLEAN ) && ! is_string( $atts['background_image'] ) && isset( $atts['background_image']['data']['css']['background-image'] ) && $atts['background_image']['data']['css']['background-image'] <> '' ) {
				$parallax_css .= 'background-image: ' . $atts['background_image']['data']['css']['background-image'] . '; ';
			}

			if( isset( $atts['background_repeat'] ) && $atts['background_repeat'] <> '' ) {
				$parallax_css .= 'background-repeat: ' . $atts['background_repeat'] . '; ';
			}

			if( isset( $atts['background_position'] ) && $atts['background_position'] <> '' ) {
				$parallax_css .= 'background-position: ' . $atts['background_position'] . '; ';
			}

			if( isset( $atts['background_cover'] ) && filter_var( $atts['background_cover'], FILTER_VALIDATE_BOOLEAN ) ) {
				$parallax_css .= 'background-size: cover; ';
			}

			if( isset( $atts['background_fixed'] ) && filter_var( $atts['background_fixed'], FILTER_VALIDATE_BOOLEAN ) ) {
				$parallax_css .= 'background-attachment: fixed; ';
			}

			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .parallax-scene .layer-bg > div {' . $parallax_css . '}' );

		}

		/**
		 * Relative position
		 **/
		if( isset( $atts['is_relative'] ) && filter_var( $atts['is_relative'], FILTER_VALIDATE_BOOLEAN ) ) {
			$inline_css .= 'position: relative; ';
		}

		/**
		 * Z-index
		 **/
		if( isset( $atts['z_index'] ) && $atts['z_index'] <> '' ) {
			$inline_css .= 'z-index: ' . $atts['z_index'] . '; ';
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

			// fix negative margin problems in Firefox and IE
			if( isset( $atts['is_relative'] ) && filter_var( $atts['is_relative'], FILTER_VALIDATE_BOOLEAN ) ) {
				wp_add_inline_style( 'wplab-albedo-style', ' .ie #' . $shortcode_id . ' { display: inline-block; }  @-moz-document url-prefix() { #' . $shortcode_id . ' { display: inline-block; } }' );
			}

		}

		if( isset( $atts['paddings'] ) && is_array( $atts['paddings'] ) && count( array_filter( $atts['paddings'] ) ) > 0 ) {
			$inline_css .= wplab_albedo_utils::get_styles( array(
				'top_padding' 		=> $atts['paddings']['top'],
				'right_padding' 	=> $atts['paddings']['right'],
				'bottom_padding' 	=> $atts['paddings']['bottom'],
				'left_padding' 		=> $atts['paddings']['left'],
			), '' );

		}
		if( isset( $atts['border_width'] ) && is_array( $atts['border_width'] ) && count( array_filter( $atts['border_width'] ) ) > 0 ) {
			$inline_css .= wplab_albedo_utils::get_styles( array(
				'top_border' 			=> $atts['border_width']['top'],
				'right_border' 		=> $atts['border_width']['right'],
				'bottom_border' 	=> $atts['border_width']['bottom'],
				'left_border' 		=> $atts['border_width']['left'],
			), '' );
		}

		if( isset( $atts['border_color'] ) && $atts['border_color'] <> '' ) {
			$inline_css .= 'border-color: ' . $atts['border_color'] . ';';
		}

		if( isset( $atts['border_style'] ) && $atts['border_style'] <> '' && $atts['border_style'] != 'none' ) {
			$inline_css .= 'border-style: ' . $atts['border_style'] . ';';
		}

		if( isset( $atts['border_radius'] ) && is_array( $atts['border_radius'] ) && count( array_filter( $atts['border_radius'] ) ) > 0 ) {
			$inline_css .= wplab_albedo_utils::get_styles( array(
				'top_border_radius' 		=> $atts['border_radius']['top'],
				'right_border_radius' 	=> $atts['border_radius']['right'],
				'bottom_border_radius' 	=> $atts['border_radius']['bottom'],
				'left_border_radius' 		=> $atts['border_radius']['left'],
			), '' );

		}

		if( isset( $atts['css_shadow']['enabled'] ) && filter_var( $atts['css_shadow']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {
			$shadow_type = isset( $atts['css_shadow']['yes']['shadow_type'] ) && $atts['css_shadow']['yes']['shadow_type'] == 'inside' ? 'inset' : '';
			$inline_css .= 'box-shadow: ' . $shadow_type . ' ' . $atts['css_shadow']['yes']['shadow_horizontal_length'] . 'px ' . $atts['css_shadow']['yes']['shadow_vertical_length'] . 'px ' . $atts['css_shadow']['yes']['shadow_blur_radius'] . 'px ' . $atts['css_shadow']['yes']['shadow_spread_radius'] . 'px ' . $atts['css_shadow']['yes']['shadow_color'] . ';';
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
		 * Responsiveness, small screen
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


		/**
		 * Infinite motion effect
		 **/
		if( isset( $atts['section_effects']['effect'] ) && $atts['section_effects']['effect'] == 'infinite_motion' ) {
			$direction = $atts['section_effects']['infinite_motion']['infinite_motion_direction'] == 'left' ? '' : '-';
			$speed = absint( $atts['section_effects']['infinite_motion']['infinite_motion_speed'] );
			$bg_width = absint( $atts['section_effects']['infinite_motion']['infinite_motion_bg_width'] );
			wp_add_inline_style( 'wplab-albedo-style', ' @keyframes wplabInfiniteAnimation { from {background-position:0 0;} to {background-position: ' . $direction . $bg_width . 'px 0;} }' );
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { background-repeat: repeat; background-position: 0 0; animation: ' . $speed . 's linear 0s normal none infinite wplabInfiniteAnimation;}' );
		}

		/**
		 * Particles effect
		 **/
		else if( isset( $atts['section_effects']['effect'] ) && $atts['section_effects']['effect'] == 'particles' ) {

			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { position: relative; }' );

			$script = "
			(function($){

				if( $('.particles-element').length ) {

					setTimeout( function() {

						$('.particles-element').each( function() {
							$(this).height( $(this).parents('.pb-section').outerHeight() ).width( $('body').width() );
						});

					}, 700 );

					$(window).on('resize', function() {

						$('.particles-element').each( function() {
							$(this).height( $(this).parents('.pb-section').outerHeight() ).width( $('body').width() );
						});

					});


				}

			})( window.jQuery );";

			$script .= '
setTimeout( function() { particlesJS( "particles-' . $shortcode_id . '", {
	"particles": {
		"number": {
			"value": ' . $atts['section_effects']['particles']['number'] . ',
				"density": {
					"enable": window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['density']['enabled'] . '"),
					"value_area": ' . $atts['section_effects']['particles']['density']['yes']['density_value'] . '
			}
		},
		"color": {
			"value": "' . $atts['section_effects']['particles']['color'] . '"
		},
		"shape": {
			"type":"' . $atts['section_effects']['particles']['shape_type'] . '",
			"stroke": {
				"width": ' . $atts['section_effects']['particles']['stroke_width'] . ',
				"color": "' . $atts['section_effects']['particles']['stroke_color'] . '"
			},
			"polygon": {
				"nb_sides": ' . $atts['section_effects']['particles']['polygon_sides'] . '
			}
		},
		"opacity": {
			"value": ' . $atts['section_effects']['particles']['opacity'] . ',
			"random":window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['opacity_rand'] . '"),
			"anim": {
				"enable": window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['animate_opacity']['enabled'] . '"),
				"speed": ' . $atts['section_effects']['particles']['animate_opacity']['yes']['speed'] . ',
				"opacity_min": ' . $atts['section_effects']['particles']['animate_opacity']['yes']['size_min'] . ',
				"sync": window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['animate_opacity']['yes']['sync'] . '")
			}
		},
		"size": {
			"value": ' . $atts['section_effects']['particles']['size'] . ',
			"random":window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['size_rand'] . '"),
			"anim": {
				"enable": window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['animate_size']['enabled'] . '"),
				"speed": ' . $atts['section_effects']['particles']['animate_size']['yes']['speed'] . ',
				"size_min": ' . $atts['section_effects']['particles']['animate_size']['yes']['size_min'] . ',
				"sync": window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['animate_size']['yes']['sync'] . '")
			}
		},
		"line_linked": {
			"enable": window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['lines']['enabled'] . '"),
			"distance": ' . $atts['section_effects']['particles']['lines']['yes']['distance'] . ',
			"color": "' . $atts['section_effects']['particles']['lines']['yes']['color'] . '",
			"opacity": ' . $atts['section_effects']['particles']['lines']['yes']['opacity'] . ',
			"width": ' . $atts['section_effects']['particles']['lines']['yes']['width'] . '
		},
		"move": {
			"enable":window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['move']['enabled'] . '"),
			"speed": ' . $atts['section_effects']['particles']['move']['yes']['speed'] . ',
			"direction":"' . $atts['section_effects']['particles']['move']['yes']['direction'] . '",
			"random":window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['move']['yes']['rand'] . '"),
			"straight":window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['move']['yes']['straight'] . '"),
			"out_mode":"' . $atts['section_effects']['particles']['move']['yes']['out_mode'] . '",
			"bounce":false,
			"attract": {
				"enable": false
			}
		}
	},
	"interactivity": {
		"detect_on":"canvas",
		"events": {
			"onhover": {
				"enable": window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['onhover']['enabled'] . '"),
				"mode": "' . $atts['section_effects']['particles']['onhover']['yes']['mode'] . '"
			},
			"onclick": {
				"enable": window.themeFrontCore.stringToBoolean("' . $atts['section_effects']['particles']['onclick']['enabled'] . '"),
				"mode": "' . $atts['section_effects']['particles']['onclick']['yes']['mode'] . '"
			},
			"resize":true
		},
		"modes": {
			"grab": {
				"distance":' . $atts['section_effects']['particles']['grab_distance'] . ',
				"line_linked": {
					"opacity": ' . $atts['section_effects']['particles']['grab_opacity'] . '
				}
			},
			"bubble": {
				"distance": ' . $atts['section_effects']['particles']['bubble_distance'] . ',
				"size": ' . $atts['section_effects']['particles']['bubble_size'] . ',
				"duration": ' . $atts['section_effects']['particles']['bubble_duration'] . ',
				"opacity": ' . $atts['section_effects']['particles']['bubble_opacity'] . ',
				"speed": ' . $atts['section_effects']['particles']['bubble_speed'] . '
			},
			"repulse": {
				"distance": ' . $atts['section_effects']['particles']['repulse_distance'] . ',
				"duration": ' . $atts['section_effects']['particles']['repulse_duration'] . '
			},
			"push": {
				"particles_nb": 4
			},
			"remove": {
				"particles_nb": 2
			}
		}
	}
	,
	"retina_detect":true
}); }, 800);
			';

			wp_add_inline_script( 'particles', $script );
		}

		/**
		 * Scroll animation
		 **/
		if( isset( $atts['parallax_effects']['effect'] ) && $atts['parallax_effects']['effect'] == 'scroll_animation' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { ' . $atts['parallax_effects']['scroll_animation']['start_css'] . '}' );
		}

		/**
		 * Section overlay
		 **/
		if( isset( $atts['overlay'] ) && $atts['overlay']['effect'] <> '' ) {

			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { position: relative; }' );

			if( $atts['overlay']['effect'] == 'solid' ) {

				if( ! is_string( $atts['overlay']['solid']['overlay_image'] ) && isset( $atts['overlay']['solid']['overlay_image']['data']['css']['background-image'] ) && $atts['overlay']['solid']['overlay_image']['data']['css']['background-image'] <> '' ) {
					wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .section-overlay-effect { background-image: ' . $atts['overlay']['solid']['overlay_image']['data']['css']['background-image'] . '}' );
				}

				wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .section-overlay-effect { background-color: ' . $atts['overlay']['solid']['overlay_color'] . '; background-repeat: ' . $atts['overlay']['solid']['overlay_image_repeat'] . '; background-position: ' . $atts['overlay']['solid']['overlay_image_position'] . '; }' );

			} elseif( $atts['overlay']['effect'] == 'gradient' ) {

				$gradient_start_color = esc_html( $atts['overlay']['gradient']['overlay_gradient_start'] );
				$gradient_end_color = esc_html( $atts['overlay']['gradient']['overlay_gradient_end'] );
				$gradient_direction = esc_html( $atts['overlay']['gradient']['overlay_gradient_direction'] );

				$inline_css = '';

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

				wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' .section-overlay-effect {' . $inline_css . '}' );

			}

		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:section',
		'_action_wplab_albedo_shortcode_section_enqueue_dynamic_css'
	);

endif;
