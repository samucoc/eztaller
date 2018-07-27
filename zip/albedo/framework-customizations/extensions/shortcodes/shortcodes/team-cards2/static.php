<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_team_cards2_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_team_cards2_enqueue_dynamic_css( $data ) {

		$shortcode = 'team-cards2';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** load static stylesheet **/
		wp_enqueue_style( 'wplab-albedo-team-cards2', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/team_cards2.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-team-cards2-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/team_cards2_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		/** include swiper carousel library styles **/
		wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/libs/swiper.min.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_script( 'swiper');
		wp_enqueue_script( 'wplab-albedo-team-cards2', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/team-cards2/static/js/scripts' . $postfix . '.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:team_cards2',
		'_action_wplab_albedo_shortcode_team_cards2_enqueue_dynamic_css'
	);

endif;
