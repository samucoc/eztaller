<?php

/**
 * Primary core controller
 **/
class wplab_albedo_core_controller {

	public $cfg;
	public $current_skin;
	public $default_styles;
	public $default_options;
	public $model;
	public $view;
	public $controller;

	private static $instance = null;

	/**
	 * @return Singleton
	*/
	public static function getInstance() {
		if ( null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	private function __clone() {}
	
	private function __construct() {}

	/**
	 * Enter point for a framework
	 * @param array
	 **/
	public function run() {

		// Start the session
		if( ! session_id() ) {
			@session_start();
		}

		// Disable Gutenberg
		add_filter( 'gutenberg_can_edit_post_type', '__return_false');

		// Translation support
		load_theme_textdomain( 'albedo', get_template_directory() . '/languages' );

		// Theme activation & deactivation
		add_action( 'init', array( $this, 'activation_hook'));
		add_action( 'switch_theme', array( $this, 'deactivation_hook' ));

		// Load core classes
		$this->_dispatch();

		// Route $_GET/$_POST actions
		add_action( 'parse_request', array( $this, 'delegate_to_controller_action' ), 1 );
		add_action( 'admin_init', array( $this, 'delegate_to_controller_action' ), 1 );

	}

	/**
	 * Set the defaults
	 **/
	private function _set_config() {

		$skin = get_option( 'wplab_albedo_skin' );
		$this->current_skin = is_string( $skin ) && $skin <> '' ? $skin : 'albedo';
		$this->default_styles = wplab_albedo_utils::get_less_vars( get_template_directory() . '/css/front/skins/' . $this->current_skin . '/vars.less');

		// $this->default_options
		require_once get_template_directory() . '/css/front/skins/' . $this->current_skin . '/config.php';

		$this->cfg = array(
			'social_profiles' => array(
				'facebook_url' => esc_html__( 'Facebook URL', 'albedo'),
				'twitter_url' => esc_html__( 'Twitter URL', 'albedo'),
				'instagram_url' => esc_html__( 'Instagram URL', 'albedo'),
				'google_plus_url' => esc_html__( 'Google Plus URL', 'albedo'),
				'pinterest_url' => esc_html__( 'Pinterest URL', 'albedo'),
				'linkedin_url' => esc_html__( 'LinkedIn URL', 'albedo'),
				'youtube_url' => esc_html__( 'YouTube URL', 'albedo'),
				'vimeo_url' => esc_html__( 'Vimeo URL', 'albedo'),
				'dribbble_url' => esc_html__( 'Dribbble URL', 'albedo'),
				'behance_url' => esc_html__( 'Behance URL', 'albedo'),
				'tumblr_url' => esc_html__( 'Tumblr URL', 'albedo'),
				'flickr_url' => esc_html__( 'Flickr URL', 'albedo'),
				'medium_url' => esc_html__( 'Medium URL', 'albedo'),
			),
			'social_icons' => array(
				'facebook_url' => 'fa fa-facebook',
				'twitter_url' => 'fa fa-twitter',
				'instagram_url' => 'fa fa-instagram',
				'google_plus_url' => 'fa fa-google-plus',
				'pinterest_url' => 'fa fa-pinterest-p',
				'linkedin_url' => 'fa fa-linkedin',
				'youtube_url' => 'fa fa-youtube-play',
				'vimeo_url' => 'fa fa-vimeo',
				'dribbble_url' => 'fa fa-dribbble',
				'behance_url' => 'fa fa-behance',
				'tumblr_url' => 'fa fa-tumblr',
				'flickr_url' => 'fa fa-flickr',
				'medium_url' => 'fa fa-medium',
			),
			'animations' => array(
				'bounce' => esc_html__('Bounce', 'albedo'),
				'pulse' => esc_html__('Pulse', 'albedo'),
				'tada' => esc_html__('Tada', 'albedo'),
				'wobble' => esc_html__('Wobble', 'albedo'),
				'jello' => esc_html__('Jello', 'albedo'),
				'bounceIn' => esc_html__('Bounce In', 'albedo'),
				'bounceInDown' => esc_html__('Bounce In Down', 'albedo'),
				'bounceInLeft' => esc_html__('Bounce In Left', 'albedo'),
				'bounceInRight' => esc_html__('Bounce In Right', 'albedo'),
				'bounceInUp' => esc_html__('Bounce In Up', 'albedo'),
				'fadeIn' => esc_html__('Fade In', 'albedo'),
				'fadeInDown' => esc_html__('Fade In Down', 'albedo'),
				'fadeInDownBig' => esc_html__('Fade In Down Big', 'albedo'),
				'fadeInLeft' => esc_html__('Fade In Left', 'albedo'),
				'fadeInLeftBig' => esc_html__('Fade In Left Big', 'albedo'),
				'fadeInRight' => esc_html__('Fade In Right', 'albedo'),
				'fadeInRightBig' => esc_html__('Fade In Right Big', 'albedo'),
				'fadeInUp' => esc_html__('Fade In Up', 'albedo'),
				'fadeInUpBig' => esc_html__('Fade In Up Big', 'albedo'),
				'flip' => esc_html__('Flip', 'albedo'),
				'flipInX' => esc_html__('Flip in X', 'albedo'),
				'flipInY' => esc_html__('Flip in Y', 'albedo'),
				'flipOutX' => esc_html__('Flip out X', 'albedo'),
				'flipOutY' => esc_html__('Flip out Y', 'albedo'),
				'lightSpeedIn' => esc_html__('Light Speed In', 'albedo'),
				'rotateIn' => esc_html__('Rotate In', 'albedo'),
				'rotateInDownLeft' => esc_html__('Rotate In Down Left', 'albedo'),
				'rotateInDownRight' => esc_html__('Rotate In Down Right', 'albedo'),
				'rotateInUpLeft' => esc_html__('Rotate In Up Left', 'albedo'),
				'rotateInUpRight' => esc_html__('Rotate In Up Right', 'albedo'),
				'slideInUp' => esc_html__('Slide In Up', 'albedo'),
				'slideInDown' => esc_html__('Slide In Down', 'albedo'),
				'slideInLeft' => esc_html__('Slide In Left', 'albedo'),
				'slideInRight' => esc_html__('Slide In Right', 'albedo'),
				'zoomIn' => esc_html__('Zoom In', 'albedo'),
				'zoomInDown' => esc_html__('Zoom In Down', 'albedo'),
				'zoomInLeft' => esc_html__('Zoom In Left', 'albedo'),
				'zoomInRight' => esc_html__('Zoom In Right', 'albedo'),
				'zoomInUp' => esc_html__('Zoom In Up', 'albedo'),
			),
			'overlay_effects' => array(
				'default' => esc_html__( 'Default', 'albedo' ),
				'slide-right-left' => esc_html__( 'Slide (from right to left)', 'albedo' ),
				'zoom-out' => esc_html__( 'Zoom Out', 'albedo' ),
				'zoom-in' => esc_html__( 'Zoom In', 'albedo' ),
				'big-zoom' => esc_html__( 'Big Zoom', 'albedo' ),
				'zoom-3d' => esc_html__( 'Zoom 3D', 'albedo' ),
				'zoom-slide' => esc_html__( 'Zoom and Slide', 'albedo' ),
				'shine' => esc_html__( 'Shine', 'albedo' ),
			),
			'base_colors' => array(
				'white' => esc_html__( 'White', 'albedo' ),
				'blue' => esc_html__( 'Blue', 'albedo' ),
				'black' => esc_html__( 'Black', 'albedo' ),
				'grey' => esc_html__( 'Grey', 'albedo' ),
				'light_grey' => esc_html__( 'Light Grey', 'albedo' ),
				'red' => esc_html__( 'Red', 'albedo' ),
				'orange' => esc_html__( 'Orange', 'albedo' ),
				'green' => esc_html__( 'Green', 'albedo' ),
				'turquoise' => esc_html__( 'Turquoise', 'albedo' ),
				'yellow' => esc_html__( 'Yellow', 'albedo' ),
				'purple' => esc_html__( 'Purple', 'albedo' ),
				'dark_purple' => esc_html__( 'Dark Purple', 'albedo' ),
			),
			'button_styles' => array(
				array (
					'attr' => array(
						'label' => esc_html__( 'Solid + shadow button styles', 'albedo' ),
					),
					'choices' => array(
						'blue'      	=> esc_html__( 'Blue', 'albedo' ),
						'black' 			=> esc_html__( 'Black', 'albedo' ),
						'grey' 				=> esc_html__( 'Grey', 'albedo' ),
						'red' 				=> esc_html__( 'Red', 'albedo' ),
						'orange' 			=> esc_html__( 'Orange', 'albedo' ),
						'green' 			=> esc_html__( 'Green', 'albedo' ),
						'turquoise'		=> esc_html__( 'Turquoise', 'albedo' ),
						'yellow'			=> esc_html__( 'Yellow', 'albedo' ),
						'purple'			=> esc_html__( 'Purple', 'albedo' ),
						'dark-purple'	=> esc_html__( 'Dark Purple', 'albedo' ),
						'white'				=> esc_html__( 'White', 'albedo' ),
					),
				),
				array (
					'attr' => array(
						'label' => esc_html__( 'Stroke + shadow button styles', 'albedo' ),
					),
					'choices' => array(
						'blue stroke'      	=> esc_html__( 'Blue Stroke', 'albedo' ),
						'black stroke' 			=> esc_html__( 'Black Stroke', 'albedo' ),
						'grey stroke' 				=> esc_html__( 'Grey Stroke', 'albedo' ),
						'red stroke' 				=> esc_html__( 'Red Stroke', 'albedo' ),
						'orange stroke' 			=> esc_html__( 'Orange Stroke', 'albedo' ),
						'green stroke' 			=> esc_html__( 'Green Stroke', 'albedo' ),
						'turquoise stroke'		=> esc_html__( 'Turquoise Stroke', 'albedo' ),
						'yellow stroke'			=> esc_html__( 'Yellow Stroke', 'albedo' ),
						'purple stroke'			=> esc_html__( 'Purple Stroke', 'albedo' ),
						'dark-purple stroke'	=> esc_html__( 'Dark Purple Stroke', 'albedo' ),
					),
				),
				array (
					'attr' => array(
						'label' => esc_html__( 'Gradient button styles (without shadow)', 'albedo' ),
					),
					'choices' => array(
						'red-gradient gradient-button'      	=> esc_html__( 'Red Gradient', 'albedo' ),
						'violet-gradient gradient-button' 		=> esc_html__( 'Violet Gradient', 'albedo' ),
						'turquoise-gradient gradient-button' 	=> esc_html__( 'Turquoise Gradient', 'albedo' ),
						'blue-gradient gradient-button' 			=> esc_html__( 'Blue Gradient', 'albedo' ),
						'grey-gradient gradient-button' 			=> esc_html__( 'Grey Gradient', 'albedo' ),
						'orange-gradient gradient-button' 		=> esc_html__( 'Orange Gradient', 'albedo' ),
						'green-gradient gradient-button' 			=> esc_html__( 'Green Gradient', 'albedo' ),
						'purple-gradient gradient-button' 		=> esc_html__( 'Purple Gradient', 'albedo' ),
					),
				),
			)
		);

	}

	/**
	 * Do some stuff when plugin was just activated
	 **/
	public function activation_hook() {
		global $pagenow, $wp_version;

		if( version_compare( PHP_VERSION, '5.3.6', '<' ) ) {
			wp_die( sprintf( esc_html__( 'Cannot activate the theme. PHP version >= 5.3.6 is required. Your PHP version: %s', 'albedo' ), PHP_VERSION ) );
		}

		if( version_compare( $wp_version, '4.3', '<' ) ) {
			wp_die( sprintf( esc_html__( 'Cannot activate the theme. WordPress version >= 4.3 is required. Your WordPress version: %s', 'albedo' ), $wp_version ) );
		}

		flush_rewrite_rules( true );
		wp_cache_flush();

	}

	/**
	 * Deactivation hook
	 **/
	public function deactivation_hook() {

		flush_rewrite_rules( true );

	}

	/**
	 * Autoload and instantiate all application
	 * classes neccessary for this plugin
	 **/
	private function _dispatch() {

		$this->model =		  new stdClass();
		$this->view =				new stdClass();
		$this->controller =	new stdClass();

		// Controllers
		require_once get_template_directory() . '/core/controller/shared/io-controller.php';
		$this->controller->io = new wplab_albedo_io_controller();

		// Autoload helpers
		$this->autoload_directory( 'helper', '/', false );

		// Set the config
		$this->_set_config();

		// Manually load dependency classes first
		require_once get_template_directory() . '/core/view/view.php';

		// Manually instantiate dependency classes first
		$this->view = new wplab_albedo_view();
		$this->controller->base = $this;

		// Models
		require_once get_template_directory() . '/core/model/database.php';
		$this->model->database = new wplab_albedo_database();

		require_once get_template_directory() . '/core/model/post.php';
		$this->model->post = new wplab_albedo_post();

		require_once get_template_directory() . '/core/model/thirdparty.php';
		$this->model->thirdparty = new wplab_albedo_thirdparty();

		require_once get_template_directory() . '/core/controller/shared/init-controller.php';
		$this->controller->init = new wplab_albedo_init_controller();

		require_once get_template_directory() . '/core/controller/shared/ajax-controller.php';
		$this->controller->ajax = new wplab_albedo_ajax_controller();

		require_once get_template_directory() . '/core/controller/shared/skins-controller.php';
		$this->controller->skins = new wplab_albedo_skins_controller();

		if( is_admin() || is_customize_preview() ) {

			require_once get_template_directory() . '/core/controller/admin/customizer-controller.php';
			$this->controller->customizer = new wplab_albedo_customizer_controller();

		}

		if( is_admin() ) {

			// Controllers for admin part only
			require_once get_template_directory() . '/core/controller/admin/backend-controller.php';
			$this->controller->backend = new wplab_albedo_backend_controller();

			require_once get_template_directory() . '/core/controller/admin/wizard-controller.php';
			$this->controller->wizard = new wplab_albedo_wizard_controller();


		} else {

			// Controllers for front-end part only
			require_once get_template_directory() . '/core/controller/front/front-controller.php';
			$this->controller->front = new wplab_albedo_front_controller();

			require_once get_template_directory() . '/core/controller/front/optimizer-controller.php';
			$this->controller->optimizer = new wplab_albedo_optimizer_controller();

			require_once get_template_directory() . '/core/controller/front/shortcodes-controller.php';
			$this->controller->shortcodes = new wplab_albedo_shortcodes_controller();

			require_once get_template_directory() . '/core/controller/front/woocommerce-controller.php';
			$this->controller->woocommerce = new wplab_albedo_woocommerce_controller();

		}

		$this->autoload_directory( 'widget', '/', false, true );

		// Inject models, view and controllers from this base
		// controller into all OTHER controllers & models
		foreach ( $this->controller as $controller ) {
			$this->_inject_application_classes( $this->model, $this->view, $controller );
		}
	}

	/**
	 * Autoload all scripts in a directory
	 * @param string
	 * @param string
	 * @param bool
	 **/
	function autoload_directory( $layer, $dir = '/', $load_class = true, $widgets = false ) {

		$directory = get_template_directory() . '/core/' . $layer . $dir;
		$handle = opendir( $directory );

		while ( false !== ( $file = readdir( $handle))) {

			if ( is_file( $directory . $file)) {
				// Figure out class name from file name
				$class = str_replace('.php', '', $file);

				$class = 'wplab_albedo_' . str_replace('-', '_', $class ) . '';
				$shortClass = str_replace( 'wplab_albedo_', '', $class );
				$shortClass = str_replace( '_' . $layer, '', $shortClass);

				if( $load_class ) {
					// Avoid recursion
					if ( $class != get_class( $this) ) {
						// Include and instantiate class
						require_once $directory . $file;
						$this->$layer->$shortClass = new $class();
					}
				} else {
					require_once $directory . $file;
				}

			} elseif( $widgets && is_dir( $directory . $file ) && file_exists( $directory . $file . '/widget.php' ) ) {
				require_once $directory . $file . '/widget.php';
			}
		}

	}

	/**
	 * Inject models, view and controllers
	 * into all other controllers to make
	 * them callable from there
	 * @param object
	 * @param object
	 * @param object
	 **/
	private function _inject_application_classes( $model, $view, $controller ) {
		$controller->model = $model;
		$controller->view = $view;
	}

	/**
	 * Parse custom request using our own routing,
	 * i.e. $_GET['wplab_albedo_action'] or $_POST['wplab_albedo_action'],
	 * and then delegate to appropriate controller
	 * action.
	 *
	 * Example 1: '/?wplab_albedo_action=front_controller-view'
	 * Example 2: '/wp-admin/index.php?wplab_albedo_action=admin_settings-save'
	 **/
	public function delegate_to_controller_action() {
		if ( isset( $_POST['wplab_albedo_action'] ) ) {
			$action = $_POST['wplab_albedo_action'];
		} elseif ( isset( $_GET['wplab_albedo_action'] ) ) {
			$action = $_GET['wplab_albedo_action'];
		}

		if ( isset( $action ) ) {
			$controller_and_action = explode( '-', $action );

			if ( count( $controller_and_action ) == 2 ) {
				//! TODO: Learn from popular frameworks how they secure this bit here!
				$controller = 'wplab_albedo_' . $controller_and_action[0] . '_controller';
				$short_controller = $controller_and_action[0];
				$action = $controller_and_action[1];

				if ( class_exists( $controller ) && method_exists( $controller , $action ) ) {
					call_user_func( array( $this->controller->$short_controller, $action ) );
				}
			}
		}
	}

	/**
	 * Get a model
	 **/
	function model( $name ) {

		$class = 'wplab_albedo_' . $name;

		if( !isset( $this->_model->$class ) ) {
			$directory = get_template_directory() . '/core/model/';
			require_once $directory . $name . '.php';

			@$this->_model->$name = new $class();

			return $this->_model->$name;
		} else {
			return $this->_model->$name;
		}

	}

}
