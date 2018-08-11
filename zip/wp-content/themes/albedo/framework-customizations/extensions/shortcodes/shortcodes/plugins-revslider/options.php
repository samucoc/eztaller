<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$_sliders_list = array(
	'' => esc_html__('- Select a slider -', 'albedo' ),
);

$sliders = array();

if( shortcode_exists('rev_slider') ) {
	$sliders = $wplab_albedo_core->model( 'thirdparty' )->get_rev_sliders();
}

if( !empty( $sliders ) ) {
	foreach( $sliders as $slider ) {
		$_sliders_list[ $slider->alias ] = $slider->title;
	}
}

$options = array(
	'slider_alias' => array(
		'label' => esc_html__( 'Choose a slider', 'albedo' ),
		'type' => 'select',
		'value' => '',
		'choices' => $_sliders_list,
		'desc' => esc_html__( 'Select one of created sliders. Slider Revolution plugin should be activated.', 'albedo' ),
	),
);
