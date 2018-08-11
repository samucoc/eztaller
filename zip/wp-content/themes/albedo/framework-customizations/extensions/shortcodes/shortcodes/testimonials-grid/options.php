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
				'items' => array(
					'type'          => 'addable-popup',
					'label'         => esc_html__( 'Testimonials', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Testimonial', 'albedo' ),
					'desc'          => esc_html__( 'Create your testimonials', 'albedo' ),
					'template'      => '{{=author}}',
					'popup-options' => array(
						'text' => array(
							'type'  => 'textarea',
							'label' => esc_html__('Text', 'albedo')
						),
						'author' => array(
							'type'  => 'text',
							'label' => esc_html__('Author', 'albedo')
						),
						'position' => array(
							'type'  => 'text',
							'label' => esc_html__('Position', 'albedo')
						),
						'photo' => array(
							'type'  => 'upload',
							'label' => esc_html__('Upload photo', 'albedo'),
							'images_only' => true,
						),
					),
				),
				'cols' => array(
					'label' => esc_html__( 'Columns', 'albedo' ),
					'type' => 'select',
					'value' => '1',
					'choices' => array(
						'1' => esc_html__('1 Column', 'albedo'),
						'2' => esc_html__('2 Columns', 'albedo'),
						'3' => esc_html__('3 Columns', 'albedo'),
						'4' => esc_html__('4 Columns', 'albedo'),
					),
				),
				'custom_font_family' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Custom font family', 'albedo' ),
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

							'font_family' => array(
								'type' => 'typography',
								'attr'  => array(
									'class' => 'wproto-hide-weight',
								),
								'value' => array(
									'family' => 'Arial',
								),
								'components' => array(
									'family' => true,
									'size'   => false,
									'color'  => false
								),
								'label' => esc_html__('Font family', 'albedo'),
							),

						),
					),
					'show_borders' => false,
				),
			)
		),
		'animation-settings' => array(
			'title' => esc_html__( 'Animation', 'albedo' ),
			'type' => 'tab',
			'options' => array(

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

				'animate_on_hover' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Animate elements on mouse hover', 'albedo' ),
							'type' => 'switch',
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'No', 'albedo' )
							),
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Yes', 'albedo' )
							),
							'value' => 'no',
						)
					),
					'choices' => array(
						'yes' => array(

							'animation_effect' => array(
								'label' => esc_html__( 'Animation Effect', 'albedo' ),
								'type' => 'select',
								'choices' => $wplab_albedo_core->cfg['animations'],
								'value' => 'zoomIn',
							),

						)
					)
				),
			)
		),
	)

);
