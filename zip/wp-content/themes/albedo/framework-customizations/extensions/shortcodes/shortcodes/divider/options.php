<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
global $wplab_albedo_core;

$options = array(
	'id' => array( 'type' => 'unique' ),
	'style' => array(
		'type'     => 'multi-picker',
		'label'    => false,
		'desc'     => false,
		'picker' => array(
			'ruler_type' => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Ruler Type', 'albedo' ),
				'desc'    => esc_html__( 'Here you can set the styling and size of the HR element', 'albedo' ),
				'choices' => array(
					'line'  => esc_html__( 'Line', 'albedo' ),
					'space' => esc_html__( 'Whitespace', 'albedo' ),
				)
			)
		),
		'choices'     => array(
			'space' => array(
				'height' => array(
					'label' => esc_html__( 'Height', 'albedo' ),
					'desc'  => esc_html__( 'How much whitespace do you need? Enter a pixel value. Positive value will increase the whitespace, negative value will reduce it. eg: \'50\', \'-25\', \'200\'', 'albedo' ),
					'type'  => 'text',
					'value' => '50'
				)
			),
			'line' => array(
				'line_color' => array(
					'type'    => 'select',
					'label'   => esc_html__( 'Line color', 'albedo' ),
					'desc'    => esc_html__( 'choose from pre-defined colors or set your own color', 'albedo' ),
					'value'		=> 'light_grey',
					'choices' => $wplab_albedo_core->cfg['base_colors'],
				),
				'custom_color' => array(
					'label' => esc_html__('Custom line color', 'albedo'),
					'type' => 'color-picker',
				),
				'corners_radius' => array(
					'label' => esc_html__('Corners radius', 'albedo'),
					'desc' => esc_html__('value in pixels, e.g. 3', 'albedo'),
					'type' => 'short-text',
				),
				'max_width' => array(
					'label' => esc_html__('Line width', 'albedo'),
					'desc' => esc_html__('for example: 30% or 30px', 'albedo'),
					'type' => 'short-text',
				),
				'margins' => array(
					'label' => esc_html__('Custom margins', 'albedo'),
					'desc' => esc_html__('for example: 30% or 30px', 'albedo'),
					'type' => 'short-text',
				),
			)
		)
	)
);
