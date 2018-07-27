<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Accordion', 'albedo' ),
	'description' => esc_html__( 'Add an Accordion', 'albedo' ),
	'tab'         => esc_html__( 'Content Elements', 'albedo' ),
	'popup_size' 	=> 'large',
);
