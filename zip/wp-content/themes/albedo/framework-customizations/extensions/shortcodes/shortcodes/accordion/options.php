<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'items' => array(
		'type'          => 'addable-popup',
		'label'         => esc_html__( 'Accordion Items', 'albedo' ),
		'popup-title'   => esc_html__( 'Add/Edit Items', 'albedo' ),
		'desc'          => esc_html__( 'Create accordion', 'albedo' ),
		'template'      => '{{=title}}',
		'size' 					=> 'large',
		'popup-options' => array(
			'title'   => array(
				'type'  => 'text',
				'label' => esc_html__('Title', 'albedo')
			),
			'content' => array(
				'type'  => 'wp-editor',
				'label' => esc_html__('Content', 'albedo'),
				'size' 	=> 'large',
			)
		)
	),
	'style' => array(
		'label' => esc_html__( 'Style', 'albedo' ),
		'desc' => esc_html__( 'Choose from one of available styles', 'albedo' ),
		'type' => 'select',
		'value' => 'default',
		'choices' => array(
			'default' => esc_html__( 'Default', 'albedo' ),
			'active_dark' => esc_html__( 'Active dark', 'albedo' ),
			'simple' => esc_html__( 'Simple, big titles', 'albedo' ),
		),
	),
);
