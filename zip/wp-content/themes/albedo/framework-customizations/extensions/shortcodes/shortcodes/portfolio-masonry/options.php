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
								'value' => 'minimal',
								'choices' => array(
									'minimal' => esc_html__( 'Minimal', 'albedo'),
									'minimal_alt' => esc_html__( 'Minimal (alt style)', 'albedo'),
									'minimal_third' => esc_html__( 'Minimal (third style)', 'albedo'),
									'active_button' => esc_html__( 'Active Button', 'albedo'),
								),
							),
							'filters_align' => array(
								'label' => esc_html__( 'Filters align', 'albedo' ),
								'type' => 'radio',
								'value' => 'center',
								'choices' => array(
									'center' => esc_html__( 'Center', 'albedo'),
									'default' => esc_html__( 'Default', 'albedo'),
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
		'appearance_tab' => array(
			'title' => esc_html__( 'Appearance', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'effect' => array(
					'label' => esc_html__( 'Loading effect', 'albedo' ),
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
				'large_screen_cols' => array(
					'label' => esc_html__( 'Large screen columns', 'albedo' ),
					'type' => 'select',
					'value' => '3',
					'choices' => array(
						'4' => '4',
						'3' => '3',
						'2' => '2',
						'1' => '1',
					),
				),
				'medium_screen_cols' => array(
					'label' => esc_html__( 'Medium screen columns', 'albedo' ),
					'type' => 'select',
					'value' => '2',
					'choices' => array(
						'4' => '4',
						'3' => '3',
						'2' => '2',
						'1' => '1',
					),
				),
				'small_screen_cols' => array(
					'label' => esc_html__( 'Small screen columns', 'albedo' ),
					'type' => 'select',
					'value' => '1',
					'choices' => array(
						'4' => '4',
						'3' => '3',
						'2' => '2',
						'1' => '1',
					),
				),
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
				'project_url_as_link' => array(
					'label' => esc_html__( 'Use Project URL instead of link to the post', 'albedo' ),
					'type' => 'switch',
					'value' => 'no',
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
				'display_link_icon' => array(
					'label' => esc_html__( 'Display link icon', 'albedo' ),
					'type' => 'switch',
					'value' => 'no',
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
				'display_hover_likes' => array(
					'label' => esc_html__( 'Display post likes', 'albedo' ),
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
				'desc_position' => array(
					'label' => esc_html__( 'Post description position', 'albedo' ),
					'type' => 'select',
					'value' => 'yes',
					'choices' => array(
						'bottom' => esc_html__('Bottom', 'albedo'),
						'center' => esc_html__('Center', 'albedo'),
						'top' => esc_html__('Top', 'albedo'),
					),
				),
				'overlay_color' => array(
					'label' => esc_html__( 'Overlay color', 'albedo' ),
					'type' => 'select',
					'choices' => $wplab_albedo_core->cfg['base_colors'],
				),
				'display_shadow' => array(
					'label' => esc_html__( 'Display shadow?', 'albedo' ),
					'type' => 'switch',
					'value' => 'no',
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
				'display_layers' => array(
					'label' => esc_html__( 'Display decoration layers?', 'albedo' ),
					'type' => 'switch',
					'value' => 'no',
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
				'custom_radius' => array(
					'label' => esc_html__( 'Custom radius for thumbnails', 'albedo' ),
					'desc' => esc_html__( 'value in pixels, e.g.: 30', 'albedo' ),
					'type' => 'short-text',
					'value' => ''
				),
				'grid_margins' => array(
					'label' => esc_html__( 'Grid margins', 'albedo' ),
					'desc' => esc_html__( 'value in pixels, e.g.: 40. This options sets margins between thumbnails', 'albedo' ),
					'type' => 'short-text',
					'value' => ''
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
				'filters_link_color' => array(
					'label' => esc_html__('Filters link color', 'albedo'),
					'desc' => esc_html__('Here you can change default color for filter link', 'albedo'),
					'type' => 'color-picker',
				),
				'filters_link_active_color' => array(
					'label' => esc_html__('Filters active / hover link color', 'albedo'),
					'type' => 'color-picker',
				),
				'filters_separator_color' => array(
					'label' => esc_html__('Filters separator color', 'albedo'),
					'type' => 'color-picker',
				),
				'bg_layer1_color' => array(
					'label' => esc_html__('Background layer 1 color', 'albedo'),
					'type' => 'rgba-color-picker',
				),
				'bg_layer2_color' => array(
					'label' => esc_html__('Background layer 2 color', 'albedo'),
					'type' => 'rgba-color-picker',
				),
			)
		),
	)

);
