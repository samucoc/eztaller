<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_services_iconic_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_services_iconic_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'services-iconic';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** load static stylesheet **/
		wp_enqueue_style( 'wplab-albedo-services-iconic', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/services_iconic.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-services-iconic-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/services_iconic_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-services-iconic', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/services-iconic/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

		/**
		 * Custom colors
		 **/

		if( isset( $atts['icon_color'] ) && $atts['icon_color'] <> '' ) {

			$inline_css = ' #' . $shortcode_id . ' .icon { color: ' . $atts['icon_color'] . '; }';
			$inline_css .= ' #' . $shortcode_id . ' svg path, #' . $shortcode_id . ' svg rect, #' . $shortcode_id . ' svg polygon, #' . $shortcode_id . ' svg circle { fill: ' . $atts['icon_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );

		}

		if( isset( $atts['icon_hover_color'] ) && $atts['icon_hover_color'] <> '' ) {

			$inline_css = ' #' . $shortcode_id . ' .item:hover .icon { color: ' . $atts['icon_hover_color'] . '; }';
			$inline_css .= ' #' . $shortcode_id . ' .item:hover svg path, #' . $shortcode_id . ' .item:hover svg rect, #' . $shortcode_id . ' .item:hover svg polygon, #' . $shortcode_id . ' .item:hover svg circle { fill: ' . $atts['icon_hover_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );

		}

		if( isset( $atts['category_color'] ) && $atts['category_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .category { color: ' . $atts['category_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['header_color'] ) && $atts['header_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' h4 { color: ' . $atts['header_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['header_hover_color'] ) && $atts['header_hover_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .item:hover h4 { color: ' . $atts['header_hover_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['text_color'] ) && $atts['text_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' .desc { color: ' . $atts['text_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['list_text_color'] ) && $atts['list_text_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' ul li { color: ' . $atts['list_text_color'] . '; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

		if( isset( $atts['list_bullets_color'] ) && $atts['list_bullets_color'] <> '' ) {
			$inline_css = ' #' . $shortcode_id . ' ul li:before { background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg%20version%3D%221.1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%20width%3D%22415.582px%22%20height%3D%22415.582px%22%20viewBox%3D%220%200%20415.582%20415.582%22%20style%3D%22enable-background%3Anew%200%200%20415.582%20415.582%3B%22%20xml%3Aspace%3D%22preserve%22%3E%3Cg%3E%3Cpath%20fill%3D%22' . urlencode( $atts['list_bullets_color'] ) . '%22%20d%3D%22M411.47%2C96.426l-46.319-46.32c-5.482-5.482-14.371-5.482-19.853%2C0L152.348%2C243.058l-82.066-82.064%20c-5.48-5.482-14.37-5.482-19.851%2C0l-46.319%2C46.32c-5.482%2C5.481-5.482%2C14.37%2C0%2C19.852l138.311%2C138.31%20c2.741%2C2.742%2C6.334%2C4.112%2C9.926%2C4.112c3.593%2C0%2C7.186-1.37%2C9.926-4.112L411.47%2C116.277c2.633-2.632%2C4.111-6.203%2C4.111-9.925%20C415.582%2C102.628%2C414.103%2C99.059%2C411.47%2C96.426z%22%2F%3E%3C%2Fg%3E%3C%2Fsvg%3E");; }';
			wp_add_inline_style( 'wplab-albedo-style', $inline_css );
		}

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:services_iconic',
		'_action_wplab_albedo_shortcode_services_iconic_enqueue_dynamic_css'
	);

endif;
