<?php

if (!function_exists('_action_wplab_albedo_shortcode_button_enqueue_dynamic_css')):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_button_enqueue_dynamic_css( $data ) {

		$shortcode = 'button';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		if( $atts['icon']['type'] == 'icon-font' ) {
			fw()->backend->option_type('icon-v2')->packs_loader->enqueue_frontend_css();
		}

		/**
		 * Custom ID
		 **/
		if( isset( $atts['button_id'] ) && $atts['button_id'] <> '' ) {
			$shortcode_id = $atts['button_id'];
		}

		$inline_css = '';

			/** margins **/
			if( isset( $atts['margins'] ) && is_array( $atts['margins'] ) && count( array_filter( $atts['margins'] ) ) > 0 ) {
				$inline_css .= wplab_albedo_utils::get_styles( array(
					'top_margin' 			=> $atts['margins']['top'],
					'right_margin' 		=> $atts['margins']['right'],
					'bottom_margin' 	=> $atts['margins']['bottom'],
					'left_margin' 		=> $atts['margins']['left'],
				), '' );
			}

			/** paddings **/
			if( isset( $atts['paddings'] ) && is_array( $atts['paddings'] ) && count( array_filter( $atts['paddings'] ) ) > 0 ) {
				$inline_css .= wplab_albedo_utils::get_styles( array(
					'top_padding' 		=> $atts['paddings']['top'],
					'right_padding' 	=> $atts['paddings']['right'],
					'bottom_padding' 	=> $atts['paddings']['bottom'],
					'left_padding' 		=> $atts['paddings']['left'],
				), '' );
			}

			/** border radius **/
			if( isset( $atts['border_radius'] ) && $atts['border_radius'] <> '' ) {
				$inline_css .= 'border-radius: ' . $atts['border_radius'] . 'px;';
			}

			/** font weight **/
			if( isset( $atts['font_weight'] ) && $atts['font_weight'] <> '' ) {
				$inline_css .= 'font-weight: ' . $atts['font_weight'] . ';';
			}

			/** font variant **/
			if( isset( $atts['font_variant'] ) && $atts['font_variant'] <> '' ) {
				$inline_css .= 'font-variant: ' . $atts['font_variant'] . ';';
			}

			/** font style **/
			if( isset( $atts['font_style'] ) && $atts['font_style'] <> '' ) {
				$inline_css .= 'font-style: ' . $atts['font_style'] . ';';
			}

			/** text transform **/
			if( isset( $atts['text_transform'] ) && $atts['text_transform'] <> '' ) {
				$inline_css .= 'text-transform: ' . $atts['text_transform'] . ';';
			}

			/** animation time **/
			if( isset( $atts['animation_time'] ) && $atts['animation_time'] <> '' ) {
				$inline_css .= 'transition: all ' . $atts['animation_time'] / 1000 . 's;';
			}

		if( $inline_css <> '' ) {
			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { ' . $inline_css . '}' );
		}

		/**
		 * Customize normal state
		 **/
		$inline_css = '';
		if( isset( $atts['customize_normal_state'] ) && filter_var( $atts['customize_normal_state']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {

			/** text color **/
			if( isset( $atts['customize_normal_state']['yes']['text_color'] ) && $atts['customize_normal_state']['yes']['text_color'] <> '' ) {
				$inline_css .= 'color: ' . $atts['customize_normal_state']['yes']['text_color'] . ';';
			}

			/** background color **/
			if( isset( $atts['customize_normal_state']['yes']['background_color'] ) && $atts['customize_normal_state']['yes']['background_color'] <> '' ) {
				$inline_css .= 'background-color: ' . $atts['customize_normal_state']['yes']['background_color'] . ';';
			}

			/** border color **/
			if( isset( $atts['customize_normal_state']['yes']['border_color'] ) && $atts['customize_normal_state']['yes']['border_color'] <> '' ) {
				$inline_css .= 'border-color: ' . $atts['customize_normal_state']['yes']['border_color'] . ';';
			}

			/** border size **/
			if( isset( $atts['customize_normal_state']['yes']['border_size'] ) && $atts['customize_normal_state']['yes']['border_size'] <> '' ) {
				$inline_css .= 'border-width: ' . $atts['customize_normal_state']['yes']['border_size'] . 'px;';
			}

			/** shadow **/
			$inline_css .= 'box-shadow: ' . $atts['customize_normal_state']['yes']['shadow_h_length'] . 'px ' . $atts['customize_normal_state']['yes']['shadow_v_length'] . 'px ' . $atts['customize_normal_state']['yes']['shadow_blur_radius'] . 'px 0px ' . $atts['customize_normal_state']['yes']['shadow_color'] . ';';

			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ' { ' . $inline_css . '}' );
		}

		/**
		 * Customize hover state
		 **/
		$inline_css = '';
		if( isset( $atts['customize_hover_state'] ) && filter_var( $atts['customize_hover_state']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {

			/** text color **/
			if( isset( $atts['customize_hover_state']['yes']['hover_text_color'] ) && $atts['customize_hover_state']['yes']['hover_text_color'] <> '' ) {
				$inline_css .= 'color: ' . $atts['customize_hover_state']['yes']['hover_text_color'] . ';';
			}

			/** background color **/
			if( isset( $atts['customize_hover_state']['yes']['hover_background_color'] ) && $atts['customize_hover_state']['yes']['hover_background_color'] <> '' ) {
				$inline_css .= 'background-color: ' . $atts['customize_hover_state']['yes']['hover_background_color'] . ';';
			}

			/** border color **/
			if( isset( $atts['customize_hover_state']['yes']['hover_border_color'] ) && $atts['customize_hover_state']['yes']['hover_border_color'] <> '' ) {
				$inline_css .= 'border-color: ' . $atts['customize_hover_state']['yes']['hover_border_color'] . ';';
			}

			/** border size **/
			if( isset( $atts['customize_hover_state']['yes']['hover_border_size'] ) && $atts['customize_hover_state']['yes']['hover_border_size'] <> '' ) {
				$inline_css .= 'border-width: ' . $atts['customize_hover_state']['yes']['hover_border_size'] . 'px;';
			}

			/** shadow **/
			$inline_css .= 'box-shadow: ' . $atts['customize_hover_state']['yes']['hover_shadow_h_length'] . 'px ' . $atts['customize_hover_state']['yes']['hover_shadow_v_length'] . 'px ' . $atts['customize_hover_state']['yes']['hover_shadow_blur_radius'] . 'px 0px ' . $atts['customize_hover_state']['yes']['hover_shadow_color'] . ';';

			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ':hover { ' . $inline_css . '}' );
		}

		/**
		 * Customize active state
		 **/
		$inline_css = '';
		if( isset( $atts['customize_click_state'] ) && filter_var( $atts['customize_click_state']['enabled'], FILTER_VALIDATE_BOOLEAN ) ) {

			/** text color **/
			if( isset( $atts['customize_click_state']['yes']['click_text_color'] ) && $atts['customize_click_state']['yes']['click_text_color'] <> '' ) {
				$inline_css .= 'color: ' . $atts['customize_click_state']['yes']['click_text_color'] . ';';
			}

			/** background color **/
			if( isset( $atts['customize_click_state']['yes']['click_background_color'] ) && $atts['customize_click_state']['yes']['click_background_color'] <> '' ) {
				$inline_css .= 'background-color: ' . $atts['customize_click_state']['yes']['click_background_color'] . ';';
			}

			/** border color **/
			if( isset( $atts['customize_click_state']['yes']['click_border_color'] ) && $atts['customize_click_state']['yes']['click_border_color'] <> '' ) {
				$inline_css .= 'border-color: ' . $atts['customize_click_state']['yes']['click_border_color'] . ';';
			}

			/** border size **/
			if( isset( $atts['customize_click_state']['yes']['click_border_size'] ) && $atts['customize_click_state']['yes']['click_border_size'] <> '' ) {
				$inline_css .= 'border-width: ' . $atts['customize_click_state']['yes']['click_border_size'] . 'px;';
			}

			/** shadow **/
			$inline_css .= 'box-shadow: ' . $atts['customize_click_state']['yes']['click_shadow_h_length'] . 'px ' . $atts['customize_click_state']['yes']['click_shadow_v_length'] . 'px ' . $atts['customize_click_state']['yes']['click_shadow_blur_radius'] . 'px 0px ' . $atts['customize_click_state']['yes']['click_shadow_color'] . ';';

			wp_add_inline_style( 'wplab-albedo-style', ' #' . $shortcode_id . ':active { ' . $inline_css . '}' );
		}


	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:button',
		'_action_wplab_albedo_shortcode_button_enqueue_dynamic_css'
	);

endif;
