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
					'value' => '9'
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
					'value' => 'DESC',
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
		'filters_tab' => array(
			'title' => esc_html__( 'Filters', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'filters' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Display post filters', 'albedo' ),
							'type' => 'switch',
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'No', 'albedo' )
							),
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Yes', 'albedo' )
							),
							'value' => 'yes',
						)
					),
					'choices' => array(
						'yes' => array(

							'filters_style' => array(
								'label' => esc_html__( 'Filters style', 'albedo' ),
								'type' => 'radio',
								'value' => 'boxed',
								'choices' => array(
									'boxed' => esc_html__( 'Boxed', 'albedo'),
									'simple' => esc_html__( 'Simple', 'albedo'),
								),
							),

						)
					)
				),

			)
		),
		'pagination_tab' => array(
			'title' => esc_html__( 'Pagination', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'pagination' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Display pagination', 'albedo' ),
							'type' => 'switch',
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'No', 'albedo' )
							),
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Yes', 'albedo' )
							),
							'value' => 'yes',
						)
					),
					'choices' => array(
						'yes' => array(

							'pagination_style' => array(
								'type' => 'multi-picker',
								'label' => false,
								'desc' => false,
								'picker' => array(

									'style' => array(
										'label' => esc_html__( 'Pagination style', 'albedo' ),
										'type' => 'radio',
										'value' => 'number',
										'choices' => array(
											'number' => esc_html__( 'Numbers', 'albedo'),
											'prev_next' => esc_html__( 'Prev / Next links', 'albedo'),
											'ajax_load_more' => esc_html__( 'AJAX (load more button)', 'albedo'),
											'ajax_infinite' => esc_html__( 'AJAX (infinite scroll)', 'albedo'),
										),
									),

								),
								'choices' => array(
									'ajax_load_more' => array(

										'button_text' => array(
											'type'  => 'text',
											'label' => esc_html__('Button text', 'albedo'),
											'value' => esc_html__('Load more', 'albedo'),
										),
										'button_style'  => array(
											'label'   => esc_html__( 'Button Style', 'albedo' ),
											'desc'    => esc_html__( 'Here you can choose pre-defined styles for a button', 'albedo' ),
											'type'    => 'select',
											'choices' => $wplab_albedo_core->cfg['button_styles']
										),

									)
								),
							),
						),
					),
					'show_borders' => false,
				),

			)
		),
		'style_tab' => array(
			'title' => esc_html__( 'Style', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'style' => array(
					'label' => esc_html__( 'Products style', 'albedo' ),
					'type' => 'radio',
					'value' => 'style_1',
					'choices' => array(
						'style_1' => esc_html__( 'Boxed', 'albedo'),
						'style_2' => esc_html__( 'Boxed Media', 'albedo'),
						'style_3' => esc_html__( 'Simple', 'albedo'),
					),
				),

			)
		),
	)

);
