<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'general' => array(
			'title' => esc_html__( 'General', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'items' => array(
					'type'          => 'addable-popup',
					'label'         => esc_html__( 'Testimonials', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Testimonial', 'albedo' ),
					'desc'          => esc_html__( 'Create your testimonials', 'albedo' ),
					'template'      => '{{=author}}',
					'popup-options' => array(
						'text' => array(
							'type'  => 'textarea',
							'label' => esc_html__('Text', 'albedo')
						),
						'author' => array(
							'type'  => 'text',
							'label' => esc_html__('Author', 'albedo')
						),
						'position' => array(
							'type'  => 'text',
							'label' => esc_html__('Position', 'albedo')
						),
						'photo' => array(
							'type'  => 'upload',
							'label' => esc_html__('Upload photo', 'albedo'),
							'images_only' => true,
						),
						'photo_bg' => array(
							'type'  => 'upload',
							'label' => esc_html__('Upload background photo', 'albedo'),
							'desc' => esc_html__('For Gradient Testimonials style', 'albedo'),
							'images_only' => true,
						),
					),
				),
				'element_style' => array(
					'type' => 'multi-picker',
					'show_borders' => false,
					'label' => false,
					'desc' => false,
					'value' => array(
						'style' => 'default',
					),
					'picker' => array(
						'style' => array(
							'label' => esc_html__( 'Element style', 'albedo' ),
							'type' => 'select',
							'value' => 'default',
							'choices' => array(
								'default' => esc_html__( 'Default (photo + quote + author)', 'albedo' ),
								'parallax' => esc_html__( 'Parallax background', 'albedo' ),
								'gradient' => esc_html__( 'Gradient', 'albedo' ),
								'simple_photo' => esc_html__( 'Simple + photo', 'albedo' ),
							),
						)
					),
					'choices' => array(

						'default' => array(

							'photo_width' => array(
								'label' => esc_html__( 'Photo width', 'albedo' ),
								'desc' => esc_html__( 'Value in pixels. Photo will be cropped in width by this value.', 'albedo' ),
								'type' => 'short-text',
								'value' => '390',
							),
							'photo_height' => array(
								'label' => esc_html__( 'Photo height', 'albedo' ),
								'desc' => esc_html__( 'Value in pixels. Photo will be cropped in height by this value.', 'albedo' ),
								'type' => 'short-text',
								'value' => '235',
							),
							'author_color' => array(
								'label' => esc_html__('Custom author text color', 'albedo'),
								'value' => '',
								'type' => 'color-picker',
							),
							'position_color' => array(
								'label' => esc_html__('Custom position text color', 'albedo'),
								'value' => '',
								'type' => 'color-picker',
							),

						),

						'parallax' => array(

							'parallax_bg' => array(
								'type'  => 'upload',
								'label' => esc_html__('Parallax background photo', 'albedo'),
								'images_only' => true,
							),
							'overlay_color' => array(
								'label' => esc_html__( 'Overlay color', 'albedo' ),
								'type' => 'select',
								'value' => 'blue',
								'choices' => $wplab_albedo_core->cfg['base_colors'],
							)

						),

						'gradient' => array(

							'gradient_color' => array(
								'label' => esc_html__( 'Gradient overlay color', 'albedo' ),
								'desc' => esc_html__( 'Gradients colors can be changed globally via Theme Options', 'albedo' ),
								'type' => 'select',
								'value' => 'violet',
								'choices' => array(
									'red' => esc_html__( 'Red', 'albedo' ),
									'violet' => esc_html__( 'Violet', 'albedo' ),
									'turquoise' => esc_html__( 'Turquoise', 'albedo' ),
									'blue' => esc_html__( 'Blue', 'albedo' ),
									'grey' => esc_html__( 'Grey', 'albedo' ),
									'orange' => esc_html__( 'Orange', 'albedo' ),
									'green' => esc_html__( 'Green', 'albedo' ),
									'purple' => esc_html__( 'Purple', 'albedo' ),
								),
							)

						),

					)
				),
				'custom_font_family' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Custom font family', 'albedo' ),
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

							'font_family' => array(
								'type' => 'typography',
								'attr'  => array(
									'class' => 'wproto-hide-weight',
								),
								'value' => array(
									'family' => 'Arial',
								),
								'components' => array(
									'family' => true,
									'size'   => false,
									'color'  => false
								),
								'label' => esc_html__('Font family', 'albedo'),
							),

						),
					),
					'show_borders' => false,
				),
			)
		),
		'carousel-settings' => array(
			'title' => esc_html__( 'Carousel Settings', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'effect' => array(
					'label' => esc_html__( 'Carousel Effect', 'albedo' ),
					'type' => 'select',
					'value' => 'slide',
					'choices' => array(
						'slide' => esc_html__( 'Slide', 'albedo' ),
						'fade' => esc_html__( 'Fade', 'albedo' ),
						'cube' => esc_html__( 'Cube', 'albedo' ),
						'coverflow' => esc_html__( 'Coverflow', 'albedo' ),
						'flip' => esc_html__( 'Flip', 'albedo' ),
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
				'loop' => array(
					'label' => esc_html__( 'Loop slider', 'albedo' ),
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
		),
	)

);
