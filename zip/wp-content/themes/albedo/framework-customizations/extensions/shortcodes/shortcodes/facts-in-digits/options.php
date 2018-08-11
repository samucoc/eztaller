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
					'label'         => esc_html__( 'Facts in Digits', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Facts in Digits', 'albedo' ),
					'desc'          => esc_html__( 'Create Facts in Digits', 'albedo' ),
					'template'      => '{{=number}} {{=text}}',
					'popup-options' => array(
						'number' => array(
							'type'  => 'short-text',
							'label' => esc_html__('Number', 'albedo')
						),
						'text' => array(
							'type'  => 'text',
							'label' => esc_html__('Description', 'albedo')
						),
						'icon_type' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'value' => array(
								'item_icon' => '',
							),
							'picker' => array(
								'item_icon' => array(
									'label' => esc_html__( 'Icon', 'albedo' ),
									'type' => 'radio',
									'choices' => array(
										'' => esc_html__( 'Without Icon', 'albedo' ),
										'fontawesome' => esc_html__( 'Choose an icon from Icon Library', 'albedo' ),
										'custom' => esc_html__( 'Upload custom Image icon', 'albedo' ),
									),
								)
							),
							'choices' => array(
								'fontawesome' => array(

									'icon' => array(
										'type' => 'icon',
										'label' => esc_html__( 'Icon', 'albedo' )
									),

								),
								'custom' => array(

									'icon' => array(
										'type'  => 'upload',
										'label' => esc_html__('Upload icon file', 'albedo'),
										'images_only' => true,
									),

								),
							)
						),
					),
				),
				'cols' => array(
					'label' => esc_html__( 'Columns', 'albedo' ),
					'type' => 'select',
					'value' => '4',
					'choices' => array(
						'1' => esc_html__('1 Column', 'albedo'),
						'2' => esc_html__('2 Columns', 'albedo'),
						'3' => esc_html__('3 Columns', 'albedo'),
						'4' => esc_html__('4 Columns', 'albedo'),
					),
				),
				'animation_type' => array(
					'type' => 'multi-picker',
					'show_borders' => false,
					'label' => false,
					'desc' => false,
					'value' => array(
						'type' => 'numinate',
					),
					'picker' => array(
						'type' => array(
							'label' => esc_html__( 'Animation type', 'albedo' ),
							'type' => 'select',
							'value' => 'typing',
							'choices' => array(
								'numinate' => esc_html__( 'Numinate', 'albedo' ),
								'typing' => esc_html__( 'Typing', 'albedo' ),
								'odometer' => esc_html__( 'Odometer', 'albedo' ),
							),
						)
					),
					'choices' => array(

						'numinate' => array(



						),

						'typing' => array(

							'speed' => array(
								'type'  => 'short-text',
								'value' => '100',
								'label' => esc_html__('Typing speed', 'albedo')
							),
							'delay' => array(
								'type'  => 'short-text',
								'value' => '100',
								'label' => esc_html__('Typing delay', 'albedo')
							),

						),

					)
				),
			)

		),
		'animation-settings' => array(
			'title' => esc_html__( 'Animation', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'animate_on_display' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Animate elements on display', 'albedo' ),
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
								'value' => 'fadeIn',
							),
							'animation_step' => array(
								'type'  => 'text',
								'label' => esc_html__('Time step', 'albedo'),
								'desc' => esc_html__('in seconds (e.g. 0.2). This option animates elements with delay.', 'albedo'),
								'value' => '0.2',
							),

						)
					)
				),

			)
		),
		'colors-settings' => array(
			'title' => esc_html__( 'Custom colors', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'icon_color' => array(
					'label' => esc_html__('Icon color', 'albedo'),
					'desc' => esc_html__('custom icon color', 'albedo'),
					'type' => 'color-picker',
				),
				'number_color' => array(
					'label' => esc_html__('Number color', 'albedo'),
					'desc' => esc_html__('custom number color', 'albedo'),
					'type' => 'color-picker',
				),
				'text_color' => array(
					'label' => esc_html__('Text color', 'albedo'),
					'desc' => esc_html__('custom text color', 'albedo'),
					'type' => 'color-picker',
				),

			)
		),
	)

);
