<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

global $wplab_albedo_core;

$options = array(
	array(
		'id' => array( 'type' => 'unique' ),
		'attributes' => array(
			'title' => esc_html__( 'Video', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'video' => array(
					'type'  => 'text',
					'label' => esc_html__( 'Paste here video URL (YouTube or Vimeo videos)', 'albedo' ),
				),
				'image' => array(
					'type'  => 'upload',
					'label' => esc_html__( 'Video poster image', 'albedo' ),
					'desc'  => esc_html__( 'Either upload a new, or choose an existing image from your media library.', 'albedo' )
				),
				'alt'  => array(
					'type'  => 'text',
					'label' => esc_html__( 'Alternate Text / Description', 'albedo' ),
				),
				'size' => array(
					'type'    => 'group',
					'options' => array(
						'width'  => array(
							'type'  => 'text',
							'label' => esc_html__( 'Poster Width', 'albedo' ),
							'desc'  => esc_html__( 'Set image width (optional)', 'albedo' )
						),
						'height' => array(
							'type'  => 'text',
							'label' => esc_html__( 'Poster Height', 'albedo' ),
							'desc'  => esc_html__( 'Set image height (optional)', 'albedo' )
						)
					)
				),
				'video_style' => array(
					'label' => esc_html__( 'Video Style', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'' => esc_html__( 'Default / custom effects', 'albedo' ),
						'boxed' => esc_html__( 'Boxed style', 'albedo' ),
						'boxed_rounded' => esc_html__( 'Boxed, rounded corners', 'albedo' ),
						'polaroid' => esc_html__( 'Polaroid', 'albedo' ),
					),
				),
				'hover_effects' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Add hover effect?', 'albedo' ),
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

							'effect' => array(
								'label' => esc_html__( 'Image Effect', 'albedo' ),
								'type' => 'select',
								'value' => 'lily',
								'choices' => $wplab_albedo_core->cfg['overlay_effects'],
							),

						)
					),
				),

			)
		),
		'video_settings' => array(
			'title' => esc_html__( 'Options', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'lazy_load' => array(
					'type'         => 'switch',
					'label'        => esc_html__( 'Lazy Load', 'albedo' ),
					'desc'         => esc_html__( 'If enabled, poster image will be loaded via JavaScript to increase page loading speed', 'albedo' ),
					'value'				 => 'no',
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Enabled', 'albedo' ),
					),
					'left-choice'  => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'Disabled', 'albedo' ),
					),
				),
			)
		),
		'styling' => array(
			'title' => esc_html__( 'Styling', 'albedo' ),
			'type' => 'tab',
			'options' => array(

				'video_align' => array(
					'label' => esc_html__( 'Video Align', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'' => esc_html__( 'Default', 'albedo' ),
						'alignleft' => esc_html__( 'Left', 'albedo' ),
						'aligncenter' => esc_html__( 'Center', 'albedo' ),
						'alignright' => esc_html__( 'Right', 'albedo' ),
					),
				),
				'animation' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Animate video container', 'albedo' ),
							'desc' => esc_html__('Using CSS animation', 'albedo'),
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

							'effect' => array(
								'label' => esc_html__( 'Choose animation effect', 'albedo' ),
								'type' => 'select',
								'value' => '',
								'choices' => array(
									array (
										'attr' => array(
											'label' => esc_html__( 'Animate.css Library', 'albedo' ),
										),
										'choices' => $wplab_albedo_core->cfg['animations'],
									),
								),
							),

							'animation_delay' => array(
								'label' => esc_html__('Animation delay', 'albedo'),
								'desc' => esc_html__('For example: 0.3s', 'albedo'),
								'type' => 'text',
							),

						),
					),
					'show_borders' => false,
				),
				'margins' => array(
					'label' => esc_html__( 'Video Margins', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'paddings' => array(
					'label' => esc_html__( 'Video Paddings', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'border_color' => array(
					'label' => esc_html__('Border Color', 'albedo'),
					'type' => 'color-picker',
				),
				'border_style' => array(
					'label' => esc_html__( 'Border Style', 'albedo' ),
					'type' => 'select',
					'value' => '',
					'choices' => array(
						'none' => esc_html__( 'None', 'albedo' ),
						'hidden' => esc_html__( 'Hidden', 'albedo' ),
						'dotted' => esc_html__( 'Dotted', 'albedo' ),
						'dashed' => esc_html__( 'Dashed', 'albedo' ),
						'solid' => esc_html__( 'Solid', 'albedo' ),
						'double' => esc_html__( 'Double', 'albedo' ),
						'groove' => esc_html__( 'Groove', 'albedo' ),
						'ridge' => esc_html__( 'Ridge', 'albedo' ),
					),
				),
				'border_width' => array(
					'label' => esc_html__( 'Border width', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
				),
				'border_radius' => array(
					'label' => esc_html__( 'Border radius', 'albedo' ),
					'type' => 'stylebox',
					'value' => '',
					'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top left, top right, bottom right, bottom left', 'albedo' ),
				),

				'css_shadow' => array(
					'type' => 'multi-picker',
					'label' => false,
					'desc' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Add CSS shadow', 'albedo' ),
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

							'shadow_color' => array(
								'label' => esc_html__('Shadow Color', 'albedo'),
								'type' => 'color-picker',
							),
							'shadow_type' => array(
								'label' => esc_html__( 'Position', 'albedo' ),
								'type' => 'switch',
								'right-choice' => array(
									'value' => 'outside',
									'label' => esc_html__( 'Outside', 'albedo' )
								),
								'left-choice' => array(
									'value' => 'inside',
									'label' => esc_html__( 'Inside', 'albedo' )
								),
								'value' => 'outside',
							),
							'shadow_blur_radius' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => 0,
									'max' => 300,
								),
								'label' => esc_html__( 'Blur Radius', 'albedo' ),
							),
							'shadow_spread_radius' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Spread Radius', 'albedo' ),
							),
							'shadow_horizontal_length' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Horizontal Length', 'albedo' ),
							),
							'shadow_vertical_length' => array(
								'type'  => 'slider',
								'value' => 0,
								'properties' => array(
									'min' => -200,
									'max' => 200,
								),
								'label' => esc_html__( 'Vertical Length', 'albedo' ),
							),

						),
					)
				),
			)
		)
	)
);
