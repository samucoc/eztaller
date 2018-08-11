<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$_grids_list = array(
	'' => esc_html__('- Select a grid -', 'albedo' ),
);

$grids = array();

if( shortcode_exists('ess_grid') ) {
	$grids = $wplab_albedo_core->model( 'thirdparty' )->get_essential_grids();
}

if( !empty( $grids ) ) {
	foreach( $grids as $grid ) {
		$_grids_list[ $grid->id ] = $grid->name;
	}
}

$options = array(
	'grid_id' => array(
		'label' => esc_html__( 'Choose a grid', 'albedo' ),
		'type' => 'select',
		'value' => '',
		'choices' => $_grids_list,
		'desc' => esc_html__( 'Select one of created grids. Essential grid plugin should be activated.', 'albedo' ),
	),
);
