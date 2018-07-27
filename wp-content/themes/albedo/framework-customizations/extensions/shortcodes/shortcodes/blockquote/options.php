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
				'text' => array(
					'type'  => 'textarea',
					'label' => esc_html__( 'Quote text', 'albedo')
				),
				'author' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Author', 'albedo')
				),
				'position' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Position', 'albedo')
				),
				'style' => array(
					'label' => esc_html__( 'Element style', 'albedo' ),
					'type' => 'select',
					'value' => 'default',
					'choices' => array(
						'default' => esc_html__( 'Standard Blockquote', 'albedo' ),
						'accent' => esc_html__( 'Accent Blockquote', 'albedo' ),
					),
				),
			)
		),
		'styling' => array(
			'title' => esc_html__( 'Styling', 'albedo' ),
			'type' => 'tab',
			'options' => array(
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
				'background_color' => array(
					'label' => esc_html__('Background color', 'albedo'),
					'desc' => esc_html__('Select the custom background color', 'albedo'),
					'type' => 'color-picker',
				),
				'quotes_color' => array(
					'label' => esc_html__('Quotes decor color', 'albedo'),
					'desc' => esc_html__('Select the custom quotes decor color', 'albedo'),
					'type' => 'color-picker',
				),
				'text_color' => array(
					'label' => esc_html__('Quote text color', 'albedo'),
					'desc' => esc_html__('Select the custom quote text color', 'albedo'),
					'type' => 'color-picker',
				),
				'author_color' => array(
					'label' => esc_html__('Author text color', 'albedo'),
					'desc' => esc_html__('Select the custom quote author text color', 'albedo'),
					'type' => 'color-picker',
				),
				'position_color' => array(
					'label' => esc_html__('Position text color', 'albedo'),
					'desc' => esc_html__('Select the custom quote author position text color', 'albedo'),
					'type' => 'color-picker',
				),
			)
		),
	'custom_margins' => array(
		'title' => esc_html__( 'Margins', 'albedo' ),
		'type' => 'tab',
		'options' => array(

			'margins' => array(
				'label' => esc_html__( 'Blockquote Margins', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),
			'margins_medium' => array(
				'label' => esc_html__( 'Blockquote Margins (for medium screens)', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),
			'margins_mobile' => array(
				'label' => esc_html__( 'Blockquote Margins (for small screens)', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),

		)
	),
	'custom_paddings' => array(
		'title' => esc_html__( 'Paddings', 'albedo' ),
		'type' => 'tab',
		'options' => array(

			'paddings' => array(
				'label' => esc_html__( 'Blockquote Paddings', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),
			'paddings_medium' => array(
				'label' => esc_html__( 'Blockquote Paddings (for medium screens)', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),
			'paddings_mobile' => array(
				'label' => esc_html__( 'Blockquote Paddings (for small screens)', 'albedo' ),
				'type' => 'stylebox',
				'value' => '',
				'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
			),

		)
	),
	)

);
