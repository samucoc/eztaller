<?php if (!defined('FW')) die('Forbidden');

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'attributes' => array(
			'title' => esc_html__( 'Attributes', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'title' => array(
					'type'  => 'text',
					'label' => esc_html__('Title', 'albedo')
				),
				'value' => array(
					'type'  => 'slider',
					'value' => 50,
					'properties' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'style' => array(
					'label' => esc_html__( 'Bar style', 'albedo' ),
					'type' => 'select',
					'value' => 'blue',
					'choices' => array(
						array (
							'attr' => array(
								'label' => esc_html__( 'Flat style', 'albedo' ),
							),
							'choices' => array(
								'blue'      	=> esc_html__( 'Blue', 'albedo' ),
								'black' 			=> esc_html__( 'Black', 'albedo' ),
								'grey' 				=> esc_html__( 'Grey', 'albedo' ),
								'red' 				=> esc_html__( 'Red', 'albedo' ),
								'orange' 			=> esc_html__( 'Orange', 'albedo' ),
								'green' 			=> esc_html__( 'Green', 'albedo' ),
								'turquoise'		=> esc_html__( 'Turquoise', 'albedo' ),
								'yellow'			=> esc_html__( 'Yellow', 'albedo' ),
								'purple'			=> esc_html__( 'Purple', 'albedo' ),
								'dark-purple'	=> esc_html__( 'Dark Purple', 'albedo' ),
							),
						),
						array (
							'attr' => array(
								'label' => esc_html__( '3D Style', 'albedo' ),
							),
							'choices' => array(
								'blue style-type-3d'      	=> esc_html__( 'Blue', 'albedo' ),
								'black style-type-3d' 			=> esc_html__( 'Black', 'albedo' ),
								'grey style-type-3d' 				=> esc_html__( 'Grey', 'albedo' ),
								'red style-type-3d' 				=> esc_html__( 'Red', 'albedo' ),
								'orange style-type-3d' 			=> esc_html__( 'Orange', 'albedo' ),
								'green style-type-3d' 			=> esc_html__( 'Green', 'albedo' ),
								'turquoise style-type-3d'		=> esc_html__( 'Turquoise', 'albedo' ),
								'yellow style-type-3d'			=> esc_html__( 'Yellow', 'albedo' ),
								'purple style-type-3d'			=> esc_html__( 'Purple', 'albedo' ),
								'dark-purple style-type-3d'	=> esc_html__( 'Dark Purple', 'albedo' ),
							),
						),
					),
				),

			)
		),
		'colors' => array(
			'title' => esc_html__( 'Custom colors', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'bar_bg_color' => array(
					'label' => esc_html__('Bar background color', 'albedo'),
					'type' => 'rgba-color-picker',
				),
				'bar_accent_color' => array(
					'label' => esc_html__('Bar accent color', 'albedo'),
					'type' => 'rgba-color-picker',
				),
				'text_color' => array(
					'label' => esc_html__('Description color', 'albedo'),
					'type' => 'rgba-color-picker',
				),
				'value_color' => array(
					'label' => esc_html__('Value color', 'albedo'),
					'type' => 'rgba-color-picker',
				),

			)
		),
	),
);
