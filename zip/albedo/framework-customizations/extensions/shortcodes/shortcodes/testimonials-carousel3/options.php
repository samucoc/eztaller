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
					'label'         => esc_html__( 'Testimonials', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Testimonial', 'albedo' ),
					'desc'          => esc_html__( 'Create your testimonials', 'albedo' ),
					'template'      => '{{=text}}',
					'popup-options' => array(
						'text' => array(
							'type'  => 'textarea',
							'label' => esc_html__('Text', 'albedo')
						),
						'photo' => array(
							'type'  => 'upload',
							'label' => esc_html__('Upload photo', 'albedo'),
							'images_only' => true,
						),
						'signature' => array(
							'type'  => 'upload',
							'label' => esc_html__('Upload signature photo', 'albedo'),
							'images_only' => true,
						),
					),
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
			)
		),
		'carousel-settings' => array(
			'title' => esc_html__( 'Carousel Settings', 'albedo' ),
			'type' => 'tab',
			'options' => array(

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
				'pagination_arrows' => array(
					'label' => esc_html__( 'Pagination arrows', 'albedo' ),
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
		),
	)

);
