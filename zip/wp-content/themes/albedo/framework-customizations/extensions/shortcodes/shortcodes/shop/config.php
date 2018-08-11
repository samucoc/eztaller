<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Woo Commerce', 'albedo' ),
	'description' => esc_html__( 'Add WooCommerce Products', 'albedo' ),
	'tab'         => esc_html__( 'Plugins', 'albedo' ),
	'popup_size' 	=> 'large',
);
