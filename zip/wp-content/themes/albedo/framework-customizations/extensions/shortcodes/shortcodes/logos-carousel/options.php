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
					'label'         => esc_html__( 'Logos', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Logo', 'albedo' ),
					'desc'          => esc_html__( 'Create logo carousel or logo grid', 'albedo' ),
					'template'      => '{{=title}}',
					'popup-options' => array(
						'title' => array(
							'type'  => 'text',
							'label' => esc_html__('Title (optional)', 'albedo'),
						),
						'image' => array(
							'type'  => 'upload',
							'label' => esc_html__('Upload image', 'albedo'),
							'images_only' => true,
						),
						'image_2x' => array(
							'type'  => 'upload',
							'label' => esc_html__('Upload image for Retina Displays', 'albedo'),
							'desc' => esc_html__('should be twice than original size', 'albedo'),
							'images_only' => true,
						),
						'url' => array(
							'type'  => 'text',
							'label' => esc_html__('URL (optional)', 'albedo')
						),
						'image_width' => array(
							'type'  => 'short-text',
							'label' => esc_html__('Logo width', 'albedo'),
							'desc' => esc_html__('value in pixels', 'albedo'),
						),
						'image_height' => array(
							'type'  => 'short-text',
							'label' => esc_html__('Logo height', 'albedo'),
							'desc' => esc_html__('value in pixels', 'albedo'),
						),
					),
				),
				'hover_opacity_effect' => array(
					'label' => esc_html__( 'Apply hover opacity effect', 'albedo' ),
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
				'element_style' => array(
					'type' => 'multi-picker',
					'show_borders' => false,
					'label' => false,
					'desc' => false,
					'value' => array(
						'style' => 'carousel',
					),
					'picker' => array(
						'style' => array(
							'label' => esc_html__( 'Element style', 'albedo' ),
							'type' => 'select',
							'value' => 'carousel',
							'choices' => array(
								'grid' => esc_html__( 'Grid', 'albedo' ),
								'carousel' => esc_html__( 'Carousel', 'albedo' ),
							),
						)
					),
					'choices' => array(

						'grid' => array(

							'cols' => array(
								'label' => esc_html__( 'Columns', 'albedo' ),
								'type' => 'select',
								'value' => '4',
								'choices' => array(
									'1' => esc_html__('1 Column', 'albedo'),
									'2' => esc_html__('2 Columns', 'albedo'),
									'3' => esc_html__('3 Columns', 'albedo'),
									'4' => esc_html__('4 Columns', 'albedo'),
								),
							),

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

						),
						'carousel' => array(

							'items_big' => array(
								'type'  => 'short-text',
								'value' => '3',
								'label' => esc_html__('Visible items (big screen)', 'albedo')
							),
							'items_medium' => array(
								'type'  => 'short-text',
								'value' => '2',
								'label' => esc_html__('Visible items (medium screen)', 'albedo')
							),
							'items_small' => array(
								'type'  => 'short-text',
								'value' => '1',
								'label' => esc_html__('Visible items (small screen)', 'albedo')
							),

							'effect' => array(
								'label' => esc_html__( 'Carousel Effect', 'albedo' ),
								'type' => 'select',
								'value' => 'slide',
								'choices' => array(
									'slide' => esc_html__( 'Slide', 'albedo' ),
									'fade' => esc_html__( 'Fade', 'albedo' ),
									'cube' => esc_html__( 'Cube', 'albedo' ),
									'coverflow' => esc_html__( 'Coverflow', 'albedo' ),
									'flip' => esc_html__( 'Flip', 'albedo' ),
								),
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
								'value' => 'no',
							),

						)

					)
				),
			)
		),
		'colors' => array(
			'title' => esc_html__( 'Colors', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'pagination_bullets_color' => array(
					'label' => esc_html__('Pagination bullets color', 'albedo'),
					'type' => 'rgba-color-picker',
				),
				'pagination_bullets_hover_color' => array(
					'label' => esc_html__('Pagination active bullet color', 'albedo'),
					'type' => 'rgba-color-picker',
				),

			)
		),
	)

);
