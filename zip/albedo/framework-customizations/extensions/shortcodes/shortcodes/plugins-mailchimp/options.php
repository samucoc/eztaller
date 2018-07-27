<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$_forms_list = array(
	'' => esc_html__('- Select a form -', 'albedo' ),
);

$forms = array();

if( shortcode_exists('mc4wp_form') ) {
	$forms = $wplab_albedo_core->model( 'thirdparty' )->get_mailchimp_forms();
}

if( !empty( $forms ) ) {
	foreach( $forms as $form ) {
		$_forms_list[ $form->ID ] = $form->post_title;
	}
}

$options = array(
	'form_id' => array(
		'label' => esc_html__( 'Choose a form', 'albedo' ),
		'type' => 'select',
		'value' => '',
		'choices' => $_forms_list,
		'desc' => esc_html__( 'Select one of created forms. Mail Chimp plugin should be activated.', 'albedo' ),
	),
);
