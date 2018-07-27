<?php
global $wplab_albedo_core;
/**
 * Team members options array
 **/
$options = array(
	'details' => array(
		'title'   => esc_html__( 'Details', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'position' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Position', 'albedo'),
			),
			'content_photo' => array(
				'label' => esc_html__( 'Content photo', 'albedo' ),
				'desc' => esc_html__( 'used in Team Tabs shortcode', 'albedo' ),
				'type' => 'upload',
				'images_only' => true,
			),
			'display_button' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'picker' => array(

					'enabled' => array(
						'label' => esc_html__( 'Display a button', 'albedo' ),
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

						'button_text' => array(
							'type'  => 'text',
							'label' => esc_html__('Button Text', 'albedo'),
							'value' => esc_html__('Read More', 'albedo'),
						),
						'button_url' => array(
							'type'  => 'text',
							'label' => esc_html__('Button URL', 'albedo'),
							'value' => '',
						),
						'button_style'  => array(
							'label'   => esc_html__( 'Button Style', 'albedo' ),
							'type'    => 'select',
							'value' 	=> 'green',
							'choices' => $wplab_albedo_core->cfg['button_styles']
						),

					)
				)
			),
			'job_vacancy' => array(
				'label' => esc_html__( 'This post is a job vacancy', 'albedo' ),
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

		) + wplab_albedo_utils::get_social_cfg_usyon()
	),

);
