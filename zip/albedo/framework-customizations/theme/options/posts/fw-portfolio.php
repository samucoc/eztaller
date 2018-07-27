<?php
global $wplab_albedo_core;
/**
 * Portfolio single options array
 **/
$options = array(
	'details' => array(
		'title'   => esc_html__( 'Project Details', 'albedo' ),
		'type'    => 'box',
		'options' => array(
			'client_name' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Client name', 'albedo'),
				'desc' => esc_html__( 'this text will be displayed in project description', 'albedo' )
			),
			'project_url' => array(
				'type'  => 'text',
				'label' => esc_html__( 'Project URL', 'albedo'),
				'desc' => esc_html__( 'this text will be displayed in project details', 'albedo' )
			),
			'single_button' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'picker' => array(

					'enabled' => array(
						'label' => esc_html__( 'Display a button', 'albedo' ),
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

						'button_text' => array(
							'type'  => 'text',
							'label' => esc_html__('Button Text', 'albedo'),
							'value' => esc_html__('Download', 'albedo'),
						),
						'button_url' => array(
							'type'  => 'text',
							'label' => esc_html__('Button URL', 'albedo'),
							'value' => '',
						),
						'button_style'  => array(
							'label'   => esc_html__( 'Button Style', 'albedo' ),
							'type'    => 'select',
							'value' 	=> 'green',
							'choices' => $wplab_albedo_core->cfg['button_styles']
						),

					)
				)
			),
		)
	),
	'appearance' => array(
		'title'   => esc_html__( 'Project Appearance', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'single_post_layout' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'picker' => array(

					'type' => array(
						'label' => esc_html__( 'Single post layout', 'albedo' ),
						'type' => 'select',
						'value' => 'custom',
						'choices' => array(
							'custom' => esc_html__('Default / Custom (can be built using Page Builder)', 'albedo'),
							'predefined' => esc_html__('Choose from predefined layouts...', 'albedo'),
						),
					),

			),
			'choices' => array(
				'predefined' => array(

					'layout' => array(
						'type'  => 'image-picker',
						'value' => '',
						'label' => esc_html__('Choose Post Layout', 'albedo'),
						'choices' => array(
							'layout_1' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_1.jpg',
							'layout_2' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_2.jpg',
							'layout_3' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_3.jpg',
							'layout_4' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_4.jpg',
							'layout_5' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_5.jpg',
							'layout_6' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_6.jpg',
							'layout_7' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_7.jpg',
							'layout_8' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_8.jpg',
							'layout_9' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_9.jpg',
							'layout_10' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_10.jpg',
							'layout_11' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_11.jpg',
							'layout_12' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_12.jpg',
							'layout_13' => get_template_directory_uri() .'/images/portfolio_single_layouts/layout_13.jpg',
						),
						'blank' => false,
					),

				)
			)
		),
		'page_header_bg' => array(
			'label' => esc_html__( 'Custom Header Background image', 'albedo' ),
			'desc' => esc_html__( 'It can be chaged individually for each post', 'albedo' ),
			'type' => 'upload',
			'images_only' => true,
		),
		'page_header_description' => array(
			'type'  => 'textarea',
			'label' => esc_html__( 'Page description', 'albedo'),
			'desc' => esc_html__( 'this text will be displayed after page header title, if header layout supports this feature', 'albedo' )
		),
		'text_align' => array(
			'label' => esc_html__( 'Text align', 'albedo' ),
			'type' => 'select',
			'value' => '',
			'choices' => array(
				'default' => esc_html__('Default', 'albedo'),
				'centered' => esc_html__('Centered', 'albedo'),
			),
		),
	)
),
'side' => array(
	'title'   => esc_html__( 'Project Options', 'albedo' ),
	'type'    => 'box',
	'context' => 'side',
	'options' => array(

		'featured' => array(
			'label' => esc_html__( 'This post is featured', 'albedo' ),
			'type' => 'switch',
			'fw-storage' => array(
				'type' => 'post-meta',
				'post-meta' => 'featured',
			),
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

		/**
		'likes' => array(
			'label' => esc_html__( 'Likes count', 'albedo' ),
			'type' => 'short-text',
			'value' => '',
			'save-in-separate-meta' => true,
		),
		**/

		)
	)
);
