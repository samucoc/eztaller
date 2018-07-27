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
					'label'         => esc_html__( 'Previous employment', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Events on TimeLine', 'albedo' ),
					'desc'          => esc_html__( 'Create events', 'albedo' ),
					'template'      => '{{=position}}',
					'popup-options' => array(
						'date_start' => array(
							'type'  => 'date-picker',
							'min-date' => '01-01-1930',
							'label' => esc_html__('Start Date', 'albedo')
						),
						'date_end' => array(
							'type'  => 'date-picker',
							'min-date' => '01-01-1930',
							'label' => esc_html__('End Date', 'albedo')
						),
						'position' => array(
							'type'  => 'text',
							'shortcodes' => true,
							'label' => esc_html__('Position', 'albedo')
						),
						'url' => array(
							'type'  => 'text',
							'shortcodes' => true,
							'label' => esc_html__('Website URL', 'albedo')
						),
					),
				),
				'date_format' => array(
					'type' => 'short-text',
					'value' => 'M Y',
					'label' => esc_html__( 'Date format', 'albedo' ),
				),
			)
		),

	)

);
