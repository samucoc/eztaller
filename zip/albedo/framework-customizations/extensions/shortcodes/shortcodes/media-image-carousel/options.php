<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$options = array(

	array(
		'id' => array( 'type' => 'unique' ),
		'general' => array(
			'title' => esc_html__( 'General', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'images' => array(
					'label' => esc_html__( 'Choose images', 'albedo' ),
					'type' => 'multi-upload',
					'desc' => esc_html__( 'Select or upload several images to create gallery', 'albedo' ),
					'images_only' => true
				),


			)
		),
		'carousel' => array(
			'title' => esc_html__( 'Carousel', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'image_width' => array(
					'label' => esc_html__( 'Images width', 'albedo' ),
					'type' => 'short-text',
					'value' => ''
				),
				'image_height' => array(
					'label' => esc_html__( 'Images height', 'albedo' ),
					'type' => 'short-text',
					'value' => ''
				),
				'effect' => array(
					'label' => esc_html__( 'Carousel Effect', 'albedo' ),
					'desc' => esc_html__( 'Fade / Cube / Coverflow / Flip effects work only for single image sliders', 'albedo' ),
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
				'display_caption' => array(
					'label' => esc_html__( 'Display image caption', 'albedo' ),
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
		'responsive-settings' => array(
			'title' => esc_html__( 'Responsive Settings', 'albedo' ),
			'type' => 'tab',
			'options' => array(

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

			)
		),
		'style' => array(
			'title' => esc_html__( 'Style', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'hover_effects' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Add hover effect?', 'albedo' ),
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
								'label' => esc_html__( 'Image Effect', 'albedo' ),
								'type' => 'select',
								'value' => 'lily',
								'choices' => $wplab_albedo_core->cfg['overlay_effects'],
							),

						)
					),
				),
				'border_radius' => array(
					'type'  => 'short-text',
					'label' => esc_html__('Border radius for images', 'albedo'),
					'desc' => esc_html__('value in pixels, e.g.: 20. This option may not work if you are using hover effects', 'albedo'),
					'value'  => '',
				),

			)
		),

	)

);
