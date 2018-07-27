<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'shortcode' => array(
		'type'	=> 'textarea',
		'size'	=> 'large',
		'label'	=> esc_html__( 'Shortcode', 'albedo' ),
		'desc'	=> esc_html__( 'Here you can add any third-party shortcode', 'albedo' )
	),
);
