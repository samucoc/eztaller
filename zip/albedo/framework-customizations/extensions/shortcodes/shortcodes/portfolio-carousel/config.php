<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Portfolio Carousel', 'albedo' ),
	'description' => esc_html__( 'Add Portfolio Carousel', 'albedo' ),
	'tab'         => esc_html__( 'Portfolio', 'albedo' ),
	'popup_size' 	=> 'large',
);
