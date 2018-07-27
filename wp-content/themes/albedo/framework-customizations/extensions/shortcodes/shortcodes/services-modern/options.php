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
				'photo' => array(
					'type'  => 'background-image',
					'label' => esc_html__('Header background', 'albedo'),
				),
				'icon_type' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'value' => array(
						'service_icon' => '',
					),
					'picker' => array(
						'service_icon' => array(
							'label' => esc_html__( 'Service icon', 'albedo' ),
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
				'category' => array(
					'type'  => 'text',
					'label' => esc_html__('Category (optional)', 'albedo')
				),
				'title' => array(
					'type'  => 'text',
					'label' => esc_html__('Title', 'albedo')
				),
				'text' => array(
					'type'  => 'textarea',
					'label' => esc_html__('Text', 'albedo'),
					'value' => 'Investigationes demonstraverunt lectores legere me lius.

* Sales
* Marketing
* Consultantation
* Planing',
					'desc' => esc_html__('Here you can use * characted to generate ordered list', 'albedo'),
				),
				'link' => array(
					'type'  => 'text',
					'label' => esc_html__('Link (optional)', 'albedo')
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
								'value' => esc_html__('VIEW DETAILS', 'albedo'),
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
				'featured' => array(
					'label' => esc_html__( 'This service is featured', 'albedo' ),
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
			),
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
								'label' => esc_html__('Animation delay', 'albedo'),
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
	)

);
