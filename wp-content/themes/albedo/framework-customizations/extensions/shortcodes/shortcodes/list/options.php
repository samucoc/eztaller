<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'text' => array(
		'type'   => 'textarea',
		'value'   => '* Consectetuer adipiscing elit, sed diam nonummy nibh;
* Investigationes lectores;
* Eodem modo typi, qui nunc nobis videntur parum clari, fiant;
* Quis nostrud exerci ullamcorper.',
		'label'  => esc_html__( 'List content', 'albedo' ),
		'desc'   => esc_html__( 'Type here some list content. Begin each list element with *', 'albedo' )
	),
	'type' => array(
		'label' => esc_html__( 'List type', 'albedo' ),
		'type' => 'select',
		'value' => '',
		'choices' => array(
			'ul' => esc_html__('Unordered list (standard)', 'albedo'),
			'ol' => esc_html__('Ordered list (standard)', 'albedo'),
			'ul custom-bullets' => esc_html__('Unordered list (custom bullets)', 'albedo'),
		),
	),
	'style' => array(
		'label' => esc_html__( 'List style', 'albedo' ),
		'type' => 'select',
		'value' => '',
		'choices' => array(
			'default' => esc_html__('Default style', 'albedo'),
			'darken' => esc_html__('Darken text', 'albedo'),
			'lighten' => esc_html__('Lighten text', 'albedo'),
		),
	),
	'margins' => array(
		'label' => esc_html__( 'List margins', 'albedo' ),
		'type' => 'select',
		'value' => '',
		'choices' => array(
			'big' => esc_html__('Big', 'albedo'),
			'medium' => esc_html__('Medium', 'albedo'),
		),
	),
);
