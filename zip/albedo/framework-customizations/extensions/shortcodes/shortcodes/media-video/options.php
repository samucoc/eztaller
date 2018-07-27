<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'url'    => array(
		'type'  => 'text',
		'label' => esc_html__( 'Insert Video URL', 'albedo' ),
		'desc'  => esc_html__( 'Insert Video URL to embed this video', 'albedo' )
	),
);
