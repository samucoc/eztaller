<?php
global $wplab_albedo_core;
/**
 * Media slides single options array
 **/
$options = array(
	'details' => array(
		'title'   => esc_html__( 'Slide Details', 'albedo' ),
		'type'    => 'box',
		'options' => array(
			'video_url' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Video URL', 'albedo'),
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
		)
	),
);
