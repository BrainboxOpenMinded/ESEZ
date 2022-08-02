<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://brainbox.com.pl/
 * @since      1.0.0
 *
 * @package    Ewidencja_Zmarlych
 * @subpackage Ewidencja_Zmarlych/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ewidencja_Zmarlych
 * @subpackage Ewidencja_Zmarlych/public
 * @author     Brainbox <strony@brainbox.com.pl>
 */
class Ewidencja_Zmarlych_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ewidencja_Zmarlych_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ewidencja_Zmarlych_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ewidencja-zmarlych-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ewidencja_Zmarlych_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ewidencja_Zmarlych_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ewidencja-zmarlych-public.js', array( 'jquery' ), $this->version, false );

	}
	  
	public function create_login_page_template( $page_template )
	  {
		  if ( is_page( 'login' ) ) {
			  $page_template = plugin_dir_path( __FILE__ ) . '/templates/login-page.php';
		  }
		  return $page_template;
	  }
	public function create_konto_page_template( $page_template )
	  {
		  if ( is_page( 'konto' ) ) {
			  $page_template = plugin_dir_path( __FILE__ ) . '/templates/konto-page.php';
		  }
		  return $page_template;
	  }

	  public function create_panel_page_template( $page_template )
	  {
		  if ( is_page( 'panel' ) ) {
			  $page_template = plugin_dir_path( __FILE__ ) . '/templates/panel-page.php';
		  }
		  return $page_template;
	  }

	  public function create_konto_all_page_template( $page_template )
	  {
		  if ( is_page( 'wolne' ) ) {
			  $page_template = plugin_dir_path( __FILE__ ) . '/templates/wolne-opaski-page.php';
		  }
		  return $page_template;
	  }

	  public function create_konto_ended_page_template( $page_template )
	  {
		  if ( is_page( 'zakonczone' ) ) {
			  $page_template = plugin_dir_path( __FILE__ ) . '/templates/zrealizowane-opaski-page.php';
		  }
		  return $page_template;
	  }

	  public function create_konto_foreign_page_template( $page_template )
	  {
		  if ( is_page( 'obce' ) ) {
			  $page_template = plugin_dir_path( __FILE__ ) . '/templates/obce-opaski-page.php';
		  }
		  return $page_template;
	  }

	  public function load_single_zgon_archive_template( $template = '' ) {
		
		global $post;
	
		if ( 'ewidencjazgonow' === $post->post_type && locate_template( array( 'single-ewidencjazgonow.php' ) ) !== $template ) {
			return plugin_dir_path( __FILE__ ) . '/templates/single-ewidencjazgonow.php';
		}
	
		return $template;
	}
	
	public function use_custom_template_to_single_zgon($to_tempalte){
		if ( is_post_type_archive ( 'ewidencjazgonow' ) ) {
		  $to_tempalte = plugin_dir_path( __FILE__ ) . '/templates/single-ewidencjazgonow.php';
		}
		return $to_tempalte;
	  }

	  public function ewidencjazgonow_template( $template ) {
		if ( is_post_type_archive('ewidencjazgonow') ) {
		  $theme_files = array('single-ewidencjazgonow.php', 'templates/single-ewidencjazgonow.php');
		  $exists_in_theme = locate_template($theme_files, false);
		  if ( $exists_in_theme != '' ) {
			return $exists_in_theme;
		  } else {
			return plugin_dir_path(__FILE__) . '/templates/single-ewidencjazgonow.php';
		  }
		}
		return $template;
	  }

	  public function my_custom_ewidencjazgonow_template($single) {

		global $post;
	
		/* Checks for single template by post type */
		if ( $post->post_type == 'ewidencjazgonow' ) {
			if ( file_exists( plugin_dir_path(__FILE__)  . '/templaates/single-ewidencjazgonow.php' ) ) {
				return plugin_dir_path(__FILE__)  . '/single-ewidencjazgonow.php';
			}
		}
	
		return $single;
	
	}
}
