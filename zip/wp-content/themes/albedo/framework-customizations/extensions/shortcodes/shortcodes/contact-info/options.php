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

				'address'   => array(
					'label' => esc_html__( 'Address', 'albedo' ),
					'type'  => 'textarea',
					'value' => ''
				),
				'phone'   => array(
					'label' => esc_html__( 'Phone', 'albedo' ),
					'type'  => 'textarea',
					'value' => ''
				),
				'email'   => array(
					'label' => esc_html__( 'E-mail', 'albedo' ),
					'type'  => 'textarea',
					'value' => ''
				),

			)
		),
	)

);
