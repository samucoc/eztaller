<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Chart', 'albedo' ),
	'description' => esc_html__( 'Add Chart', 'albedo' ),
	'tab'         => esc_html__( 'Content Elements', 'albedo' ),
	'popup_size' 	=> 'large',
);
