<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Blog Minimal', 'albedo' ),
	'description' => esc_html__( 'Add Minimal / List Blog Style', 'albedo' ),
	'tab'         => esc_html__( 'Blog', 'albedo' ),
	'popup_size' 	=> 'large',
);
