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

				'post_format' => array(
					'label' => esc_html__( 'Post format', 'albedo' ),
					'type' => 'select',
					'value' => 'standard',
					'choices' => array(
						'standard' => esc_html__('Standard', 'albedo' ),
						'audio' => esc_html__('Audio', 'albedo' ),
						'video' => esc_html__('Video', 'albedo' ),
						'gallery' => esc_html__('Gallery', 'albedo' ),
						'quote' => esc_html__('Quote', 'albedo' ),
						'link' => esc_html__('Link', 'albedo' ),
					),
				),
				'order_by' => array(
					'label' => esc_html__( 'Query ordering method', 'albedo' ),
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
					'label' => esc_html__( 'Query sorting method', 'albedo' ),
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
					'label' => esc_html__( 'Featured post only', 'albedo' ),
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
		'appearance_tab' => array(
			'title' => esc_html__( 'Appearance', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'display_thumb' => array(
					'label' => esc_html__( 'Display post thumbnail', 'albedo' ),
					'desc' => esc_html__( 'only for standard post type', 'albedo' ),
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
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Display post excerpt', 'albedo' ),
							'type' => 'switch',
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Yes', 'albedo' )
							),
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'No', 'albedo' )
							),
							'value' => 'no',
						)
					),
					'choices' => array(
						'yes' => array(
							'excerpt_length' => array(
								'label' => esc_html__( 'Excerpt lenght', 'albedo' ),
								'desc' => esc_html__( 'how many words should we display?', 'albedo' ),
								'type' => 'short-text',
								'value' => '13'
							),
						)
					)
				),
				'display_date' => array(
					'label' => esc_html__( 'Display post date', 'albedo' ),
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
				'display_author' => array(
					'label' => esc_html__( 'Display post author', 'albedo' ),
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

				'display_shadow' => array(
					'label' => esc_html__( 'Display shadow', 'albedo' ),
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
				'overlay_color' => array(
					'label' => esc_html__( 'Overlay color', 'albedo' ),
					'type' => 'select',
					'value' => 'blue',
					'choices' => $wplab_albedo_core->cfg['base_colors'],
				),
				'text_align' => array(
					'label' => esc_html__( 'Text align', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'default' => esc_html__('Default', 'albedo' ),
						'left' => esc_html__('Left', 'albedo' ),
						'center' => esc_html__('Center', 'albedo' ),
						'right' => esc_html__('Right', 'albedo' ),
					),
				),
				'custom_radius' => array(
					'label' => esc_html__( 'Custom radius for posts', 'albedo' ),
					'desc' => esc_html__( 'value in pixels, e.g.: 30', 'albedo' ),
					'type' => 'short-text',
					'value' => ''
				),
				'custom_paddings' => array(
					'label' => esc_html__( 'Custom paddings', 'albedo' ),
					'desc' => esc_html__( 'value in pixels, e.g.: 60', 'albedo' ),
					'type' => 'short-text',
					'value' => ''
				),
				'height' => array(
					'label' => esc_html__( 'Block height', 'albedo' ),
					'desc' => esc_html__( 'value in pixels, e.g.: 30', 'albedo' ),
					'type' => 'short-text',
					'value' => '450'
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
