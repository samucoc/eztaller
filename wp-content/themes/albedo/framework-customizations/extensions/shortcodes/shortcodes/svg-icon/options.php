<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'attributes' => array(
			'title' => esc_html__( 'Icon', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'icon' => array(
					'type'  => 'upload',
					'label' => esc_html__( 'Choose SVG Icon', 'albedo' ),
					'desc'  => esc_html__( 'Either upload a new, or choose an existing icon from your media library', 'albedo' )
				),
				'size' => array(
					'type'    => 'group',
					'options' => array(
						'width'  => array(
							'type'  => 'text',
							'label' => esc_html__( 'Width', 'albedo' ),
							'desc'  => esc_html__( 'Set icon width', 'albedo' ),
							'value' => 70
						),
						'height' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Height', 'albedo' ),
							'desc'  => esc_html__( 'Set icon height', 'albedo' ),
							'value' => 70
						)
					)
				),
				'skip_section' => array(
					'label' => esc_html__( 'Skip current section to next on click', 'albedo' ),
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
				'link' => array(
					'label' => esc_html__('Link', 'albedo'),
					'type' => 'text',
				),
				'is_lightbox' => array(
					'label' => esc_html__( 'Open link in lightbox', 'albedo' ),
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

			)
		),
		'styling' => array(
			'title' => esc_html__( 'Styling', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'color' => array(
					'label' => esc_html__('Icon Color', 'albedo'),
					'desc' => esc_html__('Select the custom icon color', 'albedo'),
					'type' => 'color-picker',
				),

				'icon_align' => array(
					'label' => esc_html__( 'Icon Align', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'' => esc_html__( 'Default', 'albedo' ),
						'alignleft' => esc_html__( 'Left', 'albedo' ),
						'aligncenter' => esc_html__( 'Center', 'albedo' ),
						'alignright' => esc_html__( 'Right', 'albedo' ),
					),
				),
				'animation' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Animate icon', 'albedo' ),
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
				'margins' => array(
					'label' => esc_html__( 'Icon Margins', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),

			)
		)
	)
);
