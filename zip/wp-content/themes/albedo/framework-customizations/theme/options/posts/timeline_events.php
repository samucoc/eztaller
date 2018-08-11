<?php

/**
 * Timeline events options array
 **/
$options = array(
	'details' => array(
		'title'   => esc_html__( 'CV Details', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'date_start' => array(
				'type'  => 'date-picker',
				'min-date' => '01-01-1930',
				'label' => esc_html__('Start Date', 'albedo')
			),
			'date_end' => array(
				'type'  => 'date-picker',
				'min-date' => '01-01-1930',
				'label' => esc_html__('End Date', 'albedo'),
			),

		)
	),

);
