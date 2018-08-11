<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Styled List', 'albedo' ),
	'description' => esc_html__( 'Add a List of Elements', 'albedo' ),
	'tab'         => esc_html__( 'Content Elements', 'albedo' ),
	'popup_size' 	=> 'large',
);
