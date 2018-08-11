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
						'title' => array(
							'type'  => 'text',
							'shortcodes' => true,
							'label' => esc_html__('Title', 'albedo')
						),
						'content' => array(
							'type'  => 'wp-editor',
							'shortcodes' => true,
							'label' => esc_html__('Content', 'albedo')
						),
					),
				),
				'date_format' => array(
					'type' => 'short-text',
					'value' => 'F Y',
					'label' => esc_html__( 'Date format for events', 'albedo' ),
				),
				'date_format_mobile' => array(
					'type' => 'short-text',
					'value' => 'Y',
					'label' => esc_html__( 'Date format for mobile devices', 'albedo' ),
				),
				'is_sticky' => array(
					'label' => esc_html__( 'Stick timeline', 'albedo' ),
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
				'scroll_offset_top' => array(
					'type'  => 'short-text',
					'label' => esc_html__( 'Sticky top offset', 'albedo'),
					'value' => '40',
				),
			)
		),

	)

);
