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
				'text' => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Quote text', 'albedo')
				),
				'author' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Author', 'albedo')
				),
				'position' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Position', 'albedo')
				),
				'photo' => array(
					'type'  => 'upload',
					'label' => esc_html__( 'Background photo', 'albedo'),
					'images_only' => true,
				),
				'signature' => array(
					'type'  => 'upload',
					'label' => esc_html__( 'Signature photo', 'albedo'),
					'images_only' => true,
				),
				'style' => array(
					'label' => esc_html__( 'Element style', 'albedo' ),
					'type' => 'select',
					'value' => 'default',
					'choices' => array(
						'white' => esc_html__( 'White, dark text', 'albedo' ),
						'dark' => esc_html__( 'Dark, white text', 'albedo' ),
					),
				),
			)
		),
		'styling' => array(
			'title' => esc_html__( 'Styling', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'paddings' => array(
					'label' => esc_html__( 'Quote Paddings', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'paddings_medium' => array(
					'label' => esc_html__( 'Quote Paddings (for medium screens)', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'paddings_mobile' => array(
					'label' => esc_html__( 'Quote Paddings (for small screens)', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
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
				'background_position' => array(
					'label' => esc_html__( 'Background image position', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'left top' => esc_html__( 'Left Top', 'albedo' ),
						'center top' => esc_html__( 'Center Top', 'albedo' ),
						'right top' => esc_html__( 'Right Top', 'albedo' ),
						'left bottom' => esc_html__( 'Left Bottom', 'albedo' ),
						'center bottom' => esc_html__( 'Center Bottom', 'albedo' ),
						'right bottom' => esc_html__( 'Right Bottom', 'albedo' ),
						'left center' => esc_html__( 'Left Center', 'albedo' ),
						'center center' => esc_html__( 'Center Center', 'albedo' ),
						'right center' => esc_html__( 'Right Center', 'albedo' ),
					),
				),
				'background_repeat' => array(
					'label' => esc_html__( 'Background image repeat', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
						'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
						'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
						'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
					),
				),
				'background_lazy' => array(
					'label' => esc_html__('Lazy Load Background Image', 'albedo'),
					'desc' => esc_html__('If enabled, background image will be loaded through JavaScript after text content', 'albedo'),
					'type' => 'switch',
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'label' => esc_html__( 'No', 'albedo' ),
						'color' => '#ccc',
					),
					'value' => 'no',
				),
				'background_cover' => array(
					'label' => esc_html__('Cover Background Image', 'albedo'),
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
		'animations' => array(
			'title' => esc_html__( 'Animations', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'text_animation_effect' => array(
					'label' => esc_html__( 'Text animation effect', 'albedo' ),
					'type' => 'select',
					'value' => 'fadeInUp',
					'choices' => array(
						array (
							'attr' => array(
								'label' => esc_html__( 'Animate.css Library', 'albedo' ),
							),
							'choices' => $wplab_albedo_core->cfg['animations'],
						),
					),
				),

				'text_animation_delay' => array(
					'label' => esc_html__('Text animation delay', 'albedo'),
					'desc' => esc_html__('For example: 0.3s', 'albedo'),
					'type' => 'text',
					'value' => '0.1s',
				),

				'sign_animation_effect' => array(
					'label' => esc_html__( 'Signature animation effect', 'albedo' ),
					'type' => 'select',
					'value' => 'fadeIn',
					'choices' => array(
						array (
							'attr' => array(
								'label' => esc_html__( 'Animate.css Library', 'albedo' ),
							),
							'choices' => $wplab_albedo_core->cfg['animations'],
						),
					),
				),

				'sign_animation_delay' => array(
					'label' => esc_html__('Signature animation delay', 'albedo'),
					'desc' => esc_html__('For example: 0.3s', 'albedo'),
					'type' => 'text',
					'value' => '0.2s',
				),

				'author_animation_effect' => array(
					'label' => esc_html__( 'Author animation effect', 'albedo' ),
					'type' => 'select',
					'value' => 'fadeInDown',
					'choices' => array(
						array (
							'attr' => array(
								'label' => esc_html__( 'Animate.css Library', 'albedo' ),
							),
							'choices' => $wplab_albedo_core->cfg['animations'],
						),
					),
				),

				'author_animation_delay' => array(
					'label' => esc_html__('Author animation delay', 'albedo'),
					'desc' => esc_html__('For example: 0.3s', 'albedo'),
					'type' => 'text',
					'value' => '0.3s',
				),

				'position_animation_effect' => array(
					'label' => esc_html__( 'Position animation effect', 'albedo' ),
					'type' => 'select',
					'value' => 'fadeInDown',
					'choices' => array(
						array (
							'attr' => array(
								'label' => esc_html__( 'Animate.css Library', 'albedo' ),
							),
							'choices' => $wplab_albedo_core->cfg['animations'],
						),
					),
				),

				'position_animation_delay' => array(
					'label' => esc_html__('Position animation delay', 'albedo'),
					'desc' => esc_html__('For example: 0.3s', 'albedo'),
					'type' => 'text',
					'value' => '0.4s',
				),

			)
		),
	)

);
