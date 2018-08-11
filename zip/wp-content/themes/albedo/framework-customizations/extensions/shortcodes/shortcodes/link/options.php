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
				'domain_only' => array(
					'label' => esc_html__( 'Display domain only?', 'albedo' ),
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

				'style' => array(
					'label' => esc_html__( 'Box style', 'albedo' ),
					'type' => 'select',
					'value' => 'default',
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
					'value' => 'no',
				),

			)
		),
		'animations' => array(
			'title' => esc_html__( 'Animations', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'typed_animation' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Typed Animation', 'albedo' ),
							'type' => 'switch',
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Enabled', 'albedo' )
							),
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'Disabled', 'albedo' )
							),
							'value' => 'no',
						)
					),
					'choices' => array(
						'yes' => array(

							'delay' => array(
								'label' => esc_html__('Animation delay', 'albedo'),
								'value' => '150',
								'type' => 'text',
							),
							'speed' => array(
								'label' => esc_html__('Animation speed', 'albedo'),
								'value' => '100',
								'type' => 'text',
							),

						)
					)
				),

			)
		),
	)

);
