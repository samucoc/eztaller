<?php

	if ( ! defined( 'FW' ) ) {
		die( 'Forbidden' );
	}

	global $wplab_albedo_core;

	$post_types = array( 'page' => esc_html__( 'Pages', 'albedo' ) );
	foreach( get_post_types( array( 'public' => true, 'publicly_queryable' => true), 'objects') as $post_type ) {
		$post_types[ $post_type->name ] = $post_type->label;
	}

	// temporary code until these idiots will fix fucking sidebars extension
	$sidebars_html = '';
	$sidebars = get_option('albedo-fw-sidebars-options');

	if( is_array( $sidebars ) && isset( $sidebars['sidebars'] ) && !empty( $sidebars['sidebars'] ) ) {
		$sidebars_html = '<div id="wproto-sidebars-list">';
		foreach( $sidebars['sidebars'] as $k=>$v ) {
			$sidebars_html .= '<div class="sb"><label><input type="checkbox" name="wproto-sidebar[]" value="' . $k . '" />' . $v['name'] . '</label></div>';
		}
		$sidebars_html .= '</div>';
	}

	$options = array(
		array(
			'base_options' => array(
				'title' => esc_html__( 'Base Settings', 'albedo' ),
				'type' => 'tab',
				'options' => array(

					'tools_optimization' => array(
						'title' => esc_html__( 'Optimization', 'albedo' ),
						'type' => 'tab',
						'options' => array(

							'assets-optimization-box' => array(
								'title' => esc_html__( 'Assets', 'albedo' ),
								'type' => 'box',
									'attr' => array(
										'class' => 'prevent-auto-close'
								),
								'options' => array(

									'combine_css' => array(
										'type' => 'multi-picker',
										'label' => false,
										'desc' => false,
										'value' => array(
											'enabled' => 'no',
										),
										'picker' => array(

											'enabled' => array(
												'label' => esc_html__( 'Combine CSS styles', 'albedo' ),
												'desc' => esc_html__( 'Combine generated CSS styles into one file, to decrease requests to the server', 'albedo' ),
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

										),
										'choices' => array(
											'yes' => array(

												'combibe_css_exclude' => array(
													'type'  => 'textarea',
													'value' => '',
													'label' => esc_html__('Exclude CSS styles', 'albedo'),
													'desc' => esc_html__('Here you can paste IDs for CSS files that should be excluded from combining, one style per one line', 'albedo' ),
												),

											)
										)
									),
									'combined_cache_expire' => array(
										'type'  => 'text',
										'label' => esc_html__( 'Cache expired', 'albedo'),
										'desc' => esc_html__( 'value in seconds, one year by defaults', 'albedo' ),
										'value' => '31536000'
									),
									'purge_combine_cache' => array(
										'type'  => 'html',
										'label' => esc_html__('Purge the cache', 'albedo'),
										'desc' => esc_html__('Click on this button to purge cached files for CSS styles and JS files', 'albedo'),
										'html'  => '<a href="javascript:;" id="wproto-purge-combined-cache" class="button">' . esc_html__('Purge cached files', 'albedo') . '</a>',
									),
									'purge_activation_cache' => array(
										'type'  => 'html',
										'label' => esc_html__('Purge activation cache', 'albedo'),
										'desc' => esc_html__('Click on this button to purge theme activation cache', 'albedo'),
										'html'  => '<a href="javascript:;" id="wproto-purge-activation-cache" class="button">' . esc_html__('Purge activation cache', 'albedo') . '</a>',
									),
								)
							),

							'disable_elements-box' => array(
								'title' => esc_html__( 'Disable Theme Elements', 'albedo' ),
								'type' => 'box',
								'attr' => array(
									'class' => 'prevent-auto-close'
								),
								'options' => array(

									'disabled_shortcodes' => array(
										'type'  => 'multi-select',
										'value' => array(),
										'label' => esc_html__('Disable Shortcodes', 'albedo'),
										'desc'  => esc_html__('Check shortcodes to disable', 'albedo'),
										'population' => 'array',
										'source' => '',
										'prepopulate' => false,
										'choices' => wplab_albedo_utils::get_unyson_shortcodes(),
										'fw-storage' => array(
											'type' => 'wp-option',
											'wp-option' => 'wplab_albedo_disabled_shortcodes',
										),
									),
									'disabled_custom_post_types' => array(
										'type'  => 'multi-select',
										'value' => array(),
										'label' => esc_html__('Disable Custom Post Types', 'albedo'),
										'desc'  => esc_html__('Check Custom Post Types to disable', 'albedo'),
										'population' => 'array',
										'source' => '',
										'prepopulate' => false,
										'choices' => array(
											'benefits' => esc_html__('Benefits', 'albedo'),
											'tables' => esc_html__('Tables', 'albedo'),
											'team' => esc_html__('Team', 'albedo'),
											'testimonials' => esc_html__('Testimonials', 'albedo'),
											'polls' => esc_html__('Polls', 'albedo'),
											'media_slides' => esc_html__('Media Slides', 'albedo'),
											'timeline_events' => esc_html__('Timeline Events', 'albedo'),
										),
										'fw-storage' => array(
											'type' => 'wp-option',
											'wp-option' => 'wplab_albedo_disabled_custom_post_types',
										),
									)

								)
							),

							'optimize_customizer-box' => array(
								'title' => esc_html__( 'Customizer optimization', 'albedo' ),
								'type' => 'box',
								'attr' => array(
									'class' => 'prevent-auto-close'
								),
								'options' => array(

									'hidden_customizer_sections' => array(
										'type'  => 'multi-select',
										'value' => array(),
										'label' => esc_html__('Hide WordPress Customizer sections', 'albedo'),
										'desc'  => esc_html__('In some cases you may notice a slow behaviour, it is related to the lot of available options and browser memory (e.g. you have installed many browser etensions or many tabs are open at same time). Here you may disable some sections to speed-up the customizer. Disabling a section will not remove options, it simply hides the section to make customizer faster, and at this time, all of options will be not hidden on Customizer Tab in Theme Settings Panel.', 'albedo'),
										'help'  => esc_html__('"Customizer" is a screen where you change theme options in a Visual Mode. It can be found here: WordPress Admin > Appearance > Customize', 'albedo'),
										'population' => 'array',
										'source' => '',
										'prepopulate' => false,
										'choices' => array(
											'title_tagline' => esc_html__('Site Identity', 'albedo'),
											'nav_menus' => esc_html__('Menus', 'albedo'),
											'widgets' => esc_html__('Widgets', 'albedo'),
											'static_front_page' => esc_html__('Static Front Page', 'albedo'),
											'general' => esc_html__('General theme options', 'albedo'),
											'templates' => esc_html__('Templates', 'albedo'),
											'layout' => esc_html__('Layout settings', 'albedo'),
											'sidebar' => esc_html__('Sidebar styling', 'albedo'),
											'preloader' => esc_html__('Preloader', 'albedo'),
											'colors' => esc_html__('Colors', 'albedo'),
											'fonts' => esc_html__('Fonts', 'albedo'),
											'forms' => esc_html__('Forms', 'albedo'),
											'buttons' => esc_html__('Buttons', 'albedo'),
											'custom_css' => esc_html__('Custom CSS', 'albedo'),
											'woocommerce' => esc_html__('WooCommerce', 'albedo'),
											'blog' => esc_html__('Blog', 'albedo'),
											'portfolio' => esc_html__('Portfolio', 'albedo'),
											'header' => esc_html__('Header', 'albedo'),
											'footer' => esc_html__('Footer', 'albedo'),
										),
										'fw-storage' => array(
											'type' => 'wp-option',
											'wp-option' => 'wplab_albedo_hidden_customizer_sections',
										),
									),

								)
							),

						)
					),
				'templates' => array(
					'title' => esc_html__('Templates', 'albedo'),
					'type' => 'tab',
					'options' => array(

							'templates_taxonomies' => array(
								'title' => esc_html__('Custom Templates For Taxonomies', 'albedo'),
								'type' => 'box',
								'attr' => array(
									'class' => 'closed'
								),
								'options' => array(

								'tpl_category' => array(
									'type'  => 'multi-select',
									'label' => esc_html__('Blog category', 'albedo'),
									'population' => 'posts',
									'source' => array('page'),
									'prepopulate' => 10,
									'limit' => 1,
									'choices' => array(
										'default' => esc_html__('- Default template -', 'albedo'),
									)
								),
								'tpl_tag' => array(
									'type'  => 'multi-select',
									'label' => esc_html__('Blog tag', 'albedo'),
									'population' => 'posts',
									'source' => array('page'),
									'prepopulate' => 10,
									'limit' => 1,
									'choices' => array(
										'default' => esc_html__('- Default template -', 'albedo'),
									)
								),
								'tpl_portfolio_category' => array(
									'type'  => 'multi-select',
									'label' => esc_html__('Portfolio category', 'albedo'),
									'population' => 'posts',
									'source' => array('page'),
									'prepopulate' => 10,
									'limit' => 1,
										'choices' => array(
											'default' => esc_html__('- Default template -', 'albedo'),
										)
									),
									)
								),
							'templates_archives' => array(
								'title' => esc_html__('Custom Templates For Archives', 'albedo'),
								'type' => 'box',
								'attr' => array(
									'class' => 'closed'
								),
								'options' => array(

									'tpl_archive_blog' => array(
										'type'  => 'multi-select',
										'label' => esc_html__('Blog archive', 'albedo'),
										'population' => 'posts',
										'source' => array('page'),
										'prepopulate' => 10,
										'limit' => 1,
										'choices' => array(
											'default' => esc_html__('- Default template -', 'albedo'),
										)
									),
									'tpl_archive_portfolio' => array(
										'type'  => 'multi-select',
										'label' => esc_html__('Portfolio archive', 'albedo'),
										'population' => 'posts',
										'source' => array('page'),
										'prepopulate' => 10,
										'limit' => 1,
										'choices' => array(
											'default' => esc_html__('- Default template -', 'albedo'),
										)
									),
								)
							),
							'templates_author' => array(
							'title' => esc_html__('Custom Template For Author Posts', 'albedo'),
							'type' => 'box',
							'attr' => array(
								'class' => 'closed'
							),
								'options' => array(

								'tpl_author' => array(
									'type'  => 'multi-select',
									'label' => esc_html__('Choose the page', 'albedo'),
									'population' => 'posts',
									'source' => array('page'),
									'prepopulate' => 10,
									'limit' => 1,
									'choices' => array(
										'default' => esc_html__('- Default template -', 'albedo'),
									)
								),

							)
						),

					)
				),
				'ajax_search_options' => array(
					'title' => esc_html__( 'AJAX Search', 'albedo' ),
					'type' => 'tab',
					'options' => array(

						'ajax_search_options-box' => array(
							'title' => esc_html__( 'AJAX Search / Suggestions options', 'albedo' ),
							'type' => 'box',
							'options' => array(

								'ajax_search' => array(
									'type' => 'multi-picker',
									'label' => false,
									'picker' => array(
										'enabled' => array(
											'label' => esc_html__( 'Enable AJAX search', 'albedo' ),
											'desc' => esc_html__( 'This option enables AJAX search for all search areas', 'albedo' ),
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

											'ajax_search_min_letter' => array(
												'type'  => 'short-text',
												'value'  => '3',
												'label' => esc_html__('Minimul letters to start search', 'albedo'),
												'desc' => esc_html__('It is not recommended to put here too low value to avoid database crash', 'albedo'),
											),
											'ajax_search_source_post_types' => array(
												'type'  => 'multi-select',
												'value' => array( 'post' => true, 'page' => true, 'docs' => true ),
												'label' => esc_html__('Post types to search', 'albedo'),
												'choices' => $post_types,
											),
											/**
											'ajax_search_source_taxonomies' => array(
												'type'  => 'checkboxes',
												'value' => array( 'post' => true, 'page' => true ),
												'label' => esc_html__('Taxonomies to search', 'albedo'),
												'choices' => $taxonomies,
											),
											'ajax_search_in_title' => array(
												'label' => esc_html__( 'Search In Post / Taxonomy Title', 'albedo' ),
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
											'ajax_search_in_content' => array(
												'label' => esc_html__( 'Search in Post Content', 'albedo' ),
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
											'ajax_search_in_excerpt' => array(
												'label' => esc_html__( 'Search in Post Excerpt', 'albedo' ),
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
											'ajax_search_in_tax_desc' => array(
												'label' => esc_html__( 'Search in Taxonomy Description', 'albedo' ),
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
											**/

										)
									)
								),


							)
						)

					)
				),
				'misc' => array(
					'title' => esc_html__( 'Miscellaneous', 'albedo' ),
					'type' => 'tab',
					'options' => array(

						'misc-thumbs-box' => array(
							'title' => esc_html__( 'Thumbnails', 'albedo' ),
							'type' => 'box',
							'attr' => array(
								'class' => 'prevent-auto-close'
							),
							'limit' => 0,
							'options' => array(

								'thumbs_crop_position' => array(
									'label' => esc_html__( 'Thumbnails crop position', 'albedo' ),
									'type' => 'switch',
									'right-choice' => array(
										'value' => 'default',
										'color' => '#ccc',
										'label' => esc_html__( 'Default', 'albedo' )
									),
									'left-choice' => array(
										'value' => 'top',
										'label' => esc_html__( 'Top', 'albedo' )
									),
									'value' => 'default',
									'help' => esc_html__('By defaults, WordPress crops images from center. Here you can change this behaviour and crop images from top', 'albedo'),
									'desc' => esc_html__('Change thumbnails crop position', 'albedo' ),
								),

							)
						),

						'misc-onepage-box' => array(
							'title' => esc_html__( 'One Page Menu', 'albedo' ),
							'type' => 'box',
							'attr' => array(
								'class' => 'prevent-auto-close'
							),
							'limit' => 0,
							'options' => array(

									'onepage_scroll_offset' => array(
										'type'  => 'short-text',
										'value'  => $wplab_albedo_core->default_options['onepage_scroll_offset'],
										'label' => esc_html__('Scroll offset for one-page menu', 'albedo'),
									),

								)
							),

							'misc-dev-box' => array(
								'title' => esc_html__( 'Information for developers', 'albedo' ),
								'type' => 'box',
								'attr' => array(
									'class' => 'prevent-auto-close'
								),
								'limit' => 0,
								'options' => array(

									'dev_info' => array(
										'label' => esc_html__( 'Display information for developers', 'albedo' ),
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
										'help' => esc_html__('If enabled, developers information will be displayed in HTML comment after primary footer tag.', 'albedo'),
										'desc' => esc_html__('Page generation time and SQL queries count', 'albedo' ),
									),

								)
							),

						)
					),
					'vc_page_builder' => array(
						'title' => esc_html__( 'Visual Composer', 'albedo' ),
						'type' => 'tab',
						'options' => array(

							'vc_page_builder-box' => array(
								'title' => esc_html__( 'Visual Composer Additional Options', 'albedo' ),
								'type' => 'box',
								'attr' => array(
									'class' => 'prevent-auto-close'
								),
								'limit' => 0,
								'options' => array(

									'vc_standalone' => array(
										'label' => esc_html__( 'Use Standalone mode for Visual Composer', 'albedo' ),
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
										'desc' => esc_html__( 'Enable this option to activate your own license for Visual Composer plugin.', 'albedo' ),
										'help' => esc_html__('All themes on ThemeForest / Envato that support Visual Composer come with Bundled Version of this plugin. This means that you can use Visual Composer for free, without license activation. However, you can purchase an additional license and activate Visual Composer standalone mode here. If you purchase direct license for Visual Composer there are following benefits you receive: Access official customer support, Update Visual Composer directly from WPBakery, Access to Template Library etc. We remind you that this is optional, and you can still use Visual Composer without additional licenses in bundled mode.', 'albedo'),
									),

								)
							),

						)
					),
					'page_builder' => array(
						'title' => esc_html__( 'Unyson Page Builder', 'albedo' ),
						'type' => 'tab',
						'options' => array(

							!fw_ext('page-builder') ? array(

								'page-builder-box' => array(
									'title' => esc_html__( 'Page Builder extension required', 'albedo' ),
									'type' => 'box',
									'options' => array(

										'page-builder-text' => array(
											'type' => 'html-full',
											'html' => wp_kses_post( __('Please, activate Unyson <strong>Page Builder</strong> extension to use these settings on <a href="admin.php?page=fw-extensions">this page</a>.', 'albedo' ) )
										)

									)
								)

							) : array(
								'ext:page-builder' => array(
									'type' => 'multi',
									'label' => false,
									'inner-options' => fw_ext('page-builder')->get_settings_options(),
									'fw-storage' => array(
										'type' => 'wp-option',
										'wp-option' => 'fw_ext_settings_options:page-builder'
									),
								),
							),

						)
					),
					'apis' => array(
						'title' => esc_html__( 'Social API', 'albedo' ),
						'type' => 'tab',
						'options' => array(

							!fw_ext('social') ? array(

								'social-box' => array(
									'title' => esc_html__( 'Social extension required', 'albedo' ),
									'type' => 'box',
									'options' => array(

										'social-text' => array(
											'type' => 'html-full',
											'html' => wp_kses_post( __('Please, activate Unyson <strong>Social</strong> extension to use these settings on <a href="admin.php?page=fw-extensions">this page</a>.', 'albedo' ) )
										)

									)
								)

							) : array(
								'ext:social' => array(
									'type' => 'multi',
									'label' => false,
									'inner-options' => fw_ext('social')->get_settings_options(),
									'fw-storage' => array(
										'type' => 'wp-option',
										'wp-option' => 'fw_ext_settings_options:social'
									),
								),
							),

						)
					),
					'analytics' => array(
						'title' => esc_html__( 'Google Analytics', 'albedo' ),
						'type' => 'tab',
						'options' => array(

							!fw_ext('analytics') ? array(

								'analytics-box' => array(
									'title' => esc_html__( 'Analytics extension required', 'albedo' ),
									'type' => 'box',
									'options' => array(

										'analytics-text' => array(
											'type' => 'html-full',
											'html' => wp_kses_post( __('Please, activate Unyson <strong>Analytics</strong> extension to use these settings on <a href="admin.php?page=fw-extensions">this page</a>.', 'albedo' ) )
										)

									)
								)

							) : array(
								'ext:analytics' => array(
									'type' => 'multi',
									'label' => false,
									'inner-options' => fw_ext('analytics')->get_settings_options(),
									'fw-storage' => array(
										'type' => 'wp-option',
										'wp-option' => 'fw_ext_settings_options:analytics'
									),
								),
							),

						)
					),
					'seo' => array(
						'title' => esc_html__( 'SEO', 'albedo' ),
						'type' => 'tab',
						'options' => array(

							!fw_ext('seo') ? array(

								'seo-box' => array(
									'title' => esc_html__( 'SEO extension required', 'albedo' ),
									'type' => 'box',
									'options' => array(

										'seo-text' => array(
											'type' => 'html-full',
											'html' => wp_kses_post( __('Please, activate Unyson <strong>SEO</strong> extension to use these settings on <a href="admin.php?page=fw-extensions">this page</a>.', 'albedo' ) )
										)

									)
								)

							) : array(
								'ext:seo' => array(
									'type' => 'multi',
									'label' => false,
									'inner-options' => fw_ext('seo')->get_settings_options(),
									'fw-storage' => array(
										'type' => 'wp-option',
										'wp-option' => 'fw_ext_settings_options:seo'
									),
								),
							),

						)
					),
					'sidebars' => array(
						'title' => esc_html__( 'Sidebars', 'albedo' ),
						'type' => 'tab',
						'options' => array(

							'sidebars-box' => array(
								'title' => esc_html__( 'Manage Custom Sidebars', 'albedo' ),
								'type' => 'box',
								'options' => array(

									'purge_combine_cache' => array(
										'type'  => 'html',
										'label' => esc_html__('Delete custom sidebars', 'albedo'),
										'html'  => $sidebars_html . '<a href="javascript:;" id="wproto-delete-sidebars" class="button">' . esc_html__('Delete chosen sidebars', 'albedo') . '</a>',
									),

								)
							)

						)
					)

				)
			),
		)
	);
