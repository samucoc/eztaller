<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$_polls_list = array(
	'' => esc_html__('- Select a poll -', 'albedo' ),
);

$polls = array();

$polls = $wplab_albedo_core->model( 'thirdparty' )->get_polls();

if( count( $polls ) > 0 ) {
	foreach( $polls as $poll ) {
		$_polls_list[ $poll->ID ] = $poll->post_title;
	}
}

$options = array(
	'id' => array( 'type' => 'unique' ),
	'poll_id' => array(
		'label' => esc_html__( 'Choose a poll', 'albedo' ),
		'type' => 'select',
		'value' => '',
		'choices' => $_polls_list,
		'desc' => esc_html__( 'Select one of created polls', 'albedo' ),
	),
	'cols' => array(
		'label' => esc_html__( 'Number of columns', 'albedo' ),
		'type' => 'select',
		'value' => '3',
		'choices' => array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
		),
		'desc' => esc_html__( 'Sumber of columns for possible answers', 'albedo' ),
	),
);
