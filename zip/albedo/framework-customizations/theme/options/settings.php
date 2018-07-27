<?php

	if ( ! defined( 'FW' ) ) {
		die( 'Forbidden' );
	}

	$options = array(
		fw()->theme->get_options( 'general' ),
		'customizer_settings' => array(
			'title' => esc_html__('Style Options', 'albedo'),
			'type' => 'tab',
			'options' => array(
				fw()->theme->get_options( 'customizer', array( 'no_fw_storage' => true ) ),
			)
		),
	);
