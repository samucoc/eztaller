<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'query_tab' => array(
			'title' => esc_html__( 'Query', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'posts_per_page' => array(
					'label' => esc_html__( 'Posts per page', 'albedo' ),
					'type' => 'text',
					'value' => '6'
				),
				'order_by' => array(
					'label' => esc_html__( 'Posts ordering method', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'date' => esc_html__('Date', 'albedo' ),
						'ID' => 'ID',
						'modified' => esc_html__('Modified date', 'albedo' ),
						'title' => esc_html__('Title', 'albedo'),
						'rand' => esc_html__('Random', 'albedo'),
						'menu' => esc_html__('Menu', 'albedo')
					),
				),
				'sort_by' => array(
					'label' => esc_html__( 'Posts sorting method', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'DESC' => esc_html__('Descending', 'albedo'),
						'ASC' => esc_html__('Ascending', 'albedo'),
					),
				),
				'taxonomy_query' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'value' => array(
						'tax_query_type' => '',
					),
					'picker' => array(
						'tax_query_type' => array(
							'label' => esc_html__( 'Query from category', 'albedo' ),
							'type' => 'radio',
							'choices' => array(
								'' => esc_html__( 'All', 'albedo' ),
								'only' => esc_html__( 'Only', 'albedo' ),
								'except' => esc_html__( 'Except', 'albedo' ),
							),
						)
					),
					'choices' => array(
						'only' => array(

							'cats_include' => array(
								'label' => esc_html__('Categories', 'albedo'),
								'desc' => esc_html__('Type here category slugs to include or exclude, based on previous parameter. Explode multiple categories slugs by comma', 'albedo'),
								'type' => 'textarea',
								'value' => ''
							),

						),
						'except' => array(

							'cats_exclude' => array(
								'label' => esc_html__('Categories', 'albedo'),
								'desc' => esc_html__('Type here category slugs to include or exclude, based on previous parameter. Explode multiple categories slugs by comma', 'albedo'),
								'type' => 'textarea',
								'value' => ''
							),

						),
					)
				),
			)
		),
		'appearance_tab' => array(
			'title' => esc_html__( 'Appearance', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'display_hover_title' => array(
					'label' => esc_html__( 'Display post title', 'albedo' ),
					'type' => 'switch',
					'value' => 'yes',
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
				),
				'display_hover_cats' => array(
					'label' => esc_html__( 'Display post categories', 'albedo' ),
					'type' => 'switch',
					'value' => 'yes',
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
				),
				'display_zoom_icon' => array(
					'label' => esc_html__( 'Display zoom icon', 'albedo' ),
					'type' => 'switch',
					'value' => 'yes',
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
				),
			)
		),
		'style_tab' => array(
			'title' => esc_html__( 'Style', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'columns' => array(
					'label' => esc_html__( 'Number of columns', 'albedo' ),
					'type' => 'select',
					'value' => 'col-md-6',
					'choices' => array(
						'col-md-6' => esc_html__('2 columns', 'albedo' ),
						'col-md-3' => esc_html__('4 columns', 'albedo' ),
					),
				),
				'overlay_color' => array(
					'label' => esc_html__( 'Overlay color', 'albedo' ),
					'type' => 'select',
					'choices' => $wplab_albedo_core->cfg['base_colors'],
				),
				'grid_row_height' => array(
					'label' => esc_html__( 'Row height', 'albedo' ),
					'desc' => esc_html__( 'value in pixels, e.g.: 460', 'albedo' ),
					'type' => 'short-text',
					'value' => '460'
				),
				'grid_row_height_mobile' => array(
					'label' => esc_html__( 'Row height on mobiles', 'albedo' ),
					'desc' => esc_html__( 'value in pixels, e.g.: 300', 'albedo' ),
					'type' => 'short-text',
					'value' => '300'
				),
				'thumbs_dimensions' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'value' => array(
						'type' => '',
					),
					'picker' => array(
						'type' => array(
							'label' => esc_html__( 'Thumbnails dimensions', 'albedo' ),
							'type' => 'radio',
							'choices' => array(
								'' => esc_html__( 'Original size', 'albedo' ),
								'crop' => esc_html__( 'Crop thumbnails', 'albedo' ),
							),
						)
					),
					'choices' => array(
						'crop' => array(
							'thumb_width' => array(
								'label' => esc_html__( 'Thumbnail width', 'albedo' ),
								'desc' => esc_html__( 'value in pixels, e.g.: 320', 'albedo' ),
								'type' => 'short-text',
								'value' => '320'
							),
							'thumb_height' => array(
								'label' => esc_html__( 'Thumbnail height', 'albedo' ),
								'desc' => esc_html__( 'value in pixels, e.g.: 180', 'albedo' ),
								'type' => 'short-text',
								'value' => '180'
							),
						)
					),
				),
			)
		),
	)

);
