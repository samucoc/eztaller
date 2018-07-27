<?php if (!defined('FW')) die('Forbidden');

{
	$query_params = array(
		'v' => '3.25',
		'language' => substr( get_locale(), 0, 2 ),
		'libraries' => 'places',
	);

	$postfix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

	/**
	 * Check if Map option type has the `api_key` method, as user may have a older Unyson version.
	 * TODO: Remove in next versions and provide a better solution
	 */
	if (method_exists('FW_Option_Type_Map', 'api_key')) {
		$query_params['key'] = FW_Option_Type_Map::api_key();
	}

	wp_enqueue_script(
		'google-maps-api-v3',
		'https://maps.googleapis.com/maps/api/js?'. http_build_query($query_params),
		array(),
		$query_params['v'],
		true
	);
}

wp_dequeue_style( 'fw-shortcode-google-map');

wp_enqueue_script( 'wplab-albedo-google-map', wplab_albedo_utils::locate_uri('/framework-customizations/extensions/shortcodes/shortcodes/google-map/static/js/scripts' . $postfix . '.js'), array('jquery', 'underscore', 'google-maps-api-v3'), _WPLAB_ALBEDO_CACHE_TIME_, true );
