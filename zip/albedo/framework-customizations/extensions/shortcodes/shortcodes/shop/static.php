<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_shop_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_shop_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'shop';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** load stylesheet **/
		wp_enqueue_style( 'wplab-albedo-woocommerce', wplab_albedo_utils::locate_uri( '/css/front/css/plugins/woocommerce.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-woocommerce-variable', wplab_albedo_utils::locate_uri( '/css/front/less/plugins/woocommerce_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_script( 'accounting', WC()->plugin_url() . '/assets/js/accounting/accounting' . $suffix . '.js', array( 'jquery' ), '0.4.2' );
		wp_register_script( 'wc-jquery-ui-touchpunch', WC()->plugin_url() . '/assets/js/jquery-ui-touch-punch/jquery-ui-touch-punch' . $suffix . '.js', array( 'jquery-ui-slider' ), WC_VERSION, true );
		wp_register_script( 'wc-price-slider', WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js', array( 'jquery-ui-slider', 'wc-jquery-ui-touchpunch', 'accounting' ), WC_VERSION, true );
		wp_localize_script( 'wc-price-slider', 'woocommerce_price_slider_params', array(
			'min_price'			           => isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '',
			'max_price'			           => isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '',
			'currency_format_num_decimals' => 0,
			'currency_format_symbol'       => get_woocommerce_currency_symbol(),
			'currency_format_decimal_sep'  => esc_attr( wc_get_price_decimal_separator() ),
			'currency_format_thousand_sep' => esc_attr( wc_get_price_thousand_separator() ),
			'currency_format'              => esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), get_woocommerce_price_format() ) ),
		) );
		wp_enqueue_script( 'wc-price-slider' );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-shop', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/shop/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:shop',
		'_action_wplab_albedo_shortcode_shop_enqueue_dynamic_css'
	);

endif;
