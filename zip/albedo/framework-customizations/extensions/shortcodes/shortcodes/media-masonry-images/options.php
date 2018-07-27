<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$options = array(

	array(
		'id' => array( 'type' => 'unique' ),
		'general' => array(
			'title' => esc_html__( 'General', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'images' => array(
					'label' => esc_html__( 'Choose images', 'albedo' ),
					'type' => 'multi-upload',
					'desc' => esc_html__( 'Select or upload several images to create gallery', 'albedo' ),
					'images_only' => true
				),


			)
		),
		'grid' => array(
			'title' => esc_html__( 'Grid', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'cols' => array(
					'label' => esc_html__( 'Number of columns', 'albedo' ),
					'type' => 'select',
					'choices' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					),
				),
				'effect' => array(
					'label' => esc_html__( 'Loading effect', 'albedo' ),
					'type' => 'select',
					'value' => 'effect-1',
					'choices' => array(
						'effect-1' => esc_html__('Fade', 'albedo'),
						'effect-2' => esc_html__('Move Up', 'albedo'),
						'effect-3' => esc_html__('Scale up', 'albedo'),
						'effect-4' => esc_html__('Fall perspective', 'albedo'),
						'effect-5' => esc_html__('Fly', 'albedo'),
						'effect-6' => esc_html__('Calendar', 'albedo'),
						'effect-7' => esc_html__('Helix', 'albedo'),
						'effect-8' => esc_html__('Flip', 'albedo'),
					),
				),
				'margins' => array(
					'type'  => 'short-text',
					'label' => esc_html__('Margins between images', 'albedo'),
					'value'  => 40,
				),
				'display_caption' => array(
					'label' => esc_html__( 'Display image caption', 'albedo' ),
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
					'value' => 'yes',
				),
			)
		),
		'style' => array(
			'title' => esc_html__( 'Style', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'border_radius' => array(
					'type'  => 'short-text',
					'label' => esc_html__('Border radius for images', 'albedo'),
					'desc' => esc_html__('value in pixels, e.g.: 20', 'albedo'),
					'value'  => '',
				),
				'overlay_color' => array(
					'label' => esc_html__( 'Overlay color', 'albedo' ),
					'type' => 'select',
					'value' => 'dark',
					'choices' => array(
						'dark' => esc_html__( 'Dark', 'albedo' ),
						'accent' => esc_html__( 'Theme Accent', 'albedo' )
					),
				),
				'shadows' => array(
					'label' => esc_html__( 'Add shadows', 'albedo' ),
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
				),

			)
		),

	)

);
