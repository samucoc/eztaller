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
					'label'         => esc_html__( 'Videos', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Videos', 'albedo' ),
					'desc'          => esc_html__( 'Create video carousel', 'albedo' ),
					'template'      => '{{=title}}',
					'popup-options' => array(
						'title' => array(
							'type'  => 'text',
							'label' => esc_html__('Title', 'albedo')
						),
						'url' => array(
							'type'  => 'text',
							'label' => esc_html__('Video URL', 'albedo'),
							'desc' => esc_html__('YouTube / Vimeo videos are supported', 'albedo'),
						),
						'cover' => array(
							'label' => esc_html__('Cover Image', 'albedo'),
							'desc' => esc_html__('Upload the cover image', 'albedo'),
							'type' => 'background-image',
						),
					),
				),
				'init_slide' => array(
					'label' => esc_html__( 'Initial Slide', 'albedo' ),
					'type' => 'short-text',
					'value' => 1
				),
				'image_width' => array(
					'label' => esc_html__( 'Thumbnail width', 'albedo' ),
					'type' => 'short-text',
					'value' => 760
				),
				'image_height' => array(
					'label' => esc_html__( 'Thumbnail height', 'albedo' ),
					'type' => 'short-text',
					'value' => 460
				),
			)
		),
		'carousel-settings' => array(
			'title' => esc_html__( 'Carousel Settings', 'albedo' ),
			'type' => 'tab',
			'options' => array(

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

			)
		),
	)

);
