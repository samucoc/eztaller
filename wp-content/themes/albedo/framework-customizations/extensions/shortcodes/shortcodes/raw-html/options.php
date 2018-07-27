<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'html' => array(
		'type'   => 'textarea',
		'size' => 'large',
		'label'  => esc_html__( 'HTML Content', 'albedo' ),
		'desc'   => esc_html__( 'Here you can add any HTML code into Page Builder', 'albedo' )
	),
);
