<?php

global $wplab_albedo_core;

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'general' => array(
			'title' => esc_html__( 'General', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'section_style' => array(
					'label' => esc_html__( 'Section style', 'albedo' ),
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
				'container_stretch' => array(
					'label' => esc_html__( 'Container stretch', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'default' => esc_html__( 'Default', 'albedo' ),
						'stretch_row' => esc_html__( 'Stretch row', 'albedo' ),
						'stretch_row_content' => esc_html__( 'Stretch row and content', 'albedo' ),
						'stretch_row_content_no_paddings' => esc_html__( 'Stretch row and content without grid paddings', 'albedo' ),
						'no_paddings' => esc_html__( 'Disable grid paddings', 'albedo' ),
					),
				),
				'full_height' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Full height', 'albedo' ),
							'desc' => esc_html__('makes section height equal screen height', 'albedo'),
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

							'center_content' => array(
								'label' => esc_html__( 'Center content inside', 'albedo' ),
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
							)

						)
					)
				),
				'animation' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Animate this section', 'albedo' ),
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
				'is_relative' => array(
					'label' => esc_html__('Relative position', 'albedo'),
					'desc' => esc_html__('adds position: relative; CSS property to current section', 'albedo'),
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
				'z_index' => array(
					'label' => esc_html__('Z-index', 'albedo'),
					'desc' => esc_html__('For example: 100. Can be used with relative position option', 'albedo'),
					'type' => 'text',
				),

			)
		),
		'atts' => array(
			'title' => esc_html__( 'Attributes', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'section_id' => array(
					'label' => esc_html__('Anchor (section ID)', 'albedo'),
					'desc' => esc_html__('For example: our-clients', 'albedo'),
					'type' => 'text',
				),

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
							'label' => esc_html__( 'Background type', 'albedo' ),
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
				'custom_background_position' => array(
					'label' => esc_html__( 'Custom background image position', 'albedo' ),
					'desc' => esc_html__( 'here you can put own CSS background image position, e.g.: -5% bottom', 'albedo' ),
					'type' => 'text',
					'value' => '',
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
				'background_fixed' => array(
					'label' => esc_html__('Fixed Background Image', 'albedo'),
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
	'custom_effects' => array(
		'title' => esc_html__( 'Effects', 'albedo' ),
		'type' => 'tab',
		'options' => array(
			'overlay' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'value' => array(
					'effect' => '',
				),
				'picker' => array(
					'effect' => array(
						'label' => esc_html__( 'Section Overlay', 'albedo' ),
						'type' => 'radio',
						'value' => '',
						'choices' => array(
							'' => esc_html__( 'Disabled', 'albedo' ),
							'solid' => esc_html__( 'Solid color / Image', 'albedo' ),
							'gradient' => esc_html__( 'Gradient', 'albedo' ),
						),
					)
				),
				'choices' => array(
					'solid' => array(

						'overlay_color' => array(
							'type'  => 'rgba-color-picker',
							'value' => 'rgba(0,0,0,0.7)',
							'label' => esc_html__('Overlay background color', 'albedo'),
						),
						'overlay_image' => array(
							'label' => esc_html__('Overlay Image', 'albedo'),
							'desc' => esc_html__('Upload the overlay image', 'albedo'),
							'type' => 'background-image',
						),
						'overlay_image_position' => array(
							'label' => esc_html__( 'Overlay image position', 'albedo' ),
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
						'overlay_image_repeat' => array(
							'label' => esc_html__( 'Overlay image repeat', 'albedo' ),
							'type' => 'select',
							'value' => '',
							'choices' => array(
								'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
								'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
								'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
								'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
							),
						),

					),
					'gradient' => array(

						'overlay_gradient_start' => array(
							'type'  => 'rgba-color-picker',
							'value' => 'rgba(0,0,0,1)',
							'label' => esc_html__('Gradient start color', 'albedo'),
						),
						'overlay_gradient_end' => array(
							'type'  => 'rgba-color-picker',
							'value' => 'rgba(255,255,255,0.1)',
							'label' => esc_html__('Gradient end color', 'albedo'),
						),
						'overlay_gradient_direction' => array(
							'label' => esc_html__( 'Gradient direction', 'albedo' ),
							'type' => 'select',
							'value' => 'top_bottom',
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
			'parallax_effects' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'value' => array(
					'effect' => '',
				),
				'picker' => array(
					'effect' => array(
						'label' => esc_html__( 'Parallax Effects', 'albedo' ),
						'type' => 'radio',
						'choices' => array(
							'' => esc_html__( 'No Parallax', 'albedo' ),
							'parallax' => esc_html__( 'Parallax background', 'albedo' ),
							'mouse_parallax' => esc_html__( 'Mouse Move Parallax background', 'albedo' ),
							'scroll_animation' => esc_html__( 'Scroll animation', 'albedo' ),
						),
					)
				),
				'choices' => array(
					'parallax' => array(

						'parallax_speed' => array(
							'label' => esc_html__('Parallax speed', 'albedo'),
							'desc' => esc_html__('Set a speed of parallax effect, e.g.: 1.5. Do not forget to assign some background image for this section.', 'albedo'),
							'type' => 'text',
							'value' => '1.5'
						),

					),
					'mouse_parallax' => array(

						'invert_x' => array(
							'label' => esc_html__( 'Invert X', 'albedo' ),
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
						'invert_y' => array(
							'label' => esc_html__( 'Invert Y', 'albedo' ),
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
						'depth' => array(
							'label' => esc_html__('Depth', 'albedo'),
							'type' => 'short-text',
							'value' => '0.2',
						),
						'limit_x' => array(
							'label' => esc_html__('Limit X', 'albedo'),
							'type' => 'short-text',
							'value' => '10',
						),
						'limit_y' => array(
							'label' => esc_html__('Limit Y', 'albedo'),
							'type' => 'short-text',
							'value' => '10',
						),
						'scalar_x' => array(
							'label' => esc_html__('Scalar X', 'albedo'),
							'type' => 'short-text',
							'value' => '0',
						),
						'scalar_y' => array(
							'label' => esc_html__('Scalar Y', 'albedo'),
							'type' => 'short-text',
							'value' => '0',
						),
						'friction_x' => array(
							'label' => esc_html__('Friction X', 'albedo'),
							'type' => 'short-text',
							'value' => '0',
						),
						'friction_y' => array(
							'label' => esc_html__('Friction Y', 'albedo'),
							'type' => 'short-text',
							'value' => '0',
						),
						'origin_x' => array(
							'label' => esc_html__('Origin X', 'albedo'),
							'type' => 'short-text',
							'value' => '0',
						),
						'origin_y' => array(
							'label' => esc_html__('Origin Y', 'albedo'),
							'type' => 'short-text',
							'value' => '0',
						),

					),
					'scroll_animation' => array(

						'start_css' => array(
							'label' => esc_html__('CSS code for start position', 'albedo'),
							'desc' => esc_html__('For example: background-position: 0% -100%;', 'albedo'),
							'type' => 'textarea',
						),
						'end_pos' => array(
							'label' => esc_html__('End position in pixels', 'albedo'),
							'desc' => esc_html__('For example: 500', 'albedo'),
							'type' => 'text',
						),
						'end_css' => array(
							'label' => esc_html__('CSS code for end position', 'albedo'),
							'desc' => esc_html__('For example: background-position: 0% 70%;', 'albedo'),
							'type' => 'textarea',
						),

					),
				)
			),
			'section_effects' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'value' => array(
					'effect' => '',
				),
				'picker' => array(
					'effect' => array(
						'label' => esc_html__( 'Section Effects', 'albedo' ),
						'type' => 'radio',
						'choices' => array(
							'' => esc_html__( 'No Effects', 'albedo' ),
							'video' => esc_html__( 'YouTube Video Background', 'albedo' ),
							'infinite_motion' => esc_html__( 'Infinite Background Motion', 'albedo' ),
							'particleground' => esc_html__( 'Particle Groud Effect', 'albedo' ),
							'particles' => esc_html__( 'Particles Effect', 'albedo' ),
						),
					)
				),
				'choices' => array(

					'particleground' => array(

						'dot_color' => array(
							'label' => esc_html__('Dots Color', 'albedo'),
							'type' => 'color-picker',
							'value' => '#fafafa',
						),
						'line_color' => array(
							'label' => esc_html__('Lines Color', 'albedo'),
							'type' => 'color-picker',
							'value' => '#fcfcfc',
						),
						'particle_radius' => array(
							'label' => esc_html__('Dot size', 'albedo'),
							'type' => 'short-text',
							'value' => '7'
						),
						'line_width' => array(
							'label' => esc_html__('Line width', 'albedo'),
							'type' => 'short-text',
							'value' => '1'
						),
						'curved_lines' => array(
							'label' => esc_html__( 'Curved lines', 'albedo' ),
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
						'parallax' => array(
							'label' => esc_html__( 'Parallax effect', 'albedo' ),
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
							'value' => 'yes',
						),
						'parallax_multiplier' => array(
							'label' => esc_html__('Parallax Multiplier', 'albedo'),
							'desc' => esc_html__( 'The lower the number, the more extreme the parallax effect wil be.', 'albedo'),
							'type' => 'short-text',
							'value' => '5'
						),
						'proximity' => array(
							'label' => esc_html__('Proximity', 'albedo'),
							'desc' => esc_html__( 'How close two dots need to be, in pixels, before they join.', 'albedo'),
							'type' => 'short-text',
							'value' => '100'
						),
						'min_speed_x' => array(
							'label' => esc_html__('Minimum speed X', 'albedo'),
							'type' => 'short-text',
							'value' => '0.1'
						),
						'max_speed_x' => array(
							'label' => esc_html__('Maximum speed X', 'albedo'),
							'type' => 'short-text',
							'value' => '0.7'
						),
						'min_speed_y' => array(
							'label' => esc_html__('Minimum speed Y', 'albedo'),
							'type' => 'short-text',
							'value' => '0.1'
						),
						'max_speed_y' => array(
							'label' => esc_html__('Maximum speed Y', 'albedo'),
							'type' => 'short-text',
							'value' => '0.7'
						),
						'direction_x' => array(
							'label' => esc_html__( 'Direction X', 'albedo' ),
							'desc' => esc_html__( 'Means that the dots will bounce off the edges of the canvas', 'albedo'),
							'type' => 'select',
							'value' => 'center',
							'choices' => array(
								'center' => esc_html__( 'Center', 'albedo' ),
								'left' => esc_html__( 'Left', 'albedo' ),
								'right' => esc_html__( 'Right', 'albedo' ),
							),
						),
						'direction_y' => array(
							'label' => esc_html__( 'Direction Y', 'albedo' ),
							'desc' => esc_html__( 'Means that the dots will bounce off the edges of the canvas', 'albedo'),
							'type' => 'select',
							'value' => 'center',
							'choices' => array(
								'center' => esc_html__( 'Center', 'albedo' ),
								'left' => esc_html__( 'Left', 'albedo' ),
								'right' => esc_html__( 'Right', 'albedo' ),
							),
						),
						'destiny' => array(
							'label' => esc_html__('Destiny', 'albedo'),
							'desc' => esc_html__( 'Determines how many particles will be generated: one particle every n pixels.', 'albedo'),
							'type' => 'short-text',
							'value' => '1000'
						),
					),
					'particles' => array(
						'number' => array(
							'label' => esc_html__('Particles number', 'albedo'),
							'type' => 'short-text',
							'value' => 80
						),
						'density' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Enable density', 'albedo' ),
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

									'density_value' => array(
										'label' => esc_html__('Density value', 'albedo'),
										'type' => 'short-text',
										'value' => 800
									),

								)
							)
						),
						'color' => array(
							'label' => esc_html__('Particles color', 'albedo'),
							'type' => 'color-picker',
							'value' => '#ffffff',
						),
						'shape_type' => array(
							'label' => esc_html__( 'Shape type', 'albedo' ),
							'type' => 'select',
							'value' => 'circle',
							'choices' => array(
								'circle' => esc_html__( 'Circle', 'albedo' ),
								'edge' => esc_html__( 'Edge', 'albedo' ),
								'triangle' => esc_html__( 'Triangle', 'albedo' ),
								'polygon' => esc_html__( 'Polygon', 'albedo' ),
								'star' => esc_html__( 'Star', 'albedo' ),
							),
						),
						'stroke_width' => array(
							'label' => esc_html__('Shape stroke width', 'albedo'),
							'type' => 'short-text',
							'value' => 0
						),
						'stroke_color' => array(
							'label' => esc_html__('Shape stroke color', 'albedo'),
							'type' => 'color-picker',
							'value' => '#ffffff',
						),
						'polygon_sides' => array(
							'label' => esc_html__('Polygon sides', 'albedo'),
							'type' => 'short-text',
							'value' => 5,
						),
						'opacity' => array(
							'label' => esc_html__('Opacity', 'albedo'),
							'type' => 'short-text',
							'value' => 0.8
						),
						'opacity_rand' => array(
							'label' => esc_html__( 'Opacity random', 'albedo' ),
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
							'value' => 'yes',
						),
						'animate_opacity' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Animate opacity', 'albedo' ),
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
								)
							),
							'choices' => array(
								'yes' => array(

									'speed' => array(
										'label' => esc_html__('Animate speed', 'albedo'),
										'type' => 'short-text',
										'value' => 32
									),
									'size_min' => array(
										'label' => esc_html__('Opacity min', 'albedo'),
										'type' => 'short-text',
										'value' => 0.1
									),
									'sync' => array(
										'label' => esc_html__( 'Sync animation', 'albedo' ),
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
										'value' => 'yes',
									),

								)
							)
						),
						'size' => array(
							'label' => esc_html__('Size', 'albedo'),
							'type' => 'short-text',
							'value' => 10
						),
						'size_rand' => array(
							'label' => esc_html__( 'Random size', 'albedo' ),
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
							'value' => 'yes',
						),
						'animate_size' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Animate size', 'albedo' ),
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

									'speed' => array(
										'label' => esc_html__('Animate size speed', 'albedo'),
										'type' => 'short-text',
										'value' => 32
									),
									'size_min' => array(
										'label' => esc_html__('Animate min size', 'albedo'),
										'type' => 'short-text',
										'value' => 5
									),
									'sync' => array(
										'label' => esc_html__( 'Sync size animation', 'albedo' ),
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
										'value' => 'yes',
									),

								)
							)
						),
						'lines' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Enable linked lines', 'albedo' ),
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

									'distance' => array(
										'label' => esc_html__('Distance', 'albedo'),
										'type' => 'short-text',
										'value' => 150
									),
									'color' => array(
										'label' => esc_html__('Color', 'albedo'),
										'type' => 'color-picker',
										'value' => '#ffffff',
									),
									'opacity' => array(
										'label' => esc_html__('Opacity', 'albedo'),
										'type' => 'short-text',
										'value' => 0.5
									),
									'width' => array(
										'label' => esc_html__('Width', 'albedo'),
										'type' => 'short-text',
										'value' => 1.4
									),

								)
							)
						),
						'move' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Enable move', 'albedo' ),
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
								)
							),
							'choices' => array(
								'yes' => array(

									'direction' => array(
										'label' => esc_html__( 'Move direction', 'albedo' ),
										'type' => 'select',
										'value' => 'none',
										'choices' => array(
											'none' => esc_html__( 'None', 'albedo' ),
											'top' => esc_html__( 'Top', 'albedo' ),
											'top-right' => esc_html__( 'Top right', 'albedo' ),
											'right' => esc_html__( 'Right', 'albedo' ),
											'bottom-right' => esc_html__( 'Bottom Right', 'albedo' ),
											'bottom' => esc_html__( 'Bottom', 'albedo' ),
											'bottom-left' => esc_html__( 'Bottom Left', 'albedo' ),
											'left' => esc_html__( 'Left', 'albedo' ),
											'top-left' => esc_html__( 'Top Left', 'albedo' ),
										),
									),
									'rand' => array(
										'label' => esc_html__( 'Random', 'albedo' ),
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
										'value' => 'yes',
									),
									'straight' => array(
										'label' => esc_html__( 'Straight', 'albedo' ),
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
										'value' => 'yes',
									),
									'speed' => array(
										'label' => esc_html__('Speed', 'albedo'),
										'type' => 'short-text',
										'value' => 8
									),
									'out_mode' => array(
										'label' => esc_html__( 'Out mode', 'albedo' ),
										'type' => 'select',
										'value' => 'none',
										'choices' => array(
											'none' => esc_html__( 'Out', 'albedo' ),
											'bounce' => esc_html__( 'Bounce', 'albedo' ),
										),
									),

								)
							)
						),
						'onhover' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Enable hover effect', 'albedo' ),
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
								)
							),
							'choices' => array(
								'yes' => array(

									'mode' => array(
										'label' => esc_html__( 'Hover mode', 'albedo' ),
										'type' => 'select',
										'value' => 'grab',
										'choices' => array(
											'grab' => esc_html__( 'Grab', 'albedo' ),
											'bubble' => esc_html__( 'Bubble', 'albedo' ),
											'repulse' => esc_html__( 'Repulse', 'albedo' ),
										),
									),

								)
							)
						),
						'onclick' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Enable click effect', 'albedo' ),
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
								)
							),
							'choices' => array(
								'yes' => array(

									'mode' => array(
										'label' => esc_html__( 'Click mode', 'albedo' ),
										'type' => 'select',
										'value' => 'grab',
										'choices' => array(
											'push' => esc_html__( 'Push', 'albedo' ),
											'remove' => esc_html__( 'Remove', 'albedo' ),
											'bubble' => esc_html__( 'Bubble', 'albedo' ),
											'repulse' => esc_html__( 'Repulse', 'albedo' ),
										),
									),

								)
							)
						),
						'grab_distance' => array(
							'label' => esc_html__('Grab distance', 'albedo'),
							'type' => 'short-text',
							'value' => 400
						),
						'grab_opacity' => array(
							'label' => esc_html__('Grab opacity', 'albedo'),
							'type' => 'short-text',
							'value' => 0.5
						),
						'bubble_distance' => array(
							'label' => esc_html__('Bubble distance', 'albedo'),
							'type' => 'short-text',
							'value' => 400
						),
						'bubble_size' => array(
							'label' => esc_html__('Bubble size', 'albedo'),
							'type' => 'short-text',
							'value' => 4
						),
						'bubble_duration' => array(
							'label' => esc_html__('Bubble duration', 'albedo'),
							'type' => 'short-text',
							'value' => 0.3
						),
						'bubble_opacity' => array(
							'label' => esc_html__('Bubble opacity', 'albedo'),
							'type' => 'short-text',
							'value' => 1
						),
						'bubble_speed' => array(
							'label' => esc_html__('Bubble speed', 'albedo'),
							'type' => 'short-text',
							'value' => 3
						),
						'repulse_distance' => array(
							'label' => esc_html__('Repulse distance', 'albedo'),
							'type' => 'short-text',
							'value' => 200
						),
						'repulse_duration' => array(
							'label' => esc_html__('Repulse duration', 'albedo'),
							'type' => 'short-text',
							'value' => 0.4
						),

					),
					'infinite_motion' => array(

						'infinite_motion_speed' => array(
							'label' => esc_html__('Animation speed', 'albedo'),
							'desc' => esc_html__('Set a speed of motion effect in seconds, e.g.: 10', 'albedo'),
							'type' => 'text',
							'value' => '10'
						),
						'infinite_motion_bg_width' => array(
							'label' => esc_html__('Texture width', 'albedo'),
							'desc' => esc_html__('Specify background image width to avoid twitching, e.g.: 10', 'albedo'),
							'type' => 'text',
							'value' => '500'
						),
						'infinite_motion_direction' => array(
							'label' => esc_html__('Motion direction', 'albedo'),
							'type' => 'switch',
							'right-choice' => array(
								'value' => 'left',
								'label' => esc_html__( 'From right to left', 'albedo' )
							),
							'left-choice' => array(
								'value' => 'right',
								'label' => esc_html__( 'From left to right', 'albedo' )
							),
							'value' => 'right',
						),

					),
					'video' => array(

						'video' => array(
							'label' => esc_html__('Video URL', 'albedo'),
							'desc' => esc_html__('Insert YouTube Video URL to embed this video as background', 'albedo'),
							'type' => 'text',
						),
						'video_fallback_image' => array(
							'label' => esc_html__( 'Fallback image for mobile devices', 'albedo' ),
							'desc' => esc_html__( 'The path to the fallback image in case of background video on mobile devices', 'albedo' ),
							'type' => 'upload',
						),
						'video_mute' => array(
							'label' => esc_html__('Mute video', 'albedo'),
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
						'video_parallax_speed' => array(
							'label' => esc_html__('Video parallax speed', 'albedo'),
							'desc' => esc_html__('Example: 0.2 Leave it empty to disable parallax', 'albedo'),
							'type' => 'short-text',
							'value' => ''
						),

					),
				)
			),
		)
	),
		'styling' => array(
			'title' => esc_html__( 'Styling', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'border_color' => array(
					'label' => esc_html__('Border Color', 'albedo'),
					'type' => 'color-picker',
				),
				'border_style' => array(
					'label' => esc_html__( 'Border Style', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'none' => esc_html__( 'None', 'albedo' ),
						'hidden' => esc_html__( 'Hidden', 'albedo' ),
						'dotted' => esc_html__( 'Dotted', 'albedo' ),
						'dashed' => esc_html__( 'Dashed', 'albedo' ),
						'solid' => esc_html__( 'Solid', 'albedo' ),
						'double' => esc_html__( 'Double', 'albedo' ),
						'groove' => esc_html__( 'Groove', 'albedo' ),
						'ridge' => esc_html__( 'Ridge', 'albedo' ),
					),
				),
				'border_width' => array(
					'label' => esc_html__( 'Border width', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'border_radius' => array(
					'label' => esc_html__( 'Border radius', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top left, top right, bottom right, bottom left', 'albedo' ),
				),

				'css_shadow' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Add CSS box shadow', 'albedo' ),
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

							'shadow_color' => array(
								'label' => esc_html__('Shadow Color', 'albedo'),
								'type' => 'color-picker',
							),
							'shadow_type' => array(
								'label' => esc_html__( 'Position', 'albedo' ),
								'type' => 'switch',
								'right-choice' => array(
									'value' => 'outside',
									'label' => esc_html__( 'Outside', 'albedo' )
								),
								'left-choice' => array(
									'value' => 'inside',
									'label' => esc_html__( 'Inside', 'albedo' )
								),
								'value' => 'outside',
							),
							'shadow_blur_radius' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => 0,
									'max' => 300,
								),
								'label' => esc_html__( 'Blur Radius', 'albedo' ),
							),
							'shadow_spread_radius' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Spread Radius', 'albedo' ),
							),
							'shadow_horizontal_length' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Horizontal Length', 'albedo' ),
							),
							'shadow_vertical_length' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Vertical Length', 'albedo' ),
							),

						),
					)
				),

			)
		),

	),
	'custom_margins' => array(
		'title' => esc_html__( 'Margins', 'albedo' ),
		'type' => 'tab',
		'options' => array(

			'margins' => array(
				'label' => esc_html__( 'Section Margins', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),
			'margins_medium' => array(
				'label' => esc_html__( 'Section Margins (for medium screens)', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),
			'margins_mobile' => array(
				'label' => esc_html__( 'Section Margins (for small screens)', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),

		)
	),
	'custom_paddings' => array(
		'title' => esc_html__( 'Paddings', 'albedo' ),
		'type' => 'tab',
		'options' => array(

			'paddings' => array(
				'label' => esc_html__( 'Section Paddings', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),
			'paddings_medium' => array(
				'label' => esc_html__( 'Section Paddings (for medium screens)', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),
			'paddings_mobile' => array(
				'label' => esc_html__( 'Section Paddings (for small screens)', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),

		)
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
				'label' => esc_html__('Hide section at Large screens', 'albedo'),
				'desc' => esc_html__('Switch to Yes if you need to hide this section at large desktops (1200px and up)', 'albedo'),
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
				'label' => esc_html__('Hide section at Medium Screens', 'albedo'),
				'desc' => esc_html__('Switch to Yes if you need to hide this section at Medium screens (e.g. tablets in landscape mode)', 'albedo'),
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
				'label' => esc_html__('Hide section at Small screens', 'albedo'),
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
				'label' => esc_html__('Hide section at Extra Small screens', 'albedo'),
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
