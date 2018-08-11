<?php

/**
 * Post options array
 **/
$options = array(
	'general' => array(
		'title'   => esc_html__( 'Post Settings', 'albedo' ),
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
				'type' => 'text',
				'value' => get_post_meta( 'likes', true ),
				'save-in-separate-meta' => true,
			),
			**/

		)
	),
	'header' => array(
		'title'   => esc_html__( 'Post Header Settings', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'page_header_bg' => array(
				'label' => esc_html__( 'Header Background image', 'albedo' ),
				'desc' => esc_html__( 'It can be chaged individually for each post or page', 'albedo' ),
				'type' => 'upload',
				'images_only' => true,
			),
			'page_header_description' => array(
				'type'  => 'textarea',
				'label' => esc_html__( 'Page description', 'albedo'),
				'desc' => esc_html__( 'this text will be displayed after page header title, if header layout supports this feature', 'albedo' )
			),
		),
	),
	'appearance' => array(
		'title'   => esc_html__( 'Post Appearance Settings', 'albedo' ),
		'type'    => 'box',
		'options' => array(
			'display_video_before_content' => array(
				'type' => 'multi-picker',
				'label' => false,
				'picker' => array(
					'enabled' => array(
						'label' => esc_html__( 'Display a video before post content', 'albedo' ),
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

						'video_url' => array(
							'label' => esc_html__( 'Video URL', 'albedo' ),
							'type' => 'text',
							'value' => '',
						),
						'video_poster' => array(
							'label' => esc_html__( 'Custom video poster', 'albedo' ),
							'type' => 'upload',
							'images_only' => true,
						),

					)
				)
			),

			'display_gallery_instead_thumb' => array(
				'type' => 'multi-picker',
				'label' => false,
				'picker' => array(
					'enabled' => array(
						'label' => esc_html__( 'Display gallery instead of post thumbnail', 'albedo' ),
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

						'gallery_images' => array(
							'label' => esc_html__( 'Gallery Images', 'albedo' ),
							'type' => 'multi-upload',
							'images_only' => true,
						),

					)
				)
			),
		)
	),
);
