<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'attributes' => array(
			'title' => esc_html__( 'Attributes', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'label'  => array(
					'label' => esc_html__( 'Button Label', 'albedo' ),
					'desc'  => esc_html__( 'This is the text that appears on your button', 'albedo' ),
					'type'  => 'text',
					'value' => 'Submit'
				),
				'link'   => array(
					'label' => esc_html__( 'Button Link', 'albedo' ),
					'desc'  => esc_html__( 'Where should your button link to', 'albedo' ),
					'type'  => 'text',
					'value' => '#'
				),
				'target' => array(
					'type'  => 'switch',
					'label'   => esc_html__( 'Open Link in New Window', 'albedo' ),
					'desc'    => esc_html__( 'Select here if you want to open the linked page in a new window', 'albedo' ),
					'right-choice' => array(
						'value' => '_blank',
						'label' => esc_html__('Yes', 'albedo'),
					),
					'left-choice' => array(
						'value' => '_self',
						'color' => '#ccc',
						'label' => esc_html__('No', 'albedo'),
					),
				),
				'button_id'  => array(
					'label' => esc_html__( 'Button ID', 'albedo' ),
					'desc'  => esc_html__( 'Here you can set unique identifier for this button', 'albedo' ),
					'type'  => 'text',
					'value' => ''
				),
				'custom_classes'  => array(
					'label' => esc_html__( 'Custom CSS classes', 'albedo' ),
					'desc'  => esc_html__( 'For example: my-custom-class alignleft', 'albedo' ),
					'type'  => 'text',
					'value' => ''
				),
			)
		),
		'styling' => array(
			'title' => esc_html__( 'Styling', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'style'  => array(
					'label'   => esc_html__( 'Button Style', 'albedo' ),
					'desc'    => esc_html__( 'Here you can choose pre-defined styles for a button', 'albedo' ),
					'type'    => 'select',
					'choices' => $wplab_albedo_core->cfg['button_styles']
				),
				'align'  => array(
					'label'   => esc_html__( 'Button Align', 'albedo' ),
					'type'    => 'select',
					'choices' => array(
						''      => esc_html__('None', 'albedo'),
						'left' => esc_html__( 'Left', 'albedo' ),
						'center' => esc_html__( 'Center', 'albedo' ),
						'right' => esc_html__( 'Right', 'albedo' ),
					)
				),
				'size' => array(
					'label' => esc_html__( 'Button Size', 'albedo' ),
					'type' => 'select',
					'value' => 'medium',
					'choices' => array(
						'medium' => esc_html__( 'Medium', 'albedo' ),
						'small' => esc_html__( 'Small', 'albedo' ),
						'large' => esc_html__( 'Large', 'albedo' ),
						'xlarge' => esc_html__( 'X Large', 'albedo' ),
					),
				),
				'icon' => array(
					'type'  => 'icon-v2',
				),
				'icon_position' => array(
					'label' => esc_html__( 'Icon position', 'albedo' ),
					'type' => 'select',
					'value' => 'right',
					'choices' => array(
						'left' => esc_html__( 'Left', 'albedo' ),
						'right' => esc_html__( 'Right', 'albedo' ),
					),
				),
				'animation' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Animate button', 'albedo' ),
							'desc' => esc_html__('Using CSS animation', 'albedo'),
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

							'effect' => array(
								'label' => esc_html__( 'Choose animation effect', 'albedo' ),
								'type' => 'select',
								'value' => '',
								'choices' => array(
									array (
										'attr' => array(
											'label' => esc_html__( 'Animate.css Library', 'albedo' ),
										),
										'choices' => $wplab_albedo_core->cfg['animations'],
									),
								),
							),

							'animation_delay' => array(
								'label' => esc_html__('Animation delay', 'albedo'),
								'desc' => esc_html__('For example: 0.3s', 'albedo'),
								'type' => 'text',
							),

						),
					),
					'show_borders' => false,
				),

			)
		),
		'customize' => array(
			'title' => esc_html__( 'Customize', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'border_radius' => array(
					'type'  => 'short-text',
					'value'  => '',
					'label' => esc_html__('Border radius', 'albedo'),
					'desc' => esc_html__('Value in pixels', 'albedo'),
				),
				'margins' => array(
					'label' => esc_html__( 'Button Margins', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'paddings' => array(
					'label' => esc_html__( 'Button Paddings', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'animation_time' => array(
					'type'  => 'slider',
					'value' => 300,
					'properties' => array(
						'min' => 0,
						'max' => 3000,
					),
					'label' => esc_html__( 'Animation time', 'albedo' ),
					'desc' => esc_html__( 'in milliseconds, 1000 = 1 second', 'albedo' ),
				),
				'text_transform' => array(
					'type'    => 'select',
					'label'   => esc_html__('Text Transform', 'albedo'),
					'value'		=> '',
					'choices' => array(
						'' => esc_html__('- Default -', 'albedo'),
						'none' => esc_html__('None', 'albedo'),
						'uppercase' => esc_html__('Uppercase', 'albedo'),
					),
				),
				'font_style' => array(
					'type'    => 'select',
					'label'   => esc_html__('Font Style', 'albedo'),
					'value'		=> '',
					'choices' => array(
						'' => esc_html__('- Default -', 'albedo'),
						'normal' => esc_html__('Normal', 'albedo'),
						'italic' => esc_html__('Italic', 'albedo'),
					),
				),
				'font_variant' => array(
					'type'    => 'select',
					'label'   => esc_html__('Font Variant', 'albedo'),
					'value'		=> '',
					'choices' => array(
						'' => esc_html__('- Default -', 'albedo'),
						'normal' => esc_html__('Normal', 'albedo'),
						'small-caps' => esc_html__('Small Caps', 'albedo'),
					),
				),
				'font_weight' => array(
					'type'    => 'select',
					'label'   => esc_html__('Font Weight', 'albedo'),
					'value'		=> '',
					'choices' => array(
						'' => esc_html__('- Default -', 'albedo'),
						'light' => esc_html__('Light', 'albedo'),
						'normal' => esc_html__('Normal', 'albedo'),
						'bold' => esc_html__('Bold', 'albedo'),
						'bolder' => esc_html__('Bolder', 'albedo'),
						'100' => '100',
						'300' => '300',
						'400' => '400',
						'600' => '600',
						'800' => '800',
					),
				),
				'customize_normal_state' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Custom normal state', 'albedo' ),
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

							'text_color' => array(
								'label' => esc_html__('Text color', 'albedo'),
								'desc' => esc_html__('Select the custom text color.', 'albedo'),
								'type' => 'color-picker',
							),
							'background_color' => array(
								'label' => esc_html__('Background color', 'albedo'),
								'desc' => esc_html__('Select the custom background color.', 'albedo'),
								'type' => 'color-picker',
							),
							'border_color' => array(
								'label' => esc_html__('Border color', 'albedo'),
								'desc' => esc_html__('Select the custom border color.', 'albedo'),
								'type' => 'color-picker',
							),
							'border_size' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => 0,
									'max' => 20,
								),
								'label' => esc_html__( 'Border size', 'albedo' ),
							),
							'shadow_color' => array(
								'label' => esc_html__('Shadow color', 'albedo'),
								'value' => 'rgba(0,0,0,0.0)',
								'type' => 'rgba-color-picker',
							),
							'shadow_h_length' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
							),
							'shadow_v_length' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
							),
							'shadow_blur_radius' => array(
								'type'  => 'slider',
								'value' => 90,
								'properties' => array(
									'min' => 0,
									'max' => 300,
								),
								'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
							),

						)
					)
				),
				'customize_hover_state' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Custom hover state', 'albedo' ),
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

							'hover_text_color' => array(
								'label' => esc_html__('Text color', 'albedo'),
								'desc' => esc_html__('Select the custom text color.', 'albedo'),
								'type' => 'color-picker',
							),
							'hover_background_color' => array(
								'label' => esc_html__('Background color', 'albedo'),
								'desc' => esc_html__('Select the custom background color.', 'albedo'),
								'type' => 'color-picker',
							),
							'hover_border_color' => array(
								'label' => esc_html__('Border color', 'albedo'),
								'desc' => esc_html__('Select the custom border color.', 'albedo'),
								'type' => 'color-picker',
							),
							'hover_border_size' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => 0,
									'max' => 20,
								),
								'label' => esc_html__( 'Border size', 'albedo' ),
							),
							'hover_shadow_color' => array(
								'label' => esc_html__('Shadow color', 'albedo'),
								'value' => 'rgba(0,0,0,0.0)',
								'type' => 'rgba-color-picker',
							),
							'hover_shadow_h_length' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
							),
							'hover_shadow_v_length' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
							),
							'hover_shadow_blur_radius' => array(
								'type'  => 'slider',
								'value' => 90,
								'properties' => array(
									'min' => 0,
									'max' => 300,
								),
								'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
							),

						)
					)
				),
				'customize_click_state' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Custom on click state', 'albedo' ),
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

							'click_text_color' => array(
								'label' => esc_html__('Text color', 'albedo'),
								'desc' => esc_html__('Select the custom text color.', 'albedo'),
								'type' => 'color-picker',
							),
							'click_background_color' => array(
								'label' => esc_html__('Background color', 'albedo'),
								'desc' => esc_html__('Select the custom background color.', 'albedo'),
								'type' => 'color-picker',
							),
							'click_border_color' => array(
								'label' => esc_html__('Border color', 'albedo'),
								'desc' => esc_html__('Select the custom border color.', 'albedo'),
								'type' => 'color-picker',
							),
							'click_border_size' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => 0,
									'max' => 20,
								),
								'label' => esc_html__( 'Border size', 'albedo' ),
							),
							'click_shadow_color' => array(
								'label' => esc_html__('Shadow color', 'albedo'),
								'value' => 'rgba(0,0,0,0.0)',
								'type' => 'rgba-color-picker',
							),
							'click_shadow_h_length' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
							),
							'click_shadow_v_length' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
							),
							'click_shadow_blur_radius' => array(
								'type'  => 'slider',
								'value' => 90,
								'properties' => array(
									'min' => 0,
									'max' => 300,
								),
								'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
							),


						)
					)
				),

			)
		),
	)
);
