<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Portfolio Posts Carousel', 'albedo' ),
	'description' => esc_html__( 'Add Portfolio Posts Carousel', 'albedo' ),
	'tab'         => esc_html__( 'Portfolio', 'albedo' ),
	'popup_size' 	=> 'large',
);
