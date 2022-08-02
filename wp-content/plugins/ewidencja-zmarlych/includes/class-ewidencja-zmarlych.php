<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://brainbox.com.pl/
 * @since      1.0.0
 *
 * @package    Ewidencja_Zmarlych
 * @subpackage Ewidencja_Zmarlych/includes
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
 * @package    Ewidencja_Zmarlych
 * @subpackage Ewidencja_Zmarlych/includes
 * @author     Brainbox <strony@brainbox.com.pl>
 */
class Ewidencja_Zmarlych {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ewidencja_Zmarlych_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'EWIDENCJA_ZMARLYCH_VERSION' ) ) {
			$this->version = EWIDENCJA_ZMARLYCH_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ewidencja-zmarlych';

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
	 * - Ewidencja_Zmarlych_Loader. Orchestrates the hooks of the plugin.
	 * - Ewidencja_Zmarlych_i18n. Defines internationalization functionality.
	 * - Ewidencja_Zmarlych_Admin. Defines all hooks for the admin area.
	 * - Ewidencja_Zmarlych_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ewidencja-zmarlych-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ewidencja-zmarlych-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ewidencja-zmarlych-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ewidencja-zmarlych-public.php';

		$this->loader = new Ewidencja_Zmarlych_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ewidencja_Zmarlych_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ewidencja_Zmarlych_i18n();

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

		$plugin_admin = new Ewidencja_Zmarlych_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'firma_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'esez_post_type' );
		$this->loader->add_action( 'login_head', $plugin_admin, 'redirect_to_nonexistent_page' );
		$this->loader->add_action( 'init', $plugin_admin, 'redirect_to_actual_login' );
		$this->loader->add_action( 'after_setup_theme', $plugin_admin, 'remove_admin_bar' );
		$this->loader->add_action( 'manage_posts_custom_column', $plugin_admin, 'custom_columns' );
		$this->loader->add_filter( 'manage_edit-ewidencjazgonow_columns', $plugin_admin, 'my_page_columns' );
		$this->loader->add_filter( 'get_avatar', $plugin_admin, 'get_local_avatar', 10, 5);
		$this->loader->add_filter( 'user_contactmethods', $plugin_admin, 'add_author_image', 10, 5);
		$this->loader->add_filter( 'rest_route_for_post', $plugin_admin, 'my_plugin_rest_route_for_post', 10, 2);
		$this->loader->add_action( 'acf/save_post', $plugin_admin, 'esez_new_zgon_send_email');
		$this->loader->add_filter( 'wp_mail_from', $plugin_admin, 'wpb_sender_email' );
		$this->loader->add_filter( 'wp_mail_from_name', $plugin_admin, 'wpb_sender_name' );
		$this->loader->add_action( 'wp', $plugin_admin, 'add_login_check' );
		$this->loader->add_action( 'pre_get_posts', $plugin_admin, 'ewidencja_columns_orderby' );
		$this->loader->add_filter( 'manage_edit-ewidencjazgonow_sortable_columns', $plugin_admin, 'my_column_register_sortable' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ewidencja_Zmarlych_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'page_template', $plugin_public, 'create_login_page_template' );
		$this->loader->add_filter( 'page_template', $plugin_public, 'create_konto_page_template' );
		$this->loader->add_filter( 'page_template', $plugin_public, 'create_panel_page_template' );
		$this->loader->add_filter( 'page_template', $plugin_public, 'create_konto_all_page_template' );
		$this->loader->add_filter( 'page_template', $plugin_public, 'create_konto_foreign_page_template' );
		$this->loader->add_filter( 'page_template', $plugin_public, 'create_konto_ended_page_template' );
		$this->loader->add_filter( 'archive_template', $plugin_public, 'load_single_zgon_archive_template' );
		$this->loader->add_filter( 'archive_template', $plugin_public, 'use_custom_template_to_single_zgon' ) ;
		$this->loader->add_filter( 'template_include', $plugin_public, 'ewidencjazgonow_template' ) ;
		$this->loader->add_filter( 'single_template', $plugin_public, 'my_custom_ewidencjazgonow_template' ) ;
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
	 * @return    Ewidencja_Zmarlych_Loader    Orchestrates the hooks of the plugin.
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

// usuwanie niepotrzebnych ról

remove_role( 'subscriber' );
remove_role( 'contributor' );
remove_role( 'editor' );
remove_role( 'author' );
remove_role( 'wlasciciel' );
remove_role( 'wpseo_editor' );
remove_role( 'wpseo_manager' );
remove_role( 'firma pro' );

add_role(
	'pracownik',
	__( 'Pracownik firmy'  ), 
	array(
		'read'  => true,
		'delete_posts'  => false,
		'delete_published_posts' => false,
		'edit_posts'   => true,
		'publish_posts' => true,
		'upload_files'  => true,
		'edit_pages'  => false,
		'edit_published_pages'  =>  false,
		'publish_pages'  => false,
		'delete_published_pages' => false,
	)
);

add_role(
	'firma',
	__( 'Firma'  ),
	array("manage_network"=>true,"manage_sites"=>true,
	"manage_network_users"=>true,"manage_network_plugins"=>true,
	"manage_network_themes"=>true,"manage_network_options"=>true,"read"=>true,
	'delete_posts'  => false,
	'delete_published_posts' => false,
	'edit_posts'   => true,
	'publish_posts' => true,
	'upload_files'  => true,
	'edit_pages'  => true,
	'edit_published_pages'  =>  true,
	'publish_pages'  => true,
	'delete_published_pages' => false,
	'read_ewidencjazgonow' => true,
	'edit_ewidencjazgonow'  => true,
	'publish_ewidencjazgonow'  => true,
	'edit_published_ewidencjazgonow' => true,
	)
);

add_role(
	'firmapro',
	__( 'Firma PRO'  ),
	array("manage_network"=>true,"manage_sites"=>true,
	"manage_network_users"=>true,"manage_network_plugins"=>true,
	"manage_network_themes"=>true,"manage_network_options"=>true,"read"=>true,
	'delete_posts'  => false,
	'delete_published_posts' => false,
	'edit_posts'   => true,
	'publish_posts' => true,
	'upload_files'  => true,
	'edit_pages'  => true,
	'edit_published_pages'  =>  true,
	'publish_pages'  => true,
	'delete_published_pages' => false, 
	'read_ewidencjazgonow' => true,
	'edit_ewidencjazgonow'  => true,
	'publish_ewidencjazgonow'  => true,
	'edit_published_ewidencjazgonow' => true,
	'read_esez_post_type' => true,
	'edit_esez_post_type'  => true,
	'publish_esez_post_type'  => true,
	'edit_published_esez_post_type' => true,
	)
);