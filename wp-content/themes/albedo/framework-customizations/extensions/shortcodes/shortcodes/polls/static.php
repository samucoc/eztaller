<?php if ( !defined( 'FW')) die( 'Forbidden');

if ( ! function_exists( '_action_wplab_albedo_shortcode_polls_enqueue_dynamic_css') ):

	/**
	 * @internal
	 * @param array $data
	 */
	function _action_wplab_albedo_shortcode_polls_enqueue_dynamic_css( $data ) {
		global $wplab_albedo_core;
		$shortcode = 'polls';
		$atts = shortcode_parse_atts( $data['atts_string'] );
		$atts = fw_ext_shortcodes_decode_attr( $atts, $shortcode, $data['post']->ID );

		$shortcode_id = 'shortcode-' . $atts['id'];

		$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		/** load stylesheet **/
		wp_enqueue_style( 'wplab-albedo-polls', wplab_albedo_utils::locate_uri( '/css/front/css/shortcodes/polls.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-polls-variable', wplab_albedo_utils::locate_uri( '/css/front/less/shortcodes/polls_variable.less'), false, _WPLAB_ALBEDO_CACHE_TIME_ );

		/**
		 * Shortcode scripts
		 **/
		wp_enqueue_script( 'cookie' );
		wp_enqueue_script( 'wplab-albedo-polls', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/polls/static/js/scripts' . $postfix . '.js'), array('jquery', 'cookie', 'md5'), _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_localize_script( 'wplab-albedo-polls', 'wplabAlbedoPolls', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

	}
	add_action(
		'fw_ext_shortcodes_enqueue_static:polls',
		'_action_wplab_albedo_shortcode_polls_enqueue_dynamic_css'
	);

endif;
