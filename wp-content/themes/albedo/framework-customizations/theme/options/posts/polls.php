<?php

/**
 * Polls options array
 **/
$options = array(
	'poll_items_settings' => array(
		'title'   => esc_html__( 'Edit possible answers', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'elements' => array(
				'type'  => 'addable-option',
				'value' => array( esc_html__('Answer 1', 'albedo'), esc_html__('Answer 2', 'albedo'), esc_html__('Answer 3', 'albedo') ),
				'label' => esc_html__('Poll answers', 'albedo'),
				'option' => array( 'type' => 'text' ),
				'add-button-text' => esc_html__('Add', 'albedo'),
				'sortable' => true,
			),
			'results_view' => array(
				'type'  => 'html',
				'label' => esc_html__('Vote results', 'albedo'),
				'html'  => wplab_albedo_utils::get_poll_results_html(),
			),

		)
	),
);
