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
					'label'         => esc_html__( 'Benefits', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Benefits', 'albedo' ),
					'desc'          => esc_html__( 'Create your benefits', 'albedo' ),
					'template'      => '{{=title}}',
					'popup-options' => array(
						'title' => array(
							'type'  => 'text',
							'label' => esc_html__('Title', 'albedo')
						),
						'text' => array(
							'type'  => 'textarea',
							'label' => esc_html__('Text', 'albedo')
						),
						'link' => array(
							'type'  => 'text',
							'label' => esc_html__('Link (optional)', 'albedo')
						),
						'icon_type' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'value' => array(
								'benefit_icon' => '',
							),
							'picker' => array(
								'benefit_icon' => array(
									'label' => esc_html__( 'Benefit icon', 'albedo' ),
									'type' => 'radio',
									'choices' => array(
										'' => esc_html__( 'Without Icon', 'albedo' ),
										'fontawesome' => esc_html__( 'Choose an icon from Icon Library', 'albedo' ),
										'custom' => esc_html__( 'Upload custom Image icon', 'albedo' ),
									),
								)
							),
							'choices' => array(
								'fontawesome' => array(

									'icon' => array(
										'type' => 'icon',
										'label' => esc_html__( 'Icon', 'albedo' )
									),

								),
								'custom' => array(

									'icon' => array(
										'type'  => 'upload',
										'label' => esc_html__('Upload icon file', 'albedo'),
										'images_only' => true,
									),

								),
							)
						),
					),
				),
				'link_target' => array(
					'label' => esc_html__( 'Open links at new tab', 'albedo' ),
					'type' => 'switch',
					'left-choice' => array(
						'value' => '_self',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'right-choice' => array(
						'value' => '_blank',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'value' => '_self',
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
		'responsive-settings' => array(
			'title' => esc_html__( 'Responsive Settings', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'initial_slide' => array(
					'label' => esc_html__( 'Initial slide', 'albedo' ),
					'type' => 'short-text',
					'value' => '0'
				),
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
	)

);
