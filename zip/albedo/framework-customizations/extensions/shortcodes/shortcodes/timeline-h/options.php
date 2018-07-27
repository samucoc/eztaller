<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'general' => array(
			'title' => esc_html__( 'General', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'items' => array(
					'type'          => 'addable-popup',
					'label'         => esc_html__( 'Events', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Events on TimeLine', 'albedo' ),
					'desc'          => esc_html__( 'Create events', 'albedo' ),
					'template'      => '{{=date}}',
					'popup-options' => array(
						'date' => array(
							'type'  => 'date-picker',
							'min-date' => '01-01-1930',
							'label' => esc_html__('Date', 'albedo')
						),
						'content' => array(
							'type'  => 'wp-editor',
							'shortcodes' => true,
							'label' => esc_html__('Content', 'albedo')
						),
					),
				),
				'min_distance' => array(
					'type' => 'short-text',
					'value' => '80',
					'label' => esc_html__( 'Minimum distance between items', 'albedo' ),
				)
			)
		),

	)

);
