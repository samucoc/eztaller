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
							'type'  => 'text',
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
						'bg' => array(
							'type'  => 'background-image',
							'label' => esc_html__('Background image', 'albedo'),
							'desc' => esc_html__('Can be used only for Photo Background style', 'albedo'),
						),
					),
				),
				'style' => array(
					'label' => esc_html__( 'Style', 'albedo' ),
					'type' => 'select',
					'value' => 'default',
					'choices' => array(
						'default' => esc_html__('Default', 'albedo'),
						'photo' => esc_html__('Photo background (full-width)', 'albedo'),
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

			)
		),
		'colors-settings' => array(
			'title' => esc_html__( 'Colors', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'number_color' => array(
					'label' => esc_html__('Number color', 'albedo'),
					'desc' => esc_html__('custom number color', 'albedo'),
					'type' => 'color-picker',
				),
				'number_hover_color' => array(
					'label' => esc_html__('Number hover color', 'albedo'),
					'desc' => esc_html__('custom number hover color', 'albedo'),
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

			)
		),
	)

);
