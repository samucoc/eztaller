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
					'label'         => esc_html__( 'Contact information', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Contact information', 'albedo' ),
					'desc'          => esc_html__( 'Create contact information grid', 'albedo' ),
					'template'      => '{{=address}}',
					'popup-options' => array(
						'header'   => array(
							'label' => esc_html__( 'Header', 'albedo' ),
							'type'  => 'text',
							'value' => ''
						),
						'address_title'   => array(
							'label' => esc_html__( 'Address title', 'albedo' ),
							'type'  => 'text',
							'value' => esc_html__( 'Address:', 'albedo' ),
						),
						'address'   => array(
							'label' => esc_html__( 'Address', 'albedo' ),
							'type'  => 'textarea',
							'value' => ''
						),
						'phone_title'   => array(
							'label' => esc_html__( 'Phone title', 'albedo' ),
							'type'  => 'text',
							'value' => esc_html__( 'Phone:', 'albedo' ),
						),
						'phone'   => array(
							'label' => esc_html__( 'Phone', 'albedo' ),
							'type'  => 'textarea',
							'value' => ''
						),
						'email_title'   => array(
							'label' => esc_html__( 'Email title', 'albedo' ),
							'type'  => 'text',
							'value' => esc_html__( 'Email:', 'albedo' ),
						),
						'email'   => array(
							'label' => esc_html__( 'E-mail', 'albedo' ),
							'type'  => 'textarea',
							'value' => ''
						),
					),
				),
				'cols' => array(
					'label' => esc_html__( 'Columns', 'albedo' ),
					'type' => 'select',
					'value' => '3',
					'choices' => array(
						'1' => esc_html__('1 Column', 'albedo'),
						'2' => esc_html__('2 Columns', 'albedo'),
						'3' => esc_html__('3 Columns', 'albedo'),
						'4' => esc_html__('4 Columns', 'albedo'),
					),
				),

			)
		),
	)

);
