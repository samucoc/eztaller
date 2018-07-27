<?php

/**
 * Backend controller
 **/
class wplab_albedo_backend_controller {

	protected $support_url 						= 'https://wplab.ticksy.com/';
	protected $support_forums_url 		= 'https://wordpress.org/support/';
	protected $faq_url 								= 'https://wplab.ticksy.com/articles/';
	protected $docs_url 							= 'https://www.albedo-theme.com/docs/';
	protected $customization_url 		= 'https://www.albedo-theme.com/benefits/customization-service/';

	function __construct() {

		// Extend Unyson with new option type
		add_action( 'fw_option_types_init', array( $this, 'extend_unyson_option_types' ) );

		// Add admin scripts and styles
		add_action( 'admin_enqueue_scripts', array( $this, 'add_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );

		// Footer notice
		add_filter( 'admin_footer_text', array( $this, 'add_footer_info' ) );

		// Allow additional mime types
		add_filter( 'upload_mimes', array( $this, 'add_upload_types' ) );
		// fix SVG thumbs in admin
		add_action( 'admin_init', array( $this, 'fix_svg_thumbs' ) );
		add_filter( 'wp_prepare_attachment_for_js', array( $this, 'fix_svgs_response_for_svg' ), 10, 3 );

		// Maintenance notice
		add_action( 'admin_notices', array( $this, 'add_notices'));

		// Add custom columns to post types
		add_filter( 'manage_post_posts_columns', array( $this, 'add_post_thumb_column' ), 10);
		add_action( 'manage_post_posts_custom_column', array( $this, 'print_post_thumb_column' ), 10, 2);
		add_filter( 'manage_team_posts_columns', array( $this, 'add_post_thumb_column' ), 10);
		add_action( 'manage_team_posts_custom_column', array( $this, 'print_post_thumb_column' ), 10, 2);
		add_filter( 'manage_media_slides_posts_columns', array( $this, 'add_post_thumb_column' ), 10);
		add_action( 'manage_media_slides_posts_custom_column', array( $this, 'print_post_thumb_column' ), 10, 2);
		add_filter( 'manage_testimonials_posts_columns', array( $this, 'add_post_thumb_column' ), 10);
		add_action( 'manage_testimonials_posts_custom_column', array( $this, 'print_post_thumb_column' ), 10, 2);
		add_filter( 'manage_benefits_posts_columns', array( $this, 'add_post_thumb_column' ), 10);
		add_action( 'manage_benefits_posts_custom_column', array( $this, 'print_benefits_thumb_column' ), 10, 2);
		add_filter( 'manage_post_posts_columns', array( $this, 'add_featured_post_column' ), 10);
		add_action( 'manage_post_posts_custom_column', array( $this, 'print_featured_post_column' ), 10, 2);
		add_filter( 'manage_fw-portfolio_posts_columns', array( $this, 'add_featured_post_column' ), 10);
		add_action( 'manage_fw-portfolio_posts_custom_column', array( $this, 'print_featured_post_column' ), 10, 2);
		// add Post ID column
		add_filter( 'manage_polls_posts_columns', array( $this, 'add_post_id_column' ), 10);
		add_action( 'manage_polls_posts_custom_column', array( $this, 'print_post_id_column' ), 10, 2);
		add_filter( 'manage_tables_posts_columns', array( $this, 'add_post_id_column' ), 10);
		add_action( 'manage_tables_posts_custom_column', array( $this, 'print_post_id_column' ), 10, 2);

		// Add custom fields to user profile
		add_action( 'show_user_profile', array( $this, 'add_user_custom_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'add_user_custom_fields' ) );

		// Save user custom fields
		add_action( 'personal_options_update', array( $this, 'save_user_custom_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_user_custom_fields' ) );

		// Add filters in admin (featured post)
		add_action( 'restrict_manage_posts', array( $this, 'add_posts_filters' ) );
		add_filter( 'parse_query', array( $this, 'filter_posts' ) );

		// Setup plugins
		$this->setup_plugins();

		// Add custom styles to the TinyMCE
		add_filter( 'mce_buttons_2', array( $this, 'add_tinymce_styles_button') );
		add_filter( 'tiny_mce_before_init', array( $this, 'add_tinymce_styles' ) );

		// Add Help link to the theme
		add_action( 'admin_bar_menu', array( $this, 'add_help_links' ), 99, 1 );

		// Change admin menu position
		add_action( 'fw_backend_add_custom_settings_menu', array( $this, 'add_theme_options_menu' ));
		add_action( 'admin_menu', array( $this, 'add_theme_options_menu_no_unyson' ));

		// Add custom post types support to Unyson Page Builder
		add_filter( 'fw_ext_page_builder_settings_options_post_types_default_value', array( $this, 'enable_unyson_builder_for_cpt' ) );
		add_filter( 'fw_ext_page_builder_supported_post_types', array( $this, 'add_unyson_builder_support_for_cpt' ) );

		// Pricing Tables Editor
		add_action( 'add_meta_boxes', array( $this, 'add_remove_metaboxes' ) );
		add_action( 'save_post', array( $this, 'save_custom_meta' ) );

	}

	/**
	 * Add new Unyson option types
	 **/
	function extend_unyson_option_types() {
		if( is_admin() ) {
			require_once get_template_directory() . '/framework-customizations/custom-option-types/class-fw-option-type-stylebox.php';
		}
	}

	/**
	 * Add admin styles
	 **/
	function add_styles() {
		global $wp_styles, $wplab_albedo_core;

		$screen = get_current_screen();

		// Load theme fonts
		$wplab_albedo_core->controller->init->load_theme_fonts();
		wp_enqueue_style( 'fw-font-awesome', wplab_albedo_utils::locate_uri( '/css/libs/font-awesome.min.css'), false, _WPLAB_ALBEDO_CACHE_TIME_ );
		wp_enqueue_style( 'wplab-albedo-backend', get_template_directory_uri() . '/css/admin/admin.css', false, _WPLAB_ALBEDO_CACHE_TIME_ );

	}

	/**
	 * Add admin scripts
	 **/
	function add_scripts() {
		global $post;

		wp_enqueue_media();

		$js_vars = array(
			'allDone' => esc_html__( 'All done', 'albedo' ),
			'allCachePurged' => esc_html__( 'Cache was purged successfully', 'albedo' ),
			'customizerReset' => esc_html__( 'Customizer options were changed to defaults', 'albedo' ),
			'skinChangeMessage' => esc_html__( 'All saved Theme Options will be reset to skin defaults. Click OK to continue operation or Cancel it.', 'albedo' ),
			'strWarning' => esc_html__( 'Warning', 'albedo' ),
			'strCancel' => esc_html__( 'Cancel', 'albedo' ),
			'strSelectImage' => esc_html__( 'Select an image', 'albedo' ),
			'strSelect' => esc_html__( 'Select', 'albedo' ),
			'strPackageName' => esc_html__( 'Package name', 'albedo' ),
			'strYourFeature' => esc_html__( 'Feature name', 'albedo' ),
			'strValue' => esc_html__( 'Value', 'albedo' ),
			'moveImgSrc' => get_template_directory_uri() . '/images/admin/move@2x.png',
		);

		wp_register_script( 'wplab-albedo-backend', get_template_directory_uri() . '/js/admin/admin.js', false, _WPLAB_ALBEDO_CACHE_TIME_, true );
		wp_enqueue_script( 'wplab-albedo-backend', array( 'jquery' ) );

		wp_localize_script( 'wplab-albedo-backend', 'wplabAlbedoVars', $js_vars );

		if( get_post_type( $post ) == 'tables' ) {
			wp_register_script( 'albedo-pricing-tables-admin', get_template_directory_uri() . '/js/admin/table_editor.js', false, _WPLAB_ALBEDO_CACHE_TIME_ );
			wp_enqueue_script( 'albedo-pricing-tables-admin', array( 'jquery' ) );
		}


	}

	/**
	 * Add footer info
	 **/
	function add_footer_info( $text ) {
		$allowed_tags = wp_kses_allowed_html( 'post' );
		return $text . ' ' . sprintf( wp_kses( __('<i>Theme created by <a href="%s" target="_blank">WPlab.Pro</a>. Please support the further development of this theme, <a href="%s" target="_blank">rate it with 5 &#9733;&#9733;&#9733;&#9733;&#9733;</a> on ThemeForest. Only 5 stars allows us to keep a low price for you!</i>', 'albedo' ), $allowed_tags ), 'http://themeforest.net/user/wplab/?ref=wplab', 'http://themeforest.net/downloads' );
	}

	/**
	 * Allow additional mime types to upload
	 **/
	function add_upload_types( $existing_mimes ) {
		$existing_mimes['ico'] = 'image/vnd.microsoft.icon';
		$existing_mimes['eot'] = 'application/vnd.ms-fontobject';
		$existing_mimes['woff2'] = 'application/x-woff';
		$existing_mimes['woff'] = 'application/x-woff';
		$existing_mimes['ttf'] = 'application/octet-stream';
		$existing_mimes['svg'] = 'image/svg+xml';
		$existing_mimes['mp4'] = 'video/mp4';
		$existing_mimes['ogv'] = 'video/ogg';
		$existing_mimes['webm'] = 'video/webm';
		$existing_mimes['svgz'] = 'image/svg+xml';
		return $existing_mimes;
	}

	function fix_svg_thumbs() {

		$screen = get_current_screen();

		if ( is_object($screen) && $screen->id == 'upload' ) {

			function albedo_svgs_fix_thumbs_filter( $content ) {

				return apply_filters( 'final_output', $content );

			}

			ob_start( 'albedo_svgs_fix_thumbs_filter' );

			add_filter( 'final_output', 'albedo_svgs_fix_final_output' );
			function albedo_svgs_fix_final_output( $content ) {

				$content = str_replace(
					'<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
					'<# } else if ( \'svg+xml\' === data.subtype ) { #>
						<img class="details-image" src="{{ data.url }}" draggable="false" />
						<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',

						$content
						);

				$content = str_replace(
					'<# } else if ( \'image\' === data.type && data.sizes ) { #>',
					'<# } else if ( \'svg+xml\' === data.subtype ) { #>
						<div class="centered">
							<img src="{{ data.url }}" class="thumbnail" draggable="false" />
						</div>
						<# } else if ( \'image\' === data.type && data.sizes ) { #>',

						$content
						);

				return $content;

			}

		}

	}

	function fix_svgs_response_for_svg( $response, $attachment, $meta ) {
		if ( $response['mime'] == 'image/svg+xml' && empty( $response['sizes'] ) ) {

			$svg_path = get_attached_file( $attachment->ID );

			if ( ! file_exists( $svg_path ) ) {
				// If SVG is external, use the URL instead of the path
				$svg_path = $response[ 'url' ];
			}

			$dimensions = $this->svgs_get_dimensions( $svg_path );

			$response[ 'sizes' ] = array(
				'full' => array(
					'url' => $response[ 'url' ],
					'width' => $dimensions->width,
					'height' => $dimensions->height,
					'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait'
					)
				);

		}

		return $response;
	}

	function svgs_get_dimensions( $svg ) {
		$svg = simplexml_load_file( $svg );

		if ( $svg === FALSE ) {

			$width = '0';
			$height = '0';

		} else {

			$attributes = $svg->attributes();
			$width = (string) $attributes->width;
			$height = (string) $attributes->height;
		}

		return (object) array( 'width' => $width, 'height' => $height );
	}

	/**
	 * Add admin notices
	 **/
	function add_notices() {
		global $wplab_albedo_core;

		// is maintenance enabled
		if( wplab_albedo_utils::is_unyson() && filter_var( fw_get_db_settings_option( 'maintenance_mode/enabled' ), FILTER_VALIDATE_BOOLEAN ) ) {
			$this->view->load_partial( 'notice/maintenance' );
		}

	}

	/**
	 * System status screen
	 **/
	function system_status() {
		$this->view->load_partial( 'backend/system_status' );
	}

	/**
	 * Add Thumbnail column to post types
	 **/
	function add_post_thumb_column( $columns ) {

		if( wplab_albedo_utils::is_unyson() ) {
			$column_image = array( 'thumbnail' => esc_html__( 'Cover Image', 'albedo' ) );
			$columns = array_slice( $columns, 0, 1, true ) + $column_image + array_slice( $columns, 1, NULL, true );
		}

		return $columns;
	}

	/**
	 * Print Thumbnail column
	 **/
	function print_post_thumb_column( $column_name, $post_ID ) {

		if ( $column_name == 'thumbnail' && wplab_albedo_utils::is_unyson() ) {
			if( has_post_thumbnail( $post_ID ) ) {
				echo get_the_post_thumbnail( $post_ID, 'thumbnail' );
			} else {
				echo '<img src="' . get_template_directory_uri() . '/images/thumb.png' . '" alt="" />';
			}
		}

	}

	/**
	 * Print Icon column for Benefits post type
	 **/
	function print_benefits_thumb_column( $column_name, $post_ID ) {

		if ( $column_name == 'thumbnail' && wplab_albedo_utils::is_unyson() ) {

			$icon = fw_get_db_post_option( $post_ID, 'icon' );

			if( $icon['type'] == 'icon-font' && isset( $icon['icon-class'] ) && $icon['icon-class'] <> '' ) {

				wp_enqueue_style( $icon['pack-name'], $icon['pack-css-uri'], false, _WPLAB_ALBEDO_CACHE_TIME_ );

				echo '<i class="wproto-icon-thumb ' . $icon['icon-class'] . '"></i>';

			} elseif( $icon['type'] == 'custom-upload' && isset( $icon['attachment-id'] ) && is_numeric( $icon['attachment-id'] ) ) {
				$thumb = wp_get_attachment_image_src( $icon['attachment-id'] );
				echo '<img src="' . $thumb[0] . '" alt="" />';
			}

		}

	}

	/**
	 * Add Featured Post Column
	 **/
	function add_featured_post_column( $columns ) {

		if( wplab_albedo_utils::is_unyson() ) {
			$column_featured = array( 'featured' => esc_html__( 'Featured', 'albedo' ) );
			$columns = array_slice( $columns, 0, 3, true ) + $column_featured + array_slice( $columns, 3, NULL, true );
		}

		return $columns;
	}

	/**
	 * Print Featured post column
	 **/
	function print_featured_post_column( $column_name, $post_ID ) {

		if ( $column_name == 'featured' && wplab_albedo_utils::is_unyson() ) {
			echo filter_var( fw_get_db_post_option( $post_ID, 'featured' ), FILTER_VALIDATE_BOOLEAN ) ? esc_html__( 'Yes', 'albedo' ) : esc_html__( 'No', 'albedo' );
		}

	}

	/**
	 * Add Post ID column
	 **/
	function add_post_id_column( $columns ) {
		$post_id_col = array( 'post_id' => esc_html__( 'Identifier (ID)', 'albedo' ) );
		$columns = array_slice( $columns, 0, 2, true ) + $post_id_col + array_slice( $columns, 1, NULL, true );
		return  $columns;
	}

	/**
	 * Print Post ID column
	 **/
	function print_post_id_column( $column_name, $post_ID ) {

		if ( $column_name == 'post_id' ) {
			echo absint( $post_ID );
		}

	}

	/**
	 * Add a filter by featured label
	 **/
	function add_posts_filters() {

		$screen = get_current_screen();
		$post_type = $screen->post_type;

		if( wplab_albedo_utils::is_unyson() && in_array( $post_type, array('post', 'fw-portfolio') ) ):
			$type = '';
			if( isset( $_GET['featured'] ) ) {
				$type = $_GET['featured'];
			}
			?>
			<select name="featured">
				<option value=""><?php esc_html_e( 'All types', 'albedo' ); ?></option>
				<option <?php echo $type == 'featured' ? 'selected="selected"' : ''; ?> value="featured"><?php esc_html_e( 'Featured posts only', 'albedo' ); ?></option>
			</select>
			<?php
		endif;

	}

	/**
	 * Filter posts query
	 **/
	function filter_posts( $query ) {
		global $pagenow;

			if ( $pagenow == 'edit.php' && isset( $_GET['featured'] ) && $_GET['featured'] != '') {
			$query->query_vars['meta_key'] = 'fw_option:featured';
			$query->query_vars['meta_value'] = 'yes';
			}
	}

	/**
	 * Add custom fields to the user profile
	**/
	function add_user_custom_fields( $user ) {
		$this->view->load_partial( 'user/social_icons', $user );
	}

	/**
	 * Save user custom fields
	**/
	function save_user_custom_fields( $user_id ) {
		global $wplab_albedo_core;

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
			}

		if ( empty( $_POST['social_icons'] ) ) {
			return false;
			}

		foreach( $wplab_albedo_core->cfg['social_profiles'] as $k=>$v ) {
			$val = isset( $_POST['social_icons'][ $k ] ) ? $_POST['social_icons'][ $k ] : '';
			update_user_meta( $user_id, $k, $val );
		}

	}

	/**
	 * Setup compatible plugins
	 **/
	function setup_plugins() {

		// Slider Revolution
		if ( function_exists( 'set_revslider_as_theme' ) ) {
			set_revslider_as_theme();
			remove_action( 'admin_notices', array( 'RevSliderAdmin', 'add_plugins_page_notices' ) );
		}

		// Visual Composer
		if ( class_exists( 'Vc_Manager' ) ) {

			// Disable updater.
			if ( function_exists( 'vc_manager' ) ) {
				vc_manager()->disableUpdater();
			}

			if ( function_exists( 'vc_set_default_editor_post_types' ) ) {
				vc_set_default_editor_post_types( array( 'page', 'post' ) );
			}

			if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
				vc_set_shortcodes_templates_dir( get_template_directory() . '/core/view/vc_shortcodes' );
			}

			// Hide activation message.
			add_action( 'vc_before_init', array( $this, 'vc_set_as_theme' ) );

		}

	}

	function vc_set_as_theme() {
		vc_set_as_theme();
	}

	/**
	 * Add custom styles to the TinyMCE
	 **/
	function add_tinymce_styles_button( $buttons ) {
			array_unshift( $buttons, 'styleselect' );
			array_unshift( $buttons, 'fontsizeselect' );
			return $buttons;
	}

	function add_tinymce_styles( $settings ) {

		// Create array of new styles
		$new_styles = array(
			array(
				'title' => esc_html__( 'Albedo styles', 'albedo' ),
				'items' => array(
					array(
						'title' => esc_html__('Secondary font family', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'font-secondary'
					),
					array(
						'title' => esc_html__('UPPERCASE TEXT', 'albedo'),
						'styles' => array( 'text-transform' => 'uppercase' ),
						'inline' => 'span',
					),
					array(
						'title' => esc_html__('Lighten text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-lighten'
					),
					array(
						'title' => esc_html__('Darken text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-darken'
					),
					array(
						'title' => esc_html__('White text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-white'
					),
					array(
						'title' => esc_html__('Blue text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-blue'
					),
					array(
						'title' => esc_html__('Black text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-black'
					),
					array(
						'title' => esc_html__('Grey text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-grey'
					),
					array(
						'title' => esc_html__('Light Grey text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-light-grey'
					),
					array(
						'title' => esc_html__('Red text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-red'
					),
					array(
						'title' => esc_html__('Orange text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-orange'
					),
					array(
						'title' => esc_html__('Green text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-green'
					),
					array(
						'title' => esc_html__('Turquoise text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-turquoise'
					),
					array(
						'title' => esc_html__('Yellow text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-yellow'
					),
					array(
						'title' => esc_html__('Purple text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-purple'
					),
					array(
						'title' => esc_html__('Dark Purple text color', 'albedo'),
						'selector' => 'span, h1, h2, h3, h4, h5, h6, p, ul, ol, div',
						'classes' => 'color-dark-purple'
					),
				),
			),
		);

		$settings['fontsize_formats'] = '10px 12px 14px 16px 18px 20px 22px 24px 26px 28px 30px 32px 34px 36px 38px 40px';
		$settings['style_formats_merge'] = true;

		// Add new styles
		$settings['style_formats'] = json_encode( $new_styles );

		// Return New Settings
		return $settings;

	}

	/**
	 * Create dashboard page
	 **/
	function create_dashboard() {

		$this->view->load_partial( 'dashboard/welcome' );

	}

	/**
	 * Add help links to the menu
	 **/
	function add_help_links( $wp_admin_bar ) {

		$args = array(
			'id' => 'wproto-theme',
			'title' => '<span class="ab-icon"></span>' . esc_html__( 'Theme Help', 'albedo' ),
			'href' => 'javascript:;',
			'meta' => array(
				'class' => 'wproto-theme'
			)
		);

		$wp_admin_bar->add_node( $args );

		$args = array(
			'id' => 'wproto-help',
			'title' => esc_html__( 'Online Documentation', 'albedo' ),
			'href' => $this->docs_url,
			'parent' => 'wproto-theme',
			'meta' => array(
				'class' => 'wproto-help',
				'title' => esc_html__( 'Click here to read theme documentation', 'albedo' ),
				'target' => '_blank'
			)
		);

		$wp_admin_bar->add_node( $args );

		$args = array(
			'id' => 'wproto-help-faq',
			'title' => esc_html__( 'Frequently Asked Questions', 'albedo' ),
			'href' => $this->faq_url,
			'parent' => 'wproto-theme',
			'meta' => array(
				'class' => 'wproto-help-faq',
				'title' => esc_html__( 'Click here to read theme Frequently Asked Questions', 'albedo' ),
				'target' => '_blank'
			)
		);

		$wp_admin_bar->add_node( $args );

		$args = array(
			'id' => 'wproto-help-forums',
			'title' => esc_html__( 'WordPress Forums', 'albedo' ),
			'href' => $this->support_forums_url,
			'parent' => 'wproto-theme'
		);

		$wp_admin_bar->add_node( $args );

		$args = array(
			'id' => 'wproto-help-support',
			'title' => esc_html__( 'Open a ticket', 'albedo' ),
			'parent' => 'wproto-theme',
			'href' => $this->support_url,
			'meta' => array(
				'class' => 'wproto-help-support',
				'title' => esc_html__( 'Click here to get support', 'albedo' ),
				'target' => '_blank'
			)
		);

		$wp_admin_bar->add_node( $args );

	}

	/**
	 * Move theme options menu
	 **/
	function add_theme_options_menu( $data ) {
		global $wplab_albedo_core;

		add_menu_page(
			esc_html__( 'Albedo Theme', 'albedo' ),
			esc_html__( 'Albedo Theme', 'albedo' ),
			$data['capability'],
			$data['slug'],
			$data['content_callback']
		);

		add_submenu_page(
			$data['slug'],
			esc_html__( 'Theme Settings', 'albedo' ),
			esc_html__( 'Theme Settings', 'albedo' ),
			$data['capability'],
			$data['slug'],
			$data['content_callback']
		);

		add_submenu_page(
			$data['slug'],
			esc_html__( 'Live Customizer', 'albedo' ),
			esc_html__( 'Live Customizer', 'albedo' ),
			$data['capability'],
			'customize.php?return=%2Fwp-admin%2Fadmin.php%3Fpage%3Dfw-settings'
		);

		add_submenu_page(
			$data['slug'],
			esc_html__( 'Setup Wizard', 'albedo' ),
			esc_html__( 'Setup Wizard', 'albedo' ),
			$data['capability'],
			'admin.php?wplab_albedo_action=wizard-display_wizard_screen'
		);

		if( function_exists('fw_ext') && fw_ext('backups') && function_exists('curl_version') && class_exists( 'ZipArchive' ) && wplab_albedo_utils::is_ad() ) {
			add_submenu_page(
				$data['slug'],
				esc_html__( 'Demo content', 'albedo' ),
				esc_html__( 'Demo content', 'albedo' ),
				$data['capability'],
				'tools.php?page=fw-backups-demo-content'
			);
		}

		add_submenu_page(
			$data['slug'],
			esc_html__( 'Documentation', 'albedo' ),
			esc_html__( 'Documentation', 'albedo' ),
			$data['capability'],
			$this->docs_url
		);

		add_submenu_page(
			$data['slug'],
			esc_html__( 'Frequently Asked Questions', 'albedo' ),
			esc_html__( 'Frequently Asked Questions', 'albedo' ),
			$data['capability'],
			$this->faq_url
		);

		add_submenu_page(
			$data['slug'],
			esc_html__( 'System Status', 'albedo' ),
			esc_html__( 'System Status', 'albedo' ),
			$data['capability'],
			'wplab_albedo_system_status',
			array( $this, 'system_status' )
		);

		add_submenu_page(
			$data['slug'],
			esc_html__( 'Get Support', 'albedo' ),
			esc_html__( 'Get Support', 'albedo' ),
			$data['capability'],
			$this->support_url
		);

		add_submenu_page(
			$data['slug'],
			esc_html__( 'Customization', 'albedo' ),
			esc_html__( 'Customization', 'albedo' ),
			$data['capability'],
			$this->customization_url
		);

	}

	function add_theme_options_menu_no_unyson() {

		if( ! wplab_albedo_utils::is_unyson() ) {
			add_menu_page(
				esc_html__( 'Albedo Setup Wizard', 'albedo' ),
				esc_html__( 'Albedo Setup Wizard', 'albedo' ),
				'edit_theme_options',
				'wplab_albedo_setup_wizard',
				array( $this, 'redirect_to_wizard' )
			);

			add_submenu_page(
				'wplab_albedo_setup_wizard',
				esc_html__( 'Documentation', 'albedo' ),
				esc_html__( 'Documentation', 'albedo' ),
				'edit_theme_options',
				$this->docs_url
			);

			add_submenu_page(
				'wplab_albedo_setup_wizard',
				esc_html__( 'Frequently Asked Questions', 'albedo' ),
				esc_html__( 'Frequently Asked Questions', 'albedo' ),
				'edit_theme_options',
				$this->faq_url
			);

			add_submenu_page(
				'wplab_albedo_setup_wizard',
				esc_html__( 'System Status', 'albedo' ),
				esc_html__( 'System Status', 'albedo' ),
				'edit_theme_options',
				'wplab_albedo_system_status',
				array( $this, 'system_status' )
			);

			add_submenu_page(
				'wplab_albedo_setup_wizard',
				esc_html__( 'Get Support', 'albedo' ),
				esc_html__( 'Get Support', 'albedo' ),
				'edit_theme_options',
				$this->support_url
			);

			add_submenu_page(
				'wplab_albedo_setup_wizard',
				esc_html__( 'Customization', 'albedo' ),
				esc_html__( 'Customization', 'albedo' ),
				'edit_theme_options',
				$this->customization_url
			);

		}

	}

	function redirect_to_wizard() {
		?>
		<script>window.location = "<?php echo admin_url('?wplab_albedo_action=wizard-display_wizard_screen'); ?>";</script>
		<?php
	}

	/**
		* Add Unyson Page Builder to custom post types
	**/
	function enable_unyson_builder_for_cpt() {
		$auto = array(
			'page' => true,
			'fw-portfolio' => true,
		);

		return  $auto;
	}

	function add_unyson_builder_support_for_cpt( $elems ) {
		$elems['benefits'] = esc_html__( 'Benefits', 'albedo' );
		$elems['docs'] = esc_html__( 'WeDocs Documentation', 'albedo' );
		$elems['fw-portfolio'] = esc_html__( 'Portfolio projects', 'albedo' );
		return $elems;
	}

	/**
	 * Add / Remove metaboxes
	**/
	function add_remove_metaboxes() {

		remove_meta_box( 'mymetabox_revslider_0', 'tables', 'normal');

		add_meta_box(
			'albedo_table_editor'
			, esc_html__( 'Table Editor', 'albedo' )
			, array( $this, 'render_meta_box_table_editor' )
			, 'tables'
			, 'normal'
			, 'high'
		);

	}

	/**
	 * Pricing Table Editor
	**/
	function render_meta_box_table_editor() {
		global $post;
		$data = array();
		$data['pricing_table'] = get_post_meta( $post->ID, 'pricing_table', true );
		$this->view->load_partial( 'backend/table_editor', $data );

	}

	function save_custom_meta( $post_id ) {

		if ( wp_is_post_revision( $post_id ) || ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX') && DOING_AJAX ) || isset( $_REQUEST['bulk_edit'] ) ) {
			return;
		}

		$post_type = get_post_type( $post_id );

		if( $post_type == 'tables' ) {
			update_post_meta( $post_id, "pricing_table", isset( $_POST["pt"] ) ? $_POST["pt"] : '' );
		}

	}

}
