<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$map_shortcode = fw_ext('shortcodes')->get_shortcode('google_map');
$options = array(
	'data_provider' => array(
		'type'  => 'multi-picker',
		'label' => false,
		'desc'  => false,
		'picker' => array(
			'population_method' => array(
				'label'   => __('Population Method', 'albedo'),
				'desc'    => __( 'Select map population method (Ex: events, custom)', 'albedo' ),
				'type'    => 'select',
				'choices' => $map_shortcode->_get_picker_dropdown_choices(),
			)
		),
		'choices' => $map_shortcode->_get_picker_choices(),
		'show_borders' => false,
	),
	'gmap-key' => array_merge(
		array(
			'label' => __( 'Google Maps API Key', 'albedo' ),
			'desc' => sprintf(
				__( 'Create an application in %sGoogle Console%s and add the Key here.', 'albedo' ),
				'<a href="https://console.developers.google.com/flows/enableapi?apiid=places_backend,maps_backend,geocoding_backend,directions_backend,distance_matrix_backend,elevation_backend&keyType=CLIENT_SIDE&reusekey=true">',
				'</a>'
			),
		),
		version_compare(fw()->manifest->get_version(), '2.5.7', '>=')
		? array(
			'type' => 'gmap-key',
		)
		: array(
			'type' => 'text',
			'fw-storage' => array(
				'type'      => 'wp-option',
				'wp_option' => 'fw-option-types:gmap-key',
			),
		)
	),
	'map_type' => array(
		'type'  => 'select',
		'label' => __('Map Type', 'albedo'),
		'desc'  => __('Select map type', 'albedo'),
		'choices' => array(
			'roadmap'   => __('Roadmap', 'albedo'),
			'terrain' => __('Terrain', 'albedo'),
			'satellite' => __('Satellite', 'albedo'),
			'hybrid'    => __('Hybrid', 'albedo')
		)
	),
	'map_height' => array(
		'label' => __('Map Height', 'albedo'),
		'desc'  => __('Set map height (Ex: 300)', 'albedo'),
		'type'  => 'text'
	),
	'map_zoom' => array(
		'label' => __( 'Map Zoom', 'albedo' ),
		'desc'  => __( 'Set map zoom level', 'albedo' ),
		'type'  => 'slider',
		'properties' => array(
			'min' => 1,
			'max' => 16,
		)
	),
	'disable_scrolling' => array(
		'type'  => 'switch',
		'value' => false,
		'label' => __('Disable zoom on scroll', 'albedo'),
		'desc'  => __('Prevent the map from zooming when scrolling until clicking on the map', 'albedo'),
		'left-choice' => array(
			'value' => false,
			'label' => __('Yes', 'albedo'),
		),
		'right-choice' => array(
			'value' => true,
			'label' => __('No', 'albedo'),
		),
	),
	'display_shadow' => array(
		'label' => esc_html__( 'Display shadow?', 'albedo' ),
		'type' => 'switch',
		'value' => 'no',
		'left-choice' => array(
			'value' => 'no',
			'color' => '#ccc',
			'label' => esc_html__( 'No', 'albedo' )
		),
		'right-choice' => array(
			'value' => 'yes',
			'label' => esc_html__( 'Yes', 'albedo' )
		),
	),
);
