<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$options = array(
	'id' => array( 'type' => 'unique' ),
	'general' => array(
		'title' => esc_html__( 'General', 'albedo' ),
		'type' => 'tab',
		'options' => array(

			'items' => array(
				'type'          => 'addable-popup',
				'label'         => esc_html__( 'Team Members', 'albedo' ),
				'popup-title'   => esc_html__( 'Add/Edit Team Member', 'albedo' ),
				'desc'          => esc_html__( 'Create your team', 'albedo' ),
				'template'      => '{{=name}}',
				'popup-options' => array(
					'photo' => array(
						'label' => esc_html__('Photo', 'albedo'),
						'type' => 'background-image',
					),
					'name' => array(
						'type'  => 'text',
						'label' => esc_html__('Name', 'albedo')
					),
					'position' => array(
						'type'  => 'text',
						'label' => esc_html__('Position', 'albedo')
					),
					'free_text' => array(
						'type'  => 'textarea',
						'label' => esc_html__('Free Text', 'albedo')
					),
				) + wplab_albedo_utils::get_social_cfg_usyon(),
			),
			'img_width' => array(
				'type'  => 'short-text',
				'label' => esc_html__('Photo width', 'albedo'),
				'value' => 360
			),
			'img_height' => array(
				'type'  => 'short-text',
				'label' => esc_html__('Photo height', 'albedo'),
				'value' => 590
			),

		)
	),
	'carousel-settings' => array(
		'title' => esc_html__( 'Carousel', 'albedo' ),
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
			'slide_start' => array(
				'type'  => 'short-text',
				'value' => '1',
				'label' => esc_html__('Start slide', 'albedo')
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
	),
);
