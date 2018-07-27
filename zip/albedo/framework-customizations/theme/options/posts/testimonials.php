<?php

/**
 * Testimonials options array
 **/
$options = array(
	'details' => array(
		'title'   => esc_html__( 'Details', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'author' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Author name', 'albedo'),
			),
			'position' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Position', 'albedo'),
			),
			'sign' => array(
				'label' => esc_html__( 'Signature photo', 'albedo' ),
				'desc' => esc_html__( 'used in some shortcodes', 'albedo' ),
				'type' => 'upload',
				'images_only' => true,
			),
			'bg' => array(
				'label' => esc_html__( 'Background photo', 'albedo' ),
				'desc' => esc_html__( 'used in some shortcodes', 'albedo' ),
				'type' => 'upload',
				'images_only' => true,
			),

		)
	),

);
