<?php

require_once get_template_directory() . '/core/vendor/tgm-plugin-activation/class-tgm-plugin-activation.php';

/**
 * Setup Wizard controller
 **/
class wplab_albedo_wizard_controller {

	protected $envato_username = '';
	protected $theme_name = '';
	protected $oauth_script = '';
	protected $step = '';
	protected $steps = array();
	protected $page_slug;
	protected $tgmpa_instance;
	protected $tgmpa_menu_slug = 'tgmpa-install-plugins';
	protected $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';
	protected $page_parent;
	protected $page_url;
	protected $update_url = '';
	protected $demo_url = '';
	protected $demo_data_url = '';
	private static $_current_manage_token = false;

	function __construct() {

		$this->setup_vars();
		$this->setup_actions();

	}

	/**
	 * Setup vars
	**/
	function setup_vars() {

		// fill the variables
		$this->envato_username        = 'wplab';
		$this->theme_name             = $this->envato_username . '_albedo';
		$this->oauth_script           = base64_decode( 'aHR0cDovL2VudmF0by5hbGJlZG8tdGhlbWUuY29tL2VudmF0by5hcHAucGhw' );
		$this->page_slug              = $this->theme_name . '_setup_wizard';
		$this->parent_slug            = '';
		$this->update_url             = base64_decode( 'aHR0cDovL3VwZGF0ZS5hbGJlZG8tdGhlbWUuY29t' );
		$this->demo_url               = base64_decode( 'Ly93d3cuYWxiZWRvLXRoZW1lLmNvbQ==' );
		$this->demo_data_url          = base64_decode( 'aHR0cDovL2RlbW8tZGF0YS5hbGJlZG8tdGhlbWUuY29t' );

		//If we have parent slug - set correct url
		if ( $this->parent_slug !== '' ) {
			$this->page_url = 'admin.php?page=' . $this->page_slug;
		} else {
			$this->page_url = 'themes.php?page=' . $this->page_slug;
		}

		$this->steps = array(
			'welcome' => array(
				'name'    => esc_html__( 'Welcome', 'albedo' ),
				'view'    => array( $this, 'wizard_step_welcome' ),
				'handler' => '',
			),
			'check_server' => array(
				'name'    => esc_html__( 'Check Server', 'albedo' ),
				'view'    => array( $this, 'wizard_step_check_server' ),
				'handler' => '',
			),
			'activation' => array(
				'name'    => esc_html__( 'Activation', 'albedo' ),
				'view'    => array( $this, 'wizard_step_activation' ),
				'handler' => array( $this, 'wizard_step_activation_save' ),
			),
			'page_builder' => array(
				'name'    => esc_html__( 'Page Builder', 'albedo' ),
				'view'    => array( $this, 'wizard_step_page_builder' ),
				'handler' => array( $this, 'wizard_step_page_builder_save' ),
			),
			'install_plugins' => array(
				'name'    => esc_html__( 'Plugins', 'albedo' ),
				'view'    => array( $this, 'wizard_step_install_plugins' ),
				'handler' => '',
			),
			'support' => array(
				'name'    => esc_html__( 'Support', 'albedo' ),
				'view'    => array( $this, 'wizard_step_support' ),
				'handler' => '',
			),
			'ready' => array(
				'name'    => esc_html__( 'Ready', 'albedo' ),
				'view'    => array( $this, 'wizard_step_ready' ),
				'handler' => '',
			),
		);
	}

	/**
	 * Setup actions
	**/
	function setup_actions() {
		// add actions

		add_action( 'admin_notices', array( $this, 'theme_admin_notices') );

		if ( current_user_can( 'manage_options' ) ) {
			add_action( 'after_switch_theme', array( $this, 'switch_theme' ) );

			// Required plugins
			add_action( 'tgmpa_register', array( $this, 'register_plugins' ) );
			add_action( 'init', array( $this, 'get_tgmpa_instanse' ), 30 );
			add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );

			add_action( 'admin_init', array( $this, 'admin_redirects' ), 30 );
			add_filter( 'tgmpa_load', array( $this, 'tgmpa_load' ), 10, 1 );
			add_action( 'wp_ajax_' . $this->theme_name . '_setup_plugins_wizard', array( $this, 'ajax_setup_plugins' ) );

			// Register Demo data
			add_filter( 'fw:ext:backups-demo:demos', array( $this, 'register_demo_data' ) );

			// Setup Envato Market plugin
			add_action( 'admin_init', array( $this, 'envato_market_admin_init' ), 20 );
			if ( function_exists( 'envato_market' ) ) {
				add_filter( 'http_request_args', array( $this, 'envato_market_http_request_args' ), 10, 2 );
			}

		}

	}

	/**
	* Redirect to Wizard on Theme Activation
	**/
	public function switch_theme() {
		set_transient( '_' . $this->theme_name . '_activation_redirect', 1 );
	}

	/**
	 * Register required plugins
	 **/
	function register_plugins() {

		if( ! wplab_albedo_utils::is_ad() ) {
			//return;
		}

		$page_builder = get_option( $this->theme_name . '_page_builder', 'visual_composer');
		$plugins = array();

		if( $page_builder == 'visual_composer' ) {

			$plugins = array(
				array(
					'name' 								=> 'Unyson',
					'slug' 								=> 'unyson',
					'version' 						=> '2.7.14',
					'required' 						=> false,
					'force_activation' 		=> false
				),
				array(
					'name' 								=> 'Classic Editor',
					'slug' 								=> 'classic-editor',
					'version' 						=> '0.4',
					'required' 						=> true,
					'force_activation' 		=> true
				),
				array(
					'name'     						=> 'WPlab Albedo Core',
					'slug'     						=> 'wplab-albedo-core',
					'source'   						=> get_template_directory() . '/core/vendor/plugins/wplab-albedo-core.zip',
					'required' 						=> false,
					'version' 						=> '1.0.2',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
				),
				array(
					'name'     						=> 'Visual Composer',
					'slug'     						=> 'js_composer',
					'source'   						=> get_template_directory() . '/core/vendor/plugins/js_composer.zip',
					'required' 						=> false,
					'version' 						=> '5.4.2',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
				),
				array(
					'name'     						=> 'Slider Revolution',
					'slug'     						=> 'revslider',
					'source'   						=> get_template_directory() . '/core/vendor/plugins/revslider.zip',
					'required' 						=> false,
					'version' 						=> '5.4.6',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
				),
				array(
					'name'     						=> 'Envato Market',
					'slug'     						=> 'envato-market',
					'source'   						=> get_template_directory() . '/core/vendor/plugins/envato-market.zip',
					'required' 						=> false,
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
				),
				array(
					'name' 								=> 'WooCommerce',
					'slug' 								=> 'woocommerce',
					'version' 						=> '3.4.0',
					'required' 						=> false,
					'force_activation' 		=> false
				),
				array(
					'name' 								=> 'Mail Chimp',
					'slug' 								=> 'mailchimp-for-wp',
					'version' 						=> '4.1.10',
					'required' 						=> false,
					'force_activation' 		=> false
				),
				array(
					'name' 								=> 'WP Fastest Cache',
					'slug' 								=> 'wp-fastest-cache',
					'version' 						=> '0.8.7.3',
					'required' 						=> false,
					'force_activation' 		=> false
				),
			);

		} elseif( $page_builder == 'unyson_page_builder' ) {

			$plugins = array(
				array(
					'name'                => 'Unyson',
					'slug'                => 'unyson',
					'version'             => '2.7.14',
					'required'            => false,
					'force_activation'    => false
				),
				array(
					'name' 								=> 'Classic Editor',
					'slug' 								=> 'classic-editor',
					'version' 						=> '0.4',
					'required' 						=> true,
					'force_activation' 		=> true
				),
				array(
					'name'     						=> 'WPlab Albedo Core',
					'slug'     						=> 'wplab-albedo-core',
					'source'   						=> get_template_directory() . '/core/vendor/plugins/wplab-albedo-core.zip',
					'required' 						=> false,
					'version' 						=> '1.0.2',
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
				),
				array(
					'name'                => 'Slider Revolution',
					'slug'                => 'revslider',
					'source'              => get_template_directory() . '/core/vendor/plugins/revslider.zip',
					'required'            => false,
					'version'             => '5.4.6',
					'force_activation'    => false,
					'force_deactivation'  => false,
				),
				array(
					'name'     						=> 'Envato Market',
					'slug'     						=> 'envato-market',
					'source'   						=> get_template_directory() . '/core/vendor/plugins/envato-market.zip',
					'required' 						=> false,
					'force_activation' 		=> false,
					'force_deactivation' 	=> false,
				),
				array(
					'name'                => 'WooCommerce',
					'slug'                => 'woocommerce',
					'version'             => '3.4.0',
					'required'            => false,
					'force_activation'    => false
				),
				array(
					'name'                => 'Mail Chimp',
					'slug'                => 'mailchimp-for-wp',
					'version'             => '4.1.10',
					'required'            => false,
					'force_activation'    => false
				),
				array(
					'name'                => 'WP Fastest Cache',
					'slug'                => 'wp-fastest-cache',
					'version'             => '0.8.7.3',
					'required'            => false,
					'force_activation'    => false
				),
			);

		}

		tgmpa( $plugins, array(
				'default_path' => '',                      // Default absolute path to pre-packaged plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,                   // Automatically activate plugins after installation or not.
				'message'      => ''
		) );

	}

	/**
	 * Get configured TGMPA instance
	 */
	public function get_tgmpa_instanse() {
		$this->tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
	}

	/**
	 * Update $tgmpa_menu_slug and $tgmpa_parent_slug from TGMPA instance
	 */
	public function set_tgmpa_url() {

		$this->tgmpa_menu_slug = ( property_exists( $this->tgmpa_instance, 'menu' ) ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
		$this->tgmpa_menu_slug = $this->tgmpa_menu_slug;

		$tgmpa_parent_slug = ( property_exists( $this->tgmpa_instance, 'parent_slug' ) && $this->tgmpa_instance->parent_slug !== 'themes.php' ) ? 'admin.php' : 'themes.php';
		$this->tgmpa_url = $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug;

	}

	/**
	* Redirect on Theme Setup Wizard
	**/
	public function admin_redirects() {
		if ( ! get_transient( '_' . $this->theme_name . '_activation_redirect' ) || get_option( $this->theme_name . '_setup_complete', false ) ) {
			return;
		}
		delete_transient( '_' . $this->theme_name . '_activation_redirect' );
		wp_safe_redirect( admin_url( 'admin.php?wplab_albedo_action=wizard-display_wizard_screen' ) );
		exit;
	}

	public function tgmpa_load( $status ) {
		return is_admin() || current_user_can( 'install_themes' );
	}

	function ajax_setup_plugins() {

		if ( ! check_ajax_referer( $this->theme_name . '_setup_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
			wp_send_json_error( array( 'error' => 1, 'message' => esc_html__( 'No Slug Found', 'albedo' ) ) );
		}
		$json = array();
		// send back some json we use to hit up TGM
		$plugins = $this->_get_plugins();
		// what are we doing with this plugin?
		foreach ( $plugins['activate'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-activate',
					'action2'       => - 1,
					'message'       => esc_html__( 'Activating Plugin', 'albedo' ),
				);
				break;
			}
		}
		foreach ( $plugins['update'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-update',
					'action2'       => - 1,
					'message'       => esc_html__( 'Updating Plugin', 'albedo' ),
				);
				break;
			}
		}
		foreach ( $plugins['install'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$json = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-install',
					'action2'       => - 1,
					'message'       => esc_html__( 'Installing Plugin', 'albedo' ),
				);
				break;
			}
		}

		if ( $json ) {
			$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
			wp_send_json( $json );
		} else {
			wp_send_json( array( 'done' => 1, 'message' => esc_html__( 'Success', 'albedo' ) ) );
		}
		exit;
	}

	/**
	 * Display a wizard screen
	 **/
	function display_wizard_screen() {

		$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

		wp_register_script( 'jquery-blockui', get_template_directory_uri() . '/js/admin/jquery.blockUI.js', array( 'jquery' ), '2.70', true );
		wp_register_script( 'wplab-albedo-wizard', get_template_directory_uri() . '/js/admin/wizard.js', array(
			'jquery',
			'jquery-blockui',
		), _WPLAB_ALBEDO_CACHE_TIME_ );

		wp_localize_script( 'wplab-albedo-wizard', $this->theme_name . '_wizard_params', array(
			'tgm_plugin_nonce' => array(
				'update'  => wp_create_nonce( 'tgmpa-update' ),
				'install' => wp_create_nonce( 'tgmpa-install' ),
			),
			'tgm_bulk_url'     => admin_url( $this->tgmpa_url ),
			'ajaxurl'          => admin_url( 'admin-ajax.php' ),
			'wpnonce'          => wp_create_nonce( $this->theme_name . '_setup_nonce' ),
			'verify_text'      => esc_html__( '...verifying', 'albedo' ),
		) );

		wp_enqueue_script( 'wplab-albedo-wizard');

		wp_enqueue_style( 'wplab-albedo-wizard', get_template_directory_uri() . '/css/admin/wizard.css', array(
			'wp-admin',
			'dashicons',
			'install',
		), _WPLAB_ALBEDO_CACHE_TIME_ );

		//enqueue style for admin notices
		wp_enqueue_style( 'wp-admin' );

		wp_enqueue_media();
		wp_enqueue_script( 'media' );

		if( ! empty( $_REQUEST['save_step'] ) ) {
			call_user_func( $this->steps[ $this->step ]['handler'] );
			exit;
		}
		$this->view->load_partial('wizard/header');
		$this->setup_wizard_steps();
		$show_content = true;
		echo '<div class="wplab-albedo-setup-content">';
		if ( ! empty( $_REQUEST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) {
			$show_content = call_user_func( $this->steps[ $this->step ]['handler'] );
		}
		if ( $show_content ) {
			$this->setup_wizard_content();
		}
		echo '</div>';
		$this->view->load_partial('wizard/footer', array( 'step' => $this->step ));
		exit;

	}

	/**
	 * Output the steps
	 */
	public function setup_wizard_steps() {
		$ouput_steps = $this->steps;
		array_shift( $ouput_steps );
		?>
		<ol class="wplab-albedo-setup-steps">
			<?php foreach ( $ouput_steps as $step_key => $step ) : ?>
				<li class="<?php
				$show_link = false;
				if ( $step_key === $this->step ) {
					echo 'active';
				} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
					echo 'done';
					$show_link = true;
				}
				?>"><?php
					if ( $show_link ) {
						?>
						<a href="<?php echo esc_url( $this->get_step_link( $step_key ) ); ?>"><?php echo esc_html( $step['name'] ); ?></a>
						<?php
					} else {
						echo esc_html( $step['name'] );
					}
					?></li>
			<?php endforeach; ?>
		</ol>
		<?php
	}

	/**
	 * Output the content for the current step
	 */
	public function setup_wizard_content() {
		isset( $this->steps[ $this->step ] ) ? call_user_func( $this->steps[ $this->step ]['view'] ) : false;
	}

	public function get_step_link( $step ) {
		return add_query_arg( 'step', $step, admin_url( 'admin.php?wplab_albedo_action=wizard-display_wizard_screen' ) );
	}

	private function _get_plugins() {
		$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		$plugins  = array(
			'all'      => array(), // Meaning: all plugins which still have open actions.
			'install'  => array(),
			'update'   => array(),
			'activate' => array(),
		);

		foreach ( $instance->plugins as $slug => $plugin ) {
			if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
				// No need to display plugins if they are installed, up-to-date and active.
				continue;
			} else {
				$plugins['all'][ $slug ] = $plugin;

				if ( ! $instance->is_plugin_installed( $slug ) ) {
					$plugins['install'][ $slug ] = $plugin;
				} else {
					if ( false !== $instance->does_plugin_have_update( $slug ) ) {
						$plugins['update'][ $slug ] = $plugin;
					}

					if ( $instance->can_plugin_activate( $slug ) ) {
						$plugins['activate'][ $slug ] = $plugin;
					}
				}
			}
		}

		return $plugins;
	}

	/**
	 * Register demo data
	 **/
	function register_demo_data() {

		$curr_url = get_template_directory_uri();

		$page_builder = get_option( $this->theme_name . '_page_builder', 'visual_composer');

		$demos_array = array(
			'landing' => array(
				'title' => esc_html__('Landing Website', 'albedo'),
				'screenshot' => $curr_url . '/css/front/skins/albedo/screenshot.png',
				'preview_link' => $this->demo_url,
			),
			'modern' => array(
				'title' => esc_html__('Modern', 'albedo'),
				'screenshot' => $curr_url . '/css/front/skins/modern/screenshot.png',
				'preview_link' => $this->demo_url . '/modern/',
			),
			'creative' => array(
				'title' => esc_html__('Creative', 'albedo'),
				'screenshot' => $curr_url . '/css/front/skins/agency/screenshot.png',
				'preview_link' => $this->demo_url . '/creative/',
			),
			'one_page' => array(
				'title' => esc_html__('One Page / Freelancer', 'albedo'),
				'screenshot' => $curr_url . '/css/front/skins/freelancer/screenshot.png',
				'preview_link' => $this->demo_url . '/one-page/',
			),
			'minimal' => array(
				'title' => esc_html__('Minimal', 'albedo'),
				'screenshot' => $curr_url . '/css/front/skins/minimal/screenshot.png',
				'preview_link' => $this->demo_url . '/minimal/',
			),
			'classic' => array(
				'title' => esc_html__('Classic', 'albedo'),
				'screenshot' => $curr_url . '/css/front/skins/classic/screenshot.png',
				'preview_link' => $this->demo_url . '/classic/',
			),
			'business' => array(
				'title' => esc_html__('Business', 'albedo'),
				'screenshot' => $curr_url . '/css/front/skins/business/screenshot.png',
				'preview_link' => $this->demo_url . '/business/',
			),
			'photography' => array(
				'title' => esc_html__('Photography', 'albedo'),
				'screenshot' => $curr_url . '/css/front/skins/photography/screenshot.png',
				'preview_link' => $this->demo_url . '/photography/',
			),
		);

		if( $page_builder == 'visual_composer' ) {
			$vc_demos_array = array();

			foreach( $demos_array as $key => $arr ) {
				$vc_demos_array[ $key . '_vc' ] = array(
					'title' => $arr['title'] . ' VC',
					'screenshot' => $arr['screenshot'],
					'preview_link' => $arr['preview_link'],
				);
			}

			$demos_array = $vc_demos_array;

		}

		$download_url = $this->demo_data_url;

		foreach ($demos_array as $id => $data) {
				$demo = new FW_Ext_Backups_Demo($id, 'piecemeal', array(
					'url' => $download_url,
					'file_id' => $id,
				));
				$demo->set_title( $data['title']);
				$demo->set_screenshot( $data['screenshot']);
				$demo->set_preview_link( $data['preview_link']);

				$demos[ $demo->get_id() ] = $demo;

				unset( $demo );
		}

		return $demos;
	}

	public function get_next_step_link() {
		$keys = array_keys( $this->steps );
		return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) + 1 ], remove_query_arg( 'translation_updated' ) );
	}

	function wizard_step_welcome() {
		$this->view->load_partial('wizard/steps/welcome', array( 'next_step_link' => $this->get_next_step_link() ));
	}

	function wizard_step_check_server() {
		$this->view->load_partial('wizard/steps/check_server', array( 'next_step_link' => $this->get_next_step_link() ));
	}

	function wizard_step_activation() {
		$this->view->load_partial('wizard/steps/activation', array( 'next_step_link' => $this->get_next_step_link() ));
	}

	function wizard_step_activation_save() {
		check_admin_referer( 'wplab-albedo-wizard' );

		// redirect to our custom login URL to get a copy of this token.
		$url = $this->get_oauth_login_url( $this->get_step_link( 'page_builder' ) );

		wp_redirect( esc_url_raw( $url ) );
		exit;
	}

	function wizard_step_page_builder() {

		//$this->_is_ad();
		$this->view->load_partial('wizard/steps/page_builder', array( 'next_step_link' => $this->get_next_step_link() ));
	}

	function wizard_step_page_builder_save() {
		check_admin_referer( 'wplab-albedo-wizard' );

		$page_builder = isset( $_POST['page_builder'] ) && $_POST['page_builder'] <> '' ? $_POST['page_builder'] : 'visual_composer';

		update_option( $this->theme_name . '_page_builder', $page_builder );

		wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
		exit;
	}

	function wizard_step_install_plugins() {

		//$this->_is_ad();
		$this->view->load_partial('wizard/steps/install_plugins', array( 'next_step_link' => $this->get_next_step_link() , 'plugins' => $this->_get_plugins() ) );
	}

	function wizard_step_support() {

		//$this->_is_ad();
		$this->view->load_partial('wizard/steps/support', array( 'next_step_link' => $this->get_next_step_link() ));
	}

	function wizard_step_ready() {

		//$this->_is_ad();
		$this->view->load_partial('wizard/steps/ready');
	}

	/**
	 * Notice about Theme Activation and Updates
	 **/
	public function theme_admin_notices() {

		if( ! wplab_albedo_utils::is_ad() ):
			?>
			<div class="notice notice-warning">
				<p><?php echo wp_kses_post( __( 'Dear Friend! Thank you for choosing <strong>Albedo &mdash; Advanced Creative Multi-Purpose WordPress Theme!</strong>', 'albedo') ); ?></p>
				<p><?php esc_html_e( 'Please activate your license to continue using this product. Once you activate it, you will be able to install demo data and receive automatic updates.', 'albedo'); ?>
				<p><?php printf( __( '<a class="button button-primary" href="%s">Activate</a>' ),  esc_url( admin_url('admin.php?wplab_albedo_action=wizard-display_wizard_screen&step=activation') ) ); ?></p>
			</div>
			<?php
		endif;

	}

	private function _is_ad() {
		if( ! wplab_albedo_utils::is_ad() ) {
			wp_redirect( esc_url_raw( $this->get_step_link( 'activation' ) ) );
			exit;
		}
	}

	public function get_oauth_login_url( $return ) {
		return $this->oauth_script . '?bounce_nonce=' . wp_create_nonce( 'wplab_albedo_oauth_bounce_' . $this->envato_username ) . '&wp_return=' . urlencode( $return ) . '&fail_url=' . urlencode( admin_url('admin.php?wplab_albedo_action=wizard-display_wizard_screen&step=activation&error=oauth') );
	}

	/** dirrefent URL for Envato Market plugin **/
	public function get_oauth_login_url_em( $return ) {
		return $this->oauth_script . '?bounce_nonce=' . wp_create_nonce( 'wplab_albedo_oauth_bounce_' . $this->envato_username ) . '&wp_return=' . urlencode( $return );
	}

	public function envato_market_admin_init() {

		if ( ! empty( $_REQUEST['oauth_session'] ) && ! empty( $_REQUEST['bounce_nonce'] ) && wp_verify_nonce( $_REQUEST['bounce_nonce'], 'wplab_albedo_oauth_bounce_' . $this->envato_username ) ) {
			set_transient( 'd3BsYWJfYWxiZWRvX2FjdGl2ZV9kb21haW4=', base64_encode( $_SERVER['SERVER_NAME'] ), WEEK_IN_SECONDS * 2 );
		}

		// setup Envato Market plugin if it is active
		if ( ! function_exists( 'envato_market' ) ) {
			return;
		}

		global $wp_settings_sections;
		if ( ! isset( $wp_settings_sections[ envato_market()->get_slug() ] ) ) {
			// means we're running the admin_init hook before envato market gets to setup settings area.
			// good - this means our oauth prompt will appear first in the list of settings blocks
			register_setting( envato_market()->get_slug(), envato_market()->get_option_name() );
		}

		// pull our custom options across to envato.
		$option         = get_option( 'wplab_albedo_setup_wizard', array() );
		$envato_options = envato_market()->get_options();
		$envato_options = $this->_array_merge_recursive_distinct( $envato_options, $option );
		if(!empty($envato_options['items'])) {
			foreach($envato_options['items'] as $key => $item) {
				if(!empty($item['id']) && is_string($item['id'])) {
					$envato_options['items'][$key]['id'] = (int)$item['id'];
				}
			}
		}
		update_option( envato_market()->get_option_name(), $envato_options );

		if ( ! empty( $_REQUEST['oauth_session'] ) && ! empty( $_REQUEST['bounce_nonce'] ) && wp_verify_nonce( $_REQUEST['bounce_nonce'], 'wplab_albedo_oauth_bounce_' . $this->envato_username ) ) {
			// request the token from our bounce url.
			$my_theme    = wp_get_theme();
			$oauth_nonce = get_option( 'wplab_albedo_oauth_' . $this->envato_username );
			if ( ! $oauth_nonce ) {
				// this is our 'private key' that is used to request a token from our api bounce server.
				// only hosts with this key are allowed to request a token and a refresh token
				// the first time this key is used, it is set and locked on the server.
				$oauth_nonce = wp_create_nonce( 'wplab_albedo_oauth_nonce_' . $this->envato_username );
				update_option( 'wplab_albedo_oauth_' . $this->envato_username, $oauth_nonce );
			}
			$response = wp_remote_post( $this->oauth_script, array(
					'method'      => 'POST',
					'timeout'     => 15,
					'redirection' => 1,
					'httpversion' => '1.0',
					'blocking'    => true,
					'headers'     => array(),
					'body'        => array(
						'oauth_session' => $_REQUEST['oauth_session'],
						'oauth_nonce'   => $oauth_nonce,
						'get_token'     => 'yes',
						'url'           => home_url(),
						'theme'         => $my_theme->get( 'Name' ),
						'version'       => $my_theme->get( 'Version' ),
					),
					'cookies'     => array(),
				)
			);
			if ( is_wp_error( $response ) ) {
				$error_message = $response->get_error_message();
				$class         = 'error';
				echo "<div class=\"$class\"><p>" . sprintf( esc_html__( 'Something went wrong while trying to retrieve oauth token: %s', 'albedo' ), $error_message ) . '</p></div>';
			} else {
				$token  = @json_decode( wp_remote_retrieve_body( $response ), true );
				$result = false;
				if ( is_array( $token ) && ! empty( $token['access_token'] ) ) {
					$token['oauth_session'] = $_REQUEST['oauth_session'];
					$result                 = $this->_manage_oauth_token( $token );
				}
				if ( $result !== true ) {
					echo 'Failed to get oAuth token. Please go back and try again';
					exit;
				}
			}
		}

		add_settings_section(
			envato_market()->get_option_name() . '_' . $this->envato_username . '_oauth_login',
			sprintf( esc_html__( 'Enable Albedo updates', 'albedo' ), $this->envato_username ),
			array( $this, 'render_oauth_login_description_callback' ),
			envato_market()->get_slug()
		);
		// Items setting.
		add_settings_field(
			$this->envato_username . 'oauth_keys',
			esc_html__( 'Login using Envato Account', 'albedo' ),
			array( $this, 'render_oauth_login_fields_callback' ),
			envato_market()->get_slug(),
			envato_market()->get_option_name() . '_' . $this->envato_username . '_oauth_login'
		);
	}

	public function render_oauth_login_description_callback() {
		echo wp_kses_post( sprintf( __( 'If you purchased any items from <strong>%s</strong> on ThemeForest or CodeCanyon please login here for quick and easy updates for all of them.', 'albedo'), $this->envato_username ) );
	}

	public function render_oauth_login_fields_callback() {
		$option = envato_market()->get_options();
		?>
		<div class="oauth-login" data-username="<?php echo esc_attr( $this->envato_username ); ?>">
			<a href="<?php echo esc_url( $this->get_oauth_login_url_em( admin_url( 'admin.php?page=' . envato_market()->get_slug() . '#settings' ) ) ); ?>" class="oauth-login-button button button-primary"><?php esc_html_e( 'Activate Albedo Theme to enable auto updates', 'albedo'); ?></a>
		</div>
		<?php
	}

	/**
	 * @param $args
	 * @param $url
	 *
	 * @return mixed
	 *
	 * Filter the WordPress HTTP call args.
	 * We do this to find any queries that are using an expired token from an oAuth bounce login.
	 * Since these oAuth tokens only last 1 hour we have to hit up our server again for a refresh of that token before using it on the Envato API.
	 * Hacky, but only way to do it.
	 */
	public function envato_market_http_request_args( $args, $url ) {
		if ( strpos( $url, 'api.envato.com' ) && function_exists( 'envato_market' ) ) {
			// we have an API request.
			// check if it's using an expired token.
			if ( ! empty( $args['headers']['Authorization'] ) ) {
				$token = str_replace( 'Bearer ', '', $args['headers']['Authorization'] );
				if ( $token ) {
					// check our options for a list of active oauth tokens and see if one matches, for this envato username.
					$option = envato_market()->get_options();
					if ( $option && ! empty( $option['oauth'][ $this->envato_username ] ) && $option['oauth'][ $this->envato_username ]['access_token'] == $token && $option['oauth'][ $this->envato_username ]['expires'] < time() + 120 ) {
						// we've found an expired token for this oauth user!
						// time to hit up our bounce server for a refresh of this token and update associated data.
						$this->_manage_oauth_token( $option['oauth'][ $this->envato_username ] );
						$updated_option = envato_market()->get_options();
						if ( $updated_option && ! empty( $updated_option['oauth'][ $this->envato_username ]['access_token'] ) ) {
							// hopefully this means we have an updated access token to deal with.
							$args['headers']['Authorization'] = 'Bearer ' . $updated_option['oauth'][ $this->envato_username ]['access_token'];
						}
					}
				}
			}
		}

		return $args;
	}

	private function _manage_oauth_token( $token ) {
		if ( is_array( $token ) && ! empty( $token['access_token'] ) ) {
			if ( self::$_current_manage_token == $token['access_token'] ) {
				return false; // stop loops when refresh auth fails.
			}
			self::$_current_manage_token = $token['access_token'];
			// yes! we have an access token. store this in our options so we can get a list of items using it.
			$option = get_option( 'wplab_albedo_setup_wizard', array() );
			if ( ! is_array( $option ) ) {
				$option = array();
			}
			if ( empty( $option['items'] ) ) {
				$option['items'] = array();
			}
			// check if token is expired.
			if ( empty( $token['expires'] ) ) {
				$token['expires'] = time() + 3600;
			}
			if ( $token['expires'] < time() + 120 && ! empty( $token['oauth_session'] ) ) {
				// time to renew this token!
				$my_theme    = wp_get_theme();
				$oauth_nonce = get_option( 'wplab_albedo_oauth_' . $this->envato_username );
				$response    = wp_remote_post( $this->oauth_script, array(
						'method'      => 'POST',
						'timeout'     => 10,
						'redirection' => 1,
						'httpversion' => '1.0',
						'blocking'    => true,
						'headers'     => array(),
						'body'        => array(
							'oauth_session' => $token['oauth_session'],
							'oauth_nonce'   => $oauth_nonce,
							'refresh_token' => 'yes',
							'url'           => home_url(),
							'theme'         => $my_theme->get( 'Name' ),
							'version'       => $my_theme->get( 'Version' ),
						),
						'cookies'     => array(),
					)
				);
				if ( is_wp_error( $response ) ) {
					$error_message = $response->get_error_message();
					// we clear any stored tokens which prompts the user to re-auth with the update server.
					$this->_clear_oauth();
				} else {
					$new_token = @json_decode( wp_remote_retrieve_body( $response ), true );
					$result    = false;
					if ( is_array( $new_token ) && ! empty( $new_token['new_token'] ) ) {
						$token['access_token'] = $new_token['new_token'];
						$token['expires']      = time() + 3600;
					}else {
						//refresh failed, we clear any stored tokens which prompts the user to re-register.
						$this->_clear_oauth();
					}
				}
			}
			// use this token to get a list of purchased items
			// add this to our items array.
			$response = envato_market()->api()->request( 'https://api.envato.com/v3/market/buyer/purchases', array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $token['access_token'],
				),
			) );
			self::$_current_manage_token = false;
			if ( is_array( $response ) && is_array( $response['purchases'] ) ) {
				// up to here, add to items array
				foreach ( $response['purchases'] as $purchase ) {
					// check if this item already exists in the items array.
					$exists = false;
					foreach ( $option['items'] as $id => $item ) {
						if ( ! empty( $item['id'] ) && $item['id'] == $purchase['item']['id'] ) {
							$exists = true;
							// update token.
							$option['items'][ $id ]['token']      = $token['access_token'];
							$option['items'][ $id ]['token_data'] = $token;
							$option['items'][ $id ]['oauth']      = $this->envato_username;
							if ( ! empty( $purchase['code'] ) ) {
								$option['items'][ $id ]['purchase_code'] = $purchase['code'];
							}
						}
					}
					if ( ! $exists ) {
						$option['items'][] = array(
							'id'            => '' . $purchase['item']['id'],
							// item id needs to be a string for market download to work correctly.
							'name'          => $purchase['item']['name'],
							'token'         => $token['access_token'],
							'token_data'    => $token,
							'oauth'         => $this->envato_username,
							'type'          => ! empty( $purchase['item']['wordpress_theme_metadata'] ) ? 'theme' : 'plugin',
							'purchase_code' => ! empty( $purchase['code'] ) ? $purchase['code'] : '',
						);
					}
				}
			} else {
				return false;
			}
			if ( ! isset( $option['oauth'] ) ) {
				$option['oauth'] = array();
			}
			// store our 1 hour long token here. we can refresh this token when it comes time to use it again (i.e. during an update)
			$option['oauth'][ $this->envato_username ] = $token;
			update_option( 'wplab_albedo_setup_wizard', $option );

			$envato_options = envato_market()->get_options();
			$envato_options = $this->_array_merge_recursive_distinct( $envato_options, $option );
			update_option( envato_market()->get_option_name(), $envato_options );
			envato_market()->items()->set_themes( true );
			envato_market()->items()->set_plugins( true );

			return true;
		} else {
			return false;
		}
	}

	public function _clear_oauth() {
		$envato_options = envato_market()->get_options();
		unset( $envato_options['oauth'] );
		update_option( envato_market()->get_option_name(), $envato_options );
	}

	/**
	 * @param $array1
	 * @param $array2
	 *
	 * @return mixed
	 *
	 *
	 * @since    1.1.4
	 */
	private function _array_merge_recursive_distinct( $array1, $array2 ) {
		$merged = $array1;
		foreach ( $array2 as $key => &$value ) {
			if ( is_array( $value ) && isset( $merged [ $key ] ) && is_array( $merged [ $key ] ) ) {
				$merged [ $key ] = $this->_array_merge_recursive_distinct( $merged [ $key ], $value );
			} else {
				$merged [ $key ] = $value;
			}
		}

		return $merged;
	}

}
