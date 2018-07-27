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
					'label'         => esc_html__( 'Benefits', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Benefits', 'albedo' ),
					'desc'          => esc_html__( 'Create your benefits', 'albedo' ),
					'template'      => '{{=title}}',
					'popup-options' => array(
						'title' => array(
							'type'  => 'textarea',
							'label' => esc_html__('Title', 'albedo')
						),
						'text' => array(
							'type'  => 'textarea',
							'label' => esc_html__('Text', 'albedo')
						),
						'link' => array(
							'type'  => 'text',
							'label' => esc_html__('Link (optional)', 'albedo')
						),
						'icon_type' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'value' => array(
								'benefit_icon' => '',
							),
							'picker' => array(
								'benefit_icon' => array(
									'label' => esc_html__( 'Benefit icon', 'albedo' ),
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
			)
		),
		'style-settings' => array(
			'title' => esc_html__( 'Style', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'style' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'value' => array(
						'items_style' => '',
					),
					'picker' => array(
						'items_style' => array(
							'label' => esc_html__( 'Style', 'albedo' ),
							'type' => 'select',
							'value' => 'white',
							'choices' => array(
								'white' => esc_html__( 'For white backgrounds', 'albedo' ),
								'colorful' => esc_html__( 'For colorful backgrounds', 'albedo' ),
							),
						)
					),
					'choices' => array(
						'colorful' => array(

							'accent_color' => array(
								'label' => esc_html__( 'Accent color', 'albedo' ),
								'type' => 'select',
								'choices' => $wplab_albedo_core->cfg['base_colors'],
							)

						),
					)
				),
				'display_borders' => array(
					'label' => esc_html__( 'Display borders', 'albedo' ),
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
				),
				'icon_position' => array(
					'label' => esc_html__( 'Icon position', 'albedo' ),
					'type' => 'radio',
					'value' => 'left',
					'choices' => array(
						'left' => esc_html__( 'Left', 'albedo' ),
						'top' => esc_html__( 'Top', 'albedo' ),
						'center' => esc_html__( 'Center', 'albedo' ),
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
				'margin_bottom' => array(
					'label' => esc_html__( 'Custom bottom margin', 'albedo' ),
					'desc' => esc_html__( 'by defaults it has 70px margin', 'albedo' ),
					'type' => 'short-text',
					'value' => ''
				),
				'link_target' => array(
					'label' => esc_html__( 'Open links at new tab', 'albedo' ),
					'type' => 'switch',
					'left-choice' => array(
						'value' => '_self',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'right-choice' => array(
						'value' => '_blank',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'value' => '_self',
				),
				'display_button' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Display button', 'albedo' ),
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

							'button_text' => array(
								'type'  => 'text',
								'label' => esc_html__('Button text', 'albedo'),
								'value' => esc_html__('READ MORE', 'albedo'),
							),
							'button_style'  => array(
								'label'   => esc_html__( 'Button Style', 'albedo' ),
								'desc'    => esc_html__( 'Here you can choose pre-defined styles for a button', 'albedo' ),
								'type'    => 'select',
								'choices' => $wplab_albedo_core->cfg['button_styles']
							),

						)
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
		'colors-settings' => array(
			'title' => esc_html__( 'Colors', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'icon_color' => array(
					'label' => esc_html__('Icon color', 'albedo'),
					'desc' => esc_html__('custom icon color', 'albedo'),
					'type' => 'color-picker',
				),
				'icon_hover_color' => array(
					'label' => esc_html__('Icon hover color', 'albedo'),
					'desc' => esc_html__('custom icon hover color', 'albedo'),
					'type' => 'color-picker',
				),
				'header_color' => array(
					'label' => esc_html__('Header color', 'albedo'),
					'desc' => esc_html__('custom header color', 'albedo'),
					'type' => 'color-picker',
				),
				'header_hover_color' => array(
					'label' => esc_html__('Header hover color', 'albedo'),
					'desc' => esc_html__('custom header hover color', 'albedo'),
					'type' => 'color-picker',
				),
				'text_color' => array(
					'label' => esc_html__('Text color', 'albedo'),
					'desc' => esc_html__('custom text color', 'albedo'),
					'type' => 'color-picker',
				),
				'border_color' => array(
					'label' => esc_html__('Border color', 'albedo'),
					'desc' => esc_html__('custom border color', 'albedo'),
					'type' => 'color-picker',
				),

			)
		),
	)

);
