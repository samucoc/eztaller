<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(

	array(
		'id' => array( 'type' => 'unique' ),
		'attributes' => array(
			'title' => esc_html__( 'Header Attributes', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'title'    => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Heading Title', 'albedo' ),
					'desc'  => esc_html__( 'Write the heading title content', 'albedo' ),
					'help'  => esc_html__( 'You can use color tags to display text with different colors, e.g.: This text becomes [color-green]green[/color-green]', 'albedo' ),
				),
				'heading' => array(
					'type'    => 'select',
					'label'   => esc_html__('Heading Size', 'albedo'),
					'choices' => array(
						'h1' => 'H1',
						'h2' => 'H2',
						'h3' => 'H3',
						'h4' => 'H4',
						'h5' => 'H5',
						'h6' => 'H6',
					)
				),
				'disable_br' => array(
					'label' => esc_html__( 'Hide line breaks on mobiles', 'albedo' ),
					'desc' => esc_html__('This option hides BR tag inside header on mobiles', 'albedo'),
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
				'custom_classes' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Custom CSS classes', 'albedo' ),
					'desc'  => esc_html__( 'Type here your own custom CSS classes', 'albedo' ),
				),

			)
		),
		'styling' => array(
			'title' => esc_html__( 'Styling', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'header_color' => array(
					'label' => esc_html__('Header text color', 'albedo'),
					'type' => 'color-picker',
				),
				'text_align' => array(
					'type'    => 'select',
					'label'   => esc_html__('Text Align', 'albedo'),
					'value'		=> '',
					'choices' => array(
						'' => esc_html__('- Default -', 'albedo'),
						'left' => esc_html__('Left', 'albedo'),
						'center' => esc_html__('Center', 'albedo'),
						'right' => esc_html__('Right', 'albedo'),
					),
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
						'lighter' => esc_html__('Light', 'albedo'),
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
				'font_size' => array(
					'label' => esc_html__('Font size', 'albedo'),
					'type' => 'text',
					'desc' => esc_html__('In pixels, for example: 18', 'albedo'),
				),
				'line_height' => array(
					'label' => esc_html__('Line height', 'albedo'),
					'type' => 'text',
					'desc' => esc_html__('In pixels, for example: 24', 'albedo'),
				),
				'font_size_mobile' => array(
					'label' => esc_html__('Font size (mobile devices)', 'albedo'),
					'type' => 'text',
					'desc' => esc_html__('In pixels, for example: 18', 'albedo'),
				),
				'line_height_mobile' => array(
					'label' => esc_html__('Line height (mobile devices)', 'albedo'),
					'type' => 'text',
					'desc' => esc_html__('In pixels, for example: 24', 'albedo'),
				),
				'letter_spacing' => array(
					'label' => esc_html__('Letter spacing', 'albedo'),
					'type' => 'text',
					'desc' => esc_html__('In pixels, for example: 1', 'albedo'),
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
				'margins' => array(
					'label' => esc_html__( 'Header Margins', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'paddings' => array(
					'label' => esc_html__( 'Header Paddings', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'custom_css' => array(
					'label' => esc_html__('Custom CSS code', 'albedo'),
					'type' => 'textarea',
					'desc' => esc_html__('this code will be applied only for current element', 'albedo'),
				),

			),
		),
		'animation-settings' => array(
			'title' => esc_html__( 'Animation', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'animation' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'CSS Animation', 'albedo' ),
							'desc' => esc_html__('Using CSS animation', 'albedo'),
							'type' => 'switch',
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Enabled', 'albedo' )
							),
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'Disabled', 'albedo' )
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
				'typed_animation' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Typed Animation', 'albedo' ),
							'type' => 'switch',
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Enabled', 'albedo' )
							),
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'Disabled', 'albedo' )
							),
							'value' => 'no',
						)
					),
					'choices' => array(
						'yes' => array(

							'delay' => array(
								'label' => esc_html__('Animation delay', 'albedo'),
								'value' => '150',
								'type' => 'text',
							),
							'speed' => array(
								'label' => esc_html__('Animation speed delay', 'albedo'),
								'value' => '100',
								'type' => 'text',
							),

						)
					)
				),

			)
		),
	),
);
