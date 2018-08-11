<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_team_members_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_team_members_enqueue_dynamic_css( $data ) {

		$shortcode = 'team-members';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		/** load static stylesheet **/
		wp_enqueue_style( 'wplab-albedo-team-members', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/team_members.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-team-members-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/team_members_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'wplab-albedo-team-members', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/team-members/static/js/scripts.js'), array('jquery'), _WPLAB_ALBEDO_CACHE_TIME_, true );

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:team_members',
		'_action_wplab_albedo_shortcode_team_members_enqueue_dynamic_css'
	);

endif;
