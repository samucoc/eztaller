<?php

global $wplab_albedo_core;
$settings_wp_option = 'fw_theme_settings_options:wplab-albedo';

// get all sidebars
global $wp_registered_sidebars;
$theme_sidebars = array();
foreach( $wp_registered_sidebars as $sidebar ):
	$theme_sidebars[ $sidebar['id'] ] = $sidebar['name'];
endforeach;

$options = array(
	'general' => array(
		'title' => esc_html__('General Style Options', 'albedo'),
		'type' => 'tab',
		'options' => array(

			'base' => array(
				'title' => esc_html__('General Style Options', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'prevent-auto-close'
				),
				'options' => array(

				'lazy_loading' => array(
					'label' => esc_html__( 'Lazy Loading for images', 'albedo' ),
					'desc' => esc_html__( 'Disabling this option may affect website loading speed', 'albedo' ),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'lazy_loading',
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'Disabled', 'albedo' )
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Enabled', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['lazy_loading'],
				),

				'css_animations_mobile' => array(
					'label' => esc_html__( 'CSS Animations for mobile devices', 'albedo' ),
					'desc' => esc_html__( 'Here you can disable animation for mobile devices only', 'albedo' ),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'css_animations_mobile',
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'Disabled', 'albedo' )
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Enabled', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['css_animations_mobile'],
				),

				'smooth_scrolling' => array(
					'label' => esc_html__( 'Smooth Scrolling', 'albedo' ),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'smooth_scrolling',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Enabled', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'Disabled', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['smooth_scrolling'],
					'desc' => esc_html__( 'If enabled, theme adds some beautiful delay when you scroll a website using a mouse scroller. May be useful for Parallax websites.', 'albedo' ),
				),

							'custom_scrollbar' => array(
					'label' => esc_html__( 'Custom scrollbar', 'albedo' ),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'custom_scrollbar',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Enabled', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'Disabled', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['custom_scrollbar'],
					'desc' => esc_html__( 'If enabled, default browser scrollbar will be replaced with the custom one', 'albedo' ),
				),

				'custom_inputs' => array(
					'label' => esc_html__( 'Use custom styles for inputs', 'albedo' ),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'custom_inputs',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['custom_inputs'],
					'desc' => esc_html__( 'If disabled, custom styles will be not applied for Checkboxes, Radios and Select form inputs', 'albedo' ),
				),

				)
			),

			'lightbox' => array(
				'title' => esc_html__('Lightbox', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

				'lightbox_effect' => array(
					'label' => esc_html__( 'Lightbox effect', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_options['lightbox_effect'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'lightbox_effect',
					),
					'choices' => array(
						'lg-slide' => esc_html__('Slide', 'albedo'),
						'lg-fade' => esc_html__('Fade', 'albedo'),
						'lg-zoom-in' => esc_html__('Zoom In', 'albedo'),
						'lg-zoom-in-big' => esc_html__('Zoom In Big', 'albedo'),
						'lg-zoom-out' => esc_html__('Zoom Out', 'albedo'),
						'lg-zoom-out-big' => esc_html__('Zoom Out Big', 'albedo'),
						'lg-zoom-out-in' => esc_html__('Zoom Out In', 'albedo'),
						'lg-zoom-in-out' => esc_html__('Zoom In Out', 'albedo'),
						'lg-soft-zoom' => esc_html__('Soft Zoom', 'albedo'),
						'lg-scale-up' => esc_html__('Scale Up', 'albedo'),
						'lg-slide-circular' => esc_html__('Slide circular', 'albedo'),
						'lg-slide-circular-vertical' => esc_html__('Slide circular vertical', 'albedo'),
						'lg-slide-vertical' => esc_html__('Slide vertical', 'albedo'),
						'lg-slide-vertical-growth' => esc_html__('Slide vertical growth', 'albedo'),
						'lg-slide-skew-only' => esc_html__('Slide skew only', 'albedo'),
						'lg-slide-skew-only-rev' => esc_html__('Slide skew rev only', 'albedo'),
						'lg-slide-skew-only-y' => esc_html__('Slide skew Y only', 'albedo'),
						'lg-slide-skew-only-y-rev' => esc_html__('Slide skew Y rev only', 'albedo'),
						'lg-slide-skew' => esc_html__('Slide skew', 'albedo'),
						'lg-slide-skew-rev' => esc_html__('Slide skew rev', 'albedo'),
						'lg-slide-skew-cross' => esc_html__('Slide skew cross', 'albedo'),
						'lg-slide-skew-cross-rev' => esc_html__('Slide skew cross rev', 'albedo'),
						'lg-slide-skew-ver' => esc_html__('Slide skew ver', 'albedo'),
						'lg-slide-skew-ver-rev' => esc_html__('Slide skew ver rev', 'albedo'),
						'lg-slide-skew-ver-cross' => esc_html__('Slide skew ver cross', 'albedo'),
						'lg-slide-skew-ver-cross-rev' => esc_html__('Slide skew ver cross rev', 'albedo'),
						'lg-lollipop' => esc_html__('Lollipop', 'albedo'),
						'lg-lollipop-rev' => esc_html__('Lollipop rev', 'albedo'),
						'lg-rotate' => esc_html__('Rotate', 'albedo'),
						'lg-rotate-rev' => esc_html__('Rotate rev', 'albedo'),
						'lg-tube' => esc_html__('Tube', 'albedo'),
					),
				),
				'lightbox_easing' => array(
					'label' => esc_html__( 'Lightbox easing', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_options['lightbox_easing'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'lightbox_easing',
					),
					'choices' => array(
						'0.250, 0.250, 0.750, 0.750' => 'linear',
						'0.250, 0.100, 0.250, 1.000' => 'ease',
						'0.420, 0.000, 1.000, 1.000' => 'easeIn',
						'0.000, 0.000, 0.580, 1.000' => 'easeOut',
						'0.420, 0.000, 0.580, 1.000' => 'easeInOut',
						'0.550, 0.085, 0.680, 0.530' => 'easeInQuad',
						'0.550, 0.055, 0.675, 0.190' => 'easeInCubic',
						'0.895, 0.030, 0.685, 0.220' => 'easeInQuart',
						'0.755, 0.050, 0.855, 0.060' => 'easeInQuint',
						'0.470, 0.000, 0.745, 0.715' => 'easeInSine',
						'0.950, 0.050, 0.795, 0.035' => 'easeInExpo',
						'0.600, 0.040, 0.980, 0.335' => 'easeInCirc',
						'0.600, -0.280, 0.735, 0.045' => 'easeInBack',
						'0.250, 0.460, 0.450, 0.940' => 'easeOutQuad',
						'0.215, 0.610, 0.355, 1.000' => 'easeOutCubic',
						'0.165, 0.840, 0.440, 1.000' => 'easeOutQuart',
						'0.230, 1.000, 0.320, 1.000' => 'easeOutSine',
						'0.190, 1.000, 0.220, 1.000' => 'easeOutExpo',
						'0.075, 0.820, 0.165, 1.000' => 'easeOutCirc',
						'0.175, 0.885, 0.320, 1.275' => 'easeOutBack',
						'0.455, 0.030, 0.515, 0.955' => 'easeInOutQuad',
						'0.645, 0.045, 0.355, 1.000' => 'easeInOutCubic',
						'0.770, 0.000, 0.175, 1.000' => 'easeInOutQuart',
						'0.860, 0.000, 0.070, 1.000' => 'easeInOutQuint',
						'0.445, 0.050, 0.550, 0.950' => 'easeInOutSine',
						'1.000, 0.000, 0.000, 1.000' => 'easeInOutExpo',
						'0.785, 0.135, 0.150, 0.860' => 'easeInOutCirc',
						'0.680, -0.550, 0.265, 1.550' => 'easeInOutBack',
					),
				),
				'lightbox_thumbnails' => array(
					'label' => esc_html__( 'Enable thumbnails for Lightbox Galleries', 'albedo' ),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'lightbox_thumbnails',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['lightbox_thumbnails'],
				),
				'lightbox_captions' => array(
					'label' => esc_html__( 'Show image captions', 'albedo' ),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'lightbox_captions',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['lightbox_captions'],
				),
				'lightbox_fullscreen' => array(
					'label' => esc_html__( 'Enable full screen button', 'albedo' ),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'lightbox_fullscreen',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['lightbox_fullscreen'],
				),
				'lightbox_zoom' => array(
					'label' => esc_html__( 'Enable zoom buttons', 'albedo' ),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'lightbox_zoom',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['lightbox_zoom'],
				),
				'lightbox_download' => array(
					'label' => esc_html__( 'Enable download button', 'albedo' ),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'lightbox_download',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['lightbox_download'],
				),
				'lightbox_autoplay' => array(
					'type' => 'multi-picker',
					'label' => false,
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'lightbox_autoplay',
					),
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Enable autoplay', 'albedo' ),
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
							'value' => $wplab_albedo_core->default_options['lightbox_autoplay'],
						)
					),
					'choices' => array(
						'yes' => array(

							'speed' => array(
								'type'  => 'short-text',
								'label' => esc_html__( 'Autoplay speed', 'albedo'),
								'value' => '5000',
								'fw-storage' => isset($no_fw_storage) ? null : array(
									'type' => 'wp-option',
									'wp-option' => $settings_wp_option,
									'key' => 'lightbox_autoplay/yes/speed',
								),
							),

						)
					)
				),

				),
			),

		),
	),
	'preloader' => array(
		'title' => esc_html__('Preloader', 'albedo'),
		'type' => 'tab',
		'options' => array(

		'page_preloader' => array(
			'type' => 'multi-picker',
			'label' => false,
			'desc' => false,
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'page_preloader',
			),
			'picker' => array(
				'style' => array(
					'label' => esc_html__( 'Page preloader', 'albedo' ),
					'desc' => esc_html__( 'If enabled, visitors will see a preloader while page is loading', 'albedo' ),
					'type' => 'radio',
					'value' => $wplab_albedo_core->default_options['preloader_style'],
					'choices' => array(
						'hidden' => esc_html__( 'Turn off page preloader', 'albedo' ),
						'css' => esc_html__( 'Default CSS preloader', 'albedo' ),
						'custom' => esc_html__( 'Upload custom image as a page preloader', 'albedo' )
					),
				)
			),
			'choices' => array(
				'custom' => array(

					'custom_preloader_image' => array(
						'label' => esc_html__( 'Preloader image', 'albedo' ),
						'desc' => esc_html__( 'Choose your own preloader image', 'albedo' ),
						'type' => 'upload',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'page_preloader/custom/custom_preloader_image',
						),
					),
					'custom_preloader_image_2x' => array(
						'label' => esc_html__( 'Preloader image for Retina Displays', 'albedo' ),
						'desc' => esc_html__( 'Choose your own preloader image for Retina Displays.', 'albedo' ),
						'type' => 'upload',
						'help'  => esc_html__( 'It should be in a twice size of your custom preloader image.', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'page_preloader/custom/custom_preloader_image_2x',
						),
					),
					'custom_preloader_image_width' => array(
						'label' => esc_html__( 'Preloader image width', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_options['custom_preloader_image_width'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'help' => esc_html__( 'Type here a width of preloader image in pixels, e.g.: 50', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'page_preloader/custom/custom_preloader_image_width',
						),
					),
					'custom_preloader_image_height' => array(
						'label' => esc_html__( 'Preloader image Height', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_options['custom_preloader_image_height'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'help' => esc_html__( 'Type here a height of preloader image in pixels, e.g.: 50', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'page_preloader/custom/custom_preloader_image_height',
						),
					),
				),
			),
			'show_borders' => false,
		),

		'preloader_bg' => array(
			'label' => esc_html__('Preloader background color', 'albedo'),
			'value' => $wplab_albedo_core->default_styles['preloader_bg'],
			'type' => 'rgba-color-picker',
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'preloader_bg',
			),
		),
		'preloader_color' => array(
			'label' => esc_html__('CSS Preloader color', 'albedo'),
			'value' => $wplab_albedo_core->default_styles['preloader_color'],
			'type' => 'rgba-color-picker',
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'preloader_color',
			),
		),

		)
	),
	'layout' => array(
		'title' => esc_html__('Layout', 'albedo'),
		'type' => 'tab',
		'options' => array(

			'styling_layout' => array(
				'title' => esc_html__('Layout Type', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

				'layout_type' => array(
					'label' => esc_html__( 'Layout type', 'albedo' ),
					'type' => 'radio',
					'value' => $wplab_albedo_core->default_options['layout_type'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'layout_type',
					),
					'choices' => array(
						'default' => esc_html__( 'Default', 'albedo' ),
						'boxed' => esc_html__( 'Boxed', 'albedo' ),
						'framed' => esc_html__( 'Framed', 'albedo' )
					),
				),
				'layout_width' => array(
					'type' => 'short-text',
					'value' => $wplab_albedo_core->default_styles['layout_width'],
					'label' => esc_html__('Layout width', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'layout_width',
					),
					'desc' => esc_html__('In pixels (e.g. 1200px) or percents (e.g. 80%). Do not set a number, less than 995px to avoid conflicts.', 'albedo'),
				),
				'layout_column_padding' => array(
					'type' => 'short-text',
					'value' => $wplab_albedo_core->default_styles['layout_column_padding'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'layout_column_padding',
					),
					'label' => esc_html__('Columns padding', 'albedo'),
					'desc' => esc_html__('In pixels (e.g. 15)', 'albedo'),
				),

				)
			),

			'styling_layout_box' => array(
				'title' => esc_html__('Boxed / Framed Layout settings', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

				'framed_margins' => array(
					'type' => 'short-text',
					'value' => $wplab_albedo_core->default_styles['framed_margins'],
					'label' => esc_html__( 'Box Top and Bottom margins', 'albedo'),
					'desc' => esc_html__( 'Can be applied for a Framed Layout only.', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'framed_margins',
					),
				),
				'framed_corners' => array(
					'type' => 'short-text',
					'value' => $wplab_albedo_core->default_styles['framed_corners'],
					'label' => esc_html__( 'Content box radius', 'albedo'),
					'desc' => esc_html__( 'Can be applied for a Framed Layout only.', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'framed_corners',
					),
				),
				'box_top_padding' => array(
					'type' => 'short-text',
					'value' => $wplab_albedo_core->default_styles['box_top_padding'],
					'label' => esc_html__('Content box top padding', 'albedo'),
					'desc' => esc_html__('e.g. 15px or 5%', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'box_top_padding',
					),
				),
				'box_right_padding' => array(
					'type' => 'short-text',
					'value' => $wplab_albedo_core->default_styles['box_right_padding'],
					'label' => esc_html__('Content box right padding', 'albedo'),
					'desc' => esc_html__('e.g. 15px or 5%', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'box_right_padding',
					),
				),
				'box_bottom_padding' => array(
					'type' => 'short-text',
					'value' => $wplab_albedo_core->default_styles['box_bottom_padding'],
					'label' => esc_html__('Content box bottom padding', 'albedo'),
					'desc' => esc_html__('e.g. 15px or 5%', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'box_bottom_padding',
					),
				),
				'box_left_padding' => array(
					'type' => 'short-text',
					'value' => $wplab_albedo_core->default_styles['box_left_padding'],
					'label' => esc_html__('Content box left padding', 'albedo'),
					'desc' => esc_html__('e.g. 15px or 5%', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'box_left_padding',
					),
				),
				'boxed_framed_shadow_color' => array(
					'label' => esc_html__('Content box shadow color', 'albedo'),
					'desc' => esc_html__('Can be applied for a Framed / Boxed Layouts only.', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['boxed_framed_shadow_color'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'boxed_framed_shadow_color',
					),
				),
				'boxed_framed_shadow_h_length' => array(
					'type'  => 'short-text',
					'value' => $wplab_albedo_core->default_styles['boxed_framed_shadow_h_length'],
					'label' => esc_html__( 'Content box horizontal shadow length', 'albedo' ),
					'desc' => esc_html__('Can be applied for a Framed / Boxed Layouts only.', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'boxed_framed_shadow_h_length',
					),
				),
				'boxed_framed_shadow_v_length' => array(
					'type'  => 'short-text',
					'value' => $wplab_albedo_core->default_styles['boxed_framed_shadow_v_length'],
					'label' => esc_html__( 'Content box vertical shadow length', 'albedo' ),
					'desc' => esc_html__('Can be applied for a Framed / Boxed Layouts only.', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'boxed_framed_shadow_v_length',
					),
				),
				'boxed_framed_shadow_blur_radius' => array(
					'type'  => 'short-text',
					'value' => $wplab_albedo_core->default_styles['boxed_framed_shadow_blur_radius'],
					'label' => esc_html__( 'Content box shadow blur radius', 'albedo' ),
					'desc' => esc_html__('Can be applied for a Framed / Boxed Layouts only.', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'boxed_framed_shadow_blur_radius',
					),
				),

				)
			),

			'styling_body' => array(
				'title' => esc_html__('Body Background', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

				'body_bg_color' => array(
					'label' => esc_html__('Body background color', 'albedo'),
					'desc' => esc_html__('Select custom background color.', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['body_bg_color'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'body_bg_color',
					),
				),
				'body_bg_image_src' => array(
					'label' => esc_html__('Body background Image', 'albedo'),
					'desc' => esc_html__('Upload background image', 'albedo'),
					'type' => 'background-image',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'body_bg_image_src',
					),
				),
				'body_bg_image_position' => array(
					'label' => esc_html__( 'Background image position', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_styles['body_bg_image_position'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'body_bg_image_position',
					),
					'choices' => array(
						'left top' => esc_html__( 'Left Top', 'albedo' ),
						'center top' => esc_html__( 'Center Top', 'albedo' ),
						'right top' => esc_html__( 'Right Top', 'albedo' ),
						'left bottom' => esc_html__( 'Left Bottom', 'albedo' ),
						'center bottom' => esc_html__( 'Center Bottom', 'albedo' ),
						'right bottom' => esc_html__( 'Right Bottom', 'albedo' ),
						'left center' => esc_html__( 'Left Center', 'albedo' ),
						'center center' => esc_html__( 'Center Center', 'albedo' ),
						'right center' => esc_html__( 'Right Center', 'albedo' ),
					),
				),
				'body_bg_image_repeat' => array(
					'label' => esc_html__( 'Background image repeat', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_styles['body_bg_image_repeat'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'body_bg_image_repeat',
					),
					'choices' => array(
						'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
						'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
						'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
						'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
					),
				),
				'body_bg_image_attachment' => array(
					'label' => esc_html__('Background Attachment', 'albedo'),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'body_bg_image_attachment',
					),
					'right-choice' => array(
						'value' => 'fixed',
						'label' => esc_html__( 'Fixed', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'scroll',
						'color' => '#ccc',
						'label' => esc_html__( 'Scroll', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_styles['body_bg_image_attachment'],
				),
				'body_bg_image_cover' => array(
					'label' => esc_html__('Cover Background Image', 'albedo'),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'body_bg_image_cover',
					),
					'right-choice' => array(
						'value' => 'cover',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'auto',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_styles['body_bg_image_cover'],
				),

				)
			),

			'styling_box_outer' => array(
				'title' => esc_html__('Box Outer Background (Framed / Boxed layouts)', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

				'boxed_bg_color' => array(
					'label' => esc_html__('Box outer background color', 'albedo'),
					'desc' => esc_html__('Can be used only for Boxed or Framed layouts', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['boxed_bg_color'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'boxed_bg_color',
					),
				),
				'boxed_bg_image_src' => array(
					'label' => esc_html__('Box outer background image', 'albedo'),
					'desc' => esc_html__('Upload background image', 'albedo'),
					'type' => 'background-image',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'boxed_bg_image_src',
					),
				),
				'boxed_bg_image_position' => array(
					'label' => esc_html__( 'Background image position', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_styles['boxed_bg_image_position'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'boxed_bg_image_position',
					),
					'choices' => array(
						'left top' => esc_html__( 'Left Top', 'albedo' ),
						'center top' => esc_html__( 'Center Top', 'albedo' ),
						'right top' => esc_html__( 'Right Top', 'albedo' ),
						'left bottom' => esc_html__( 'Left Bottom', 'albedo' ),
						'center bottom' => esc_html__( 'Center Bottom', 'albedo' ),
						'right bottom' => esc_html__( 'Right Bottom', 'albedo' ),
						'left center' => esc_html__( 'Left Center', 'albedo' ),
						'center center' => esc_html__( 'Center Center', 'albedo' ),
						'right center' => esc_html__( 'Right Center', 'albedo' ),
					),
				),
				'boxed_bg_image_repeat' => array(
					'label' => esc_html__( 'Background image repeat', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_styles['boxed_bg_image_repeat'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'boxed_bg_image_repeat',
					),
					'choices' => array(
						'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
						'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
						'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
						'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
					),
				),
				'boxed_bg_image_attachment' => array(
					'label' => esc_html__('Background Attachment', 'albedo'),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'boxed_bg_image_attachment',
					),
					'right-choice' => array(
						'value' => 'fixed',
						'label' => esc_html__( 'Fixed', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'scroll',
						'color' => '#ccc',
						'label' => esc_html__( 'Scroll', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_styles['boxed_bg_image_attachment'],
				),
				'boxed_bg_image_cover' => array(
					'label' => esc_html__('Cover Background Image', 'albedo'),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'boxed_bg_image_cover',
					),
					'right-choice' => array(
						'value' => 'cover',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'auto',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_styles['boxed_bg_image_cover'],
				),

				)
			),

		'page_404_settings' => array(
			'title' => esc_html__('Page 404', 'albedo'),
			'type' => 'box',
			'attr' => array(
				'class' => 'closed'
			),
			'options' => array(

				'page_404_style' => array(
					'label' => esc_html__( 'Page style', 'albedo' ),
					'type' => 'radio',
					'value' => $wplab_albedo_core->default_options['page_404_style'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_style',
					),
					'choices' => array(
						'modern' => esc_html__( 'Modern', 'albedo' ),
						'simple' => esc_html__( 'Simple', 'albedo' ),
						'minimal' => esc_html__( 'Minimal', 'albedo' ),
						'background' => esc_html__( 'Background Image (white text)', 'albedo' )
					),
				),

				'page_404_title_1' => array(
					'type'  => 'text',
					'label' => esc_html__('First line title', 'albedo'),
					'value' => $wplab_albedo_core->default_options['page_404_title_1'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_title_1',
					),
				),
				'page_404_title_2' => array(
					'type'  => 'textarea',
					'label' => esc_html__('Second line title', 'albedo'),
					'value' => $wplab_albedo_core->default_options['page_404_title_2'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_title_2',
					),
				),
				'page_404_title_3' => array(
					'type'  => 'textarea',
					'label' => esc_html__('Third line title', 'albedo'),
					'value' => $wplab_albedo_core->default_options['page_404_title_3'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_title_3',
					),
				),
				'page_404_display_search' => array(
					'label' => esc_html__('Display search form', 'albedo'),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_display_search',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['page_404_display_search'],
				),
				'page_404_display_home_btn' => array(
					'type' => 'multi-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_display_home_btn',
					),
					'label' => false,
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Display Home Button', 'albedo' ),
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
							'value' => $wplab_albedo_core->default_options['page_404_display_home_btn'],
						)
					),
					'choices' => array(
						'yes' => array(

							'page_404_home_btn_text' => array(
								'type'  => 'text',
								'label' => esc_html__( 'Button text', 'albedo'),
								'value' => $wplab_albedo_core->default_options['page_404_home_btn_text'],
								'fw-storage' => isset($no_fw_storage) ? null : array(
									'type' => 'wp-option',
									'wp-option' => $settings_wp_option,
									'key' => 'page_404_display_home_btn/yes/page_404_home_btn_text',
								),
							),

						)
					)
				),

				'page_404_bg_img' => array(
					'label' => esc_html__('Background image', 'albedo'),
					'desc' => esc_html__('Upload background image', 'albedo'),
					'type' => 'background-image',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_bg_img',
					),
				),
				'page_404_bg_img_position' => array(
					'label' => esc_html__( 'Background image position', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_options['page_404_bg_img_position'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_bg_img_position',
					),
					'choices' => array(
						'left top' => esc_html__( 'Left Top', 'albedo' ),
						'center top' => esc_html__( 'Center Top', 'albedo' ),
						'right top' => esc_html__( 'Right Top', 'albedo' ),
						'left bottom' => esc_html__( 'Left Bottom', 'albedo' ),
						'center bottom' => esc_html__( 'Center Bottom', 'albedo' ),
						'right bottom' => esc_html__( 'Right Bottom', 'albedo' ),
						'left center' => esc_html__( 'Left Center', 'albedo' ),
						'center center' => esc_html__( 'Center Center', 'albedo' ),
						'right center' => esc_html__( 'Right Center', 'albedo' ),
					),
				),
				'page_404_bg_img_repeat' => array(
					'label' => esc_html__( 'Background image repeat', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_options['page_404_bg_img_repeat'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_bg_img_repeat',
					),
					'choices' => array(
						'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
						'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
						'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
						'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
					),
				),
				'page_404_bg_img_attachment' => array(
					'label' => esc_html__('Background Attachment', 'albedo'),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_bg_img_attachment',
					),
					'right-choice' => array(
						'value' => 'fixed',
						'label' => esc_html__( 'Fixed', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'scroll',
						'color' => '#ccc',
						'label' => esc_html__( 'Scroll', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['page_404_bg_img_attachment'],
				),
				'page_404_bg_img_cover' => array(
					'label' => esc_html__('Cover Background Image', 'albedo'),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_bg_img_cover',
					),
					'right-choice' => array(
						'value' => 'cover',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'auto',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['page_404_bg_img_cover'],
				),
				'page_404_bg_img_parallax' => array(
					'label' => esc_html__('Mouse Move Parallax Effect', 'albedo'),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_bg_img_parallax',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Enabled', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'Disabled', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['page_404_bg_img_parallax'],
				),
						'page_404_slider_header_mode' => array(
					'label' => esc_html__('Slider Header Mode', 'albedo'),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_slider_header_mode',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['page_404_slider_header_mode'],
				),
						'page_404_slider_footer_mode' => array(
					'label' => esc_html__('Slider Footer Mode', 'albedo'),
					'type' => 'switch',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'page_404_slider_footer_mode',
					),
					'right-choice' => array(
						'value' => 'yes',
						'label' => esc_html__( 'Yes', 'albedo' )
					),
					'left-choice' => array(
						'value' => 'no',
						'color' => '#ccc',
						'label' => esc_html__( 'No', 'albedo' )
					),
					'value' => $wplab_albedo_core->default_options['page_404_slider_footer_mode'],
				),

				)
			),

		)
),

'header' => array(
	'title' => esc_html__('Header', 'albedo'),
	'type' => 'tab',
	'options' => array(

		'header_logo' => array(
		'title' => esc_html__('Logo, Favicon', 'albedo'),
		'type' => 'box',
		'attr' => array(
			'class' => 'closed'
		),
		'options' => array(

			'header_logo_type' => array(
				'type' => 'multi-picker',
				'show_borders' => false,
				'label' => false,
				'desc' => false,
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_logo_type',
				),
				'value' => array(
					'logo_type' => $wplab_albedo_core->default_options['header_logo_type'],
				),
				'picker' => array(
					'logo_type' => array(
						'label' => esc_html__( 'Logo Type', 'albedo' ),
						'type' => 'radio',
						'choices' => array(
							'title' => esc_html__( 'Site title', 'albedo' ),
							'title_and_tagline'  => esc_html__( 'Site title and tagline', 'albedo' ),
							'image' => esc_html__( 'Image logo', 'albedo' ),
						),
					)
				),
				'choices' => array(
					'image' => array(

						'header_logo_image' => array(
							'label' => esc_html__( 'Header Logo', 'albedo' ),
							'type' => 'upload',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_logo_image',
							),
							'attr' => array( 'class' => 'wproto-image-auto-width' ),
						),
						'header_logo_image_2x' => array(
							'label' => esc_html__( 'Header Logo for Retina / HDPI Displays', 'albedo' ),
							'desc' => esc_html__( 'For example, if your normal logo has 150x75 size, upload 300x150 image', 'albedo' ),
							'type' => 'upload',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_logo_image',
							),
							'attr' => array( 'class' => 'wproto-image-auto-width' ),
						),
						'header_logo_width' => array(
							'label' => esc_html__( 'Logo Width', 'albedo' ),
							'type' => 'short-text',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_logo_width',
							),
							'value' => $wplab_albedo_core->default_options['header_logo_width'],
							'desc' => esc_html__( 'value in pixels', 'albedo' ),
							'help' => esc_html__( 'Type here your image logo width in pixels, e.g.: 150. This value will be used to set correct size for Retina / HDPI Displays.', 'albedo' ),
						),
						'header_logo_height' => array(
							'label' => esc_html__( 'Logo Height', 'albedo' ),
							'type' => 'short-text',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_logo_height',
							),
							'value' => $wplab_albedo_core->default_options['header_logo_height'],
							'desc' => esc_html__( 'value in pixels', 'albedo' ),
							'help' => esc_html__( 'Type here your image logo height in pixels, e.g.: 75. This value will be used to set correct size for Retina / HDPI Displays.', 'albedo' ),
						),
						'header_logo_margins' => array(
							'label' => esc_html__( 'Logo Margins', 'albedo' ),
							'type' => 'stylebox',
							'value' => '',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_logo_margins',
							),
							'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
						),

						'header_logo_transp_image' => array(
							'label' => esc_html__( 'Header Logo for Transparent Header', 'albedo' ),
							'type' => 'upload',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_logo_transp_image',
							),
							'attr' => array( 'class' => 'wproto-image-auto-width' ),
						),
						'header_logo_transp_image_2x' => array(
							'label' => esc_html__( 'Header Logo for Transparent Header (Retina / HDPI displays)', 'albedo' ),
							'desc' => esc_html__( 'For example, if your normal logo has 150x75 size, upload 300x150 image.', 'albedo' ),
							'type' => 'upload',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_logo_transp_image',
							),
							'attr' => array( 'class' => 'wproto-image-auto-width' ),
						),
						'header_logo_transp_width' => array(
							'label' => esc_html__( 'Logo Width (for Transparent Header)', 'albedo' ),
							'type' => 'short-text',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_logo_transp_width',
							),
							'value' => $wplab_albedo_core->default_options['header_logo_transp_width'],
							'desc' => esc_html__( 'value in pixels', 'albedo' ),
							'help' => esc_html__( 'Type here your image logo width in pixels, e.g.: 150. This value will be used to calculate correct size for Retina / HDPI Displays.', 'albedo' ),
						),
						'header_logo_transp_height' => array(
							'label' => esc_html__( 'Logo Height (for Transparent Header)', 'albedo' ),
							'type' => 'short-text',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_logo_transp_height',
							),
							'value' => $wplab_albedo_core->default_options['header_logo_transp_height'],
							'desc' => esc_html__( 'value in pixels', 'albedo' ),
							'help' => esc_html__( 'Type here your image logo height in pixels, e.g.: 75. This value will be used to calculate correct size for Retina / HDPI Displays.', 'albedo' ),
						),
						'header_logo_transp_margins' => array(
							'label' => esc_html__( 'Logo Margins (for Transparent Header)', 'albedo' ),
							'type' => 'stylebox',
							'value' => '',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_logo_transp_margins',
							),
							'desc' => esc_html__( 'Example: 10px 20% 20px 20%. Follow clockwise: top, right, bottom, left', 'albedo' ),
						),

					)
				),

			),
			'favicon' => array(
				'label' => esc_html__( 'Favicon', 'albedo' ),
				'desc' => esc_html__( 'We recommend to use at least 144x144 image size in PNG format', 'albedo' ),
				'type' => 'upload',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'favicon',
				),
				'images_only' => true,
			),
			'header_logo_title_color' => array(
				'label' => esc_html__('Site title text color', 'albedo'),
				'desc' => esc_html__('Used in Text Logo mode', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_logo_title_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_logo_title_color',
				),
			),
			'header_logo_desc_color' => array(
				'label' => esc_html__('Site description text color', 'albedo'),
				'desc' => esc_html__('Used in Text Logo mode', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_logo_desc_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_logo_desc_color',
				),
			),
			'header_transp_logo_title_color' => array(
				'label' => esc_html__('Site title text color (for transparent header mode)', 'albedo'),
				'desc' => esc_html__('Used in Text Logo mode', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_transp_logo_title_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_transp_logo_title_color',
				),
			),
			'header_transp_logo_desc_color' => array(
				'label' => esc_html__('Site description text color (for transparent header mode)', 'albedo'),
				'desc' => esc_html__('Used in Text Logo mode', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_transp_logo_desc_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_transp_logo_desc_color',
				),
			),

			)
	),
	'top_bar' => array(
		'title' => esc_html__('Top bar', 'albedo'),
		'type' => 'box',
		'options' => array(

			'top_bar_enabled' => array(
				'type' => 'multi-picker',
				'label' => false,
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_enabled',
				),
				'picker' => array(
					'enabled' => array(
						'label' => esc_html__( 'Enable Top Bar', 'albedo' ),
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
						'value' => $wplab_albedo_core->default_options['top_bar_enabled'],
					)
				),
				'choices' => array(
					'yes' => array(

						'top_bar_elements' => array(
							'type'          => 'addable-popup',
							'label'         => esc_html__( 'Top Bar Elements', 'albedo' ),
							'popup-title'   => esc_html__( 'Add/Edit', 'albedo' ),
							'desc'          => esc_html__( 'Add some top bar content', 'albedo' ),
							'template'      => '{{if( type.elem_type == "text" ) return type.text.content; if( type.elem_type == "text_icon" ) return type.text_icon.content; if( type.elem_type == "social_icons" ) return type.social_icons.content; if( type.elem_type == "wpml_switcher" ) return type.wpml_switcher.content; if( type.elem_type == "polylang_switcher" ) return type.polylang_switcher.content; }}',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'top_bar_enabled/yes/top_bar_elements',
							),
							'popup-options' => array(

								'type' => array(
									'type' => 'multi-picker',
									'label' => false,
									'desc' => false,
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'top_bar_enabled/yes/top_bar_elements/type',
									),
									'value' => array(
										'elem_type' => 'text',
									),
									'picker' => array(
										'elem_type' => array(
											'label' => esc_html__( 'Element type', 'albedo' ),
											'type' => 'radio',
											'choices' => array(
												'text' => esc_html__( 'Text', 'albedo' ),
												'text_icon' => esc_html__( 'Text and Icon', 'albedo' ),
												'social_icons' => esc_html__( 'Social icons', 'albedo' ),
												'wpml_switcher' => esc_html__( 'WPML Language Switcher', 'albedo' ),
												'polylang_switcher' => esc_html__( 'Polylang Language Switcher', 'albedo' ),
											),
										)
									),
									'choices' => array(
										'text' => array(

											'content' => array(
												'type'  => 'text',
												'label' => esc_html__('Content', 'albedo'),
												'value' => '',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/text/content',
												),
											),
											'move_right' => array(
												'label' => esc_html__( 'Move to the right', 'albedo' ),
												'type' => 'switch',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/text/move_right',
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
											'hide_on_mobiles' => array(
												'label' => esc_html__( 'Hide this item on mobiles', 'albedo' ),
												'type' => 'switch',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/text/hide_on_mobiles',
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

										),
										'text_icon' => array(

											'content' => array(
												'type'  => 'text',
												'label' => esc_html__('Content', 'albedo'),
												'value' => '',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/text_icon/content',
												),
											),
											'icon' => array(
												'type'  => 'icon-v2',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/text_icon/icon',
												),
											),
											'move_right' => array(
												'label' => esc_html__( 'Move to the right', 'albedo' ),
												'type' => 'switch',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/text_icon/move_right',
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
											'hide_on_mobiles' => array(
												'label' => esc_html__( 'Hide this item on mobiles', 'albedo' ),
												'type' => 'switch',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/text_icon/hide_on_mobiles',
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

										),
										'wpml_switcher' => array(
											'content' => array(
												'type'  => 'hidden',
												'value' => esc_html__('WPML Language Switcher', 'albedo'),
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/wpml_switcher/content',
												),
											),
											'move_right' => array(
												'label' => esc_html__( 'Move to the right', 'albedo' ),
												'type' => 'switch',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/wpml_switcher/move_right',
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
											'hide_on_mobiles' => array(
												'label' => esc_html__( 'Hide this item on mobiles', 'albedo' ),
												'type' => 'switch',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/wpml_switcher/hide_on_mobiles',
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
										),
										'polylang_switcher' => array(
											'content' => array(
												'type'  => 'hidden',
												'value' => esc_html__('Polylang Language Switcher', 'albedo'),
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/polylang_switcher/content',
												),
											),
											'move_right' => array(
												'label' => esc_html__( 'Move to the right', 'albedo' ),
												'type' => 'switch',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/polylang_switcher/move_right',
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
											'hide_on_mobiles' => array(
												'label' => esc_html__( 'Hide this item on mobiles', 'albedo' ),
												'type' => 'switch',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/polylang_switcher/hide_on_mobiles',
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
										),
										'social_icons' => array(

											'content' => array(
												'type'  => 'hidden',
												'value' => esc_html__('Social Icons', 'albedo'),
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/social_icons/content',
												),
											),
											'instagram_url' => array(
												'type'  => 'text',
												'label' => esc_html__('Instagram URL', 'albedo'),
												'value' => '',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/social_icons/instagram_url',
												),
											),
											'facebook_url' => array(
												'type'  => 'text',
												'label' => esc_html__('Facebook URL', 'albedo'),
												'value' => '',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/social_icons/facebook_url',
												),
											),
											'twitter_url' => array(
												'type'  => 'text',
												'label' => esc_html__('Twitter URL', 'albedo'),
												'value' => '',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/social_icons/twitter_url',
												),
											),
											'linkedin_url' => array(
												'type'  => 'text',
												'label' => esc_html__('LinkedIn URL', 'albedo'),
												'value' => '',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/social_icons/linkedin_url',
												),
											),
											'google_plus_url' => array(
												'type'  => 'text',
												'label' => esc_html__('Google Plus URL', 'albedo'),
												'value' => '',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/social_icons/google_plus_url',
												),
											),
											'youtube_url' => array(
												'type'  => 'text',
												'label' => esc_html__('YouTube URL', 'albedo'),
												'value' => '',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/social_icons/youtube_url',
												),
											),
											'medium_url' => array(
												'type'  => 'text',
												'label' => esc_html__('Medium URL', 'albedo'),
												'value' => '',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/social_icons/medium_url',
												),
											),
											'move_right' => array(
												'label' => esc_html__( 'Move to the right', 'albedo' ),
												'type' => 'switch',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/social_icons/move_right',
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
											'hide_on_mobiles' => array(
												'label' => esc_html__( 'Hide this item on mobiles', 'albedo' ),
												'type' => 'switch',
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'top_bar_enabled/yes/top_bar_elements/social_icons/hide_on_mobiles',
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

										),
									)
								),

							)
						),

					)
				)
			),
			'top_bar_responsive_at' => array(
				'label' => esc_html__( 'Responsive at', 'albedo' ),
				'type' => 'short-text',
				'value' => $wplab_albedo_core->default_options['top_bar_responsive_at'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_responsive_at',
				),
				'desc' => esc_html__( 'type here a screen width when top bar will be switched into responsive mode', 'albedo' ),
			),
			'top_bar_sticky' => array(
				'label' => esc_html__( 'Sticky Top Bar', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_sticky',
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
				'value' => $wplab_albedo_core->default_options['top_bar_sticky'],
			),
			'top_bar_sticky_mobile' => array(
				'label' => esc_html__( 'Sticky Top Bar on Mobile Devices', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_sticky_mobile',
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
				'value' => $wplab_albedo_core->default_options['top_bar_sticky_mobile'],
			),
			'top_bar_hide_mobile' => array(
				'label' => esc_html__( 'Hide Top Bar on Mobile Devices', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_hide_mobile',
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
				'value' => $wplab_albedo_core->default_options['top_bar_hide_mobile'],
			),
			'top_bar_font_size' => array(
				'label' => esc_html__( 'Font size', 'albedo' ),
				'type' => 'short-text',
				'value' => $wplab_albedo_core->default_styles['top_bar_font_size'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_font_size',
				),
				'desc' => esc_html__( 'value in pixels', 'albedo' ),
			),
			'top_bar_font_line_height' => array(
				'label' => esc_html__( 'Line height', 'albedo' ),
				'type' => 'short-text',
				'value' => $wplab_albedo_core->default_styles['top_bar_font_line_height'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_font_line_height',
				),
				'desc' => esc_html__( 'value in pixels', 'albedo' ),
			),
			'top_bar_bg_color' => array(
				'label' => esc_html__('Background color', 'albedo'),
				'desc' => esc_html__('Top bar background color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['top_bar_bg_color'],
				'type' => 'rgba-color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_bg_color',
				),
			),
			'top_bar_font_color' => array(
				'label' => esc_html__('Text color', 'albedo'),
				'desc' => esc_html__('Top bar text color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['top_bar_font_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_font_color',
				),
			),
			'top_bar_link_color' => array(
				'label' => esc_html__('Link color', 'albedo'),
				'desc' => esc_html__('Top bar link color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['top_bar_link_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_link_color',
				),
			),
			'top_bar_link_hover_color' => array(
				'label' => esc_html__('Link hover color', 'albedo'),
				'desc' => esc_html__('Top bar link hover color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['top_bar_link_hover_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_link_hover_color',
				),
			),
			'top_bar_icon_color' => array(
				'label' => esc_html__('Icons color', 'albedo'),
				'desc' => esc_html__('Top bar icons color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['top_bar_icon_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_icon_color',
				),
			),
			'top_bar_icon_hover_color' => array(
				'label' => esc_html__('Icons hover color', 'albedo'),
				'desc' => esc_html__('Top bar icons hover color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['top_bar_icon_hover_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_icon_hover_color',
				),
			),
			'top_bar_shadow_color' => array(
				'label' => esc_html__('Shadow color', 'albedo'),
				'desc' => esc_html__('Top bar shadow color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['top_bar_shadow_color'],
				'type' => 'rgba-color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_shadow_color',
				),
			),
			'top_bar_shadow_h_length' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['top_bar_shadow_h_length'],
				'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
				'desc' => esc_html__('Top bar Horizontal shadow length', 'albedo'),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_shadow_h_length',
				),
			),
			'top_bar_shadow_v_length' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['top_bar_shadow_v_length'],
				'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
				'desc' => esc_html__('Top bar Vertical shadow length', 'albedo'),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_shadow_v_length',
				),
			),
			'top_bar_shadow_blur_radius' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['top_bar_shadow_blur_radius'],
				'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
				'desc' => esc_html__('Top Bar Shadow blur radius', 'albedo'),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'top_bar_shadow_blur_radius',
				),
			),

		)
	),
	'header_style' => array(
		'title' => esc_html__('Header Layout', 'albedo'),
		'type' => 'box',
		'options' => array(

			'header_layout' => array(
				'type'  => 'image-picker',
				'value' => $wplab_albedo_core->default_options['header_layout'],
				'label' => esc_html__('Header Layout', 'albedo'),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_layout',
				),
				'choices' => array(
					'style_1' => get_template_directory_uri() .'/images/header_layout_1.jpg',
					'style_2' => get_template_directory_uri() .'/images/header_layout_2.jpg',
					'style_3' => get_template_directory_uri() .'/images/header_layout_3.jpg',
					'style_4' => get_template_directory_uri() .'/images/header_layout_4.jpg',
					'style_5' => get_template_directory_uri() .'/images/header_layout_5.jpg',
					'style_6' => get_template_directory_uri() .'/images/header_layout_6.jpg',
					'style_7' => get_template_directory_uri() .'/images/header_layout_7.jpg',
					'style_8' => get_template_directory_uri() .'/images/header_layout_8.jpg',
				),
				'blank' => false,
			),
			'display_header_page_title' => array(
				'label' => esc_html__( 'Display Page Title', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'display_header_page_title',
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'albedo' )
				),
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'albedo' )
				),
				'value' => $wplab_albedo_core->default_options['display_header_page_title'],
			),
			'display_header_page_desc' => array(
				'label' => esc_html__( 'Display Page Description', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'display_header_page_desc',
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'albedo' )
				),
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'albedo' )
				),
				'value' => $wplab_albedo_core->default_options['display_header_page_desc'],
			),
			'header_cta' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_cta',
				),
				'picker' => array(

					'enabled' => array(
						'label' => esc_html__( 'Display Call To Action button after Page Title / Page Description text', 'albedo' ),
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
						'value' => $wplab_albedo_core->default_options['header_cta'],
					)

				),
				'choices' => array(
					'yes' => array(

						'header_cta_button_text' => array(
							'type'  => 'text',
							'label' => esc_html__('CTA Button Text', 'albedo'),
							'value' => $wplab_albedo_core->default_options['header_cta_button_text'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_cta_button_text',
							),
						),
						'header_cta_button_url' => array(
							'type'  => 'text',
							'label' => esc_html__('CTA Button URL', 'albedo'),
							'value' => $wplab_albedo_core->default_options['header_cta_button_url'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_cta_button_url',
							),
						),
						'header_cta_button_style'  => array(
							'label'   => esc_html__( 'CTA Button Style', 'albedo' ),
							'type'    => 'select',
							'value' => $wplab_albedo_core->default_options['header_cta_button_style'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_cta_button_style',
							),
							'choices' => $wplab_albedo_core->cfg['button_styles']
						),

					)
				)
			),
					'display_header_second_menu' => array(
				'label' => esc_html__( 'Display Second Menu', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'display_header_second_menu',
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'albedo' )
				),
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'albedo' )
				),
				'value' => $wplab_albedo_core->default_options['display_header_second_menu'],
			),
			'display_header_breadcrumbs' => array(
				'label' => esc_html__( 'Display Breadcrumbs', 'albedo' ),
				'desc' => esc_html__( 'Unyson Breadcrumbs extension should be active', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'display_header_breadcrumbs',
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'albedo' )
				),
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'albedo' )
				),
				'value' => $wplab_albedo_core->default_options['display_header_breadcrumbs'],
			),

		)
	),
	'header_styles' => array(
		'title' => esc_html__('Header Styles (Colors, Background, Shadows, etc.)', 'albedo'),
		'type' => 'box',
		'options' => array(

			'header_bg_gradient' => array(
				'label' => esc_html__('Header Background Color', 'albedo'),
				'desc' => esc_html__('This option sets background color for a whole header. Background color for breadcrumbs / menu container can be changed separately in settings below', 'albedo'),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_bg_gradient',
				),
				'value' => array(
					'primary'   => $wplab_albedo_core->default_styles['header_bg_gradient_from'],
					'secondary' => $wplab_albedo_core->default_styles['header_bg_gradient_to'],
				),
				'type' => 'gradient',
			),
			'header_bg_pos' => array(
				'label' => esc_html__( 'Background Gradient Position', 'albedo' ),
				'type' => 'select',
				'value' => $wplab_albedo_core->default_styles['header_bg_pos'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_bg_pos',
				),
				'choices' => array(
					'to bottom right' => esc_html__( 'To bottom right', 'albedo' ),
					'to bottom' => esc_html__( 'To bottom', 'albedo' ),
					'to bottom left' => esc_html__( 'To bottom left', 'albedo' ),
					'to right' => esc_html__( 'To right', 'albedo' ),
					'to left' => esc_html__( 'To left', 'albedo' ),
					'to top right' => esc_html__( 'To top right', 'albedo' ),
					'to top' => esc_html__( 'To top', 'albedo' ),
					'to top left' => esc_html__( 'To top left', 'albedo' ),
				),
			),
			'header_bg_overlay_color' => array(
				'label' => esc_html__('Header Background Overlay Color', 'albedo'),
				'desc' => esc_html__('Sets a custom overlay color if header layout supports it.', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_bg_overlay_color'],
				'type' => 'rgba-color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_bg_overlay_color',
				),
			),
			'header_bg_image_src' => array(
				'label' => esc_html__('Header Background Image', 'albedo'),
				'desc' => esc_html__('Upload background image', 'albedo'),
				'type' => 'background-image',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_bg_image_src',
				),
			),
			'header_bg_image_position' => array(
				'label' => esc_html__( 'Header Background Image Position', 'albedo' ),
				'type' => 'select',
				'value' => $wplab_albedo_core->default_styles['header_bg_image_position'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_bg_image_position',
				),
				'choices' => array(
					'left top' => esc_html__( 'Left Top', 'albedo' ),
					'center top' => esc_html__( 'Center Top', 'albedo' ),
					'right top' => esc_html__( 'Right Top', 'albedo' ),
					'left bottom' => esc_html__( 'Left Bottom', 'albedo' ),
					'center bottom' => esc_html__( 'Center Bottom', 'albedo' ),
					'right bottom' => esc_html__( 'Right Bottom', 'albedo' ),
					'left center' => esc_html__( 'Left Center', 'albedo' ),
					'center center' => esc_html__( 'Center Center', 'albedo' ),
					'right center' => esc_html__( 'Right Center', 'albedo' ),
				),
			),
			'header_bg_image_repeat' => array(
				'label' => esc_html__( 'Header Background Image Repeat', 'albedo' ),
				'type' => 'select',
				'value' => $wplab_albedo_core->default_styles['header_bg_image_repeat'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_bg_image_repeat',
				),
				'choices' => array(
					'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
					'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
					'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
					'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
				),
			),
			'header_shadow_color' => array(
				'label' => esc_html__('Header Shadow Color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_shadow_color'],
				'type' => 'rgba-color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_shadow_color',
				),
			),
			'header_shadow_h_length' => array(
					'type'  => 'short-text',
					'value' => $wplab_albedo_core->default_styles['header_shadow_h_length'],
					'label' => esc_html__( 'Header Horizontal Shadow Length', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_shadow_h_length',
				),
			),
			'header_shadow_v_length' => array(
			'type'  => 'short-text',
			'value' => $wplab_albedo_core->default_styles['header_shadow_v_length'],
			'label' => esc_html__( 'Header Vertical Shadow Length', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_shadow_v_length',
				),
			),
			'header_shadow_blur_radius' => array(
			'type'  => 'short-text',
			'value' => $wplab_albedo_core->default_styles['header_shadow_blur_radius'],
			'label' => esc_html__( 'Header Shadow Blur Radius', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_shadow_blur_radius',
				),
			),
			'header_page_title_color' => array(
				'label' => esc_html__('Page Title Text Color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_page_title_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_page_title_color',
				),
			),
			'header_page_desc_text_color' => array(
				'label' => esc_html__('Page Description Text Color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_page_desc_text_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_page_desc_text_color',
				),
			),
			'subheader_custom_top_padding' => array(
				'type'  => 'short-text',
				'label' => esc_html__( 'Subheader Top Padding', 'albedo'),
				'desc' => esc_html__( 'Example: 10px or 20%.', 'albedo' ),
				'value' => '',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'subheader_custom_top_padding',
				),
			),
			'subheader_custom_bottom_padding' => array(
				'type'  => 'short-text',
				'label' => esc_html__( 'Subheader Bottom Padding', 'albedo'),
				'desc' => esc_html__( 'Example: 10px or 20%.', 'albedo' ),
				'value' => '',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'subheader_custom_bottom_padding',
				),
			),
					'header_bottom_margin' => array(
				'type'  => 'short-text',
				'label' => esc_html__( 'Custom Header Bottom Margin', 'albedo'),
				'desc' => esc_html__( 'Example: 10px or 20%.', 'albedo' ),
				'value' => '',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_bottom_margin',
				),
			),

		)
	),
	'header_effects' => array(
		'title' => esc_html__('Header Effects (Parallax, Video Backgrounds, Canvas, etc.)', 'albedo'),
		'type' => 'box',
		'options' => array(

			'header_parallax_effect' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'value' => array(
					'effect' => $wplab_albedo_core->default_options['header_parallax_effect'],
				),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_parallax_effect',
				),
				'picker' => array(
					'effect' => array(
						'label' => esc_html__( 'Parallax Effects', 'albedo' ),
						'type' => 'radio',
						'choices' => array(
							'' => esc_html__( 'No Parallax', 'albedo' ),
							'parallax' => esc_html__( 'Parallax background', 'albedo' ),
							'mouse_parallax' => esc_html__( 'Mouse Move Parallax background', 'albedo' ),
						),
					)
				),
				'choices' => array(
					'parallax' => array(

						'parallax_speed' => array(
							'label' => esc_html__('Parallax speed', 'albedo'),
							'desc' => esc_html__('Set a speed of parallax effect, e.g.: 1.5. Do not forget to assign some background image for a header.', 'albedo'),
							'type' => 'text',
							'value' => $wplab_albedo_core->default_options['header_parallax_effect_parallax_speed'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_parallax_effect_parallax_speed',
							),
						),

					),
					'mouse_parallax' => array(

						'invert_x' => array(
							'label' => esc_html__( 'Invert X', 'albedo' ),
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
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_invert_x'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_invert_x',
							),
						),
						'invert_y' => array(
							'label' => esc_html__( 'Invert Y', 'albedo' ),
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
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_invert_y'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_invert_y',
							),
						),
						'depth' => array(
							'label' => esc_html__('Depth', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_depth'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_depth',
							),
						),
						'limit_x' => array(
							'label' => esc_html__('Limit X', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_limit_x'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_limit_x',
							),
						),
						'limit_y' => array(
							'label' => esc_html__('Limit Y', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_limit_y'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_limit_y',
							),
						),
						'scalar_x' => array(
							'label' => esc_html__('Scalar X', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_scalar_x'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_scalar_x',
							),
						),
						'scalar_y' => array(
							'label' => esc_html__('Scalar Y', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_scalar_y'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_scalar_y',
							),
						),
						'friction_x' => array(
							'label' => esc_html__('Friction X', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_friction_x'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_friction_x',
							),
						),
						'friction_y' => array(
							'label' => esc_html__('Friction Y', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_friction_y'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_friction_y',
							),
						),
						'origin_x' => array(
							'label' => esc_html__('Origin X', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_origin_x'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_origin_x',
							),
						),
						'origin_y' => array(
							'label' => esc_html__('Origin Y', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_mouse_parallax_origin_y'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_mouse_parallax_origin_y',
							),
						),

					),
				)
			),
			'header_media_effect' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'value' => array(
					'effect' => $wplab_albedo_core->default_options['header_media_effect'],
				),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_media_effect',
				),
				'picker' => array(
					'effect' => array(
						'label' => esc_html__( 'Media Effects', 'albedo' ),
						'type' => 'radio',
						'choices' => array(
							'' => esc_html__( 'No Effects', 'albedo' ),
							'video' => esc_html__( 'YouTube Video Background', 'albedo' ),
							'particleground' => esc_html__( 'Particle Groud Effect', 'albedo' ),
							'particles' => esc_html__( 'Particles Effect', 'albedo' ),
						),
					)
				),
				'choices' => array(

					'particleground' => array(

						'dot_color' => array(
							'label' => esc_html__('Dots Color', 'albedo'),
							'type' => 'color-picker',
							'value' => $wplab_albedo_core->default_options['header_particleground_dot_color'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_dot_color',
							),
						),
						'line_color' => array(
							'label' => esc_html__('Lines Color', 'albedo'),
							'type' => 'color-picker',
							'value' => $wplab_albedo_core->default_options['header_particleground_line_color'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_line_color',
							),
						),
						'particle_radius' => array(
							'label' => esc_html__('Dot size', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particleground_particle_radius'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_particle_radius',
							),
						),
						'line_width' => array(
							'label' => esc_html__('Line width', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particleground_line_width'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_line_width',
							),
						),
						'curved_lines' => array(
							'label' => esc_html__( 'Curved lines', 'albedo' ),
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
							'value' => $wplab_albedo_core->default_options['header_particleground_curved_lines'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_curved_lines',
							),
						),
						'parallax' => array(
							'label' => esc_html__( 'Parallax effect', 'albedo' ),
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
							'value' => $wplab_albedo_core->default_options['header_particleground_parallax'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_parallax',
							),
						),
						'parallax_multiplier' => array(
							'label' => esc_html__('Parallax Multiplier', 'albedo'),
							'desc' => esc_html__( 'The lower the number, the more extreme the parallax effect wil be.', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particleground_parallax_multiplier'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_parallax_multiplier',
							),
						),
						'proximity' => array(
							'label' => esc_html__('Proximity', 'albedo'),
							'desc' => esc_html__( 'How close two dots need to be, in pixels, before they join.', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particleground_proximity'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_proximity',
							),
						),
						'min_speed_x' => array(
							'label' => esc_html__('Minimum speed X', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particleground_min_speed_x'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_min_speed_x',
							),
						),
						'max_speed_x' => array(
							'label' => esc_html__('Maximum speed X', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particleground_max_speed_x'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_max_speed_x',
							),
						),
						'min_speed_y' => array(
							'label' => esc_html__('Minimum speed Y', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particleground_min_speed_y'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_min_speed_y',
							),
						),
						'max_speed_y' => array(
							'label' => esc_html__('Maximum speed Y', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particleground_max_speed_y'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_max_speed_y',
							),
						),
						'direction_x' => array(
							'label' => esc_html__( 'Direction X', 'albedo' ),
							'desc' => esc_html__( 'Means that the dots will bounce off the edges of the canvas', 'albedo'),
							'type' => 'select',
							'choices' => array(
								'center' => esc_html__( 'Center', 'albedo' ),
								'left' => esc_html__( 'Left', 'albedo' ),
								'right' => esc_html__( 'Right', 'albedo' ),
							),
							'value' => $wplab_albedo_core->default_options['header_particleground_direction_x'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_direction_x',
							),
						),
						'direction_y' => array(
							'label' => esc_html__( 'Direction Y', 'albedo' ),
							'desc' => esc_html__( 'Means that the dots will bounce off the edges of the canvas', 'albedo'),
							'type' => 'select',
							'choices' => array(
								'center' => esc_html__( 'Center', 'albedo' ),
								'left' => esc_html__( 'Left', 'albedo' ),
								'right' => esc_html__( 'Right', 'albedo' ),
							),
							'value' => $wplab_albedo_core->default_options['header_particleground_direction_y'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_direction_y',
							),
						),
						'destiny' => array(
							'label' => esc_html__('Destiny', 'albedo'),
							'desc' => esc_html__( 'Determines how many particles will be generated: one particle every n pixels.', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particleground_destiny'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particleground_destiny',
							),
						),
					),
					'particles' => array(
						'number' => array(
							'label' => esc_html__('Particles number', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_number'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_number',
							),
						),
						'density' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Enable density', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['header_particles_density'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'header_particles_density',
									),
								)
							),
							'choices' => array(
								'yes' => array(

									'density_value' => array(
										'label' => esc_html__('Density value', 'albedo'),
										'type' => 'short-text',
										'value' => $wplab_albedo_core->default_options['header_particles_density_value'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_density_value',
										),
									),

								)
							)
						),
						'color' => array(
							'label' => esc_html__('Particles color', 'albedo'),
							'type' => 'color-picker',
							'value' => $wplab_albedo_core->default_options['header_particles_color'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_color',
							),
						),
						'shape_type' => array(
							'label' => esc_html__( 'Shape type', 'albedo' ),
							'type' => 'select',
							'choices' => array(
								'circle' => esc_html__( 'Circle', 'albedo' ),
								'edge' => esc_html__( 'Edge', 'albedo' ),
								'triangle' => esc_html__( 'Triangle', 'albedo' ),
								'polygon' => esc_html__( 'Polygon', 'albedo' ),
								'star' => esc_html__( 'Star', 'albedo' ),
							),
							'value' => $wplab_albedo_core->default_options['header_particles_shape_type'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_shape_type',
							),
						),
						'stroke_width' => array(
							'label' => esc_html__('Shape stroke width', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_stroke_width'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_stroke_width',
							),
						),
						'stroke_color' => array(
							'label' => esc_html__('Shape stroke color', 'albedo'),
							'type' => 'color-picker',
							'value' => $wplab_albedo_core->default_options['header_particles_stroke_color'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_stroke_color',
							),
						),
						'polygon_sides' => array(
							'label' => esc_html__('Polygon sides', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_polygon_sides'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_polygon_sides',
							),
						),
						'opacity' => array(
							'label' => esc_html__('Opacity', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_opacity'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_opacity',
							),
						),
						'opacity_rand' => array(
							'label' => esc_html__( 'Opacity random', 'albedo' ),
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
							'value' => $wplab_albedo_core->default_options['header_particles_opacity_rand'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_opacity_rand',
							),
						),
						'animate_opacity' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Animate opacity', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['header_particles_animate_opacity'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'header_particles_animate_opacity',
									),
								)
							),
							'choices' => array(
								'yes' => array(

									'speed' => array(
										'label' => esc_html__('Animate speed', 'albedo'),
										'type' => 'short-text',
										'value' => $wplab_albedo_core->default_options['header_particles_animate_opacity_speed'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_animate_opacity_speed',
										),
									),
									'size_min' => array(
										'label' => esc_html__('Opacity min', 'albedo'),
										'type' => 'short-text',
										'value' => $wplab_albedo_core->default_options['header_particles_animate_opacity_size_min'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_animate_opacity_size_min',
										),
									),
									'sync' => array(
										'label' => esc_html__( 'Sync animation', 'albedo' ),
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
										'value' => $wplab_albedo_core->default_options['header_particles_animate_opacity_sync'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_animate_opacity_sync',
										),
									),

								)
							)
						),
						'size' => array(
							'label' => esc_html__('Size', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_size'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_size',
							),
						),
						'size_rand' => array(
							'label' => esc_html__( 'Random size', 'albedo' ),
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
							'value' => $wplab_albedo_core->default_options['header_particles_size_rand'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_size_rand',
							),
						),
						'animate_size' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Animate size', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['header_particles_animate_size'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'header_particles_animate_size',
									),
								)
							),
							'choices' => array(
								'yes' => array(

									'speed' => array(
										'label' => esc_html__('Animate size speed', 'albedo'),
										'type' => 'short-text',
										'value' => $wplab_albedo_core->default_options['header_particles_animate_size_speed'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_animate_size_speed',
										),
									),
									'size_min' => array(
										'label' => esc_html__('Animate min size', 'albedo'),
										'type' => 'short-text',
										'value' => $wplab_albedo_core->default_options['header_particles_animate_size_min'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_animate_size_min',
										),
									),
									'sync' => array(
										'label' => esc_html__( 'Sync size animation', 'albedo' ),
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
										'value' => $wplab_albedo_core->default_options['header_particles_animate_sync'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_animate_sync',
										),
									),

								)
							)
						),
						'lines' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Enable linked lines', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['header_particles_lines'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'header_particles_lines',
									),
								)
							),
							'choices' => array(
								'yes' => array(

									'distance' => array(
										'label' => esc_html__('Distance', 'albedo'),
										'type' => 'short-text',
										'value' => $wplab_albedo_core->default_options['header_particles_lines_distance'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_lines_distance',
										),
									),
									'color' => array(
										'label' => esc_html__('Color', 'albedo'),
										'type' => 'color-picker',
										'value' => $wplab_albedo_core->default_options['header_particles_lines_color'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_lines_color',
										),
									),
									'opacity' => array(
										'label' => esc_html__('Opacity', 'albedo'),
										'type' => 'short-text',
										'value' => $wplab_albedo_core->default_options['header_particles_lines_opacity'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_lines_opacity',
										),
									),
									'width' => array(
										'label' => esc_html__('Width', 'albedo'),
										'type' => 'short-text',
										'value' => $wplab_albedo_core->default_options['header_particles_lines_width'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_lines_width',
										),
									),

								)
							)
						),
						'move' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Enable move', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['header_particles_move'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'header_particles_move',
									),
								)
							),
							'choices' => array(
								'yes' => array(

									'direction' => array(
										'label' => esc_html__( 'Move direction', 'albedo' ),
										'type' => 'select',
										'value' => $wplab_albedo_core->default_options['header_particles_move_direction'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_move_direction',
										),
										'choices' => array(
											'none' => esc_html__( 'None', 'albedo' ),
											'top' => esc_html__( 'Top', 'albedo' ),
											'top-right' => esc_html__( 'Top right', 'albedo' ),
											'right' => esc_html__( 'Right', 'albedo' ),
											'bottom-right' => esc_html__( 'Bottom Right', 'albedo' ),
											'bottom' => esc_html__( 'Bottom', 'albedo' ),
											'bottom-left' => esc_html__( 'Bottom Left', 'albedo' ),
											'left' => esc_html__( 'Left', 'albedo' ),
											'top-left' => esc_html__( 'Top Left', 'albedo' ),
										),
									),
									'rand' => array(
										'label' => esc_html__( 'Random', 'albedo' ),
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
										'value' => $wplab_albedo_core->default_options['header_particles_move_rand'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_move_rand',
										),
									),
									'straight' => array(
										'label' => esc_html__( 'Straight', 'albedo' ),
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
										'value' => $wplab_albedo_core->default_options['header_particles_move_straight'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_move_straight',
										),
									),
									'speed' => array(
										'label' => esc_html__('Speed', 'albedo'),
										'type' => 'short-text',
										'value' => $wplab_albedo_core->default_options['header_particles_move_speed'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_move_speed',
										),
									),
									'out_mode' => array(
										'label' => esc_html__( 'Out mode', 'albedo' ),
										'type' => 'select',
										'value' => $wplab_albedo_core->default_options['header_particles_move_out_mode'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_move_out_mode',
										),
										'choices' => array(
											'none' => esc_html__( 'Out', 'albedo' ),
											'bounce' => esc_html__( 'Bounce', 'albedo' ),
										),
									),

								)
							)
						),
						'onhover' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Enable hover effect', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['header_particles_onhover'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'header_particles_onhover',
									),
								)
							),
							'choices' => array(
								'yes' => array(

									'mode' => array(
										'label' => esc_html__( 'Hover mode', 'albedo' ),
										'type' => 'select',
										'value' => $wplab_albedo_core->default_options['header_particles_onhover_mode'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_onhover_mode',
										),
										'choices' => array(
											'grab' => esc_html__( 'Grab', 'albedo' ),
											'bubble' => esc_html__( 'Bubble', 'albedo' ),
											'repulse' => esc_html__( 'Repulse', 'albedo' ),
										),
									),

								)
							)
						),
						'onclick' => array(
							'type' => 'multi-picker',
							'label' => false,
							'desc' => false,
							'picker' => array(
								'enabled' => array(
									'label' => esc_html__( 'Enable click effect', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['header_particles_onclick'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'header_particles_onclick',
									),
								)
							),
							'choices' => array(
								'yes' => array(

									'mode' => array(
										'label' => esc_html__( 'Click mode', 'albedo' ),
										'type' => 'select',
										'value' => $wplab_albedo_core->default_options['header_particles_onclick_mode'],
										'fw-storage' => isset($no_fw_storage) ? null : array(
											'type' => 'wp-option',
											'wp-option' => $settings_wp_option,
											'key' => 'header_particles_onclick_mode',
										),
										'choices' => array(
											'push' => esc_html__( 'Push', 'albedo' ),
											'remove' => esc_html__( 'Remove', 'albedo' ),
											'bubble' => esc_html__( 'Bubble', 'albedo' ),
											'repulse' => esc_html__( 'Repulse', 'albedo' ),
										),
									),

								)
							)
						),
						'grab_distance' => array(
							'label' => esc_html__('Grab distance', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_grab_distance'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_grab_distance',
							),
						),
						'grab_opacity' => array(
							'label' => esc_html__('Grab opacity', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_grab_opacity'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_grab_opacity',
							),
						),
						'bubble_distance' => array(
							'label' => esc_html__('Bubble distance', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_bubble_distance'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_bubble_distance',
							),
						),
						'bubble_size' => array(
							'label' => esc_html__('Bubble size', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_bubble_size'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_bubble_size',
							),
						),
						'bubble_duration' => array(
							'label' => esc_html__('Bubble duration', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_bubble_duration'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_bubble_duration',
							),
						),
						'bubble_opacity' => array(
							'label' => esc_html__('Bubble opacity', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_bubble_opacity'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_bubble_opacity',
							),
						),
						'bubble_speed' => array(
							'label' => esc_html__('Bubble speed', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_bubble_speed'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_bubble_speed',
							),
						),
						'repulse_distance' => array(
							'label' => esc_html__('Repulse distance', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_repulse_distance'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_repulse_distance',
							),
						),
						'repulse_duration' => array(
							'label' => esc_html__('Repulse duration', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_particles_repulse_duration'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_particles_repulse_duration',
							),
						),

					),
					'video' => array(

						'video' => array(
							'label' => esc_html__('Video URL', 'albedo'),
							'desc' => esc_html__('Insert YouTube Video URL to embed this video as a header background', 'albedo'),
							'type' => 'text',
							'value' => $wplab_albedo_core->default_options['header_videobg_url'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_videobg_url',
							),
						),
						'video_fallback_image' => array(
							'label' => esc_html__( 'Fallback image for mobile devices', 'albedo' ),
							'desc' => esc_html__( 'The path to the fallback image in case of background video on mobile devices', 'albedo' ),
							'type' => 'upload',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_media_effect/video/video_fallback_image',
							),
						),
								'video_fallback_image' => array(
							'label' => esc_html__( 'Fallback image for mobile devices', 'albedo' ),
							'desc' => esc_html__( 'The path to the fallback image in case of background video on mobile devices', 'albedo' ),
							'type' => 'upload',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_media_effect/video/video_fallback_image',
							),
						),
						'video_mute' => array(
							'label' => esc_html__('Mute video', 'albedo'),
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
							'value' => $wplab_albedo_core->default_options['header_videobg_video_mute'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_videobg_video_mute',
							),
						),
						'video_parallax_speed' => array(
							'label' => esc_html__('Video parallax speed', 'albedo'),
							'desc' => esc_html__('Example: 0.2 Leave it empty to disable parallax', 'albedo'),
							'type' => 'short-text',
							'value' => $wplab_albedo_core->default_options['header_videobg_parallax_speed'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'header_videobg_parallax_speed',
							),
						),

					),
				)
			),

		)
	),
	'menu' => array(
		'title' => esc_html__('Menu Layout', 'albedo'),
		'type' => 'box',
		'options' => array(

			'menu_style' => array(
				'type' => 'multi-picker',
				'label' => false,
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_style',
				),
				'picker' => array(

						'style' => array(
						'type'  => 'image-picker',
						'value' => $wplab_albedo_core->default_options['menu_style'],
						'label' => esc_html__('Header menu style', 'albedo'),
						'choices' => array(
							'classic' => get_template_directory_uri() .'/images/menu1.png',
							//'two_menus' => get_template_directory_uri() .'/images/menu2.png',
							//'centered' => get_template_directory_uri() .'/images/menu3.png',
							'minimal' => get_template_directory_uri() .'/images/menu4.png',
						),
						'blank' => false,
					),

				),
				'choices' => array(
					'minimal' => array(

						'submenu_minimal_style' => array(
							'type'  => 'image-picker',
							'value' => $wplab_albedo_core->default_options['submenu_minimal_style'],
							'label' => esc_html__('Sub-menu style', 'albedo'),
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'submenu_minimal_style',
							),
							'choices' => array(
								'style_1' => get_template_directory_uri() .'/images/minimal_menu1.jpg',
								'style_2' => get_template_directory_uri() .'/images/minimal_menu2.jpg',
								'style_3' => get_template_directory_uri() .'/images/minimal_menu3.jpg',
								'style_4' => get_template_directory_uri() .'/images/minimal_menu4.jpg',
							),
							'blank' => false,
						),

						'submenu_minimal_free_text' => array(
							'type'  => 'textarea',
							'label' => esc_html__('Text after menu', 'albedo'),
							'desc' => esc_html__('if layout supports it', 'albedo'),
							'value' => $wplab_albedo_core->default_options['submenu_minimal_free_text'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'submenu_minimal_free_text',
							),
						),

					)
				)
			),
			'menu_responsive_at' => array(
				'label' => esc_html__( 'Responsive at', 'albedo' ),
				'type' => 'short-text',
				'value' => $wplab_albedo_core->default_options['menu_responsive_at'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_responsive_at',
				),
				'desc' => esc_html__( 'type here a screen width when menu will be switched into responsive mode', 'albedo' ),
			),
			'menu_cta' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_cta',
				),
				'picker' => array(

					'enabled' => array(
						'label' => esc_html__( 'Display Call To Action button', 'albedo' ),
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
						'value' => $wplab_albedo_core->default_options['menu_cta'],
					)

				),
				'choices' => array(
					'yes' => array(

						'menu_cta_button_text' => array(
							'type'  => 'text',
							'label' => esc_html__('CTA Button Text', 'albedo'),
							'value' => $wplab_albedo_core->default_options['menu_cta_button_text'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'menu_cta_button_text',
							),
						),
						'menu_cta_button_url' => array(
							'type'  => 'text',
							'label' => esc_html__('CTA Button URL', 'albedo'),
							'value' => $wplab_albedo_core->default_options['menu_cta_button_url'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'menu_cta_button_url',
							),
						),
						'menu_cta_button_style'  => array(
							'label'   => esc_html__( 'CTA Button Style', 'albedo' ),
							'type'    => 'select',
							'value' => $wplab_albedo_core->default_options['menu_cta_button_style'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'menu_cta_button_style',
							),
							'choices' => $wplab_albedo_core->cfg['button_styles']
						),

					)
				)
			),
			'menu_search' => array(
				'label' => esc_html__( 'Display search icon', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_search',
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
				'value' => $wplab_albedo_core->default_options['menu_search'],
			),
			'menu_cart' => array(
				'label' => esc_html__( 'Display cart icon', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_cart',
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
				'value' => $wplab_albedo_core->default_options['menu_cart'],
			),
			'menu_side_overlay' => array(
				'label' => esc_html__( 'Enable side overlay menu', 'albedo' ),
				'desc' => esc_html__( 'This option adds additional overlay menu, you can add any of available widgets to this menu through Sidebars Options', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_side_overlay',
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
				'value' => $wplab_albedo_core->default_options['menu_side_overlay'],
			),
			'menu_container_height' => array(
				'type'  => 'short-text',
				'label' => esc_html__( 'Menu container height', 'albedo'),
				'desc' => esc_html__( 'value in pixels, e.g.: 100', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_container_height'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_height',
				),
			),
				'menu_items_right_margin' => array(
				'type'  => 'short-text',
				'label' => esc_html__( 'Menu items right margin', 'albedo'),
				'desc' => esc_html__( 'value in pixels, e.g.: 30', 'albedo'),
				'value' => $wplab_albedo_core->default_options['menu_items_right_margin'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_items_right_margin',
				),
			),
			'menu_items_left_margin' => array(
				'type'  => 'short-text',
				'label' => esc_html__( 'Menu items left margin', 'albedo'),
				'desc' => esc_html__( 'value in pixels, e.g.: 30', 'albedo'),
				'value' => $wplab_albedo_core->default_options['menu_items_left_margin'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_items_left_margin',
				),
			),
			'menu_scrolling' => array(
				'type' => 'multi-picker',
				'label' => false,
				'desc' => false,
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_scrolling',
				),
				'picker' => array(

					'enabled' => array(
						'label' => esc_html__( 'Scroll menu', 'albedo' ),
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
						'value' => $wplab_albedo_core->default_options['menu_scrolling'],
					)

				),
				'choices' => array(
					'yes' => array(

						'menu_container_height_scrolled' => array(
							'type'  => 'short-text',
							'label' => esc_html__( 'Scrolled menu container height', 'albedo'),
							'desc' => esc_html__( 'value in pixels, e.g.: 100', 'albedo'),
							'value' => $wplab_albedo_core->default_styles['menu_container_height_scrolled'],
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'menu_scrolling/yes/menu_container_height_scrolled',
							),
						),
						'do_not_scroll_on_mobiles' => array(
							'label' => esc_html__( 'Do not scroll menu on mobiles', 'albedo' ),
							'type' => 'switch',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'menu_scrolling/yes/do_not_scroll_on_mobiles',
							),
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Yes', 'albedo' )
							),
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'No', 'albedo' )
							),
							'value' => $wplab_albedo_core->default_options['do_not_scroll_on_mobiles'],
						),
						'do_not_scroll_on_singles' => array(
							'label' => esc_html__( 'Do not scroll menu on single posts', 'albedo' ),
							'type' => 'switch',
							'fw-storage' => isset($no_fw_storage) ? null : array(
								'type' => 'wp-option',
								'wp-option' => $settings_wp_option,
								'key' => 'menu_scrolling/yes/do_not_scroll_on_singles',
							),
							'right-choice' => array(
								'value' => 'yes',
								'label' => esc_html__( 'Yes', 'albedo' )
							),
							'left-choice' => array(
								'value' => 'no',
								'color' => '#ccc',
								'label' => esc_html__( 'No', 'albedo' )
							),
							'value' => $wplab_albedo_core->default_options['do_not_scroll_on_singles'],
						),

					),
				),
			),


		)
	),
	'menu_styles' => array(
		'title' => esc_html__('Menu Container Styles (Background, Shadows, etc.)', 'albedo'),
		'type' => 'box',
		'options' => array(

			'menu_container_bg_gradient' => array(
				'label' => esc_html__('Menu Container Background Color', 'albedo'),
				'desc' => esc_html__('This option changes container background color (if header layout supports it)', 'albedo'),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_bg_gradient',
				),
				'value' => array(
					'primary'   => $wplab_albedo_core->default_styles['menu_container_bg_gradient_from'],
					'secondary' => $wplab_albedo_core->default_styles['menu_container_bg_gradient_to'],
				),
				'type' => 'gradient',
			),
			'menu_container_bg_enabled' => array(
				'label' => esc_html__( 'Background color', 'albedo' ),
				'desc' => esc_html__( 'here you can disable background color to make transparent container for menu', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_bg_enabled',
				),
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'Disabled', 'albedo' )
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Enabled', 'albedo' )
				),
				'value' => $wplab_albedo_core->default_options['menu_container_bg_enabled'],
			),
				'menu_scroll_container_bg_enabled' => array(
				'label' => esc_html__( 'Background color in Scroll Mode', 'albedo' ),
				'desc' => esc_html__( 'here you can disable background color to make transparent container for menu in Scroll Mode', 'albedo' ),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_scroll_container_bg_enabled',
				),
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'Disabled', 'albedo' )
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Enabled', 'albedo' )
				),
				'value' => $wplab_albedo_core->default_options['menu_scroll_container_bg_enabled'],
			),
			'menu_container_bg_pos' => array(
				'label' => esc_html__( 'Background Gradient Position', 'albedo' ),
				'type' => 'select',
				'value' => $wplab_albedo_core->default_styles['menu_container_bg_pos'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_bg_pos',
				),
				'choices' => array(
					'to bottom right' => esc_html__( 'To bottom right', 'albedo' ),
					'to bottom' => esc_html__( 'To bottom', 'albedo' ),
					'to bottom left' => esc_html__( 'To bottom left', 'albedo' ),
					'to right' => esc_html__( 'To right', 'albedo' ),
					'to left' => esc_html__( 'To left', 'albedo' ),
					'to top right' => esc_html__( 'To top right', 'albedo' ),
					'to top' => esc_html__( 'To top', 'albedo' ),
					'to top left' => esc_html__( 'To top left', 'albedo' ),
				),
			),
			'menu_container_bg_image_src' => array(
				'label' => esc_html__('Menu Container Background Image', 'albedo'),
				'desc' => esc_html__('Upload background image', 'albedo'),
				'type' => 'background-image',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_bg_image_src',
				),
			),
			'menu_container_bg_image_position' => array(
				'label' => esc_html__( 'Menu Container Background Image Position', 'albedo' ),
				'type' => 'select',
				'value' => $wplab_albedo_core->default_styles['menu_container_bg_image_position'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_bg_image_position',
				),
				'choices' => array(
					'left top' => esc_html__( 'Left Top', 'albedo' ),
					'center top' => esc_html__( 'Center Top', 'albedo' ),
					'right top' => esc_html__( 'Right Top', 'albedo' ),
					'left bottom' => esc_html__( 'Left Bottom', 'albedo' ),
					'center bottom' => esc_html__( 'Center Bottom', 'albedo' ),
					'right bottom' => esc_html__( 'Right Bottom', 'albedo' ),
					'left center' => esc_html__( 'Left Center', 'albedo' ),
					'center center' => esc_html__( 'Center Center', 'albedo' ),
					'right center' => esc_html__( 'Right Center', 'albedo' ),
				),
			),
			'menu_container_bg_image_repeat' => array(
				'label' => esc_html__( 'Menu Container Background Image Repeat', 'albedo' ),
				'type' => 'select',
				'value' => $wplab_albedo_core->default_styles['menu_container_bg_image_repeat'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_bg_image_repeat',
				),
				'choices' => array(
					'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
					'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
					'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
					'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
				),
			),
			'menu_container_shadow_color' => array(
				'label' => esc_html__('Menu Container Shadow Color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_container_shadow_color'],
				'type' => 'rgba-color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_shadow_color',
				),
			),
			'menu_container_shadow_h_length' => array(
			'type'  => 'short-text',
			'value' => $wplab_albedo_core->default_styles['menu_container_shadow_h_length'],
			'label' => esc_html__( 'Menu Container Horizontal Shadow Length', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_shadow_h_length',
				),
			),
			'menu_container_shadow_v_length' => array(
			'type'  => 'short-text',
			'value' => $wplab_albedo_core->default_styles['menu_container_shadow_v_length'],
			'label' => esc_html__( 'Menu Container Vertical Shadow Length', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_shadow_v_length',
				),
			),
			'menu_container_shadow_blur_radius' => array(
			'type'  => 'short-text',
			'value' => $wplab_albedo_core->default_styles['menu_container_shadow_blur_radius'],
			'label' => esc_html__( 'Menu Container Shadow Blur Radius', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_shadow_blur_radius',
				),
			),
			'menu_container_display_shadow' => array(
				'label' => esc_html__( 'Display Header shadow', 'albedo' ),
				'type' => 'radio',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_display_shadow',
				),
				'choices' => array(
					'no' => esc_html__( 'No', 'albedo' ),
					'yes' => esc_html__( 'Yes', 'albedo' ),
				),
				'value' => $wplab_albedo_core->default_options['menu_container_display_shadow'],
			),
			'menu_container_display_shadow_transp_header' => array(
				'label' => esc_html__( 'Display shadow in Slider Header Mode', 'albedo' ),
				'desc' => esc_html__( 'display or hide shadow for menu container in Slider Header Mode', 'albedo' ),
				'type' => 'radio',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_container_display_shadow_transp_header',
				),
				'choices' => array(
					'no' => esc_html__( 'No', 'albedo' ),
					'yes' => esc_html__( 'Yes', 'albedo' ),
					'yes_onscroll' => esc_html__( 'Yes, but on scroll only', 'albedo' ),
				),
				'value' => $wplab_albedo_core->default_options['menu_container_display_shadow_transp_header'],
			),

		)
	),
	'menu_customizer' => array(
		'title' => esc_html__('Menu Links Colors', 'albedo'),
		'type' => 'box',
		'options' => array(

			'menu_text_size' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['menu_text_size'],
				'label' => esc_html__( 'Menu Links Fonts Size', 'albedo' ),
				'desc' => esc_html__( 'value in pixels', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_text_size',
				),
			),
			'menu_text_line_height' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['menu_text_line_height'],
				'label' => esc_html__( 'Menu Links Line Height', 'albedo' ),
				'desc' => esc_html__( 'value in pixels', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_text_line_height',
				),
			),
			'menu_link_color' => array(
				'label' => esc_html__('Link color', 'albedo'),
				'desc' => esc_html__('Used in top-level menu', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_link_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_link_color',
				),
			),
			'menu_link_icon_color' => array(
				'label' => esc_html__('Link icon color', 'albedo'),
				'desc' => esc_html__('Used in top-level menu. This is a color of menu icon that appears on the left side of menu item.', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_link_icon_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_link_icon_color',
				),
			),
			'menu_desc_color' => array(
				'label' => esc_html__('Description text color', 'albedo'),
				'desc' => esc_html__('Used in top-level menu. Any of menu item can have description text.', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_desc_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_desc_color',
				),
			),
			'menu_accent_color' => array(
				'label' => esc_html__('Accent color', 'albedo'),
				'desc' => esc_html__('Used in top-level menu. This is a hover / active color.', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_accent_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_accent_color',
				),
			),
			'menu_accent_inner_color' => array(
				'label' => esc_html__('Accent inner color', 'albedo'),
				'desc' => esc_html__('e.g. Used as text color in Shopping Cart widget', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_accent_inner_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_accent_inner_color',
				),
			),
			'menu_widget_icon_color' => array(
				'label' => esc_html__('Menu widget icon color', 'albedo'),
				'desc' => esc_html__('Icon color for header widgets, e.g.: cart, search etc.', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_widget_icon_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_widget_icon_color',
				),
			),
			'menu_widget_icon_notice_bg_color' => array(
				'label' => esc_html__('Widget notice background color', 'albedo'),
				'desc' => esc_html__('E.g. used in Cart widget to display number of products', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_widget_icon_notice_bg_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_widget_icon_notice_bg_color',
				),
			),
			'menu_widget_icon_notice_text_color' => array(
				'label' => esc_html__('Widget notice text color', 'albedo'),
				'desc' => esc_html__('E.g. used in Cart widget. This is a color of text inside notice.', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_widget_icon_notice_text_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_widget_icon_notice_text_color',
				),
			),
			'menu_transp_link_color' => array(
				'label' => esc_html__('Link color (for Transparent Header mode)', 'albedo'),
				'desc' => esc_html__('Used in top-level menu', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_transp_link_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_transp_link_color',
				),
			),
			'menu_transp_link_icon_color' => array(
				'label' => esc_html__('Link icon color (for Transparent Header mode)', 'albedo'),
				'desc' => esc_html__('Used in top-level menu. This is a color of menu icon that appears on the left side of menu item.', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_transp_link_icon_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_transp_link_icon_color',
				),
			),
			'menu_transp_desc_color' => array(
				'label' => esc_html__('Description text color (for Transparent Header mode)', 'albedo'),
				'desc' => esc_html__('Used in top-level menu. Any of menu item can have description text.', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_transp_desc_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_transp_desc_color',
				),
			),
			'menu_transp_accent_color' => array(
				'label' => esc_html__('Accent color (for Transparent Header mode)', 'albedo'),
				'desc' => esc_html__('Used in top-level menu. This is a hover / active color.', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_transp_accent_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_transp_accent_color',
				),
			),
			'menu_transp_widget_icon_color' => array(
				'label' => esc_html__('Menu widget icon color (for Transparent Header mode)', 'albedo'),
				'desc' => esc_html__('Icon color for header widgets, e.g.: cart, search etc.', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['menu_transp_widget_icon_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'menu_transp_widget_icon_color',
				),
			),

		)
	),
	'submenu_customizer' => array(
		'title' => esc_html__('Dropdown Menu', 'albedo'),
		'type' => 'box',
		'options' => array(

			'submenu_text_size' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['submenu_text_size'],
				'label' => esc_html__( 'Sub-Menu Links Fonts Size', 'albedo' ),
				'desc' => esc_html__( 'value in pixels', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_text_size',
				),
			),
			'submenu_text_line_height' => array(
			'type'  => 'short-text',
			'value' => $wplab_albedo_core->default_styles['submenu_text_line_height'],
			'label' => esc_html__( 'Sub-Menu Links Line Height', 'albedo' ),
			'desc' => esc_html__( 'value in pixels', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_text_line_height',
				),
			),
			'submenu_bg_color' => array(
				'label' => esc_html__('Background color', 'albedo'),
				'desc' => esc_html__('Background color of drop-down menu', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['submenu_bg_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_bg_color',
				),
			),
			'submenu_corners' => array(
				'type' => 'short-text',
				'value' => $wplab_albedo_core->default_styles['submenu_corners'],
				'label' => esc_html__( 'Border radius', 'albedo'),
				'desc' => esc_html__( 'Value in pixels', 'albedo'),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_corners',
				),
			),
			'submenu_shadow_color' => array(
				'label' => esc_html__('Shadow color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['submenu_shadow_color'],
				'type' => 'rgba-color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_shadow_color',
				),
			),
			'submenu_shadow_h_length' => array(
					'type'  => 'short-text',
					'value' => $wplab_albedo_core->default_styles['submenu_shadow_h_length'],
					'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_shadow_h_length',
				),
			),
			'submenu_shadow_v_length' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['submenu_shadow_v_length'],
				'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_shadow_v_length',
				),
			),
			'submenu_shadow_blur_radius' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['submenu_shadow_blur_radius'],
				'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_shadow_blur_radius',
				),
			),
			'submenu_link_color' => array(
				'label' => esc_html__('Link color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['submenu_link_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_link_color',
				),
			),
			'submenu_desc_color' => array(
				'label' => esc_html__('Description text color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['submenu_desc_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_desc_color',
				),
			),
			'submenu_icon_color' => array(
				'label' => esc_html__('Icon color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['submenu_icon_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_icon_color',
				),
			),
			'submenu_border_color' => array(
				'label' => esc_html__('Borders color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['submenu_border_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_border_color',
				),
			),
			'submenu_accent_color' => array(
				'label' => esc_html__('Accent color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['submenu_accent_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_accent_color',
				),
			),
			'submenu_overlay_bg_color' => array(
				'label' => esc_html__('Overlay background color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['submenu_overlay_bg_color'],
				'type' => 'rgba-color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_overlay_bg_color',
				),
			),
			'submenu_overlay_close_color' => array(
				'label' => esc_html__('Close overlay icon color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['submenu_overlay_close_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'submenu_overlay_close_color',
				),
			),

		)
	),
	'header_second_menu_style' => array(
		'title' => esc_html__('Second Menu Colors', 'albedo'),
		'type' => 'box',
		'options' => array(

			'header_second_menu_text_color' => array(
				'label' => esc_html__('Second Menu Links Color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_second_menu_text_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_text_color',
				),
			),
			'header_second_menu_active_color' => array(
				'label' => esc_html__('Second Menu Active / Hover Text Color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_second_menu_active_color'],
				'type' => 'color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_active_color',
				),
			),
			'header_second_menu_bg_gradient' => array(
				'label' => esc_html__('Second Menu Container Background Color', 'albedo'),
				'desc' => esc_html__('This option changes container background color (if header layout supports it)', 'albedo'),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_bg_gradient',
				),
				'value' => array(
					'primary'   => $wplab_albedo_core->default_styles['header_second_menu_bg_gradient_from'],
					'secondary' => $wplab_albedo_core->default_styles['header_second_menu_bg_gradient_to'],
				),
				'type' => 'gradient',
			),
			'header_second_menu_bg_pos' => array(
				'label' => esc_html__( 'Background Gradient Position', 'albedo' ),
				'type' => 'select',
				'value' => $wplab_albedo_core->default_styles['header_second_menu_bg_pos'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_bg_pos',
				),
				'choices' => array(
					'to bottom right' => esc_html__( 'To bottom right', 'albedo' ),
					'to bottom' => esc_html__( 'To bottom', 'albedo' ),
					'to bottom left' => esc_html__( 'To bottom left', 'albedo' ),
					'to right' => esc_html__( 'To right', 'albedo' ),
					'to left' => esc_html__( 'To left', 'albedo' ),
					'to top right' => esc_html__( 'To top right', 'albedo' ),
					'to top' => esc_html__( 'To top', 'albedo' ),
					'to top left' => esc_html__( 'To top left', 'albedo' ),
				),
			),
			'header_second_menu_bg_image_src' => array(
				'label' => esc_html__('Second Menu Background Image', 'albedo'),
				'desc' => esc_html__('Upload background image', 'albedo'),
				'type' => 'background-image',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_bg_image_src',
				),
			),
			'header_second_menu_bg_image_position' => array(
				'label' => esc_html__( 'Second Menu Background Image Position', 'albedo' ),
				'type' => 'select',
				'value' => $wplab_albedo_core->default_styles['header_second_menu_bg_image_position'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_bg_image_position',
				),
				'choices' => array(
					'left top' => esc_html__( 'Left Top', 'albedo' ),
					'center top' => esc_html__( 'Center Top', 'albedo' ),
					'right top' => esc_html__( 'Right Top', 'albedo' ),
					'left bottom' => esc_html__( 'Left Bottom', 'albedo' ),
					'center bottom' => esc_html__( 'Center Bottom', 'albedo' ),
					'right bottom' => esc_html__( 'Right Bottom', 'albedo' ),
					'left center' => esc_html__( 'Left Center', 'albedo' ),
					'center center' => esc_html__( 'Center Center', 'albedo' ),
					'right center' => esc_html__( 'Right Center', 'albedo' ),
				),
			),
			'header_second_menu_bg_image_repeat' => array(
				'label' => esc_html__( 'Second Menu Background Image Repeat', 'albedo' ),
				'type' => 'select',
				'value' => $wplab_albedo_core->default_styles['header_second_menu_bg_image_repeat'],
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_bg_image_repeat',
				),
				'choices' => array(
					'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
					'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
					'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
					'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
				),
			),
			'header_second_menu_shadow_color' => array(
				'label' => esc_html__('Second Menu Shadow Color', 'albedo'),
				'value' => $wplab_albedo_core->default_styles['header_second_menu_shadow_color'],
				'type' => 'rgba-color-picker',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_shadow_color',
				),
			),
			'header_second_menu_shadow_h_length' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['header_second_menu_shadow_h_length'],
				'label' => esc_html__( 'Second Menu Horizontal Shadow Length', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_shadow_h_length',
				),
			),
			'header_second_menu_shadow_v_length' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['header_second_menu_shadow_v_length'],
				'label' => esc_html__( 'Second Menu Vertical Shadow Length', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_shadow_v_length',
				),
			),
			'header_second_menu_shadow_blur_radius' => array(
				'type'  => 'short-text',
				'value' => $wplab_albedo_core->default_styles['header_second_menu_shadow_blur_radius'],
				'label' => esc_html__( 'Second Menu Shadow Blur Radius', 'albedo' ),
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'header_second_menu_shadow_blur_radius',
				),
			),

				)
			),
		'breadcrumbs_style' => array(
			'title' => esc_html__('Breadcrumbs Bar Colors', 'albedo'),
			'type' => 'box',
			'options' => array(

				'breadcrumbs_text_color' => array(
					'label' => esc_html__('Breadcrumbs Links Color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_text_color'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_text_color',
					),
				),
				'breadcrumbs_active_color' => array(
					'label' => esc_html__('Breadcrumbs Active / Hover Text Color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_active_color'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_active_color',
					),
				),
				'breadcrumbs_separator_color' => array(
					'label' => esc_html__('Separator Icon Color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_separator_color'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_separator_color',
					),
				),
				'breadcrumbs_border_color' => array(
					'label' => esc_html__('Border Color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_border_color'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_border_color',
					),
				),
				'breadcrumbs_bg_gradient' => array(
					'label' => esc_html__('Breadcrumbs Container Background Color', 'albedo'),
					'desc' => esc_html__('This option changes container background color (if header layout supports it)', 'albedo'),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_bg_gradient',
					),
					'value' => array(
						'primary'   => $wplab_albedo_core->default_styles['breadcrumbs_bg_gradient_from'],
						'secondary' => $wplab_albedo_core->default_styles['breadcrumbs_bg_gradient_to'],
					),
					'type' => 'gradient',
				),
				'breadcrumbs_bg_pos' => array(
					'label' => esc_html__( 'Background Gradient Position', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_bg_pos'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_bg_pos',
					),
					'choices' => array(
						'to bottom right' => esc_html__( 'To bottom right', 'albedo' ),
						'to bottom' => esc_html__( 'To bottom', 'albedo' ),
						'to bottom left' => esc_html__( 'To bottom left', 'albedo' ),
						'to right' => esc_html__( 'To right', 'albedo' ),
						'to left' => esc_html__( 'To left', 'albedo' ),
						'to top right' => esc_html__( 'To top right', 'albedo' ),
						'to top' => esc_html__( 'To top', 'albedo' ),
						'to top left' => esc_html__( 'To top left', 'albedo' ),
					),
				),
				'breadcrumbs_bg_image_src' => array(
					'label' => esc_html__('Breadcrumbs Background Image', 'albedo'),
					'desc' => esc_html__('Upload background image', 'albedo'),
					'type' => 'background-image',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_bg_image_src',
					),
				),
				'breadcrumbs_bg_image_position' => array(
					'label' => esc_html__( 'Breadcrumbs Background Image Position', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_bg_image_position'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_bg_image_position',
					),
					'choices' => array(
						'left top' => esc_html__( 'Left Top', 'albedo' ),
						'center top' => esc_html__( 'Center Top', 'albedo' ),
						'right top' => esc_html__( 'Right Top', 'albedo' ),
						'left bottom' => esc_html__( 'Left Bottom', 'albedo' ),
						'center bottom' => esc_html__( 'Center Bottom', 'albedo' ),
						'right bottom' => esc_html__( 'Right Bottom', 'albedo' ),
						'left center' => esc_html__( 'Left Center', 'albedo' ),
						'center center' => esc_html__( 'Center Center', 'albedo' ),
						'right center' => esc_html__( 'Right Center', 'albedo' ),
					),
				),
				'breadcrumbs_bg_image_repeat' => array(
					'label' => esc_html__( 'Breadcrumbs Background Image Repeat', 'albedo' ),
					'type' => 'select',
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_bg_image_repeat'],
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_bg_image_repeat',
					),
					'choices' => array(
						'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
						'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
						'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
						'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
					),
				),
				'breadcrumbs_shadow_color' => array(
					'label' => esc_html__('Breadcrumbs Shadow Color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_shadow_color'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_shadow_color',
					),
				),
				'breadcrumbs_shadow_h_length' => array(
					'type'  => 'short-text',
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_shadow_h_length'],
					'label' => esc_html__( 'Breadcrumbs Horizontal Shadow Length', 'albedo' ),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_shadow_h_length',
					),
				),
				'breadcrumbs_shadow_v_length' => array(
					'type'  => 'short-text',
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_shadow_v_length'],
					'label' => esc_html__( 'Breadcrumbs Vertical Shadow Length', 'albedo' ),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_shadow_v_length',
					),
				),
				'breadcrumbs_shadow_blur_radius' => array(
					'type'  => 'short-text',
					'value' => $wplab_albedo_core->default_styles['breadcrumbs_shadow_blur_radius'],
					'label' => esc_html__( 'Breadcrumbs Shadow Blur Radius', 'albedo' ),
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'breadcrumbs_shadow_blur_radius',
					),
				),

				)
			),

	)
),
	'footer' => array(
		'title' => esc_html__('Footer', 'albedo'),
		'type' => 'tab',
		'options' => array(

			'footer-layout_box' => array(
				'title' => esc_html__('Footer Layout', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'footer_widgets' => array(
						'type' => 'multi-picker',
						'label' => false,
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_widgets',
						),
						'picker' => array(
							'enabled' => array(
								'label' => esc_html__( 'Enable Footer Widgets Area', 'albedo' ),
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
								'value' => $wplab_albedo_core->default_options['footer_widgets'],
							)
						),
						'choices' => array(
							'yes' => array(

								'footer_widgets_area' => array(
									'label' => esc_html__( 'Choose Footer Sidebar', 'albedo' ),
									'type' => 'select',
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_widgets_area',
									),
									'value' => $wplab_albedo_core->default_options['footer_widgets_area'],
									'choices' => $theme_sidebars
								),
								'footer_widgets_cols' => array(
									'label' => esc_html__( 'Number of columns', 'albedo' ),
									'type' => 'select',
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_widgets_cols',
									),
									'value' => $wplab_albedo_core->default_options['footer_widgets_cols'],
									'choices' => array(
										'1' => '1',
										'2' => '2',
										'3' => '3',
										'4' => '4',
									),
								),

							)
						)
					),

					'footer_bar' => array(
						'type' => 'multi-picker',
						'label' => false,
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_bar',
						),
						'picker' => array(
							'enabled' => array(
								'label' => esc_html__( 'Enable Bottom Bar', 'albedo' ),
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
								'value' => $wplab_albedo_core->default_options['footer_bar'],
							)
						),
						'choices' => array(
							'yes' => array(

								'footer_bar_style' => array(
									'label' => esc_html__( 'Footer Bar Style', 'albedo' ),
									'type' => 'select',
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_bar_style',
									),
									'value' => $wplab_albedo_core->default_options['footer_bar_style'],
									'choices' => array(
										'classic' => esc_html__( 'Classic', 'albedo' ),
										'modern' => esc_html__( 'Modern', 'albedo' ),
									),
								),
												'footer_bar_text' => array(
									'type'  => 'textarea',
									'label' => esc_html__('Footer bar text', 'albedo'),
									'value' => $wplab_albedo_core->default_options['footer_bar_text'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_bar_text',
									),
								),
								'gotop_link' => array(
									'type' => 'multi-picker',
									'label' => false,
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'gotop_link',
									),
									'picker' => array(
										'enabled' => array(
											'label' => esc_html__( 'Display GoTop link', 'albedo' ),
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
											'value' => $wplab_albedo_core->default_options['gotop_link'],
										)
									),
									'choices' => array(
										'yes' => array(

											'gotop_link_text' => array(
												'type'  => 'text',
												'label' => esc_html__('GoTop Link Text', 'albedo'),
												'value' => $wplab_albedo_core->default_options['gotop_link_text'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'gotop_link_text',
												),
											),

										)
									)
								),

							)
						)
					),

				)
			),
			'footer-styles_box' => array(
				'title' => esc_html__('Footer Style', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

								'footer_top_padding' => array(
						'type'  => 'short-text',
						'label' => esc_html__( 'Footer Top Padding', 'albedo'),
						'desc' => esc_html__( 'Example: 10px or 20%', 'albedo' ),
						'value' => '',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_top_padding',
						),
					),
					'footer_bottom_padding' => array(
						'type'  => 'short-text',
						'label' => esc_html__( 'Footer Bottom Padding', 'albedo'),
						'desc' => esc_html__( 'Example: 10px or 20%', 'albedo' ),
						'value' => '',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_bottom_padding',
						),
					),
					'footer_forms_style' => array(
						'label' => esc_html__( 'Forms style for Footer', 'albedo' ),
						'type' => 'select',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_forms_style',
						),
						'value' => $wplab_albedo_core->default_options['footer_forms_style'],
						'choices' => array(
							'white' => esc_html__('White', 'albedo'),
							'white_alt' => esc_html__('White Alt', 'albedo'),
							'dark' => esc_html__('Dark', 'albedo'),
							'dark_alt' => esc_html__('Dark Alt', 'albedo'),
						),
					),
					'footer_text_color' => array(
						'label' => esc_html__('Footer text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['footer_text_color'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_text_color',
						),
					),
					'footer_borders_color' => array(
						'label' => esc_html__('Footer Borders Color', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_borders_color',
						),
						'value' => $wplab_albedo_core->default_styles['footer_borders_color'],
						'type' => 'rgba-color-picker',
					),
					'footer_headers_color' => array(
						'label' => esc_html__('Footer headers color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['footer_headers_color'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_headers_color',
						),
					),
					'footer_link_color' => array(
						'label' => esc_html__('Footer link color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['footer_link_color'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_link_color',
						),
					),
					'footer_link_hover_color' => array(
						'label' => esc_html__('Footer link hover color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['footer_link_hover_color'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_link_hover_color',
						),
					),
					'footer_accent_color' => array(
						'label' => esc_html__('Footer accent color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['footer_accent_color'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_accent_color',
						),
					),
					'footer_img_overlay_color' => array(
						'label' => esc_html__('Footer Images Overlay Color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['footer_img_overlay_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_img_overlay_color',
						),
					),
					'footer_bg_color' => array(
						'label' => esc_html__('Footer Background Color', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_bg_color',
						),
						'value' => $wplab_albedo_core->default_styles['footer_bg_color'],
						'type' => 'rgba-color-picker',
					),
					'footer_bg_overlay_color' => array(
						'label' => esc_html__('Footer Background Overlay Color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['footer_bg_overlay_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_bg_overlay_color',
						),
					),
					'footer_bg_image_src' => array(
						'label' => esc_html__('Footer Background Image', 'albedo'),
						'desc' => esc_html__('Upload background image', 'albedo'),
						'type' => 'background-image',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_bg_image_src',
						),
					),
					'footer_bg_image_cover' => array(
						'label' => esc_html__('Cover Background Image', 'albedo'),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_bg_image_cover',
						),
						'right-choice' => array(
							'value' => 'cover',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'auto',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_styles['footer_bg_image_cover'],
					),
					'footer_bg_image_position' => array(
						'label' => esc_html__( 'Footer Background Image Position', 'albedo' ),
						'type' => 'select',
						'value' => $wplab_albedo_core->default_styles['footer_bg_image_position'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_bg_image_position',
						),
						'choices' => array(
							'left top' => esc_html__( 'Left Top', 'albedo' ),
							'center top' => esc_html__( 'Center Top', 'albedo' ),
							'right top' => esc_html__( 'Right Top', 'albedo' ),
							'left bottom' => esc_html__( 'Left Bottom', 'albedo' ),
							'center bottom' => esc_html__( 'Center Bottom', 'albedo' ),
							'right bottom' => esc_html__( 'Right Bottom', 'albedo' ),
							'left center' => esc_html__( 'Left Center', 'albedo' ),
							'center center' => esc_html__( 'Center Center', 'albedo' ),
							'right center' => esc_html__( 'Right Center', 'albedo' ),
						),
					),
					'footer_bg_image_repeat' => array(
						'label' => esc_html__( 'Footer Background Image Repeat', 'albedo' ),
						'type' => 'select',
						'value' => $wplab_albedo_core->default_styles['footer_bg_image_repeat'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_bg_image_repeat',
						),
						'choices' => array(
							'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
							'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
							'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
							'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
						),
					),
					'bottom_bar_font_size' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['bottom_bar_font_size'],
						'label' => esc_html__( 'Bottom Bar Font Size', 'albedo' ),
						'desc' => esc_html__( 'example: 14px', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'bottom_bar_font_size',
						),
					),
					'bottom_bar_text_color' => array(
						'label' => esc_html__('Bottom bar text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['bottom_bar_text_color'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'bottom_bar_text_color',
						),
					),
					'bottom_bar_link_color' => array(
						'label' => esc_html__('Bottom bar link color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['bottom_bar_link_color'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'bottom_bar_link_color',
						),
					),
					'bottom_bar_link_hover_color' => array(
						'label' => esc_html__('Bottom bar link hover color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['bottom_bar_link_hover_color'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'bottom_bar_link_hover_color',
						),
					),
					'bottom_bar_bg_color' => array(
						'label' => esc_html__('Bottom Bar Background Color', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'bottom_bar_bg_color',
						),
						'value' => $wplab_albedo_core->default_styles['bottom_bar_bg_color'],
						'type' => 'rgba-color-picker',
					),
					'bottom_bar_bg_image_src' => array(
						'label' => esc_html__('Bottom Bar Background Image', 'albedo'),
						'desc' => esc_html__('Upload background image', 'albedo'),
						'type' => 'background-image',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'bottom_bar_bg_image_src',
						),
					),
					'bottom_bar_bg_image_position' => array(
						'label' => esc_html__( 'Bottom Bar Background Image Position', 'albedo' ),
						'type' => 'select',
						'value' => $wplab_albedo_core->default_styles['bottom_bar_bg_image_position'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'bottom_bar_bg_image_position',
						),
						'choices' => array(
							'left top' => esc_html__( 'Left Top', 'albedo' ),
							'center top' => esc_html__( 'Center Top', 'albedo' ),
							'right top' => esc_html__( 'Right Top', 'albedo' ),
							'left bottom' => esc_html__( 'Left Bottom', 'albedo' ),
							'center bottom' => esc_html__( 'Center Bottom', 'albedo' ),
							'right bottom' => esc_html__( 'Right Bottom', 'albedo' ),
							'left center' => esc_html__( 'Left Center', 'albedo' ),
							'center center' => esc_html__( 'Center Center', 'albedo' ),
							'right center' => esc_html__( 'Right Center', 'albedo' ),
						),
					),
					'bottom_bar_bg_image_repeat' => array(
						'label' => esc_html__( 'Bottom Bar Background Image Repeat', 'albedo' ),
						'type' => 'select',
						'value' => $wplab_albedo_core->default_styles['bottom_bar_bg_image_repeat'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'bottom_bar_bg_image_repeat',
						),
						'choices' => array(
							'no-repeat' => esc_html__( 'No repeat', 'albedo' ),
							'repeat-x' => esc_html__( 'Repeat horizontally', 'albedo' ),
							'repeat-y' => esc_html__( 'Repeat vertically', 'albedo' ),
							'repeat' => esc_html__( 'Repeat horizontally and vertically', 'albedo' ),
						),
					),

				)
			),
			'footer-effects_box' => array(
				'title' => esc_html__('Footer Effects', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'footer_parallax_effect' => array(
						'type' => 'multi-picker',
						'label' => false,
						'desc' => false,
						'value' => array(
							'effect' => $wplab_albedo_core->default_options['footer_parallax_effect'],
						),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_parallax_effect',
						),
						'picker' => array(
							'effect' => array(
								'label' => esc_html__( 'Parallax Effects', 'albedo' ),
								'type' => 'radio',
								'choices' => array(
									'' => esc_html__( 'No Parallax', 'albedo' ),
									'parallax' => esc_html__( 'Parallax background', 'albedo' ),
									'mouse_parallax' => esc_html__( 'Mouse Move Parallax background', 'albedo' ),
								),
							)
						),
						'choices' => array(
							'parallax' => array(

								'parallax_speed' => array(
									'label' => esc_html__('Parallax speed', 'albedo'),
									'desc' => esc_html__('Set a speed of parallax effect, e.g.: 1.5. Do not forget to assign some background image for a footer.', 'albedo'),
									'type' => 'text',
									'value' => $wplab_albedo_core->default_options['footer_parallax_effect_parallax_speed'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_parallax_effect_parallax_speed',
									),
								),

							),
							'mouse_parallax' => array(

								'invert_x' => array(
									'label' => esc_html__( 'Invert X', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_invert_x'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_invert_x',
									),
								),
								'invert_y' => array(
									'label' => esc_html__( 'Invert Y', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_invert_y'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_invert_y',
									),
								),
								'depth' => array(
									'label' => esc_html__('Depth', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_depth'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_depth',
									),
								),
								'limit_x' => array(
									'label' => esc_html__('Limit X', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_limit_x'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_limit_x',
									),
								),
								'limit_y' => array(
									'label' => esc_html__('Limit Y', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_limit_y'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_limit_y',
									),
								),
								'scalar_x' => array(
									'label' => esc_html__('Scalar X', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_scalar_x'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_scalar_x',
									),
								),
								'scalar_y' => array(
									'label' => esc_html__('Scalar Y', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_scalar_y'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_scalar_y',
									),
								),
								'friction_x' => array(
									'label' => esc_html__('Friction X', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_friction_x'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_friction_x',
									),
								),
								'friction_y' => array(
									'label' => esc_html__('Friction Y', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_friction_y'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_friction_y',
									),
								),
								'origin_x' => array(
									'label' => esc_html__('Origin X', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_origin_x'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_origin_x',
									),
								),
								'origin_y' => array(
									'label' => esc_html__('Origin Y', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_mouse_parallax_origin_y'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_mouse_parallax_origin_y',
									),
								),

							),
						)
					),
					'footer_media_effect' => array(
						'type' => 'multi-picker',
						'label' => false,
						'desc' => false,
						'value' => array(
							'effect' => $wplab_albedo_core->default_options['footer_media_effect'],
						),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'footer_media_effect',
						),
						'picker' => array(
							'effect' => array(
								'label' => esc_html__( 'Media Effects', 'albedo' ),
								'type' => 'radio',
								'choices' => array(
									'' => esc_html__( 'No Effects', 'albedo' ),
									'video' => esc_html__( 'YouTube Video Background', 'albedo' ),
									'particleground' => esc_html__( 'Particle Groud Effect', 'albedo' ),
									'particles' => esc_html__( 'Particles Effect', 'albedo' ),
								),
							)
						),
						'choices' => array(

							'particleground' => array(

								'dot_color' => array(
									'label' => esc_html__('Dots Color', 'albedo'),
									'type' => 'color-picker',
									'value' => $wplab_albedo_core->default_options['footer_particleground_dot_color'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_dot_color',
									),
								),
								'line_color' => array(
									'label' => esc_html__('Lines Color', 'albedo'),
									'type' => 'color-picker',
									'value' => $wplab_albedo_core->default_options['footer_particleground_line_color'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_line_color',
									),
								),
								'particle_radius' => array(
									'label' => esc_html__('Dot size', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particleground_particle_radius'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_particle_radius',
									),
								),
								'line_width' => array(
									'label' => esc_html__('Line width', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particleground_line_width'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_line_width',
									),
								),
								'curved_lines' => array(
									'label' => esc_html__( 'Curved lines', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['footer_particleground_curved_lines'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_curved_lines',
									),
								),
								'parallax' => array(
									'label' => esc_html__( 'Parallax effect', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['footer_particleground_parallax'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_parallax',
									),
								),
								'parallax_multiplier' => array(
									'label' => esc_html__('Parallax Multiplier', 'albedo'),
									'desc' => esc_html__( 'The lower the number, the more extreme the parallax effect wil be.', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particleground_parallax_multiplier'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_parallax_multiplier',
									),
								),
								'proximity' => array(
									'label' => esc_html__('Proximity', 'albedo'),
									'desc' => esc_html__( 'How close two dots need to be, in pixels, before they join.', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particleground_proximity'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_proximity',
									),
								),
								'min_speed_x' => array(
									'label' => esc_html__('Minimum speed X', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particleground_min_speed_x'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_min_speed_x',
									),
								),
								'max_speed_x' => array(
									'label' => esc_html__('Maximum speed X', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particleground_max_speed_x'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_max_speed_x',
									),
								),
								'min_speed_y' => array(
									'label' => esc_html__('Minimum speed Y', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particleground_min_speed_y'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_min_speed_y',
									),
								),
								'max_speed_y' => array(
									'label' => esc_html__('Maximum speed Y', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particleground_max_speed_y'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_max_speed_y',
									),
								),
								'direction_x' => array(
									'label' => esc_html__( 'Direction X', 'albedo' ),
									'desc' => esc_html__( 'Means that the dots will bounce off the edges of the canvas', 'albedo'),
									'type' => 'select',
									'choices' => array(
										'center' => esc_html__( 'Center', 'albedo' ),
										'left' => esc_html__( 'Left', 'albedo' ),
										'right' => esc_html__( 'Right', 'albedo' ),
									),
									'value' => $wplab_albedo_core->default_options['footer_particleground_direction_x'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_direction_x',
									),
								),
								'direction_y' => array(
									'label' => esc_html__( 'Direction Y', 'albedo' ),
									'desc' => esc_html__( 'Means that the dots will bounce off the edges of the canvas', 'albedo'),
									'type' => 'select',
									'choices' => array(
										'center' => esc_html__( 'Center', 'albedo' ),
										'left' => esc_html__( 'Left', 'albedo' ),
										'right' => esc_html__( 'Right', 'albedo' ),
									),
									'value' => $wplab_albedo_core->default_options['footer_particleground_direction_y'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_direction_y',
									),
								),
								'destiny' => array(
									'label' => esc_html__('Destiny', 'albedo'),
									'desc' => esc_html__( 'Determines how many particles will be generated: one particle every n pixels.', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particleground_destiny'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particleground_destiny',
									),
								),
							),
							'particles' => array(
								'number' => array(
									'label' => esc_html__('Particles number', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_number'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_number',
									),
								),
								'density' => array(
									'type' => 'multi-picker',
									'label' => false,
									'desc' => false,
									'picker' => array(
										'enabled' => array(
											'label' => esc_html__( 'Enable density', 'albedo' ),
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
											'value' => $wplab_albedo_core->default_options['footer_particles_density'],
											'fw-storage' => isset($no_fw_storage) ? null : array(
												'type' => 'wp-option',
												'wp-option' => $settings_wp_option,
												'key' => 'footer_particles_density',
											),
										)
									),
									'choices' => array(
										'yes' => array(

											'density_value' => array(
												'label' => esc_html__('Density value', 'albedo'),
												'type' => 'short-text',
												'value' => $wplab_albedo_core->default_options['footer_particles_density_value'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_density_value',
												),
											),

										)
									)
								),
								'color' => array(
									'label' => esc_html__('Particles color', 'albedo'),
									'type' => 'color-picker',
									'value' => $wplab_albedo_core->default_options['footer_particles_color'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_color',
									),
								),
								'shape_type' => array(
									'label' => esc_html__( 'Shape type', 'albedo' ),
									'type' => 'select',
									'choices' => array(
										'circle' => esc_html__( 'Circle', 'albedo' ),
										'edge' => esc_html__( 'Edge', 'albedo' ),
										'triangle' => esc_html__( 'Triangle', 'albedo' ),
										'polygon' => esc_html__( 'Polygon', 'albedo' ),
										'star' => esc_html__( 'Star', 'albedo' ),
									),
									'value' => $wplab_albedo_core->default_options['footer_particles_shape_type'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_shape_type',
									),
								),
								'stroke_width' => array(
									'label' => esc_html__('Shape stroke width', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_stroke_width'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_stroke_width',
									),
								),
								'stroke_color' => array(
									'label' => esc_html__('Shape stroke color', 'albedo'),
									'type' => 'color-picker',
									'value' => $wplab_albedo_core->default_options['footer_particles_stroke_color'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_stroke_color',
									),
								),
								'polygon_sides' => array(
									'label' => esc_html__('Polygon sides', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_polygon_sides'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_polygon_sides',
									),
								),
								'opacity' => array(
									'label' => esc_html__('Opacity', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_opacity'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_opacity',
									),
								),
								'opacity_rand' => array(
									'label' => esc_html__( 'Opacity random', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['footer_particles_opacity_rand'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_opacity_rand',
									),
								),
								'animate_opacity' => array(
									'type' => 'multi-picker',
									'label' => false,
									'desc' => false,
									'picker' => array(
										'enabled' => array(
											'label' => esc_html__( 'Animate opacity', 'albedo' ),
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
											'value' => $wplab_albedo_core->default_options['footer_particles_animate_opacity'],
											'fw-storage' => isset($no_fw_storage) ? null : array(
												'type' => 'wp-option',
												'wp-option' => $settings_wp_option,
												'key' => 'footer_particles_animate_opacity',
											),
										)
									),
									'choices' => array(
										'yes' => array(

											'speed' => array(
												'label' => esc_html__('Animate speed', 'albedo'),
												'type' => 'short-text',
												'value' => $wplab_albedo_core->default_options['footer_particles_animate_opacity_speed'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_animate_opacity_speed',
												),
											),
											'size_min' => array(
												'label' => esc_html__('Opacity min', 'albedo'),
												'type' => 'short-text',
												'value' => $wplab_albedo_core->default_options['footer_particles_animate_opacity_size_min'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_animate_opacity_size_min',
												),
											),
											'sync' => array(
												'label' => esc_html__( 'Sync animation', 'albedo' ),
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
												'value' => $wplab_albedo_core->default_options['footer_particles_animate_opacity_sync'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_animate_opacity_sync',
												),
											),

										)
									)
								),
								'size' => array(
									'label' => esc_html__('Size', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_size'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_size',
									),
								),
								'size_rand' => array(
									'label' => esc_html__( 'Random size', 'albedo' ),
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
									'value' => $wplab_albedo_core->default_options['footer_particles_size_rand'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_size_rand',
									),
								),
								'animate_size' => array(
									'type' => 'multi-picker',
									'label' => false,
									'desc' => false,
									'picker' => array(
										'enabled' => array(
											'label' => esc_html__( 'Animate size', 'albedo' ),
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
											'value' => $wplab_albedo_core->default_options['footer_particles_animate_size'],
											'fw-storage' => isset($no_fw_storage) ? null : array(
												'type' => 'wp-option',
												'wp-option' => $settings_wp_option,
												'key' => 'footer_particles_animate_size',
											),
										)
									),
									'choices' => array(
										'yes' => array(

											'speed' => array(
												'label' => esc_html__('Animate size speed', 'albedo'),
												'type' => 'short-text',
												'value' => $wplab_albedo_core->default_options['footer_particles_animate_size_speed'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_animate_size_speed',
												),
											),
											'size_min' => array(
												'label' => esc_html__('Animate min size', 'albedo'),
												'type' => 'short-text',
												'value' => $wplab_albedo_core->default_options['footer_particles_animate_size_min'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_animate_size_min',
												),
											),
											'sync' => array(
												'label' => esc_html__( 'Sync size animation', 'albedo' ),
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
												'value' => $wplab_albedo_core->default_options['footer_particles_animate_sync'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_animate_sync',
												),
											),

										)
									)
								),
								'lines' => array(
									'type' => 'multi-picker',
									'label' => false,
									'desc' => false,
									'picker' => array(
										'enabled' => array(
											'label' => esc_html__( 'Enable linked lines', 'albedo' ),
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
											'value' => $wplab_albedo_core->default_options['footer_particles_lines'],
											'fw-storage' => isset($no_fw_storage) ? null : array(
												'type' => 'wp-option',
												'wp-option' => $settings_wp_option,
												'key' => 'footer_particles_lines',
											),
										)
									),
									'choices' => array(
										'yes' => array(

											'distance' => array(
												'label' => esc_html__('Distance', 'albedo'),
												'type' => 'short-text',
												'value' => $wplab_albedo_core->default_options['footer_particles_lines_distance'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_lines_distance',
												),
											),
											'color' => array(
												'label' => esc_html__('Color', 'albedo'),
												'type' => 'color-picker',
												'value' => $wplab_albedo_core->default_options['footer_particles_lines_color'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_lines_color',
												),
											),
											'opacity' => array(
												'label' => esc_html__('Opacity', 'albedo'),
												'type' => 'short-text',
												'value' => $wplab_albedo_core->default_options['footer_particles_lines_opacity'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_lines_opacity',
												),
											),
											'width' => array(
												'label' => esc_html__('Width', 'albedo'),
												'type' => 'short-text',
												'value' => $wplab_albedo_core->default_options['footer_particles_lines_width'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_lines_width',
												),
											),

										)
									)
								),
								'move' => array(
									'type' => 'multi-picker',
									'label' => false,
									'desc' => false,
									'picker' => array(
										'enabled' => array(
											'label' => esc_html__( 'Enable move', 'albedo' ),
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
											'value' => $wplab_albedo_core->default_options['footer_particles_move'],
											'fw-storage' => isset($no_fw_storage) ? null : array(
												'type' => 'wp-option',
												'wp-option' => $settings_wp_option,
												'key' => 'footer_particles_move',
											),
										)
									),
									'choices' => array(
										'yes' => array(

											'direction' => array(
												'label' => esc_html__( 'Move direction', 'albedo' ),
												'type' => 'select',
												'value' => $wplab_albedo_core->default_options['footer_particles_move_direction'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_move_direction',
												),
												'choices' => array(
													'none' => esc_html__( 'None', 'albedo' ),
													'top' => esc_html__( 'Top', 'albedo' ),
													'top-right' => esc_html__( 'Top right', 'albedo' ),
													'right' => esc_html__( 'Right', 'albedo' ),
													'bottom-right' => esc_html__( 'Bottom Right', 'albedo' ),
													'bottom' => esc_html__( 'Bottom', 'albedo' ),
													'bottom-left' => esc_html__( 'Bottom Left', 'albedo' ),
													'left' => esc_html__( 'Left', 'albedo' ),
													'top-left' => esc_html__( 'Top Left', 'albedo' ),
												),
											),
											'rand' => array(
												'label' => esc_html__( 'Random', 'albedo' ),
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
												'value' => $wplab_albedo_core->default_options['footer_particles_move_rand'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_move_rand',
												),
											),
											'straight' => array(
												'label' => esc_html__( 'Straight', 'albedo' ),
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
												'value' => $wplab_albedo_core->default_options['footer_particles_move_straight'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_move_straight',
												),
											),
											'speed' => array(
												'label' => esc_html__('Speed', 'albedo'),
												'type' => 'short-text',
												'value' => $wplab_albedo_core->default_options['footer_particles_move_speed'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_move_speed',
												),
											),
											'out_mode' => array(
												'label' => esc_html__( 'Out mode', 'albedo' ),
												'type' => 'select',
												'value' => $wplab_albedo_core->default_options['footer_particles_move_out_mode'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_move_out_mode',
												),
												'choices' => array(
													'none' => esc_html__( 'Out', 'albedo' ),
													'bounce' => esc_html__( 'Bounce', 'albedo' ),
												),
											),

										)
									)
								),
								'onhover' => array(
									'type' => 'multi-picker',
									'label' => false,
									'desc' => false,
									'picker' => array(
										'enabled' => array(
											'label' => esc_html__( 'Enable hover effect', 'albedo' ),
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
											'value' => $wplab_albedo_core->default_options['footer_particles_onhover'],
											'fw-storage' => isset($no_fw_storage) ? null : array(
												'type' => 'wp-option',
												'wp-option' => $settings_wp_option,
												'key' => 'footer_particles_onhover',
											),
										)
									),
									'choices' => array(
										'yes' => array(

											'mode' => array(
												'label' => esc_html__( 'Hover mode', 'albedo' ),
												'type' => 'select',
												'value' => $wplab_albedo_core->default_options['footer_particles_onhover_mode'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_onhover_mode',
												),
												'choices' => array(
													'grab' => esc_html__( 'Grab', 'albedo' ),
													'bubble' => esc_html__( 'Bubble', 'albedo' ),
													'repulse' => esc_html__( 'Repulse', 'albedo' ),
												),
											),

										)
									)
								),
								'onclick' => array(
									'type' => 'multi-picker',
									'label' => false,
									'desc' => false,
									'picker' => array(
										'enabled' => array(
											'label' => esc_html__( 'Enable click effect', 'albedo' ),
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
											'value' => $wplab_albedo_core->default_options['footer_particles_onclick'],
											'fw-storage' => isset($no_fw_storage) ? null : array(
												'type' => 'wp-option',
												'wp-option' => $settings_wp_option,
												'key' => 'footer_particles_onclick',
											),
										)
									),
									'choices' => array(
										'yes' => array(

											'mode' => array(
												'label' => esc_html__( 'Click mode', 'albedo' ),
												'type' => 'select',
												'value' => $wplab_albedo_core->default_options['footer_particles_onclick_mode'],
												'fw-storage' => isset($no_fw_storage) ? null : array(
													'type' => 'wp-option',
													'wp-option' => $settings_wp_option,
													'key' => 'footer_particles_onclick_mode',
												),
												'choices' => array(
													'push' => esc_html__( 'Push', 'albedo' ),
													'remove' => esc_html__( 'Remove', 'albedo' ),
													'bubble' => esc_html__( 'Bubble', 'albedo' ),
													'repulse' => esc_html__( 'Repulse', 'albedo' ),
												),
											),

										)
									)
								),
								'grab_distance' => array(
									'label' => esc_html__('Grab distance', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_grab_distance'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_grab_distance',
									),
								),
								'grab_opacity' => array(
									'label' => esc_html__('Grab opacity', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_grab_opacity'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_grab_opacity',
									),
								),
								'bubble_distance' => array(
									'label' => esc_html__('Bubble distance', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_bubble_distance'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_bubble_distance',
									),
								),
								'bubble_size' => array(
									'label' => esc_html__('Bubble size', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_bubble_size'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_bubble_size',
									),
								),
								'bubble_duration' => array(
									'label' => esc_html__('Bubble duration', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_bubble_duration'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_bubble_duration',
									),
								),
								'bubble_opacity' => array(
									'label' => esc_html__('Bubble opacity', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_bubble_opacity'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_bubble_opacity',
									),
								),
								'bubble_speed' => array(
									'label' => esc_html__('Bubble speed', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_bubble_speed'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_bubble_speed',
									),
								),
								'repulse_distance' => array(
									'label' => esc_html__('Repulse distance', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_repulse_distance'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_repulse_distance',
									),
								),
								'repulse_duration' => array(
									'label' => esc_html__('Repulse duration', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_particles_repulse_duration'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_particles_repulse_duration',
									),
								),

							),
							'video' => array(

								'video' => array(
									'label' => esc_html__('Video URL', 'albedo'),
									'desc' => esc_html__('Insert YouTube Video URL to embed this video as a footer background', 'albedo'),
									'type' => 'text',
									'value' => $wplab_albedo_core->default_options['footer_videobg_url'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_videobg_url',
									),
								),
												'video_fallback_image' => array(
										'label' => esc_html__( 'Fallback image for mobile devices', 'albedo' ),
										'desc' => esc_html__( 'The path to the fallback image in case of background video on mobile devices', 'albedo' ),
										'type' => 'upload',
										'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_media_effect/video/video_fallback_image',
										),
									),
								'video_mute' => array(
									'label' => esc_html__('Mute video', 'albedo'),
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
									'value' => $wplab_albedo_core->default_options['footer_videobg_video_mute'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_videobg_video_mute',
									),
								),
								'video_parallax_speed' => array(
									'label' => esc_html__('Video parallax speed', 'albedo'),
									'desc' => esc_html__('Example: 0.2 Leave it empty to disable parallax', 'albedo'),
									'type' => 'short-text',
									'value' => $wplab_albedo_core->default_options['footer_videobg_parallax_speed'],
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'footer_videobg_parallax_speed',
									),
								),

							),
						)
					),

				)
			),

		)
	),
	'sidebar' => array(
		'title' => esc_html__('Sidebar', 'albedo'),
		'type' => 'tab',
		'options' => array(

			'widgets_style' => array(
				'label' => esc_html__( 'Widgets styles', 'albedo' ),
				'type' => 'select',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'widgets_style',
				),
				'value' => $wplab_albedo_core->default_options['widgets_style'],
				'choices' => array(
					'boxed' => esc_html__( 'Boxed', 'albedo' ),
					'separator' => esc_html__( 'Separator', 'albedo' ),
				),
			),
			'sidebar_size' => array(
				'type'  => 'select',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'sidebar_size',
				),
				'value' => $wplab_albedo_core->default_options['sidebar_size'],
				'choices' => array(
					'3' => esc_html__( 'Small', 'albedo' ),
					'4' => esc_html__( 'Medium', 'albedo' ),
					'5' => esc_html__( 'Big', 'albedo' ),
				),
				'label' => esc_html__( 'Sidebar size', 'albedo' ),
			),
			'sidebar_gap' => array(
				'label' => esc_html__('Display a gap between sidebar and content', 'albedo'),
				'desc' => esc_html__('This option works only for single sidebar (left or right)', 'albedo'),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'sidebar_gap',
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'albedo' )
				),
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'albedo' )
				),
				'value' => $wplab_albedo_core->default_options['sidebar_gap'],
			),
			'hide_sidebar_on_mobiles' => array(
				'label' => esc_html__('Hide sidebar on mobiles', 'albedo'),
				'type' => 'switch',
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'hide_sidebar_on_mobiles',
				),
				'right-choice' => array(
					'value' => 'yes',
					'label' => esc_html__( 'Yes', 'albedo' )
				),
				'left-choice' => array(
					'value' => 'no',
					'color' => '#ccc',
					'label' => esc_html__( 'No', 'albedo' )
				),
				'value' => $wplab_albedo_core->default_options['hide_sidebar_on_mobiles'],
			),
			'scroll_last_widget' => array(
				'type' => 'multi-picker',
				'label' => false,
				'fw-storage' => isset($no_fw_storage) ? null : array(
					'type' => 'wp-option',
					'wp-option' => $settings_wp_option,
					'key' => 'scroll_last_widget',
				),
				'picker' => array(
					'enabled' => array(
						'label' => esc_html__( 'Scroll last widget', 'albedo' ),
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
					'value' => $wplab_albedo_core->default_options['scroll_last_widget'],
				)
					),
			'choices' => array(
				'yes' => array(

					'scroll_last_widget_offset' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_options['scroll_last_widget_offset'],
						'label' => esc_html__( 'Offset', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'scroll_last_widget_offset',
						),
					),

				)
			)
		),

	)
),
'colors' => array(
	'title' => esc_html__('Colors, Shadows, Borders', 'albedo'),
	'type' => 'tab',
	'options' => array(

		'accent_colors' => array(
			'title' => esc_html__('Accent Colors', 'albedo'),
			'type' => 'box',
			'attr' => array(
				'class' => 'closed'
			),
			'options' => array(

				'color_accent_inner' => array(
					'label' => esc_html__('Accent inner color', 'albedo'),
					'desc' => esc_html__('This color used inside accent colors, e.g. white text on blue button', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_inner'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_inner',
					),
				),
				'color_accent_blue' => array(
					'label' => esc_html__('Blue color', 'albedo'),
					'desc' => esc_html__('All content elements which have blue color (e.g. blue buttons, accent color on pricing tables, some of testimonials elements etc)', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_blue'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_blue',
					),
				),
				'color_accent_blue_shadow' => array(
					'label' => esc_html__('Blue shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_blue_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_blue_shadow',
					),
				),
				'color_accent_black' => array(
					'label' => esc_html__('Black color', 'albedo'),
					'desc' => esc_html__('All content elements which have black color (e.g. black buttons)', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_black'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_black',
					),
				),
				'color_accent_black_shadow' => array(
					'label' => esc_html__('Black shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_black_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_black_shadow',
					),
				),
				'color_accent_grey' => array(
					'label' => esc_html__('Grey color', 'albedo'),
					'desc' => esc_html__('All content elements which have grey color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_grey'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_grey',
					),
				),
				'color_accent_grey_shadow' => array(
					'label' => esc_html__('Grey shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_grey_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_grey_shadow',
					),
				),
				'color_accent_light_grey' => array(
					'label' => esc_html__('Light grey color', 'albedo'),
					'desc' => esc_html__('All content elements which have light grey color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_light_grey'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_light_grey',
					),
				),
				'color_accent_light_grey_shadow' => array(
					'label' => esc_html__('Light grey shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_light_grey_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_light_grey_shadow',
					),
				),
				'color_accent_red' => array(
					'label' => esc_html__('Red color', 'albedo'),
					'desc' => esc_html__('All content elements which have red color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_red'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_red',
					),
				),
				'color_accent_red_shadow' => array(
					'label' => esc_html__('Red shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_red_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_red_shadow',
					),
				),
				'color_accent_pink' => array(
					'label' => esc_html__('Pink color', 'albedo'),
					'desc' => esc_html__('All content elements which have pink color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_pink'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_pink',
					),
				),
				'color_accent_pink_shadow' => array(
					'label' => esc_html__('Pink shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_pink_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_pink_shadow',
					),
				),
				'color_accent_orange' => array(
					'label' => esc_html__('Orange color', 'albedo'),
					'desc' => esc_html__('All content elements which have orange color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_orange'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_orange',
					),
				),
				'color_accent_orange_shadow' => array(
					'label' => esc_html__('Orange shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_orange_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_orange_shadow',
					),
				),
				'color_accent_green' => array(
					'label' => esc_html__('Green color', 'albedo'),
					'desc' => esc_html__('All content elements which have green color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_green'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_green',
					),
				),
				'color_accent_green_shadow' => array(
					'label' => esc_html__('Green shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_green_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_green_shadow',
					),
				),
				'color_accent_turquoise' => array(
					'label' => esc_html__('Turquoise color', 'albedo'),
					'desc' => esc_html__('All content elements which have turquoise color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_turquoise'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_turquoise',
					),
				),
				'color_accent_turquoise_shadow' => array(
					'label' => esc_html__('Turquoise shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_turquoise_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_turquoise_shadow',
					),
				),
				'color_accent_yellow' => array(
					'label' => esc_html__('Yellow color', 'albedo'),
					'desc' => esc_html__('All content elements which have yellow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_yellow'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_yellow',
					),
				),
				'color_accent_yellow_shadow' => array(
					'label' => esc_html__('Yellow shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_yellow_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_yellow_shadow',
					),
				),
				'color_accent_purple' => array(
					'label' => esc_html__('Purple color', 'albedo'),
					'desc' => esc_html__('All content elements which have purple color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_purple'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_purple',
					),
				),
				'color_accent_purple_shadow' => array(
					'label' => esc_html__('Purple shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_purple_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_purple_shadow',
					),
				),
				'color_accent_dark_purple' => array(
					'label' => esc_html__('Dark purple color', 'albedo'),
					'desc' => esc_html__('All content elements which have dark purple color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_dark_purple'],
					'type' => 'color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_dark_purple',
					),
				),
				'color_accent_dark_purple_shadow' => array(
					'label' => esc_html__('Dark Purple shadow color', 'albedo'),
					'value' => $wplab_albedo_core->default_styles['color_accent_dark_purple_shadow'],
					'type' => 'rgba-color-picker',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'color_accent_dark_purple_shadow',
					),
				),

				)
			),
			'gradient_colors' => array(
				'title' => esc_html__('Gradient Colors', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'gradient_red' => array(
						'label' => esc_html__('Red gradient', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'gradient_red',
						),
						'value' => array(
							'primary'   => $wplab_albedo_core->default_styles['gradient_red_from'],
							'secondary' => $wplab_albedo_core->default_styles['gradient_red_to'],
						),
						'type' => 'gradient',
					),
					'gradient_violet' => array(
						'label' => esc_html__('Violet gradient', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'gradient_violet',
						),
						'value' => array(
							'primary'   => $wplab_albedo_core->default_styles['gradient_violet_from'],
							'secondary' => $wplab_albedo_core->default_styles['gradient_violet_to'],
						),
						'type' => 'gradient',
					),
					'gradient_turquoise' => array(
						'label' => esc_html__('Turquoise gradient', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'gradient_turquoise',
						),
						'value' => array(
							'primary'   => $wplab_albedo_core->default_styles['gradient_turquoise_from'],
							'secondary' => $wplab_albedo_core->default_styles['gradient_turquoise_to'],
						),
						'type' => 'gradient',
					),
					'gradient_blue' => array(
						'label' => esc_html__('Blue gradient', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'gradient_blue',
						),
						'value' => array(
							'primary'   => $wplab_albedo_core->default_styles['gradient_blue_from'],
							'secondary' => $wplab_albedo_core->default_styles['gradient_blue_to'],
						),
						'type' => 'gradient',
					),
					'gradient_grey' => array(
						'label' => esc_html__('Grey gradient', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'gradient_grey',
						),
						'value' => array(
							'primary'   => $wplab_albedo_core->default_styles['gradient_grey_from'],
							'secondary' => $wplab_albedo_core->default_styles['gradient_grey_to'],
						),
						'type' => 'gradient',
					),
					'gradient_orange' => array(
						'label' => esc_html__('Orange gradient', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'gradient_orange',
						),
						'value' => array(
							'primary'   => $wplab_albedo_core->default_styles['gradient_orange_from'],
							'secondary' => $wplab_albedo_core->default_styles['gradient_orange_to'],
						),
						'type' => 'gradient',
					),
					'gradient_green' => array(
						'label' => esc_html__('Green gradient', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'gradient_green',
						),
						'value' => array(
							'primary'   => $wplab_albedo_core->default_styles['gradient_green_from'],
							'secondary' => $wplab_albedo_core->default_styles['gradient_green_to'],
						),
						'type' => 'gradient',
					),
					'gradient_purple' => array(
						'label' => esc_html__('Purple gradient', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'gradient_purple',
						),
						'value' => array(
							'primary'   => $wplab_albedo_core->default_styles['gradient_purple_from'],
							'secondary' => $wplab_albedo_core->default_styles['gradient_purple_to'],
						),
						'type' => 'gradient',
					),

				)
			),
			'more_colors' => array(
				'title' => esc_html__('Borders and Alternate Backgrounds', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'color_bg_alt' => array(
						'label' => esc_html__('Alternate background color', 'albedo'),
						'desc' => esc_html__('Used in addition to the body background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['color_bg_alt'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'color_bg_alt',
						),
					),
					'color_bg_white' => array(
						'label' => esc_html__('White background color', 'albedo'),
						'desc' => esc_html__('Used in some content elements', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['color_bg_white'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'color_bg_white',
						),
					),
					'color_hr_border' => array(
						'label' => esc_html__('HR element color, Table accent color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['color_hr_border'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'color_hr_border',
						),
					),
					'color_bg_light' => array(
						'label' => esc_html__('Light background color', 'albedo'),
						'desc' => esc_html__('e.g. used in Tabs', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['color_bg_light'],
						'type' => 'color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'color_bg_light',
						),
					),

				)
			),
			'content_boxes' => array(
				'title' => esc_html__('Content boxes', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'box_bg_color' => array(
						'label' => esc_html__('Box background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['box_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_bg_color',
						),
					),
					'box_shadow_color' => array(
						'label' => esc_html__('Box shadow color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['box_shadow_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_shadow_color',
						),
					),
					'box_border_color' => array(
						'label' => esc_html__('Box border color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['box_border_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_border_color',
						),
					),
					'box_border_size' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['box_border_size'],
						'label' => esc_html__( 'Box border size', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_border_size',
						),
					),
					'box_radius_top_left' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['box_radius_top_left'],
						'label' => esc_html__( 'Box corners top left radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_radius_top_left',
						),
					),
					'box_radius_top_right' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['box_radius_top_right'],
						'label' => esc_html__( 'Box corners top right radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_radius_top_right',
						),
					),
					'box_radius_bottom_right' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['box_radius_bottom_right'],
						'label' => esc_html__( 'Box corners bottom right radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_radius_bottom_right',
						),
					),
					'box_radius_bottom_left' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['box_radius_bottom_left'],
						'label' => esc_html__( 'Box corners bottom left radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_radius_bottom_left',
						),
					),
					'box_shadow_h_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['box_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_shadow_h_length',
						),
					),
					'box_shadow_v_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['box_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_shadow_v_length',
						),
					),
					'box_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['box_shadow_blur_radius'],
						'label' => esc_html__( 'Blur radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'box_shadow_blur_radius',
						),
					),

				)
			),
			'content_elements' => array(
				'title' => esc_html__('Content elements', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'content_elements_radius' => array(
						'label' => esc_html__( 'Border radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['content_elements_radius'],
						'desc' => esc_html__( 'Value in pixels. Used for content elements like Tabs, Toggles, etc.', 'albedo' ),
						'help' => esc_html__( 'Type here a border radius in pixels, e.g.: 8', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'content_elements_radius',
						),
					),

					'smallbox_shadow_h_length' => array(
							'type'  => 'short-text',
							'value' => $wplab_albedo_core->default_styles['smallbox_shadow_h_length'],
							'label' => esc_html__( 'Small boxes Horizontal shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'smallbox_shadow_h_length',
						),
					),
					'smallbox_shadow_v_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['smallbox_shadow_v_length'],
						'label' => esc_html__( 'Small boxes Vertical shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'smallbox_shadow_v_length',
						),
					),
					'smallbox_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['smallbox_shadow_blur_radius'],
						'label' => esc_html__( 'Small boxes Blur radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'smallbox_shadow_blur_radius',
						),
					),

				)
			),

		)
	),
	'fonts' => array(
		'title' => esc_html__('Fonts', 'albedo'),
		'type' => 'tab',
		'options' => array(

			'fonts_base' => array(
				'title' => esc_html__('Base font', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'primary_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'primary_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['primary_font_family'],
							'style' => $wplab_albedo_core->default_styles['primary_font_weight'],
							'weight' => $wplab_albedo_core->default_styles['primary_font_weight'],
							'subset' => 'latin',
							'variation' => 'regular',
							'size' => $wplab_albedo_core->default_styles['primary_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['primary_font_line_height'],
							//'letter-spacing' => 0,
							'color' => $wplab_albedo_core->default_styles['primary_font_color']
						),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => true
						),
						'label' => esc_html__('Primary font', 'albedo'),
						'desc'  => esc_html__('used in base typography, e.g. Paragraph of text', 'albedo'),
					),
					'primary_font_mobile' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'primary_font_mobile',
						),
						'value' => array(
							'size' => $wplab_albedo_core->default_styles['primary_font_size_mobile'],
							'line-height' => $wplab_albedo_core->default_styles['primary_font_line_height_mobile'],
						),
						'components' => array(
							'family' => false,
							'size' => true,
							'style' => false,
							'weight' => false,
							'variation' => false,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Primary font settings for mobile devices', 'albedo'),
						'desc'  => esc_html__('here you can decrease font size for mobile devices if needed', 'albedo'),
					),
					'bigger_font_size' => array(
						'label' => esc_html__( 'Bigger font size', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['bigger_font_size'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'bigger_font_size',
						),
						'desc' => esc_html__( 'value in pixels. Bigger font size used in font-size-bigger CSS class.', 'albedo' ),
					),
					'bigger_font_line_height' => array(
						'label' => esc_html__( 'Bigger line height', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['bigger_font_line_height'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'bigger_font_line_height',
						),
						'desc' => esc_html__( 'value in pixels. Bigger line height used in font-size-bigger CSS class.', 'albedo' ),
					),
					'smaller_font_size' => array(
						'label' => esc_html__( 'Smaller font size', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['smaller_font_size'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'smaller_font_size',
						),
						'desc' => esc_html__( 'value in pixels.', 'albedo' ),
					),
					'smaller_font_line_height' => array(
						'label' => esc_html__( 'Smaller line height', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['smaller_font_line_height'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'smaller_font_line_height',
						),
						'desc' => esc_html__( 'value in pixels.', 'albedo' ),
					),
					'small_font_size' => array(
						'label' => esc_html__( 'Small font size', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_font_size'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_font_size',
						),
						'desc' => esc_html__( 'value in pixels.', 'albedo' ),
					),
					'small_font_line_height' => array(
						'label' => esc_html__( 'Small line height', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_font_line_height'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_font_line_height',
						),
						'desc' => esc_html__( 'value in pixels.', 'albedo' ),
					),
					'secondary_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'secondary_font',
						),
						'attr' => array(
							'class' => 'wproto-hide-weight'
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['secondary_font_family'],
						),
						'components' => array(
							'family' => true,
							'size' => false,
							'style' => false,
							'weight' => false,
							'variation' => false,
							'line-height' => false,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Secondary font', 'albedo'),
						'desc'  => esc_html__('used in elements heading, e.g. Table Headings', 'albedo'),
					),
					'color_text_darken' => array(
						'label' => esc_html__('Darken text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['color_text_darken'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'color_text_darken',
						),
						'type' => 'color-picker',
					),
					'color_text_lighten' => array(
						'label' => esc_html__('Lighten text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['color_text_lighten'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'color_text_lighten',
						),
						'type' => 'color-picker',
					),
					'color_link' => array(
						'label' => esc_html__('Link color', 'albedo'),
						'desc' => esc_html__('Default color for links', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['color_link'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'color_link',
						),
						'type' => 'color-picker',
					),
					'color_link_hover' => array(
						'label' => esc_html__('Hover link color', 'albedo'),
						'desc' => esc_html__('Default color for links on Hover state', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['color_link_hover'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'color_link_hover',
						),
						'type' => 'color-picker',
					),

				)
			),
			'fonts_header1' => array(
				'title' => esc_html__('Header 1', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'h1_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h1_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['h1_font_family'],
							'style' => $wplab_albedo_core->default_styles['h1_font_weight'],
							'weight' => $wplab_albedo_core->default_styles['h1_font_weight'],
							'subset' => 'latin',
							'variation' => $wplab_albedo_core->default_styles['h1_font_weight'],
							'size' => $wplab_albedo_core->default_styles['h1_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['h1_font_line_height'],
							'color' => $wplab_albedo_core->default_styles['h1_font_color']
						),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => true
						),
						'label' => esc_html__('Header 1 font', 'albedo'),
					),
					'h1_font_mobile' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h1_font_mobile',
						),
						'value' => array(
							'size' => $wplab_albedo_core->default_styles['h1_font_size_mobile'],
							'line-height' => $wplab_albedo_core->default_styles['h1_font_line_height_mobile'],
						),
						'components' => array(
							'family' => false,
							'size' => true,
							'style' => false,
							'weight' => false,
							'variation' => false,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Header 1 settings for mobile devices', 'albedo'),
						'desc'  => esc_html__('here you can decrease font size for mobile devices if needed', 'albedo'),
					),
					'h1_font_transform' => array(
						'label' => esc_html__( 'Text transform', 'albedo' ),
						'type' => 'select',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h1_font_transform',
						),
						'value' => $wplab_albedo_core->default_styles['h1_font_transform'],
						'choices' => array(
							'none' => esc_html__('None', 'albedo'),
							'capitalize' => esc_html__('Capitalize', 'albedo'),
							'lowercase' => esc_html__('Lowercase', 'albedo'),
							'uppercase' => esc_html__('Uppercase', 'albedo'),
						),
					),

				)
			),
			'fonts_header2' => array(
				'title' => esc_html__('Header 2', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'h2_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h2_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['h2_font_family'],
							'style' => $wplab_albedo_core->default_styles['h2_font_weight'],
							'weight' => $wplab_albedo_core->default_styles['h2_font_weight'],
							'subset' => 'latin',
							'variation' => $wplab_albedo_core->default_styles['h2_font_weight'],
							'size' => $wplab_albedo_core->default_styles['h2_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['h2_font_line_height'],
							'color' => $wplab_albedo_core->default_styles['h2_font_color']
						),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => true
						),
						'label' => esc_html__('Header 2 font', 'albedo'),
					),
					'h2_font_mobile' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h2_font_mobile',
						),
						'value' => array(
							'size' => $wplab_albedo_core->default_styles['h2_font_size_mobile'],
							'line-height' => $wplab_albedo_core->default_styles['h2_font_line_height_mobile'],
						),
						'components' => array(
							'family' => false,
							'size' => true,
							'style' => false,
							'weight' => false,
							'variation' => false,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Header 2 settings for mobile devices', 'albedo'),
						'desc'  => esc_html__('here you can decrease font size for mobile devices if needed', 'albedo'),
					),
					'h2_font_transform' => array(
						'label' => esc_html__( 'Text transform', 'albedo' ),
						'type' => 'select',
						'value' => $wplab_albedo_core->default_styles['h2_font_transform'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h2_font_transform',
						),
						'choices' => array(
							'none' => esc_html__('None', 'albedo'),
							'capitalize' => esc_html__('Capitalize', 'albedo'),
							'lowercase' => esc_html__('Lowercase', 'albedo'),
							'uppercase' => esc_html__('Uppercase', 'albedo'),
						),
					),

				)
			),
			'fonts_header3' => array(
				'title' => esc_html__('Header 3', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'h3_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h3_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['h3_font_family'],
							'style' => $wplab_albedo_core->default_styles['h3_font_weight'],
							'weight' => $wplab_albedo_core->default_styles['h3_font_weight'],
							'subset' => 'latin',
							'variation' => $wplab_albedo_core->default_styles['h3_font_weight'],
							'size' => $wplab_albedo_core->default_styles['h3_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['h3_font_line_height'],
							'color' => $wplab_albedo_core->default_styles['h3_font_color']
						),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => true
						),
						'label' => esc_html__('Header 3 font', 'albedo'),
					),
					'h3_font_mobile' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h3_font_mobile',
						),
						'value' => array(
							'size' => $wplab_albedo_core->default_styles['h3_font_size_mobile'],
							'line-height' => $wplab_albedo_core->default_styles['h3_font_line_height_mobile'],
						),
						'components' => array(
							'family' => false,
							'size' => true,
							'style' => false,
							'weight' => false,
							'variation' => false,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Header 3 settings for mobile devices', 'albedo'),
						'desc'  => esc_html__('here you can decrease font size for mobile devices if needed', 'albedo'),
					),
					'h3_font_transform' => array(
						'label' => esc_html__( 'Text transform', 'albedo' ),
						'type' => 'select',
						'value' => $wplab_albedo_core->default_styles['h3_font_transform'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h3_font_transform',
						),
						'choices' => array(
							'none' => esc_html__('None', 'albedo'),
							'capitalize' => esc_html__('Capitalize', 'albedo'),
							'lowercase' => esc_html__('Lowercase', 'albedo'),
							'uppercase' => esc_html__('Uppercase', 'albedo'),
						),
					),

				)
			),
			'fonts_header4' => array(
				'title' => esc_html__('Header 4', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'h4_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h4_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['h4_font_family'],
							'style' => $wplab_albedo_core->default_styles['h4_font_weight'],
							'weight' => $wplab_albedo_core->default_styles['h4_font_weight'],
							'subset' => 'latin',
							'variation' => $wplab_albedo_core->default_styles['h4_font_weight'],
							'size' => $wplab_albedo_core->default_styles['h4_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['h4_font_line_height'],
							'color' => $wplab_albedo_core->default_styles['h4_font_color']
						),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => true
						),
						'label' => esc_html__('Header 4 font', 'albedo'),
					),
					'h4_font_mobile' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h4_font_mobile',
						),
						'value' => array(
							'size' => $wplab_albedo_core->default_styles['h4_font_size_mobile'],
							'line-height' => $wplab_albedo_core->default_styles['h4_font_line_height_mobile'],
						),
						'components' => array(
							'family' => false,
							'size' => true,
							'style' => false,
							'weight' => false,
							'variation' => false,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Header 4 settings for mobile devices', 'albedo'),
						'desc'  => esc_html__('here you can decrease font size for mobile devices if needed', 'albedo'),
					),
					'h4_font_transform' => array(
						'label' => esc_html__( 'Text transform', 'albedo' ),
						'type' => 'select',
						'value' => $wplab_albedo_core->default_styles['h4_font_transform'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h4_font_transform',
						),
						'choices' => array(
							'none' => esc_html__('None', 'albedo'),
							'capitalize' => esc_html__('Capitalize', 'albedo'),
							'lowercase' => esc_html__('Lowercase', 'albedo'),
							'uppercase' => esc_html__('Uppercase', 'albedo'),
						),
					),

				)
			),
			'fonts_header5' => array(
				'title' => esc_html__('Header 5', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'h5_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h5_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['h5_font_family'],
							'style' => $wplab_albedo_core->default_styles['h5_font_weight'],
							'weight' => $wplab_albedo_core->default_styles['h5_font_weight'],
							'subset' => 'latin',
							'variation' => $wplab_albedo_core->default_styles['h5_font_weight'],
							'size' => $wplab_albedo_core->default_styles['h5_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['h5_font_line_height'],
							'color' => $wplab_albedo_core->default_styles['h5_font_color']
						),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => true
						),
						'label' => esc_html__('Header 5 font', 'albedo'),
					),
					'h5_font_mobile' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h5_font_mobile',
						),
						'value' => array(
							'size' => $wplab_albedo_core->default_styles['h5_font_size_mobile'],
							'line-height' => $wplab_albedo_core->default_styles['h5_font_line_height_mobile'],
						),
						'components' => array(
							'family' => false,
							'size' => true,
							'style' => false,
							'weight' => false,
							'variation' => false,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Header 5 settings for mobile devices', 'albedo'),
						'desc'  => esc_html__('here you can decrease font size for mobile devices if needed', 'albedo'),
					),
					'h5_font_transform' => array(
						'label' => esc_html__( 'Text transform', 'albedo' ),
						'type' => 'select',
						'value' => $wplab_albedo_core->default_styles['h5_font_transform'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h5_font_transform',
						),
						'choices' => array(
							'none' => esc_html__('None', 'albedo'),
							'capitalize' => esc_html__('Capitalize', 'albedo'),
							'lowercase' => esc_html__('Lowercase', 'albedo'),
							'uppercase' => esc_html__('Uppercase', 'albedo'),
						),
					),

				)
			),
			'fonts_header6' => array(
				'title' => esc_html__('Header 6', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'h6_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h6_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['h6_font_family'],
							'style' => $wplab_albedo_core->default_styles['h6_font_weight'],
							'weight' => $wplab_albedo_core->default_styles['h6_font_weight'],
							'subset' => 'latin',
							'variation' => $wplab_albedo_core->default_styles['h6_font_weight'],
							'size' => $wplab_albedo_core->default_styles['h6_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['h6_font_line_height'],
							'color' => $wplab_albedo_core->default_styles['h6_font_color']
						),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => true
						),
						'label' => esc_html__('Header 6 font', 'albedo'),
					),
					'h6_font_mobile' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h6_font_mobile',
						),
						'value' => array(
							'size' => $wplab_albedo_core->default_styles['h6_font_size_mobile'],
							'line-height' => $wplab_albedo_core->default_styles['h6_font_line_height_mobile'],
						),
						'components' => array(
							'family' => false,
							'size' => true,
							'style' => false,
							'weight' => false,
							'variation' => false,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Header 6 settings for mobile devices', 'albedo'),
						'desc'  => esc_html__('here you can decrease font size for mobile devices if needed', 'albedo'),
					),
					'h6_font_transform' => array(
						'label' => esc_html__( 'Text transform', 'albedo' ),
						'type' => 'select',
						'value' => $wplab_albedo_core->default_styles['h6_font_transform'],
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'h6_font_transform',
						),
						'choices' => array(
							'none' => esc_html__('None', 'albedo'),
							'capitalize' => esc_html__('Capitalize', 'albedo'),
							'lowercase' => esc_html__('Lowercase', 'albedo'),
							'uppercase' => esc_html__('Uppercase', 'albedo'),
						),
					),

				)
			),

		)
	),
	'forms' => array(
		'title' => esc_html__('Forms', 'albedo'),
		'type' => 'tab',
		'options' => array(

			'forms_select' => array(
				'title' => esc_html__('Dropdown Input Shadows', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'dropdown_shadow_h_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['dropdown_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'dropdown_shadow_h_length',
						),
					),
					'dropdown_shadow_v_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['dropdown_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'dropdown_shadow_v_length',
						),
					),
					'dropdown_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['dropdown_shadow_blur_radius'],
						'label' => esc_html__( 'Blur radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'dropdown_shadow_blur_radius',
						),
					),

				)
			),
			'forms_white' => array(
				'title' => esc_html__('White Form', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'form_1_normal_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Normal State', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_normal_title',
						),
					),
					'form_1_animation_time' => array(
						'label' => esc_html__( 'Animation time', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_1_animation_time'],
						'desc' => esc_html__( 'value in milliseconds, 1000 ms = 1 second', 'albedo' ),
						'help' => esc_html__( 'Set 0 to disable hover / animation effect', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_animation_time',
						),
					),
					'form_1_input_placeholder_color' => array(
						'label' => esc_html__('Input placeholder color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_input_placeholder_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_input_placeholder_color',
						),
					),
					'form_1_input_text_color' => array(
						'label' => esc_html__('Input text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_input_text_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_input_text_color',
						),
					),
					'form_1_input_icon_color' => array(
						'label' => esc_html__('Input icon color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_input_icon_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_input_icon_color',
						),
					),
					'form_1_input_bg_color' => array(
						'label' => esc_html__('Input background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_input_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_input_bg_color',
						),
					),
					'form_1_input_border_color' => array(
						'label' => esc_html__('Input border color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_input_border_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_input_border_color',
						),
					),
					'form_1_input_border_size' => array(
						'label' => esc_html__( 'Input border size', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_1_input_border_size'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_input_border_size',
						),
					),
					'form_1_input_border_radius' => array(
						'label' => esc_html__( 'Input border radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_1_input_border_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_input_border_radius',
						),
					),
					'form_1_dropdown_bg_color' => array(
						'label' => esc_html__('Dropdown background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_dropdown_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_dropdown_bg_color',
						),
					),
					'form_1_dropdown_accent_color' => array(
						'label' => esc_html__('Dropdown accent color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_dropdown_accent_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_dropdown_accent_color',
						),
					),
					'form_1_dropdown_accent_inner_color' => array(
						'label' => esc_html__('Dropdown accent inner color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_dropdown_accent_inner_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_dropdown_accent_inner_color',
						),
					),
					'form_1_dropdown_accent_radius' => array(
						'label' => esc_html__( 'Dropdown accent radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_1_dropdown_accent_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_dropdown_accent_radius',
						),
					),
					'form_1_dropdown_shadow_color' => array(
						'label' => esc_html__('Dropdown shadow color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_dropdown_shadow_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_dropdown_shadow_color',
						),
					),

					'form_1_active_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Active / Hover State', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_active_title',
						),
					),
					'form_1_hover_input_text_color' => array(
						'label' => esc_html__('Input text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_hover_input_text_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_hover_input_text_color',
						),
					),
					'form_1_hover_input_icon_color' => array(
						'label' => esc_html__('Input icon color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_hover_input_icon_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_hover_input_icon_color',
						),
					),
					'form_1_hover_input_bg_color' => array(
						'label' => esc_html__('Input background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_hover_input_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_hover_input_bg_color',
						),
					),
					'form_1_hover_input_border_color' => array(
						'label' => esc_html__('Input border color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_1_hover_input_border_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_hover_input_border_color',
						),
					),
					'form_1_hover_input_border_radius' => array(
						'label' => esc_html__( 'Input border radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_1_hover_input_border_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_1_hover_input_border_radius',
						),
					),

				)
			),
			'forms_white_alt' => array(
				'title' => esc_html__('White Alternate Form', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'form_2_normal_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Normal State', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_normal_title',
						),
					),
					'form_2_animation_time' => array(
						'label' => esc_html__( 'Animation time', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_2_animation_time'],
						'desc' => esc_html__( 'value in milliseconds, 1000 ms = 1 second', 'albedo' ),
						'help' => esc_html__( 'Set 0 to disable hover / animation effect', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_animation_time',
						),
					),
					'form_2_input_placeholder_color' => array(
						'label' => esc_html__('Input placeholder color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_input_placeholder_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_input_placeholder_color',
						),
					),
					'form_2_input_text_color' => array(
						'label' => esc_html__('Input text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_input_text_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_input_text_color',
						),
					),
					'form_2_input_icon_color' => array(
						'label' => esc_html__('Input icon color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_input_icon_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_input_icon_color',
						),
					),
					'form_2_input_bg_color' => array(
						'label' => esc_html__('Input background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_input_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_input_bg_color',
						),
					),
					'form_2_input_border_color' => array(
						'label' => esc_html__('Input border color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_input_border_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_input_border_color',
						),
					),
					'form_2_input_border_size' => array(
						'label' => esc_html__( 'Input border size', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_2_input_border_size'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_input_border_size',
						),
					),
					'form_2_input_border_radius' => array(
						'label' => esc_html__( 'Input border radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_2_input_border_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_input_border_radius',
						),
					),
					'form_2_dropdown_bg_color' => array(
						'label' => esc_html__('Dropdown background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_dropdown_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_dropdown_bg_color',
						),
					),
					'form_2_dropdown_accent_color' => array(
						'label' => esc_html__('Dropdown accent color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_dropdown_accent_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_dropdown_accent_color',
						),
					),
					'form_2_dropdown_accent_inner_color' => array(
						'label' => esc_html__('Dropdown accent inner color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_dropdown_accent_inner_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_dropdown_accent_inner_color',
						),
					),
					'form_2_dropdown_accent_radius' => array(
						'label' => esc_html__( 'Dropdown accent radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_2_dropdown_accent_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_dropdown_accent_radius',
						),
					),
					'form_2_dropdown_shadow_color' => array(
						'label' => esc_html__('Dropdown shadow color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_dropdown_shadow_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_dropdown_shadow_color',
						),
					),

					'form_2_active_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Active / Hover State', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_active_title',
						),
					),
					'form_2_hover_input_text_color' => array(
						'label' => esc_html__('Input text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_hover_input_text_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_hover_input_text_color',
						),
					),
					'form_2_hover_input_icon_color' => array(
						'label' => esc_html__('Input icon color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_hover_input_icon_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_hover_input_icon_color',
						),
					),
					'form_2_hover_input_bg_color' => array(
						'label' => esc_html__('Input background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_hover_input_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_hover_input_bg_color',
						),
					),
					'form_2_hover_input_border_color' => array(
						'label' => esc_html__('Input border color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_2_hover_input_border_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_hover_input_border_color',
						),
					),
					'form_2_hover_input_border_radius' => array(
						'label' => esc_html__( 'Input border radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_2_hover_input_border_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_2_hover_input_border_radius',
						),
					),

				)
			),
			'forms_dark' => array(
				'title' => esc_html__('Dark Form', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'form_3_normal_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Normal State', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_normal_title',
						),
					),
					'form_3_animation_time' => array(
						'label' => esc_html__( 'Animation time', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_3_animation_time'],
						'desc' => esc_html__( 'value in milliseconds, 1000 ms = 1 second', 'albedo' ),
						'help' => esc_html__( 'Set 0 to disable hover / animation effect', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_animation_time',
						),
					),
					'form_3_input_placeholder_color' => array(
						'label' => esc_html__('Input placeholder color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_input_placeholder_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_input_placeholder_color',
						),
					),
					'form_3_input_text_color' => array(
						'label' => esc_html__('Input text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_input_text_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_input_text_color',
						),
					),
					'form_3_input_icon_color' => array(
						'label' => esc_html__('Input icon color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_input_icon_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_input_icon_color',
						),
					),
					'form_3_input_bg_color' => array(
						'label' => esc_html__('Input background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_input_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_input_bg_color',
						),
					),
					'form_3_input_border_color' => array(
						'label' => esc_html__('Input border color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_input_border_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_input_border_color',
						),
					),
					'form_3_input_border_size' => array(
						'label' => esc_html__( 'Input border size', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_3_input_border_size'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_input_border_size',
						),
					),
					'form_3_input_border_radius' => array(
						'label' => esc_html__( 'Input border radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_3_input_border_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_input_border_radius',
						),
					),
					'form_3_dropdown_bg_color' => array(
						'label' => esc_html__('Dropdown background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_dropdown_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_dropdown_bg_color',
						),
					),
					'form_3_dropdown_accent_color' => array(
						'label' => esc_html__('Dropdown accent color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_dropdown_accent_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_dropdown_accent_color',
						),
					),
					'form_3_dropdown_accent_inner_color' => array(
						'label' => esc_html__('Dropdown accent inner color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_dropdown_accent_inner_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_dropdown_accent_inner_color',
						),
					),
					'form_3_dropdown_accent_radius' => array(
						'label' => esc_html__( 'Dropdown accent radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_3_dropdown_accent_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_dropdown_accent_radius',
						),
					),
					'form_3_dropdown_shadow_color' => array(
						'label' => esc_html__('Dropdown shadow color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_dropdown_shadow_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_dropdown_shadow_color',
						),
					),

					'form_3_active_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Active / Hover State', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_active_title',
						),
					),
					'form_3_hover_input_text_color' => array(
						'label' => esc_html__('Input text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_hover_input_text_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_hover_input_text_color',
						),
					),
					'form_3_hover_input_icon_color' => array(
						'label' => esc_html__('Input icon color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_hover_input_icon_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_hover_input_icon_color',
						),
					),
					'form_3_hover_input_bg_color' => array(
						'label' => esc_html__('Input background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_hover_input_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_hover_input_bg_color',
						),
					),
					'form_3_hover_input_border_color' => array(
						'label' => esc_html__('Input border color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_3_hover_input_border_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_hover_input_border_color',
						),
					),
					'form_3_hover_input_border_radius' => array(
						'label' => esc_html__( 'Input border radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_3_hover_input_border_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_3_hover_input_border_radius',
						),
					),

				)
			),
			'forms_dark_alt' => array(
				'title' => esc_html__('Dark Alternate Form', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'form_4_normal_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Normal State', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_normal_title',
						),
					),
					'form_4_animation_time' => array(
						'label' => esc_html__( 'Animation time', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_4_animation_time'],
						'desc' => esc_html__( 'value in milliseconds, 1000 ms = 1 second', 'albedo' ),
						'help' => esc_html__( 'Set 0 to disable hover / animation effect', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_animation_time',
						),
					),
					'form_4_input_placeholder_color' => array(
						'label' => esc_html__('Input placeholder color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_input_placeholder_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_input_placeholder_color',
						),
					),
					'form_4_input_text_color' => array(
						'label' => esc_html__('Input text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_input_text_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_input_text_color',
						),
					),
					'form_4_input_icon_color' => array(
						'label' => esc_html__('Input icon color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_input_icon_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_input_icon_color',
						),
					),
					'form_4_input_bg_color' => array(
						'label' => esc_html__('Input background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_input_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_input_bg_color',
						),
					),
					'form_4_input_border_color' => array(
						'label' => esc_html__('Input border color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_input_border_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_input_border_color',
						),
					),
					'form_4_input_border_size' => array(
						'label' => esc_html__( 'Input border size', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_4_input_border_size'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_input_border_size',
						),
					),
					'form_4_input_border_radius' => array(
						'label' => esc_html__( 'Input border radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_4_input_border_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_input_border_radius',
						),
					),
					'form_4_dropdown_bg_color' => array(
						'label' => esc_html__('Dropdown background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_dropdown_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_dropdown_bg_color',
						),
					),
					'form_4_dropdown_accent_color' => array(
						'label' => esc_html__('Dropdown accent color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_dropdown_accent_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_dropdown_accent_color',
						),
					),
					'form_4_dropdown_accent_inner_color' => array(
						'label' => esc_html__('Dropdown accent inner color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_dropdown_accent_inner_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_dropdown_accent_inner_color',
						),
					),
					'form_4_dropdown_accent_radius' => array(
						'label' => esc_html__( 'Dropdown accent radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_4_dropdown_accent_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_dropdown_accent_radius',
						),
					),
					'form_4_dropdown_shadow_color' => array(
						'label' => esc_html__('Dropdown shadow color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_dropdown_shadow_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_dropdown_shadow_color',
						),
					),

					'form_4_active_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Active / Hover State', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_active_title',
						),
					),
					'form_4_hover_input_text_color' => array(
						'label' => esc_html__('Input text color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_hover_input_text_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_hover_input_text_color',
						),
					),
					'form_4_hover_input_icon_color' => array(
						'label' => esc_html__('Input icon color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_hover_input_icon_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_hover_input_icon_color',
						),
					),
					'form_4_hover_input_bg_color' => array(
						'label' => esc_html__('Input background color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_hover_input_bg_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_hover_input_bg_color',
						),
					),
					'form_4_hover_input_border_color' => array(
						'label' => esc_html__('Input border color', 'albedo'),
						'value' => $wplab_albedo_core->default_styles['form_4_hover_input_border_color'],
						'type' => 'rgba-color-picker',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'form_4_hover_input_border_color',
						),
					),
					'form_4_hover_input_border_radius' => array(
						'label' => esc_html__( 'Input border radius', 'albedo' ),
						'type' => 'short-text',
						'value' => $wplab_albedo_core->default_styles['form_4_hover_input_border_radius'],
						'desc' => esc_html__( 'value in pixels', 'albedo' ),
					),

				)
			),

		)
	),
	'buttons' => array(
		'title' => esc_html__('Buttons', 'albedo'),
		'type' => 'tab',
		'options' => array(

			'button_small' => array(
				'title' => esc_html__('Small Buttons', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'small_button_group_basic_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Default styles', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_group_basic_title',
						),
					),
					'small_button_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['small_button_font_family'],
							'style' => $wplab_albedo_core->default_styles['small_button_font_weight'],
							'variation' => $wplab_albedo_core->default_styles['small_button_font_weight'],
							'size' => $wplab_albedo_core->default_styles['small_button_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['small_button_font_line_height']
						),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Small buttons font', 'albedo'),
					),
					'small_button_animation_time' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_animation_time',
						),
						'value' => $wplab_albedo_core->default_styles['small_button_animation_time'],
						'label' => esc_html__( 'Animation time', 'albedo' ),
						'desc' => esc_html__( 'in milliseconds, 1000 = 1 second', 'albedo' ),
					),
					'small_button_font_transform' => array(
						'label' => esc_html__( 'Text transform', 'albedo' ),
						'type' => 'select',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_font_transform',
						),
						'value' => $wplab_albedo_core->default_styles['small_button_font_transform'],
						'choices' => array(
							'none' => esc_html__('None', 'albedo'),
							'capitalize' => esc_html__('Capitalize', 'albedo'),
							'lowercase' => esc_html__('Lowercase', 'albedo'),
							'uppercase' => esc_html__('Uppercase', 'albedo'),
						),
					),
					'small_button_border' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_border',
						),
					),
					'small_button_radius' => array(
						'type'  => 'short-text',
						'value'  => $wplab_albedo_core->default_styles['small_button_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_radius',
						),
					),
					'small_button_shadow_h_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_shadow_h_length',
						),
					),
					'small_button_shadow_v_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_shadow_v_length',
						),
					),
					'small_button_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_shadow_blur_radius',
						),
					),

					'small_button_group_hover_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Hover styles', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_group_hover_title',
						),
					),

					'small_button_hover_border' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_hover_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_hover_border',
						),
					),
					'small_button_hover_radius' => array(
						'type'  => 'short-text',
						'value'  => $wplab_albedo_core->default_styles['small_button_hover_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_hover_radius',
						),
					),
					'small_button_hover_shadow_h_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_hover_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_hover_shadow_h_length',
						),
					),
					'small_button_hover_shadow_v_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_hover_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_hover_shadow_v_length',
						),
					),
					'small_button_hover_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_hover_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_hover_shadow_blur_radius',
						),
					),
					'small_button_group_click_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('On click styles', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_group_click_title',
						),
					),
					'small_button_click_border' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_click_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_click_border',
						),
					),
					'small_button_click_radius' => array(
						'type'  => 'short-text',
						'value'  => $wplab_albedo_core->default_styles['small_button_click_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_click_radius',
						),
					),
					'small_button_click_shadow_h_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_click_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_click_shadow_h_length',
						),
					),
					'small_button_click_shadow_v_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_click_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_click_shadow_v_length',
						),
					),
					'small_button_click_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['small_button_click_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'small_button_click_shadow_blur_radius',
						),
					),

				)
			),
			'button_medium' => array(
				'title' => esc_html__('Medium Buttons', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'medium_button_group_basic_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Default styles', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_group_basic_title',
						),
					),
					'medium_button_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['medium_button_font_family'],
							'style' => $wplab_albedo_core->default_styles['medium_button_font_weight'],
							'variation' => $wplab_albedo_core->default_styles['medium_button_font_weight'],
							'size' => $wplab_albedo_core->default_styles['medium_button_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['medium_button_font_line_height']
						),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Medium buttons font', 'albedo'),
					),
					'medium_button_animation_time' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_animation_time',
						),
						'value' => $wplab_albedo_core->default_styles['medium_button_animation_time'],
						'label' => esc_html__( 'Animation time', 'albedo' ),
						'desc' => esc_html__( 'in milliseconds, 1000 = 1 second', 'albedo' ),
					),
					'medium_button_font_transform' => array(
						'label' => esc_html__( 'Text transform', 'albedo' ),
						'type' => 'select',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_font_transform',
						),
						'value' => $wplab_albedo_core->default_styles['medium_button_font_transform'],
						'choices' => array(
							'none' => esc_html__('None', 'albedo'),
							'capitalize' => esc_html__('Capitalize', 'albedo'),
							'lowercase' => esc_html__('Lowercase', 'albedo'),
							'uppercase' => esc_html__('Uppercase', 'albedo'),
						),
					),
					'medium_button_border' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_border',
						),
						'value' => $wplab_albedo_core->default_styles['medium_button_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
					),
					'medium_button_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_radius',
						),
						'value'  => $wplab_albedo_core->default_styles['medium_button_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
					),
					'medium_button_shadow_h_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_shadow_h_length',
						),
						'value' => $wplab_albedo_core->default_styles['medium_button_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
					),
					'medium_button_shadow_v_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_shadow_v_length',
						),
						'value' => $wplab_albedo_core->default_styles['medium_button_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
					),
					'medium_button_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_shadow_blur_radius',
						),
						'value' => $wplab_albedo_core->default_styles['medium_button_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
					),
					'medium_button_group_hover_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Hover styles', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_group_hover_title',
						),
					),

					'medium_button_hover_border' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['medium_button_hover_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_hover_border',
						),
					),
					'medium_button_hover_radius' => array(
						'type'  => 'short-text',
						'value'  => $wplab_albedo_core->default_styles['medium_button_hover_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_hover_radius',
						),
					),
					'medium_button_hover_shadow_h_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['medium_button_hover_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_hover_shadow_h_length',
						),
					),
					'medium_button_hover_shadow_v_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['medium_button_hover_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_hover_shadow_v_length',
						),
					),
					'medium_button_hover_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['medium_button_hover_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_hover_shadow_blur_radius',
						),
					),
					'medium_button_group_click_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('On click styles', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_group_click_title',
						),
					),
					'medium_button_click_border' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['medium_button_click_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_click_border',
						),
					),
					'medium_button_click_radius' => array(
						'type'  => 'short-text',
						'value'  => $wplab_albedo_core->default_styles['medium_button_click_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_click_radius',
						),
					),
					'medium_button_click_shadow_h_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['medium_button_click_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_click_shadow_h_length',
						),
					),
					'medium_button_click_shadow_v_length' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['medium_button_click_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_click_shadow_v_length',
						),
					),
					'medium_button_click_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'value' => $wplab_albedo_core->default_styles['medium_button_click_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'medium_button_click_shadow_blur_radius',
						),
					),

				)
			),
			'button_large' => array(
				'title' => esc_html__('Large Buttons', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'large_button_group_basic_title' => array(
						'type'  => 'html',
						'html'  => '',
						'label' => esc_html__('Default styles', 'albedo'),
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_group_basic_title',
						),
					),
					'large_button_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['large_button_font_family'],
							'style' => $wplab_albedo_core->default_styles['large_button_font_weight'],
							'variation' => $wplab_albedo_core->default_styles['large_button_font_weight'],
							'size' => $wplab_albedo_core->default_styles['large_button_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['large_button_font_line_height']
							),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('Large buttons font', 'albedo'),
					),
					'large_button_animation_time' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_animation_time',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_animation_time'],
						'label' => esc_html__( 'Animation time', 'albedo' ),
						'desc' => esc_html__( 'in milliseconds, 1000 = 1 second', 'albedo' ),
					),
					'large_button_font_transform' => array(
						'label' => esc_html__( 'Text transform', 'albedo' ),
						'type' => 'select',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_font_transform',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_font_transform'],
						'choices' => array(
							'none' => esc_html__('None', 'albedo'),
							'capitalize' => esc_html__('Capitalize', 'albedo'),
							'lowercase' => esc_html__('Lowercase', 'albedo'),
							'uppercase' => esc_html__('Uppercase', 'albedo'),
						),
					),
					'large_button_border' => array(
						'type'  => 'short-text',
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'large_button_border',
					),
						'value' => $wplab_albedo_core->default_styles['large_button_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
					),
					'large_button_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_radius',
						),
						'value'  => $wplab_albedo_core->default_styles['large_button_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
					),
					'large_button_shadow_h_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_shadow_h_length',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
					),
					'large_button_shadow_v_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_shadow_v_length',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
					),
					'large_button_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_shadow_blur_radius',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
					),
					'large_button_group_hover_title' => array(
						'type'  => 'html',
						'html'  => '',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_group_hover_title',
						),
						'label' => esc_html__('Hover styles', 'albedo'),
					),

					'large_button_hover_border' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_hover_border',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_hover_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
					),
					'large_button_hover_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_hover_radius',
						),
						'value'  => $wplab_albedo_core->default_styles['large_button_hover_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
					),
					'large_button_hover_shadow_h_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_hover_shadow_h_length',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_hover_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
					),
					'large_button_hover_shadow_v_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_hover_shadow_v_length',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_hover_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
					),
					'large_button_hover_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_hover_shadow_blur_radius',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_hover_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
					),
					'large_button_group_click_title' => array(
						'type'  => 'html',
						'html'  => '',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_group_click_title',
						),
						'label' => esc_html__('On click styles', 'albedo'),
					),
					'large_button_click_border' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_click_border',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_click_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
					),
					'large_button_click_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_click_radius',
						),
						'value'  => $wplab_albedo_core->default_styles['large_button_click_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
					),
					'large_button_click_shadow_h_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_click_shadow_h_length',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_click_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
					),
					'large_button_click_shadow_v_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_click_shadow_v_length',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_click_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
					),
					'large_button_click_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'large_button_click_shadow_blur_radius',
						),
						'value' => $wplab_albedo_core->default_styles['large_button_click_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
					),

				)
			),
			'button_xlarge' => array(
				'title' => esc_html__('X-Large Buttons', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'closed'
				),
				'options' => array(

					'xlarge_button_group_basic_title' => array(
						'type'  => 'html',
						'html'  => '',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_group_basic_title',
						),
						'label' => esc_html__('Default styles', 'albedo'),
					),
					'xlarge_button_font' => array(
						'type' => 'typography-v2',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_font',
						),
						'value' => array(
							'family' => $wplab_albedo_core->default_styles['xlarge_button_font_family'],
							'style' => $wplab_albedo_core->default_styles['xlarge_button_font_weight'],
							'variation' => $wplab_albedo_core->default_styles['xlarge_button_font_weight'],
							'size' => $wplab_albedo_core->default_styles['xlarge_button_font_size'],
							'line-height' => $wplab_albedo_core->default_styles['xlarge_button_font_line_height']
						),
						'components' => array(
							'family' => true,
							'size' => true,
							'style' => true,
							'weight' => true,
							'variation' => true,
							'line-height' => true,
							'letter-spacing' => false,
							'color' => false
						),
						'label' => esc_html__('X Large buttons font', 'albedo'),
					),
					'xlarge_button_animation_time' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_animation_time',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_animation_time'],
						'label' => esc_html__( 'Animation time', 'albedo' ),
						'desc' => esc_html__( 'in milliseconds, 1000 = 1 second', 'albedo' ),
					),
					'xlarge_button_font_transform' => array(
						'label' => esc_html__( 'Text transform', 'albedo' ),
						'type' => 'select',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_font_transform',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_font_transform'],
						'choices' => array(
							'none' => esc_html__('None', 'albedo'),
							'capitalize' => esc_html__('Capitalize', 'albedo'),
							'lowercase' => esc_html__('Lowercase', 'albedo'),
							'uppercase' => esc_html__('Uppercase', 'albedo'),
						),
					),
					'xlarge_button_border' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_border',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
					),
					'xlarge_button_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_radius',
						),
						'value'  => $wplab_albedo_core->default_styles['xlarge_button_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
					),
					'xlarge_button_shadow_h_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_shadow_h_length',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
					),
					'xlarge_button_shadow_v_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_shadow_v_length',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
					),
					'xlarge_button_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_shadow_blur_radius',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
					),
					'xlarge_button_group_hover_title' => array(
						'type'  => 'html',
						'html'  => '',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_group_hover_title',
						),
						'label' => esc_html__('Hover styles', 'albedo'),
					),

					'xlarge_button_hover_border' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_hover_border',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_hover_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
					),
					'xlarge_button_hover_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_hover_radius',
						),
						'value'  => $wplab_albedo_core->default_styles['xlarge_button_hover_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
					),
					'xlarge_button_hover_shadow_h_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_hover_shadow_h_length',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_hover_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
					),
					'xlarge_button_hover_shadow_v_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_hover_shadow_v_length',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_hover_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
					),
					'xlarge_button_hover_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_hover_shadow_blur_radius',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_hover_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
					),
					'xlarge_button_group_click_title' => array(
						'type'  => 'html',
						'html'  => '',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_group_click_title',
						),
						'label' => esc_html__('On click styles', 'albedo'),
					),
					'xlarge_button_click_border' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_click_border',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_click_border'],
						'label' => esc_html__( 'Button border size', 'albedo' ),
					),
					'xlarge_button_click_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_click_radius',
						),
						'value'  => $wplab_albedo_core->default_styles['xlarge_button_click_radius'],
						'label' => esc_html__('Border radius', 'albedo'),
						'desc' => esc_html__('Value in pixels', 'albedo'),
					),
					'xlarge_button_click_shadow_h_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_click_shadow_h_length',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_click_shadow_h_length'],
						'label' => esc_html__( 'Horizontal shadow length', 'albedo' ),
					),
					'xlarge_button_click_shadow_v_length' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_click_shadow_v_length',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_click_shadow_v_length'],
						'label' => esc_html__( 'Vertical shadow length', 'albedo' ),
					),
					'xlarge_button_click_shadow_blur_radius' => array(
						'type'  => 'short-text',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'xlarge_button_click_shadow_blur_radius',
						),
						'value' => $wplab_albedo_core->default_styles['xlarge_button_click_shadow_blur_radius'],
						'label' => esc_html__( 'Shadow blur radius', 'albedo' ),
					),

				)
			),


		)
	),
	'blog' => array(
		'title' => esc_html__('Blog', 'albedo'),
		'type' => 'tab',
		'options' => array(

			'blog_single' => array(
				'title' => esc_html__('Single post options', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'prevent-auto-close'
				),
				'options' => array(

					'blog_single_post_style' => array(
						'label' => esc_html__( 'Single post style', 'albedo' ),
						'type' => 'select',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_post_style',
						),
						'value' => $wplab_albedo_core->default_options['blog_single_post_style'],
						'choices' => array(
							'default' => esc_html__( 'Default', 'albedo' ),
							'boxed' => esc_html__( 'Boxed', 'albedo' ),
							'wide' => esc_html__( 'Wide (with spacing)', 'albedo' ),
							//'minimal' => esc_html__( 'Minimal', 'albedo' ),
						),
					),
					'blog_single_comment_form_style' => array(
						'label' => esc_html__( 'Comment form style', 'albedo' ),
						'type' => 'select',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_comment_form_style',
						),
						'value' => $wplab_albedo_core->default_options['blog_single_comment_form_style'],
						'choices' => array(
							'white' => esc_html__( 'Style 1', 'albedo' ),
							'white_alt' => esc_html__( 'Style 2', 'albedo' ),
						),
					),
					'blog_single_comment_form_inputs_style' => array(
						'label' => esc_html__( 'Comment form inputs', 'albedo' ),
						'type' => 'select',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_comment_form_inputs_style',
						),
						'value' => $wplab_albedo_core->default_options['blog_single_comment_form_inputs_style'],
						'choices' => array(
							'rounded' => esc_html__( 'Rounded', 'albedo' ),
							'square' => esc_html__( 'Square', 'albedo' ),
						),
					),
					'blog_single_display_featured_image' => array(
						'label' => esc_html__( 'Display featured image', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_featured_image',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_featured_image'],
					),
					'blog_single_display_post_excerpt' => array(
						'label' => esc_html__( 'Display post excerpt before post media', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_post_excerpt',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_post_excerpt'],
					),
					'blog_single_display_post_title' => array(
						'label' => esc_html__( 'Display post title in content', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_post_title',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_post_title'],
					),
					'blog_single_display_post_date' => array(
						'label' => esc_html__( 'Display post date', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_post_date',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_post_date'],
					),
					'blog_single_display_post_author' => array(
						'label' => esc_html__( 'Display post author', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_post_author',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_post_author'],
					),
					'blog_single_display_post_categories' => array(
						'label' => esc_html__( 'Display post categories', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_post_categories',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_post_categories'],
					),
					'blog_single_display_post_comments_num' => array(
						'label' => esc_html__( 'Display comments number', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_post_comments_num',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_post_comments_num'],
					),
					'blog_single_display_post_likes' => array(
						'label' => esc_html__( 'Display post likes', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_post_likes',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_post_likes'],
					),
					'blog_single_display_post_tags' => array(
						'label' => esc_html__( 'Display post tags', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_post_tags',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_post_tags'],
					),
					'blog_single_display_share_links' => array(
						'label' => esc_html__( 'Display share links', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_share_links',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_share_links'],
					),
					'blog_single_display_about_author' => array(
						'label' => esc_html__( 'Display About Author', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_about_author',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['blog_single_display_about_author'],
					),
					'blog_single_display_prev_next_posts' => array(
						'type' => 'multi-picker',
						'label' => false,
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'blog_single_display_prev_next_posts',
						),
						'picker' => array(
							'enabled' => array(
								'label' => esc_html__( 'Display links to previous / next posts', 'albedo' ),
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
								'value' => $wplab_albedo_core->default_options['blog_single_display_prev_next_posts'],
							)
						),
						'choices' => array(
							'yes' => array(

								'blog_single_prev_next_posts_style' => array(
									'label' => esc_html__( 'Previous / Next posts style', 'albedo' ),
									'type' => 'select',
									'fw-storage' => isset($no_fw_storage) ? null : array(
										'type' => 'wp-option',
										'wp-option' => $settings_wp_option,
										'key' => 'blog_single_display_prev_next_posts/yes/blog_single_prev_next_posts_style',
									),
									'value' => $wplab_albedo_core->default_options['blog_single_prev_next_posts_style'],
									'choices' => array(
										'titles' => esc_html__( 'Prev / next post titles', 'albedo' ),
										'links_boxed' => esc_html__( 'Prev / next post links, boxed style', 'albedo' ),
										'thumb_title' => esc_html__( 'Title and Thumbnail', 'albedo' ),
									),
								),

							)
						)
					),

				)
			),

		)
	),
	'portfolio' => array(
		'title' => esc_html__('Portfolio', 'albedo'),
		'type' => 'tab',
		'options' => array(

			'portfolio_single' => array(
				'title' => esc_html__('Single post options', 'albedo'),
				'type' => 'box',
				'attr' => array(
					'class' => 'prevent-auto-close'
				),
				'options' => array(

					'portfolio_single_display_post_title' => array(
						'label' => esc_html__( 'Display post title in content', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'portfolio_single_display_post_title',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['portfolio_single_display_post_title'],
					),
					'portfolio_single_display_post_excerpt' => array(
						'label' => esc_html__( 'Display post excerpt in content', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'portfolio_single_display_post_excerpt',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['portfolio_single_display_post_excerpt'],
					),
					'portfolio_single_display_post_thumb' => array(
						'label' => esc_html__( 'Display post thumbnail in content', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'portfolio_single_display_post_thumb',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['portfolio_single_display_post_thumb'],
					),
					'portfolio_single_display_post_gallery' => array(
						'label' => esc_html__( 'Display post gallery in content', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'portfolio_single_display_post_gallery',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['portfolio_single_display_post_gallery'],
					),
					'portfolio_single_display_post_cats' => array(
						'label' => esc_html__( 'Display post categories in content', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'portfolio_single_display_post_cats',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['portfolio_single_display_post_cats'],
					),
					'portfolio_single_display_post_likes' => array(
						'label' => esc_html__( 'Display post likes', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'portfolio_single_display_post_likes',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['portfolio_single_display_post_likes'],
					),
					'portfolio_single_display_share_links' => array(
						'label' => esc_html__( 'Display share links', 'albedo' ),
						'type' => 'switch',
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'portfolio_single_display_share_links',
						),
						'right-choice' => array(
							'value' => 'yes',
							'label' => esc_html__( 'Yes', 'albedo' )
						),
						'left-choice' => array(
							'value' => 'no',
							'color' => '#ccc',
							'label' => esc_html__( 'No', 'albedo' )
						),
						'value' => $wplab_albedo_core->default_options['portfolio_single_display_share_links'],
					),
					'portfolio_single_display_prev_next_posts' => array(
						'type' => 'multi-picker',
						'label' => false,
						'fw-storage' => isset($no_fw_storage) ? null : array(
							'type' => 'wp-option',
							'wp-option' => $settings_wp_option,
							'key' => 'portfolio_single_display_prev_next_posts',
						),
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Display links to previous / next posts', 'albedo' ),
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
							'value' => $wplab_albedo_core->default_options['portfolio_single_display_prev_next_posts'],
						)
					),
					'choices' => array(
						'yes' => array(

							'portfolio_single_prev_next_posts_style' => array(
								'label' => esc_html__( 'Previous / Next posts style', 'albedo' ),
								'type' => 'select',
								'fw-storage' => isset($no_fw_storage) ? null : array(
									'type' => 'wp-option',
									'wp-option' => $settings_wp_option,
									'key' => 'portfolio_single_display_prev_next_posts/yes/portfolio_single_prev_next_posts_style',
								),
								'value' => $wplab_albedo_core->default_options['portfolio_single_prev_next_posts_style'],
								'choices' => array(
									'titles' => esc_html__( 'Prev / next post titles', 'albedo' ),
									'links_boxed' => esc_html__( 'Prev / next post links, boxed style', 'albedo' ),
									'thumb_title' => esc_html__( 'Title and Thumbnail', 'albedo' ),
								),
							),

						)
					)
				),
				'portfolio_single_display_similar_posts' => array(
					'type' => 'multi-picker',
					'label' => false,
					'fw-storage' => isset($no_fw_storage) ? null : array(
						'type' => 'wp-option',
						'wp-option' => $settings_wp_option,
						'key' => 'portfolio_single_display_similar_posts',
					),
					'picker' => array(
						'enabled' => array(
							'label' => esc_html__( 'Display similar posts', 'albedo' ),
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
							'value' => $wplab_albedo_core->default_options['portfolio_single_display_similar_posts'],
						)
					),
					'choices' => array(
						'yes' => array(

							'portfolio_single_similar_posts_title' => array(
								'type'  => 'text',
								'fw-storage' => isset($no_fw_storage) ? null : array(
									'type' => 'wp-option',
									'wp-option' => $settings_wp_option,
									'key' => 'portfolio_single_similar_posts_title',
								),
								'label' => esc_html__('Similar posts title', 'albedo'),
								'value' => $wplab_albedo_core->default_options['portfolio_single_similar_posts_title'],
							),

							'portfolio_single_similar_posts_desc' => array(
								'type'  => 'textarea',
								'fw-storage' => isset($no_fw_storage) ? null : array(
									'type' => 'wp-option',
									'wp-option' => $settings_wp_option,
									'key' => 'portfolio_single_similar_posts_desc',
								),
								'label' => esc_html__('Similar posts description', 'albedo'),
								'value' => $wplab_albedo_core->default_options['portfolio_single_similar_posts_desc'],
							),

							'portfolio_single_similar_posts_style' => array(
								'label' => esc_html__( 'Similar posts style', 'albedo' ),
								'type' => 'select',
								'fw-storage' => isset($no_fw_storage) ? null : array(
									'type' => 'wp-option',
									'wp-option' => $settings_wp_option,
									'key' => 'portfolio_single_display_similar_posts/yes/portfolio_single_similar_posts_style',
								),
								'value' => $wplab_albedo_core->default_options['portfolio_single_similar_posts_style'],
								'choices' => array(
									'carousel' => esc_html__( 'Carousel', 'albedo' ),
									'3cols_grid' => esc_html__( 'Grid', 'albedo' ),
								),
							),

						)
					)
				),

			)
		),

	)
),
'woocommerce' => array(
	'title' => esc_html__('WooCommerce', 'albedo'),
	'type' => 'tab',
	'options' => array(

		'shop_title' => array(
			'type'  => 'text',
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'shop_title',
			),
			'label' => esc_html__('Shop title', 'albedo'),
			'value' => $wplab_albedo_core->default_options['shop_title'],
			'desc' => esc_html__('used in a page header', 'albedo'),
		),
		'woo_posts_count' => array(
			'type'  => 'short-text',
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'woo_posts_count',
			),
			'label' => esc_html__('Posts per page', 'albedo'),
			'desc' => esc_html__( 'Products count per one page', 'albedo' ),
			'value' => $wplab_albedo_core->default_options['woo_posts_count']
		),
		'woo_related_products_number' => array(
			'type'  => 'short-text',
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'woo_related_products_number',
			),
			'label' => esc_html__('Max number of related products', 'albedo'),
			'value' => $wplab_albedo_core->default_options['woo_related_products_number']
		),
		'woo_products_style' => array(
			'label' => esc_html__( 'Products style', 'albedo' ),
			'type' => 'select',
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'woo_products_style',
			),
			'value' => $wplab_albedo_core->default_options['woo_products_style'],
			'choices' => array(
				'style_1' => esc_html__( 'Boxed', 'albedo' ),
				'style_2' => esc_html__( 'Boxed Media', 'albedo' ),
				'style_3' => esc_html__( 'Simple', 'albedo' ),
			),
		),
		'woo_single_post_style' => array(
			'label' => esc_html__( 'Single post style', 'albedo' ),
			'type' => 'select',
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'woo_single_post_style',
			),
			'value' => $wplab_albedo_core->default_options['woo_single_post_style'],
			'choices' => array(
				'style_1' => esc_html__( 'Boxed', 'albedo' ),
				'style_2' => esc_html__( 'Simple', 'albedo' ),
			),
		),
		'woo_pagination_style' => array(
			'label' => esc_html__( 'Pagination style', 'albedo' ),
			'type' => 'select',
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'woo_pagination_style',
			),
			'value' => $wplab_albedo_core->default_options['woo_pagination_style'],
			'choices' => array(
				'style_1' => esc_html__( 'Boxed', 'albedo' ),
				'style_2' => esc_html__( 'Simple', 'albedo' ),
			),
		),
		'woo_ordering_boxes' => array(
			'label' => esc_html__( 'Ordering boxes', 'albedo' ),
			'type' => 'switch',
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'woo_ordering_boxes',
			),
			'right-choice' => array(
				'value' => 'yes',
				'label' => esc_html__( 'Enabled', 'albedo' )
			),
			'left-choice' => array(
				'value' => 'no',
				'color' => '#ccc',
				'label' => esc_html__( 'Disabled', 'albedo' )
			),
			'value' => $wplab_albedo_core->default_options['woo_ordering_boxes'],
			'desc' => esc_html__( 'If disabled, your shop will work as a simple Catalog', 'albedo' ),
		),

	)
),
	'custom_css' => array(
		'title' => esc_html__('Custom CSS Code', 'albedo'),
		'type' => 'tab',
		'options' => array(

		'custom_css_code' => array(
			'label' => esc_html__( 'Custom CSS Code', 'albedo' ),
			'type' => 'textarea',
			'fw-storage' => isset($no_fw_storage) ? null : array(
				'type' => 'wp-option',
				'wp-option' => $settings_wp_option,
				'key' => 'custom_css_code',
			),
			'value' => $wplab_albedo_core->default_options['custom_css_code'],
			'desc' => esc_html__( 'here you can paste your own custom CSS', 'albedo' ),
		),

		),
	),
);
