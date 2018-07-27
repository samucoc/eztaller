<?php if (!defined('FW')) die('Forbidden');

global $wplab_albedo_core;

$_docs_list = array(
	'' => esc_html__('- Select documentation -', 'albedo' ),
);

$docs = $wplab_albedo_core->model( 'thirdparty' )->get_wedocs();

if( !empty( $docs ) ) {
	foreach( $docs as $doc ) {
		$_docs_list[ $doc->ID ] = $doc->post_title;
	}
}

$options = array(
	'docs_id' => array(
		'label' => esc_html__( 'Choose docs', 'albedo' ),
		'type' => 'select',
		'value' => '',
		'choices' => $_docs_list,
		'desc' => esc_html__( 'Select one of created documentation. WeDocs plugin should be activated.', 'albedo' ),
	),
);
