<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_benefits_v2_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_benefits_v2_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'benefits_v2';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		fw()->backend->option_type('icon-v2')->packs_loader->enqueue_frontend_css();

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** load stylesheet **/
		wp_enqueue_style( 'wplab-albedo-benefits_v2', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/benefits_v2.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-benefits_v2-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/benefits_v2_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/** include Masonry Grid **/
		wp_enqueue_style( 'masonry', get_template_directory_uri() . '/css/libs/masonry.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'masonry-effects', get_template_directory_uri() . '/css/libs/masonry_effects.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'isotope');
		wp_enqueue_script( 'anim-on-scroll' );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'sticky-kit');
		wp_enqueue_script( 'wplab-albedo-benefits_v2', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/benefits-v2/static/js/scripts' . $postfix . '.js'), array('jquery', 'isotope'), _WPLAB_ALBEDO_CACHE_TIME_, true );


	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:benefits_v2',
		'_action_wplab_albedo_shortcode_benefits_v2_enqueue_dynamic_css'
	);

endif;
