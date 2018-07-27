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
				'featured_only' => array(
					'label' => esc_html__( 'Featured posts only', 'albedo' ),
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
			)
		),
		'carousel' => array(
			'title' => esc_html__( 'Carousel', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'initial_slide' => array(
					'label' => esc_html__( 'Initial slide', 'albedo' ),
					'type' => 'short-text',
					'value' => '0'
				),
				'slides_num' => array(
					'label' => esc_html__( 'Slides number for large screens', 'albedo' ),
					'type' => 'short-text',
					'value' => '3'
				),
				'slides_num_small' => array(
					'label' => esc_html__( 'Slides number for small screens', 'albedo' ),
					'type' => 'short-text',
					'value' => '1'
				),
				'display_title' => array(
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
				'display_excerpt' => array(
					'label' => esc_html__( 'Display post excerpt', 'albedo' ),
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
				'display_cats' => array(
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
				'display_lightbox_icon' => array(
					'label' => esc_html__( 'Display lightbox icon', 'albedo' ),
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
				'display_likes' => array(
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
				'pagination' => array(
					'label' => esc_html__( 'Pagination', 'albedo' ),
					'type' => 'switch',
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'Disabled', 'albedo' )
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Enabled', 'albedo' )
					),
					'value' => 'yes',
				),
				'autoplay' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Autoplay', 'albedo' ),
							'type' => 'switch',
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'Disabled', 'albedo' )
							),
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Enabled', 'albedo' )
							),
							'value' => 'no',
						)
					),
					'choices' => array(
						'yes' => array(
							'autoplay_speed' => array(
								'type'  => 'text',
								'value' => '2000',
								'label' => esc_html__('Autoplay speed', 'albedo'),
								'desc'  => esc_html__('in milliseconds, e.g.: 2000 = 2 seconds', 'albedo'),
							),
							'autoplay_stop_on_last' => array(
								'label' => esc_html__( 'Stop on last slide', 'albedo' ),
								'desc' => esc_html__( 'Enable this parameter and autoplay will be stopped when it reaches last slide (has no effect in loop mode)', 'albedo' ),
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
							),
							'autoplay_disable_on_interaction' => array(
								'label' => esc_html__( 'Disable autoplay on iteration', 'albedo' ),
								'desc' => esc_html__( 'Set to false and autoplay will not be disabled after user interactions, it will be restarted every time after interaction', 'albedo' ),
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
						)
					)
				),
				'display_button' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Display button', 'albedo' ),
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

							'button_text' => array(
								'type'  => 'text',
								'label' => esc_html__('Button text', 'albedo'),
								'value' => esc_html__('ALL WORKS', 'albedo'),
							),
							'button_link' => array(
								'type'  => 'text',
								'label' => esc_html__('Button link', 'albedo'),
								'value' => '',
							),
							'button_style'  => array(
								'label'   => esc_html__( 'Button Style', 'albedo' ),
								'desc'    => esc_html__( 'Here you can choose pre-defined styles for a button', 'albedo' ),
								'type'    => 'select',
								'choices' => $wplab_albedo_core->cfg['button_styles']
							),

						)
					)
				),

			)
		),
		'style' => array(
			'title' => esc_html__( 'Style', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'overlay_color' => array(
					'label' => esc_html__( 'Overlay color', 'albedo' ),
					'type' => 'select',
					'value' => 'grey',
					'choices' => $wplab_albedo_core->cfg['base_colors'],
				),
				'display_shadow' => array(
					'label' => esc_html__( 'Display shadow?', 'albedo' ),
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
