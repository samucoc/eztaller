<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$_forms_list = array(
	'' => esc_html__('- Select a form -', 'albedo' ),
);

$forms = array();

if( shortcode_exists('gravityform') ) {
	$forms = $wplab_albedo_core->model( 'thirdparty' )->get_gravityforms();
}

if( !empty( $forms ) ) {
	foreach( $forms as $form ) {
		$_forms_list[ $form->id ] = $form->title;
	}
}

$options = array(
	'form_id' => array(
		'label' => esc_html__( 'Choose a form', 'albedo' ),
		'type' => 'select',
		'value' => '',
		'choices' => $_forms_list,
		'desc' => esc_html__( 'Select one of created forms. Gravity Forms plugin should be activated.', 'albedo' ),
	),
	'display_title' => array(
		'label' => esc_html__( 'Display form title', 'albedo' ),
		'type' => 'switch',
		'left-choice' => array(
			'value' => 'false',
			'color' => '#ccc',
			'label' => esc_html__( 'Disabled', 'albedo' )
		),
		'right-choice' => array(
			'value' => 'true',
			'label' => esc_html__( 'Enabled', 'albedo' )
		),
		'value' => 'false',
	),
	'display_desc' => array(
		'label' => esc_html__( 'Display form description', 'albedo' ),
		'type' => 'switch',
		'left-choice' => array(
			'value' => 'false',
			'color' => '#ccc',
			'label' => esc_html__( 'Disabled', 'albedo' )
		),
		'right-choice' => array(
			'value' => 'true',
			'label' => esc_html__( 'Enabled', 'albedo' )
		),
		'value' => 'false',
	),
	'ajax' => array(
		'label' => esc_html__( 'Use AJAX', 'albedo' ),
		'type' => 'switch',
		'left-choice' => array(
			'value' => 'false',
			'color' => '#ccc',
			'label' => esc_html__( 'Disabled', 'albedo' )
		),
		'right-choice' => array(
			'value' => 'true',
			'label' => esc_html__( 'Enabled', 'albedo' )
		),
		'value' => 'false',
	),
);
