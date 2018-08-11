<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

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
						'tab_icon' => array(
							'type' => 'icon-v2',
							'label' => esc_html__( 'Tab Icon', 'albedo' )
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
				'tabs_style' => array(
					'label' => esc_html__( 'Tabs style', 'albedo' ),
					'type' => 'select',
					'value' => 'simple',
					'choices' => array(
						'simple' => esc_html__( 'Simple', 'albedo' ),
						'modern' => esc_html__( 'Modern', 'albedo' ),
						'modern_alt' => esc_html__( 'Modern Alternate', 'albedo' ),
					),
				),
				'tabs_type' => array(
					'label' => esc_html__( 'Tabs type', 'albedo' ),
					'type' => 'select',
					'value' => 'horizontal',
					'choices' => array(
						'horizontal' => esc_html__( 'Horizontal', 'albedo' ),
						'vertical' => esc_html__( 'Vertical', 'albedo' ),
					),
				),
				'display_title' => array(
					'type'         => 'switch',
					'label'        => esc_html__( 'Display tab title within Content', 'albedo' ),
					'desc'         => esc_html__( 'If enabled, tab title will be duplicated in Tab Content area', 'albedo' ),
					'value'				 => 'yes',
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' ),
					),
					'left-choice'  => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' ),
					),
				),
				'responsive_break' => array(
					'label' => esc_html__('Responsive at', 'albedo'),
					'desc' => esc_html__('For example: 767. If screen size will be less than this number, tabs will be turned into small screen mode', 'albedo'),
					'type' => 'text',
				),
			)
		),
	)

);
