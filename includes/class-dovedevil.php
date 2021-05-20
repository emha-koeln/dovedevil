<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://emha.koeln
 * @since      0.1.0
 *
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
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
 * @since      0.1.0
 * @package    Dovedevil
 * @subpackage Dovedevil/includes
 * @author     emha.koeln <mheep@emha.koeln>
 */
class Dovedevil {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      Dovedevil_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * DB connection
	 *
	 * @since    0.1.1
	 * @access   protected
	 * @var      Dovedevil_DB    $db    The DB.
	 */
	public $db;
	
	
	/**
	 * Current Fancier
	 *
	 * @since    0.1.1
	 * @access   protected
	 * @var      Dovedevil_Fancier    $fancier    Current Fancier
	 */
	public $fancier;
	
	/**
	 * Parser
	 *
	 * @since    0.1.1
	 * @access   protected
	 * @var      Dovedevil_Parser    $parser
	 */
	public $parser;
	
	/**
	 * The current path of the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	public $path;
	
	
	/**
	 * The current url of the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	public $url;
	
	/**
	 * The current wp userid
	 *
	 * @since    0.1.1
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	public $userid;  // Unused
	
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function __construct( $path, $url ) {
		if ( defined( 'DOVEDEVIL_VERSION' ) ) {
			$this->version = DOVEDEVIL_VERSION;
		} else {
			$this->version = '0.1.1';
		}
		$this->plugin_name = 'dovedevil';

		$this->path = $path;
		$this->url = $url;
		
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Dovedevil_Loader. Orchestrates the hooks of the plugin.
	 * - Dovedevil_i18n. Defines internationalization functionality.
	 * - Dovedevil_Admin. Defines all hooks for the admin area.
	 * - Dovedevil_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dovedevil-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dovedevil-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-dovedevil-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-dovedevil-public.php';

		/**
		 * The class responsible for db connections, select, etc.
		 * of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dovedevil-db.php';
		
		$this->db = new Dovedevil_DB( $this );
		
		/**
		 * The parser class 
		 * of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dovedevil-parser.php';
		
		$this->parser = new Dovedevil_Parser();
		
		/**
		 * The current fancier, set by admin modules
		 * of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-dovedevil-fancier.php';
		
		$this->fancier = new Dovedevil_Fancier( $this );
		
		
		// And start loader
		$this->loader = new Dovedevil_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Dovedevil_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Dovedevil_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Dovedevil_Admin( $this->get_plugin_name(), $this->get_version(), $this );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_setting' );
	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_public_hooks() {

	    $plugin_public = new Dovedevil_Public( $this->get_plugin_name(), $this->get_version(), $this );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1.0
	 * @return    Dovedevil_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
