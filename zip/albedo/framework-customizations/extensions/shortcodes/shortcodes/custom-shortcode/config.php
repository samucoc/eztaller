<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Custom Shortcode', 'albedo' ),
	'description' => esc_html__( 'Add custom / third-party Shortcode', 'albedo' ),
	'tab'         => esc_html__( 'Content Elements', 'albedo' ),
	'popup_size' 	=> 'large',
);
