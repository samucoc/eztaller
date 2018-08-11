<?php

/**
 * Benefits options array
 **/
$options = array(
	'icon_settings' => array(
		'title'   => esc_html__( 'Benefit icon', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'icon' => array(
				'type'  => 'icon-v2',
				'preview_size' => 'large',
				'modal_size' => 'large',
				'label' => esc_html__('Upload benefit icon or image', 'albedo'),
			),

		)
	),
	'link_settings' => array(
		'title'   => esc_html__( 'Link', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'link' => array(
				'type'  => 'text',
				'label' => esc_html__('URL', 'albedo'),
			),

		)
	),
	'styling_settings' => array(
		'title'   => esc_html__( 'Styling', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'bg_image' => array(
				'label' => esc_html__( 'Custom Background image', 'albedo' ),
				'desc' => esc_html__( 'used in some shortcodes', 'albedo' ),
				'type' => 'upload',
				'images_only' => true,
			),

			'custom_shadow' => array(
				'type' => 'multi-picker',
				'label' => false,
				'picker' => array(
					'enabled' => array(
						'label' => esc_html__( 'Customize icon shadow', 'albedo' ),
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

						'shadow_color' => array(
							'label' => esc_html__('Shadow color', 'albedo'),
							'value' => '',
							'type' => 'rgba-color-picker',
						),
						'shadow_h_length' => array(
							'type'  => 'slider',
							'value' => 0,
							'properties' => array(
								'min' => -200,
								'max' => 200,
							),
							'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
						),
						'shadow_v_length' => array(
							'type'  => 'slider',
							'value' => 10,
							'properties' => array(
								'min' => -200,
								'max' => 200,
							),
							'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
						),
						'shadow_blur_radius' => array(
							'type'  => 'slider',
							'value' => 30,
							'properties' => array(
								'min' => 0,
								'max' => 300,
							),
							'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
						),

					)
				)
			),

		)
	)
);
