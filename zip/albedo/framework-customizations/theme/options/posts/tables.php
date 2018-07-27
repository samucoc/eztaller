<?php

/**
 * Pricing table options metabox
 **/
$options = array(
	'general' => array(
		'title'   => esc_html__( 'Table style', 'albedo' ),
		'type'    => 'box',
		'context' => 'side',
		'options' => array(

			'table_style' => array(
				'label' => esc_html__( 'Choose the style', 'albedo' ),
				'type' => 'select',
				'value' => '',
				'fw-storage' => array(
					'type' => 'post-meta',
					'post-meta' => 'table_style',
				),
				'choices' => array(
					'fw-pricing style-1' => esc_html__('Pricing table (white)', 'albedo'),
					'fw-pricing style-2' => esc_html__('Pricing table (grey / blue)', 'albedo'),
					'fw-pricing style-3' => esc_html__('Pricing table (white / grey)', 'albedo'),
					'fw-pricing style-4' => esc_html__('Pricing table (white / dark / icons)', 'albedo'),
					'fw-pricing style-5' => esc_html__('Pricing table (minimal)', 'albedo'),
					'fw-pricing style-6' => esc_html__('Pricing table (dark)', 'albedo'),
					'fw-pricing style-7' => esc_html__('Pricing table (white / icons)', 'albedo'),
					'fw-table' => esc_html__('Standard Table (style 1)', 'albedo'),
					'fw-table style-2' => esc_html__('Standard Table (style 2)', 'albedo'),
					'fw-table style-3' => esc_html__('Standard Table (style 3)', 'albedo'),
					'fw-table style-4' => esc_html__('Standard Table (style 4)', 'albedo'),
					'fw-table style-5' => esc_html__('Standard Table (style 5)', 'albedo'),
				),
			),

		)
	),
);
