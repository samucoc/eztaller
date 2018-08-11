<?php

global $wplab_albedo_core;

$options = array(

	array(
		'id' => array( 'type' => 'unique' ),
		'general' => array(
			'title' => esc_html__( 'General', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'column_style' => array(
					'label' => esc_html__( 'Column style', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'' => esc_html__( 'Default', 'albedo' ),
						'boxed' => esc_html__( 'Boxed style', 'albedo' ),
						'boxed_rounded' => esc_html__( 'Boxed style, rounded corners', 'albedo' ),
						'bg-layers bg-layers-pos-top' => esc_html__( 'Layers style (layers on top)', 'albedo' ),
						'bg-layers bg-layers-pos-bottom' => esc_html__( 'Layers style (layers on bottom)', 'albedo' ),
					),
				),
				'animation' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Animate this column', 'albedo' ),
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
		'attributes' => array(
			'title' => esc_html__( 'Attributes', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'section_class' => array(
					'label' => esc_html__('Custom CSS Classes', 'albedo'),
					'type' => 'text',
					'desc' => esc_html__('For example: my-custom-class', 'albedo'),
				),

			)
		),
		'bg_options' => array(
			'title' => esc_html__( 'Background', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'bg_css_type' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'value' => array(
						'type' => 'color',
					),
					'picker' => array(
						'type' => array(
							'label' => esc_html__( 'Background CSS type', 'albedo' ),
							'type' => 'radio',
							'choices' => array(
								'color' => esc_html__( 'Background color', 'albedo' ),
								'gradient' => esc_html__( 'Gradient background', 'albedo' ),
								'custom_gradient' => esc_html__( 'Custom Gradient background', 'albedo' ),
							),
						)
					),
					'choices' => array(
						'custom_gradient' => array(

							'gradient_color' => array(
								'type'  => 'gradient',
								'value' => array(
									'primary'   => '#ffffff',
									'secondary' => '#eeeeee',
								),
								'label' => esc_html__('Gradient colors', 'albedo'),
							),
							'gradient_style' => array(
								'type' => 'multi-picker',
								'label' => false,
								'desc' => false,
								'value' => array(
									'type' => 'linear',
								),
								'picker' => array(
									'type' => array(
										'label' => esc_html__( 'Gradient style', 'albedo' ),
										'type' => 'radio',
										'choices' => array(
											'linear' => esc_html__( 'Linear', 'albedo' ),
											'radial' => esc_html__( 'Radial', 'albedo' ),
										),
									)
								),
								'choices' => array(
									'radial' => array(

										'gradient_position' => array(
											'label' => esc_html__( 'Gradient position', 'albedo' ),
											'type' => 'select',
											'value' => '',
											'choices' => array(
												'left top' => esc_html__( 'Top Left', 'albedo' ),
												'center top' => esc_html__( 'Top Center', 'albedo' ),
												'right top' => esc_html__( 'Top Right', 'albedo' ),
												'left center' => esc_html__( 'Middle Left', 'albedo' ),
												'center' => esc_html__( 'Middle Center', 'albedo' ),
												'right center' => esc_html__( 'Middle Right', 'albedo' ),
												'left bottom' => esc_html__( 'Bottom Left', 'albedo' ),
												'right bottom' => esc_html__( 'Bottom Right', 'albedo' ),
											),
										),
										'gradient_size' => array(
											'label' => esc_html__( 'Gradient size', 'albedo' ),
											'type' => 'select',
											'value' => '',
											'choices' => array(
												'closest-side' => esc_html__( 'Closest Side', 'albedo' ),
												'closest-corner' => esc_html__( 'Closest Corner', 'albedo' ),
												'farthest-side' => esc_html__( 'Farthest side', 'albedo' ),
												'farthest-corner' => esc_html__( 'Farthest corner', 'albedo' ),
											),
										),

									),
									'linear' => array(

										'gradient_position' => array(
											'label' => esc_html__( 'Gradient position', 'albedo' ),
											'type' => 'select',
											'value' => '',
											'choices' => array(
												'top left' => esc_html__( 'To bottom right', 'albedo' ),
												'top' => esc_html__( 'To bottom', 'albedo' ),
												'top right' => esc_html__( 'To bottom left', 'albedo' ),
												'left' => esc_html__( 'To right', 'albedo' ),
												'right' => esc_html__( 'To left', 'albedo' ),
												'bottom left' => esc_html__( 'To top right', 'albedo' ),
												'bottom' => esc_html__( 'To top', 'albedo' ),
												'bottom right' => esc_html__( 'To top left', 'albedo' ),
											),
										),

									)
								)
							),
							'gradient_start' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => 0,
									'max' => 100,
								),
								'label' => esc_html__( 'Gradient start position', 'albedo' ),
							),
							'gradient_end' => array(
								'type'  => 'slider',
								'value' => 100,
								'properties' => array(
									'min' => 0,
									'max' => 100,
								),
								'label' => esc_html__( 'Gradient end position', 'albedo' ),
							),

						),
						'color' => array(

							'background_color' => array(
								'label' => esc_html__('Background Color', 'albedo'),
								'desc' => esc_html__('Select the custom background color', 'albedo'),
								'type' => 'color-picker',
							),

						),
						'gradient' => array(

							'background_gradient' => array(
								'type'  => 'gradient',
								'value' => array(
									'primary'   => '#ffffff',
									'secondary' => '#eeeeee',
								),
								'label' => esc_html__('Gradient background', 'albedo'),
							),
							'background_gradient_direction' => array(
								'label' => esc_html__( 'Gradient direction', 'albedo' ),
								'type' => 'select',
								'value' => '',
								'choices' => array(
									'top_bottom' => esc_html__( 'Linear, From Top to Bottom', 'albedo' ),
									'left_right' => esc_html__( 'Linear, From Left to Right', 'albedo' ),
									'top_left_bottom_right' => esc_html__( 'Linear, From Left Top to Right Bottom', 'albedo' ),
									'bottom_left_top_right' => esc_html__( 'Linear, From Left Bottom to Right Top', 'albedo' ),
									'radial' => esc_html__( 'Radial', 'albedo' ),
								),
							),

						),
					)
				),

				'background_image' => array(
					'label' => esc_html__('Background Image', 'albedo'),
					'desc' => esc_html__('Upload the background image', 'albedo'),
					'type' => 'background-image',
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
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
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
			)
		),
		'col_margins' => array(
			'title' => esc_html__( 'Margins', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'margins' => array(
					'label' => esc_html__( 'Column Margins', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'margins_medium' => array(
					'label' => esc_html__( 'Column Margins (for medium screens)', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'margins_mobile' => array(
					'label' => esc_html__( 'Column Margins (for small screens)', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),

			)
		),

		'col_paddings' => array(
			'title' => esc_html__( 'Paddings', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'paddings' => array(
					'label' => esc_html__( 'Column Paddings', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'paddings_medium' => array(
					'label' => esc_html__( 'Column Paddings (for medium screens)', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'paddings_mobile' => array(
					'label' => esc_html__( 'Column Paddings (for small screens)', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),

			)
		),

	),
	'responsiveness' => array(
		'title' => esc_html__( 'Responsiveness', 'albedo' ),
		'type' => 'tab',
		'options' => array(

			'hide_bg_large_screens' => array(
				'label' => esc_html__('Hide background image at large screens', 'albedo'),
				'desc' => esc_html__('Background-color will be still visible', 'albedo'),
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
			'hide_bg_medium_screens' => array(
				'label' => esc_html__('Hide background image at medium screens', 'albedo'),
				'desc' => esc_html__('Background-color will be still visible', 'albedo'),
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
			'hide_bg_small_screens' => array(
				'label' => esc_html__('Hide background image at small screens', 'albedo'),
				'desc' => esc_html__('Background-color will be still visible', 'albedo'),
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
			'hide_bg_estra_small_screens' => array(
				'label' => esc_html__('Hide background image at extra small screens', 'albedo'),
				'desc' => esc_html__('Background-color will be still visible', 'albedo'),
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
			'hide_lg' => array(
				'label' => esc_html__('Hide Column at Large screens', 'albedo'),
				'desc' => esc_html__('Switch to Yes if you need to hide this column at large desktops (1200px and up)', 'albedo'),
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
			'hide_md' => array(
				'label' => esc_html__('Hide Column at Medium screens', 'albedo'),
				'desc' => esc_html__('Switch to Yes if you need to hide this section at Medium devices (desktops / tablets)', 'albedo'),
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
			'hide_sm' => array(
				'label' => esc_html__('Hide Column at Small screens', 'albedo'),
				'desc' => esc_html__('Switch to Yes if you need to hide this section at Tablets (small screen size)', 'albedo'),
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
			'hide_xs' => array(
				'label' => esc_html__('Hide Column at Extra Small screens', 'albedo'),
				'desc' => esc_html__('Switch to Yes if you need to hide this section at Phones (extra small screen size)', 'albedo'),
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

);
