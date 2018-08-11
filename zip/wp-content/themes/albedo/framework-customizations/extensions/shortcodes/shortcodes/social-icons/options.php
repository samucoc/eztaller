<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'attributes' => array(
			'title' => esc_html__( 'Icons', 'albedo' ),
			'type' => 'tab',
			'options' => wplab_albedo_utils::get_social_cfg_usyon()
		),
		'styling' => array(
			'title' => esc_html__( 'Styling', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'color' => array(
					'label' => esc_html__('Icon Color', 'albedo'),
					'desc' => esc_html__('Select the custom icon color', 'albedo'),
					'type' => 'color-picker',
				),
				'hover_color' => array(
					'label' => esc_html__('Icon Hover Color', 'albedo'),
					'desc' => esc_html__('Select the custom hover icon color', 'albedo'),
					'type' => 'color-picker',
				),
				'font_size' => array(
					'type'  => 'short-text',
					'label' => esc_html__( 'Custom font size', 'albedo' ),
					'desc' => esc_html__( 'value in pixels, e.g. 18', 'albedo' ),
					'value' => ''
				),

			)
		)
	)
);
