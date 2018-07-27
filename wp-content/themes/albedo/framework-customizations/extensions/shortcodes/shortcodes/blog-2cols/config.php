<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Blog 2 Cols', 'albedo' ),
	'description' => esc_html__( 'Add 2 Columns Posts List', 'albedo' ),
	'tab'         => esc_html__( 'Blog', 'albedo' ),
	'popup_size' 	=> 'large',
);
