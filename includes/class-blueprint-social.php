<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://memphismckay.com
 * @since      1.0.0
 *
 * @package    Blueprint_Social
 * @subpackage Blueprint_Social/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Blueprint_Social
 * @subpackage Blueprint_Social/includes
 * @author     Memphis McKay <support@memphismckay.com>
 */
class Blueprint_Social {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Blueprint_Social_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BLUEPRINT_SOCIAL_VERSION' ) ) {
			$this->version = BLUEPRINT_SOCIAL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'blueprint-social';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_customizer_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Blueprint_Social_Loader. Orchestrates the hooks of the plugin.
	 * - Blueprint_Social_i18n. Defines internationalization functionality.
	 * - Blueprint_Social_Admin. Defines all hooks for the admin area.
	 * - Blueprint_Social_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once BLUEPRINT_SOCIAL_PLUGIN_DIR . 'includes/class-blueprint-social-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once BLUEPRINT_SOCIAL_PLUGIN_DIR . 'includes/class-blueprint-social-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once BLUEPRINT_SOCIAL_PLUGIN_DIR . 'admin/class-blueprint-social-admin.php';

		/**
		 * The classes responsible for defining shortcodes
		 */
		require_once BLUEPRINT_SOCIAL_PLUGIN_DIR . 'admin/shortcodes/class-blueprint-social-shortcodes.php';


    /**
    * The Class responsible for defining available networks
    */
    require_once BLUEPRINT_SOCIAL_PLUGIN_DIR . 'admin/class-blueprint-social-networks.php';


		/**
		 * The classes responsible for setting up Customizer
		 */
		require_once BLUEPRINT_SOCIAL_PLUGIN_DIR . 'admin/customizer/class-blueprint-social-custom-link-control.php';

		require_once BLUEPRINT_SOCIAL_PLUGIN_DIR . 'admin/customizer/class-blueprint-social-customizer.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once BLUEPRINT_SOCIAL_PLUGIN_DIR . 'public/class-blueprint-social-public.php';

		$this->loader = new Blueprint_Social_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Blueprint_Social_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Blueprint_Social_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Blueprint_Social_Admin( $this->get_plugin_name(), $this->get_version() );

		$shortcodes = new Blueprint_Social_Shortcodes( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_filter( 'blueprint_rest_fields', $plugin_admin, 'add_rest_fields' );

    //$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );

		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		//$this->loader->add_action( 'customize_preview_init', $plugin_admin, 'enqueue_scripts' );


	}

	/**
	 * Register all of the hooks related to the customizer functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */

	private function define_customizer_hooks() {

		$customize = new Blueprint_Social_Customizer( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'customize_preview_init', $customize, 'live_preview' );

		$this->loader->add_action( 'customize_register', $customize, 'register_customizer' );

		$this->loader->add_action( 'customize_register', $customize, 'register_display_customizer'  );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Blueprint_Social_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		$this->loader->add_action( 'wp_head', $plugin_public, 'custom_css');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Blueprint_Social_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
