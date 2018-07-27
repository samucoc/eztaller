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
				'url' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Link URL', 'albedo')
				),
				'text' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Link text', 'albedo')
				),
				'target' => array(
					'label' => esc_html__( 'Open link at new tab?', 'albedo' ),
					'type' => 'switch',
					'right-choice' => array(
						'value' => '_blank',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => '_self',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => '_blank',
				),

			)
		),
		'styling' => array(
			'title' => esc_html__( 'Styling', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'height' => array(
					'type'  => 'short-text',
					'label' => esc_html__( 'Block height', 'albedo')
				),
				'paddings' => array(
					'type'  => 'short-text',
					'label' => esc_html__( 'Block paddings', 'albedo')
				),
				'text_align' => array(
					'label' => esc_html__( 'Text align', 'albedo' ),
					'type' => 'select',
					'value' => 'default',
					'choices' => array(
						'default' => esc_html__( 'Default', 'albedo' ),
						'left' => esc_html__( 'Left', 'albedo' ),
						'center' => esc_html__( 'Center', 'albedo' ),
						'right' => esc_html__( 'Right', 'albedo' ),
					),
				),
				'style' => array(
					'label' => esc_html__( 'Box style', 'albedo' ),
					'type' => 'select',
					'value' => 'purple',
					'choices' => $wplab_albedo_core->cfg['base_colors'],
				),
				'shadow' => array(
					'label' => esc_html__( 'Add shadow?', 'albedo' ),
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
					'value' => 'yes',
				),

			)
		),

	)

);
