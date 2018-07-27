<?php

/**
 * Page options array
 **/
$options = array(
	'header_settings' => array(
		'title'   => esc_html__( 'Page Header Settings', 'albedo' ),
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
			'one_page_menu' => array(
				'label' => esc_html__( 'Enable One-Page Menu', 'albedo' ),
				'desc' => esc_html__( 'This option replaces default Header Menu with One Page Menu and enables One-Page navigation', 'albedo' ),
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
			),
			'slider_header_mode' => array(
				'label' => esc_html__( 'Slider Header Mode', 'albedo' ),
				'desc' => esc_html__( 'Can be useful for Home Page, e.g. for Full Screen Slider. This option makes Header Menu transparent and removes sub-header elements, including Breadcrumbs etc. Only Logo and Header Menu will be visible. Header will have absolute position.', 'albedo' ),
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
			),
			'hide_header_title' => array(
				'label' => esc_html__( 'Hide Header Page Title Block', 'albedo' ),
				'desc' => esc_html__( 'this option removes Header Page Title Block from current page only', 'albedo' ),
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
			'hide_header_second_menu' => array(
				'label' => esc_html__( 'Hide Header Second Menu', 'albedo' ),
				'desc' => esc_html__( 'this option removes Second Menu Block from current page only', 'albedo' ),
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
			'hide_header_breadcrumbs' => array(
				'label' => esc_html__( 'Hide Header Breadcrumbs Block', 'albedo' ),
				'desc' => esc_html__( 'this option removes Breadcrumbs Block from current page only', 'albedo' ),
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
			'page_custom_logo' => array(
				'type' => 'multi-picker',
				'label' => false,
				'picker' => array(
					'enabled' => array(
						'label' => esc_html__( 'Use custom logo image', 'albedo' ),
						'desc' => esc_html__( 'If enabled, a logo image from global settings will be replaced with custom logo for this page only', 'albedo' ),
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

						'header_logo_image' => array(
							'label' => esc_html__( 'Logo image', 'albedo' ),
							'type' => 'upload',
							'images_only' => true,
						),
						'header_logo_image_2x' => array(
							'label' => esc_html__( 'Logo image for Retina / HDPI displays', 'albedo' ),
							'desc' => esc_html__( 'For example, if your normal logo has 150x75 size, upload 300x150 image', 'albedo' ),
							'type' => 'upload',
							'images_only' => true,
						),
						'header_logo_width' => array(
							'label' => esc_html__( 'Logo Width', 'albedo' ),
							'type' => 'short-text',
							'value' => '',
							'desc' => esc_html__( 'value in pixels', 'albedo' ),
							'help' => esc_html__( 'Type here your image logo width in pixels, e.g.: 150. This value will be used to calculate correct size for Retina / HDPI Displays.', 'albedo' ),
						),
						'header_logo_height' => array(
							'label' => esc_html__( 'Logo Height', 'albedo' ),
							'type' => 'short-text',
							'value' => '',
							'desc' => esc_html__( 'value in pixels', 'albedo' ),
							'help' => esc_html__( 'Type here your image logo height in pixels, e.g.: 75. This value will be used to calculate correct size for Retina / HDPI Displays.', 'albedo' ),
						),
						'header_logo_margins' => array(
							'label' => esc_html__( 'Logo Margins', 'albedo' ),
							'type' => 'stylebox',
							'value' => '',
							'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
						),
						'header_logo_transp_image' => array(
							'label' => esc_html__( 'Logo image (for transparent header)', 'albedo' ),
							'type' => 'upload',
							'images_only' => true,
						),
						'header_logo_transp_image_2x' => array(
							'label' => esc_html__( 'HDPI / Retina Logo image (for transparent header)', 'albedo' ),
							'type' => 'upload',
							'images_only' => true,
						),
						'header_logo_transp_width' => array(
							'label' => esc_html__( 'Logo Width (for Transparent Header)', 'albedo' ),
							'type' => 'short-text',
							'value' => '',
							'desc' => esc_html__( 'value in pixels', 'albedo' ),
							'help' => esc_html__( 'Type here your image logo width in pixels, e.g.: 150. This value will be used to calculate correct size for Retina / HDPI Displays.', 'albedo' ),
						),
						'header_logo_transp_height' => array(
							'label' => esc_html__( 'Logo Height (for Transparent Header)', 'albedo' ),
							'type' => 'short-text',
							'value' => '',
							'desc' => esc_html__( 'value in pixels', 'albedo' ),
							'help' => esc_html__( 'Type here your image logo height in pixels, e.g.: 75. This value will be used to calculate correct size for Retina / HDPI Displays.', 'albedo' ),
						),
						'header_logo_transp_margins' => array(
							'label' => esc_html__( 'Logo Margins (for Transparent Header)', 'albedo' ),
							'type' => 'stylebox',
							'value' => '',
							'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
						),

					)
				)
			),
		)
	),
	'body_settings' => array(
		'title'   => esc_html__( 'Page Body Settings', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'page_body_bg_color' => array(
				'label' => esc_html__('Body background color', 'albedo'),
				'desc' => esc_html__('Select the custom background color for this page or leave this field blank to use global settings.', 'albedo'),
				'value' => '',
				'type' => 'color-picker',
			),

		)
	),
	'footer_settings' => array(
		'title'   => esc_html__( 'Page Footer Settings', 'albedo' ),
		'type'    => 'box',
		'options' => array(

			'slider_footer_mode' => array(
				'label' => esc_html__( 'Slider Footer Mode', 'albedo' ),
				'desc' => esc_html__( 'This option makes footer transparent and fixed position. Can be used on full-screen websites.', 'albedo' ),
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
			),

		)
	),
);
