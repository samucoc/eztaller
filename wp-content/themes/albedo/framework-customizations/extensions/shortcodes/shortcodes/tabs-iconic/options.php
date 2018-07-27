<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(
	array(
		'general' => array(
			'title' => esc_html__( 'General', 'albedo' ),
			'type' => 'tab',
			'options' => array(
				'tabs' => array(
					'type'          => 'addable-popup',
					'label'         => esc_html__( 'Tabs', 'albedo' ),
					'popup-title'   => esc_html__( 'Add/Edit Tab', 'albedo' ),
					'desc'          => esc_html__( 'Create your tabs', 'albedo' ),
					'template'      => '{{=tab_title}}',
					'size' 					=> 'large',
					'popup-options' => array(
						'tab_title' => array(
							'type'  => 'text',
							'label' => esc_html__('Title', 'albedo')
						),
						'tab_content' => array(
							'type'  => 'wp-editor',
							'label' => esc_html__('Content', 'albedo'),
							'reinit' => true,
							'size' => 'large',
							'shortcodes' => true,
						),
						'icon_type' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'value' => array(
								'tab_icon' => 'custom',
							),
							'picker' => array(
								'tab_icon' => array(
									'label' => esc_html__( 'Tab icon', 'albedo' ),
									'type' => 'radio',
									'choices' => array(
										'fontawesome' => esc_html__( 'Choose an icon from Icon Library', 'albedo' ),
										'custom' => esc_html__( 'Upload custom Image icon', 'albedo' ),
									),
								)
							),
							'choices' => array(
								'fontawesome' => array(

									'icon' => array(
										'type' => 'icon',
										'label' => esc_html__( 'Icon', 'albedo' )
									),

								),
								'custom' => array(

									'icon' => array(
										'type'  => 'upload',
										'label' => esc_html__('Upload icon file', 'albedo'),
										'images_only' => true,
									),

								),
							)
						),
						'tab_image' => array(
							'type'  => 'upload',
							'label' => esc_html__( 'Tab Image', 'albedo' ),
							'desc'  => esc_html__( 'Can be applied for Modern Styles only. Either upload a new, or choose an existing image from your media library.', 'albedo' )
						),
						'tab_image_width' => array(
							'label' => esc_html__('Image width', 'albedo'),
							'desc' => esc_html__('Value in pixels, for example: 400', 'albedo'),
							'type' => 'short-text',
						),
						'tab_image_height' => array(
							'label' => esc_html__('Image height', 'albedo'),
							'desc' => esc_html__('Value in pixels, for example: 400', 'albedo'),
							'type' => 'short-text',
						),
					),
				),
				'responsive_break' => array(
					'label' => esc_html__('Responsive at', 'albedo'),
					'desc' => esc_html__('For example: 767. If screen size will be less than this number, tabs will be turned into small screen mode', 'albedo'),
					'type' => 'text',
				),
			)
		),
		'animation-settings' => array(
			'title' => esc_html__( 'Animation', 'albedo' ),
			'type' => 'tab',
			'options' => array(

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
