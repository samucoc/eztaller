<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Featured Post', 'albedo' ),
	'description' => esc_html__( 'Add Featured Post Block', 'albedo' ),
	'tab'         => esc_html__( 'Blog', 'albedo' ),
	'popup_size' 	=> 'large',
);
