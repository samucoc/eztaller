<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'text' => array(
		'type'   => 'wp-editor',
		'teeny'  => false,
		'reinit' => true,
		'shortcodes' => true,
		'size' => 'large',
		'label'  => esc_html__( 'Content', 'albedo' ),
		'desc'   => esc_html__( 'Enter some content for this texblock', 'albedo' )
	),
	'dropcap' => array(
		'type' => 'multi-picker',
		'label' => false,
		'desc' => false,
		'picker' => array(
			'enabled' => array(
				'label' => esc_html__( 'Dropcap', 'albedo' ),
				'desc' => esc_html__('This option stylish a first letter of first paragraph', 'albedo'),
				'type' => 'switch',
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'albedo' )
				),
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'albedo' )
				),
				'value' => 'no',
			)
		),
		'choices' => array(
			'yes' => array(

				'style' => array(
					'label' => esc_html__( 'Dropcap style', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'blue' => esc_html__('Blue', 'albedo'),
						'grey' => esc_html__('Grey', 'albedo'),
						'red' => esc_html__('Red', 'albedo'),
						'orange' => esc_html__('Orange', 'albedo'),
						'green' => esc_html__('Green', 'albedo'),
						'turquoise' => esc_html__('Turquoise', 'albedo'),
						'purple' => esc_html__('Purple', 'albedo'),
						'dark-purple' => esc_html__('Dark Purple', 'albedo'),
						'blue with-shadow' => esc_html__('Blue + Shadow', 'albedo'),
						'grey with-shadow' => esc_html__('Grey + Shadow', 'albedo'),
						'red with-shadow' => esc_html__('Red + Shadow', 'albedo'),
						'orange with-shadow' => esc_html__('Orange + Shadow', 'albedo'),
						'green with-shadow' => esc_html__('Green + Shadow', 'albedo'),
						'turquoise with-shadow' => esc_html__('Turquoise + Shadow', 'albedo'),
						'purple with-shadow' => esc_html__('Purple + Shadow', 'albedo'),
						'dark-purple with-shadow' => esc_html__('Dark Purple + Shadow', 'albedo'),
					),
				),


			),
		),
		'show_borders' => false,
	),
);
