<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Blog Media Grid', 'albedo' ),
	'description' => esc_html__( 'Add Blog Media Grid', 'albedo' ),
	'tab'         => esc_html__( 'Blog', 'albedo' ),
	'popup_size' 	=> 'large',
);
