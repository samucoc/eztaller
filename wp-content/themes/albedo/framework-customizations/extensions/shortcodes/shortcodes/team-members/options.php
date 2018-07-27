<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$options = array(
	'id' => array( 'type' => 'unique' ),
	'general' => array(
		'title' => esc_html__( 'General', 'albedo' ),
		'type' => 'tab',
		'options' => array(

			'items' => array(
				'type'          => 'addable-popup',
				'label'         => esc_html__( 'Team Members', 'albedo' ),
				'popup-title'   => esc_html__( 'Add/Edit Team Member', 'albedo' ),
				'desc'          => esc_html__( 'Create your team', 'albedo' ),
				'template'      => '{{=name}}',
				'popup-options' => array(
					'photo' => array(
						'label' => esc_html__('Photo', 'albedo'),
						'type' => 'background-image',
					),
					'name' => array(
						'type'  => 'text',
						'label' => esc_html__('Name', 'albedo')
					),
					'position' => array(
						'type'  => 'text',
						'label' => esc_html__('Position', 'albedo')
					),
					'free_text' => array(
						'type'  => 'textarea',
						'label' => esc_html__('Free Text', 'albedo')
					),
					'is_vacancy' => array(
						'label' => esc_html__( 'Job vacancy', 'albedo' ),
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
					'display_button' => array(
						'type' => 'multi-picker',
						'label' => false,
						'picker' => array(
							'enabled' => array(
								'label' => esc_html__( 'Display a button', 'albedo' ),
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

								'btn_text' => array(
									'type'  => 'text',
									'label' => esc_html__('Button text', 'albedo')
								),
								'btn_url' => array(
									'type'  => 'text',
									'label' => esc_html__('Button URL', 'albedo')
								),
								'btn_style'  => array(
									'label'   => esc_html__( 'Button Style', 'albedo' ),
									'desc'    => esc_html__( 'Here you can choose pre-defined styles for a button', 'albedo' ),
									'type'    => 'select',
									'choices' => $wplab_albedo_core->cfg['button_styles']
								),
								'btn_target' => array(
									'label' => esc_html__( 'Open link at new tab?', 'albedo' ),
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
								)

							)
						)
					),
				) + wplab_albedo_utils::get_social_cfg_usyon(),
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
);
