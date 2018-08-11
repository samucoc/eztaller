<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'general' => array(
			'title' => esc_html__( 'Query', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'query_type' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'value' => array(
						'type' => 'all',
					),
					'picker' => array(
						'type' => array(
							'label' => esc_html__( 'Query', 'albedo' ),
							'type' => 'radio',
							'choices' => array(
								'all' => esc_html__( 'Display all Benefits posts', 'albedo' ),
								'include' => esc_html__( 'Display Benefits only from selected categories', 'albedo' ),
								'exclude' => esc_html__( 'Display all, except selected categories', 'albedo' ),
								'all_child' => esc_html__( 'Display child from selected category', 'albedo' ),
							),
						)
					),
					'choices' => array(

						'include' => array(
							'terms' => array(
								'type'  => 'multi-select',
								'value' => array(),
								'label' => esc_html__('Include categories', 'albedo'),
								'desc' => esc_html__('Start typing category name to find it', 'albedo'),
								'population' => 'taxonomy',
								'source' => 'benefits_category',
								'limit' => 50,
							),
						),
						'exclude' => array(
							'terms' => array(
								'type'  => 'multi-select',
								'value' => array(),
								'label' => esc_html__('Exclude categories', 'albedo'),
								'desc' => esc_html__('Start typing category name to find it', 'albedo'),
								'population' => 'taxonomy',
								'source' => 'benefits_category',
								'limit' => 50,
							),
						),
						'all_child' => array(

							'terms' => array(
								'type'  => 'multi-select',
								'value' => array(),
								'label' => esc_html__('Select a category', 'albedo'),
								'desc' => esc_html__('Start typing category name to find it', 'albedo'),
								'population' => 'taxonomy',
								'source' => 'benefits_category',
								'limit' => 1,
							),

						),

					)
				),
				/**
				'posts_per_page' => array(
					'label' => esc_html__( 'Posts per page', 'albedo' ),
					'type' => 'text',
					'value' => '9'
				),
				**/
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
						'menu_order' => esc_html__('Menu', 'albedo')
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

			)
		),
		'style-settings' => array(
			'title' => esc_html__( 'Style', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'style' => array(
					'label' => esc_html__( 'Style', 'albedo' ),
					'type' => 'select',
					'value' => 'default',
					'choices' => array(
						'default' => esc_html__('Default', 'albedo'),
						'alt' => esc_html__('Alternate', 'albedo'),
					),
				),
				'scroll_nav' => array(
					'label' => esc_html__( 'Scroll navigation', 'albedo' ),
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
				),
				'scroll_nav_offset_top' => array(
					'type'  => 'short-text',
					'label' => esc_html__( 'Scroll top offset', 'albedo'),
					'value' => '40',
				),
				'cols' => array(
					'label' => esc_html__( 'Columns', 'albedo' ),
					'type' => 'select',
					'value' => '2',
					'choices' => array(
						'1' => esc_html__('1 Column', 'albedo'),
						'2' => esc_html__('2 Columns', 'albedo'),
						'3' => esc_html__('3 Columns', 'albedo'),
						'4' => esc_html__('4 Columns', 'albedo'),
					),
				),

				'display_filters' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Display filters', 'albedo' ),
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

							'all_button' => array(
								'label' => esc_html__( 'Display All filter', 'albedo' ),
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
							),

							'terms_order_by' => array(
								'label' => esc_html__( 'Terms ordering method', 'albedo' ),
								'type' => 'select',
								'value' => 'name',
								'choices' => array(
									'id' => esc_html__('ID', 'albedo'),
									'count' => esc_html__('Count', 'albedo'),
									'name' => esc_html__('Name', 'albedo'),
									'slug' => esc_html__('Slug', 'albedo'),
								),
							),
							'terms_sort_by' => array(
								'label' => esc_html__( 'Terms sorting method', 'albedo' ),
								'type' => 'select',
								'value' => 'DESC',
								'choices' => array(
									'DESC' => esc_html__('Descending', 'albedo'),
									'ASC' => esc_html__('Ascending', 'albedo'),
								),
							),

						)
					)
				),

			)
		),
		'animation-settings' => array(
			'title' => esc_html__( 'Animation', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'effect' => array(
					'label' => esc_html__( 'Loading / filter effect', 'albedo' ),
					'type' => 'select',
					'value' => 'effect-1',
					'choices' => array(
						'effect-1' => esc_html__('Fade', 'albedo'),
						'effect-2' => esc_html__('Move Up', 'albedo'),
						'effect-3' => esc_html__('Scale up', 'albedo'),
						'effect-4' => esc_html__('Fall perspective', 'albedo'),
						'effect-5' => esc_html__('Fly', 'albedo'),
						'effect-6' => esc_html__('Calendar', 'albedo'),
						'effect-7' => esc_html__('Helix', 'albedo'),
						'effect-8' => esc_html__('Flip', 'albedo'),
					),
				),
				'animate_on_hover' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Animate elements on mouse hover', 'albedo' ),
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
							'value' => 'no',
						)
					),
					'choices' => array(
						'yes' => array(

							'animation_effect' => array(
								'label' => esc_html__( 'Animation Effect', 'albedo' ),
								'type' => 'select',
								'choices' => $wplab_albedo_core->cfg['animations'],
								'value' => 'zoomIn',
							),

						)
					)
				),

			)
		),
	)

);
