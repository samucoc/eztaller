<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'general' => array(
			'title' => esc_html__( 'General', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'label' => array(
					'type'  => 'text',
					'value' => esc_html__('Earnings', 'albedo'),
					'label' => esc_html__('Chart label', 'albedo'),
				),
				'items' => array(
					'type'          => 'addable-popup',
					'label'         => esc_html__( 'Charts', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Chart Items', 'albedo' ),
					'desc'          => esc_html__( 'Create a chart', 'albedo' ),
					'template'      => '{{=title}}',
					'popup-options' => array(
						'title' => array(
							'type'  => 'text',
							'label' => esc_html__('Title', 'albedo')
						),
						'value' => array(
							'type'  => 'text',
							'label' => esc_html__('Value', 'albedo'),
							'reinit' => true
						),
						'color' => array(
							'type'  => 'color-picker',
							'value' => '#ed1c24',
							'label' => esc_html__('Color', 'albedo'),
							'desc' => esc_html__('can be allpied for Pie Chart only', 'albedo'),
						),
					),
				),
				'type' => array(
					'label' => esc_html__( 'Chart type', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'line' => esc_html__('Line', 'albedo'),
						'bar' => esc_html__('Bar', 'albedo'),
						'pie' => esc_html__('Pie', 'albedo'),
					),
				),
				'height' => array(
					'type'  => 'text',
					'value' => '70',
					'label' => esc_html__('Height', 'albedo'),
					'desc' => esc_html__('e.g. 70', 'albedo'),
				),
			)
		),
	)

);
