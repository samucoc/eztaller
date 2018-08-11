<?php if (!defined('FW')) die('Forbidden');

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
					'label'         => esc_html__( 'Slides', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Presentation Slides', 'albedo' ),
					'desc'          => esc_html__( 'Create slides', 'albedo' ),
					'template'      => '{{=title}}',
					'size' 					=> 'large',
					'popup-options' => array(

						'content_type' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'value' => array(
								'media_type' => '',
							),
							'picker' => array(
								'media_type' => array(
									'label' => esc_html__( 'Media type', 'albedo' ),
									'type' => 'select',
									'value' => 'white',
									'choices' => array(
										'image' => esc_html__( 'Image', 'albedo' ),
										'video' => esc_html__( 'Video', 'albedo' ),
									),
								)
							),
							'choices' => array(
								'video' => array(

									'video_url'   => array(
										'type'  => 'text',
										'label' => esc_html__('Video URL', 'albedo')
									),

								),
							)
						),

						'img_src' => array(
							'type'  => 'upload',
							'label' => esc_html__('Upload cover', 'albedo'),
							'images_only' => true,
						),

						'title'   => array(
							'type'  => 'text',
							'label' => esc_html__('Title', 'albedo')
						),
						'text' => array(
							'type'  => 'wp-editor',
							'label' => esc_html__('Text', 'albedo'),
							'size' 	=> 'large',
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

									'link' => array(
										'type'  => 'text',
										'label' => esc_html__('Button Link', 'albedo')
									),
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


			)
		),
		'carousel' => array(
			'title' => esc_html__( 'Carousel', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'mousewheel' => array(
					'label' => esc_html__( 'Use Mouse Wheel to scroll slides?', 'albedo' ),
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

				'pagination' => array(
					'label' => esc_html__( 'Pagination', 'albedo' ),
					'type' => 'switch',
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'Disabled', 'albedo' )
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Enabled', 'albedo' )
					),
					'value' => 'yes',
				),
				'autoplay' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Autoplay', 'albedo' ),
							'type' => 'switch',
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'Disabled', 'albedo' )
							),
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Enabled', 'albedo' )
							),
							'value' => 'no',
						)
					),
					'choices' => array(
						'yes' => array(
							'autoplay_speed' => array(
								'type'  => 'text',
								'value' => '2000',
								'label' => esc_html__('Autoplay speed', 'albedo'),
								'desc'  => esc_html__('in milliseconds, e.g.: 2000 = 2 seconds', 'albedo'),
							),
							'autoplay_stop_on_last' => array(
								'label' => esc_html__( 'Stop on last slide', 'albedo' ),
								'desc' => esc_html__( 'Enable this parameter and autoplay will be stopped when it reaches last slide (has no effect in loop mode)', 'albedo' ),
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
							'autoplay_disable_on_interaction' => array(
								'label' => esc_html__( 'Disable autoplay on iteration', 'albedo' ),
								'desc' => esc_html__( 'Set to false and autoplay will not be disabled after user interactions, it will be restarted every time after interaction', 'albedo' ),
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
				'loop' => array(
					'label' => esc_html__( 'Loop slider', 'albedo' ),
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
		),
		'style' => array(
			'title' => esc_html__( 'Style', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'accent_color' => array(
					'label' => esc_html__( 'Accent color', 'albedo' ),
					'type' => 'select',
					'choices' => $wplab_albedo_core->cfg['base_colors'],
				),
				'cover_featured_image' => array(
					'label' => esc_html__( 'Cover featured image', 'albedo' ),
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
				'featured_image_position' => array(
					'label' => esc_html__( 'Featured image position', 'albedo' ),
					'type' => 'select',
					'value' => 'left top',
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
				'background_fixed' => array(
					'label' => esc_html__('Fixed Featured Image', 'albedo'),
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

	)

);
