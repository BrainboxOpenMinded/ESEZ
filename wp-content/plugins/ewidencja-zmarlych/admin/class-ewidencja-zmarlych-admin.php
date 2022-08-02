<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://brainbox.com.pl/
 * @since      1.0.0
 *
 * @package    Ewidencja_Zmarlych
 * @subpackage Ewidencja_Zmarlych/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ewidencja_Zmarlych
 * @subpackage Ewidencja_Zmarlych/admin
 * @author     Brainbox <strony@brainbox.com.pl>
 */
class Ewidencja_Zmarlych_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ewidencja-zmarlych-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ewidencja-zmarlych-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function load_plugin() {

		global $wp_rewrite;

    if ( is_admin() && get_option( 'Activated_Plugin' ) == 'ewidencja-zmarlych' ) {

      delete_option( 'Activated_Plugin' );

		  $wp_rewrite->init();
		  $wp_rewrite->flush_rules();

    }
	}



	public static function firma_post_type() {

		$cap_type 	= 'post';
		$plural 	= 'Firmy';
		$single 	= 'Firma';
		$cpt_name 	= 'Firmy';


		$opts['can_export']						  		= TRUE;
		$opts['capability_type']						= $cap_type;
		$opts['description']						  	= 'Zbiór profili firm pogrzebowych';
		$opts['exclude_from_search']					= FALSE;
		$opts['has_archive']						  	= 'r';
		$opts['hierarchical']						  	= FALSE;
		$opts['map_meta_cap']						  	= TRUE;
		$opts['menu_icon']							  	= 'dashicons-excerpt-view';
		$opts['public']								    = TRUE;
		$opts['publicly_querable']						= TRUE;
		$opts['query_var']								= TRUE;
		$opts['register_meta_box_cb']					= '';
		$opts['show_in_admin_bar']						= TRUE;
		$opts['show_in_menu']						  	= TRUE;
		$opts['show_in_nav_menu']						= TRUE;
		$opts['show_ui']							    = TRUE;
		$opts['supports']								= array( 'title', 'author' );

		$opts['labels']['add_new']						= esc_html__( "Dodaj {$single}", 'ewidencja-zmarlych' );
		$opts['labels']['add_new_item']					= esc_html__( "Dodaj nowy {$single}", 'ewidencja-zmarlych' );
		$opts['labels']['all_items']					= esc_html__( "Wszystkie zakłady", 'ewidencja-zmarlych' );
		$opts['labels']['edit_item']					= esc_html__( "Edytuj {$single}" , 'ewidencja-zmarlych' );
		$opts['labels']['menu_name']					= esc_html__( "Firmy", 'ewidencja-zmarlych' );
		$opts['labels']['name']							= esc_html__( "Firma", 'ewidencja-zmarlych' );
		$opts['labels']['name_admin_bar']				= esc_html__( $single, 'ewidencja-zmarlych' );
		$opts['labels']['new_item']						= esc_html__( "Nowa {$single}", 'ewidencja-zmarlych' );
		$opts['labels']['not_found']					= esc_html__( "Nie {$plural} znaleziono", 'ewidencja-zmarlych' );
		$opts['labels']['not_found_in_trash']			= esc_html__( "Nie {$plural} w koszu", 'ewidencja-zmarlych' );
		$opts['labels']['parent_item_colon']			= esc_html__( "Rodzic {$plural} :", 'ewidencja-zmarlych' );
		$opts['labels']['search_items']					= esc_html__( "Szukaj {$plural}", 'ewidencja-zmarlych' );
		$opts['labels']['singular_name']				= esc_html__( "Firma", 'ewidencja-zmarlych' );
		$opts['labels']['view_item']					= esc_html__( "Zobacz {$single}", 'ewidencja-zmarlych' ); 

		$opts['rewrite']['ep_mask']						= EP_PERMALINK;
		$opts['rewrite']['feeds']						= FALSE;
		$opts['rewrite']['pages']						= TRUE;
		$opts['rewrite']['slug']						= esc_html__( strtolower( 'r' ), 'r' );
		$opts['rewrite']['with_front']					= FALSE;

		$opts = apply_filters( 'firma_post_type', $opts );

		register_post_type( strtolower( $cpt_name ), $opts );

	} 
  public static function esez_post_type() {

    $cap_type 	= 'post';
    $plural 	= 'Zgon';
    $single 	= 'Zgon';
    $cpt_name 	= 'Ewidencja zgonow';
  
  
    $opts['can_export']						  		= TRUE;
    $opts['capability_type']						= $cap_type;
    $opts['description']						  	= 'Zbiór profili osób zmarłych';
    $opts['exclude_from_search']					= FALSE;
    $opts['has_archive']						  	= FALSE;
    $opts['hierarchical']						  	= FALSE;
    $opts['map_meta_cap']						  	= TRUE;
    $opts['rewrite']							   	= array('slug'=>'z');
    $opts['menu_icon']							  	= 'dashicons-id-alt';
    $opts['public']								    = TRUE;
    $opts['publicly_querable']						= TRUE;
    $opts['query_var']								= TRUE;
    $opts['register_meta_box_cb']					= '';
    $opts['show_in_admin_bar']						= TRUE;
    $opts['show_in_menu']						  	= TRUE;
	$opts['rest_base']								= 'ewidencjazgonow';
    $opts['rest_controller_class']					= 'WP_REST_Posts_Controller';
	$opts['show_in_rest']						  	= TRUE;
    $opts['show_in_nav_menu']						= TRUE;
    $opts['show_ui']							    = TRUE;
    $opts['supports']								= array( 'title', 'author' );
  
    $opts['labels']['add_new']						= esc_html__( "Dodaj zgon", 'ewidencja-zmarlych' );
    $opts['labels']['add_new_item']					= esc_html__( "Dodaj nowy zgon", 'ewidencja-zmarlych' );
    $opts['labels']['all_items']					= esc_html__( "Wszystkie zgony", 'ewidencja-zmarlych' );
    $opts['labels']['edit_item']					= esc_html__( "Edytuj {$single}" , 'ewidencja-zmarlych' );
    $opts['labels']['menu_name']					= esc_html__( 'Ewidencja', 'ewidencja-zmarlych' );
    $opts['labels']['name']							= esc_html__( "Ewidencja zgonów", 'ewidencja-zmarlych' );
    $opts['labels']['name_admin_bar']				= esc_html__( "Ewidencja zgonów", 'ewidencja-zmarlych' );
    $opts['labels']['new_item']						= esc_html__( "Nowa {$single}", 'ewidencja-zmarlych' );
    $opts['labels']['not_found']					= esc_html__( "Nie {$plural} znaleziono", 'ewidencja-zmarlych' );
    $opts['labels']['not_found_in_trash']			= esc_html__( "Nie {$plural} w koszu", 'ewidencja-zmarlych' );
    $opts['labels']['parent_item_colon']			= esc_html__( "Rodzic {$plural} :", 'ewidencja-zmarlych' );
    $opts['labels']['search_items']					= esc_html__( "Szukaj {$plural}", 'ewidencja-zmarlych' );
    $opts['labels']['singular_name']				= esc_html__( "Zgon", 'ewidencja-zmarlych' );
    $opts['labels']['view_item']					= esc_html__( "Zobacz {$single}", 'ewidencja-zmarlych' ); 
  
    $opts['rewrite']['ep_mask']						= EP_PERMALINK;
    $opts['rewrite']['feeds']						= FALSE;
    $opts['rewrite']['pages']						= TRUE;
    $opts['rewrite']['slug']						= esc_html__( strtolower( 'z' ), 'z' );
    $opts['rewrite']['with_front']					= FALSE;
  
    $opts = apply_filters( 'esez_post_type', $opts );
  
    register_post_type( strtolower( $cpt_name ), $opts );
  
  }

  	public function add_author_support_to_posts() {
		add_post_type_support( 'esez_post_type', 'author' ); 
}
	public function redirect_to_nonexistent_page() {
 
   $new_login =  'customtext';
   if (strpos($_SERVER['REQUEST_URI'], $new_login) === false) {
	 wp_safe_redirect(home_url('/login'), 302);
	 exit();
   }
 }
 
 	public function redirect_to_actual_login() {
 
   $new_login =  'customtext';
   if (parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) == $new_login && ($_GET['redirect'] !== false)) {
	 wp_safe_redirect(home_url("wp-login.php?$new_login&redirect=false"));
	 exit();
   }
 }
 	public function remove_admin_bar() {
	 if (!current_user_can('administrator') && !is_admin()) {
	   show_admin_bar(false);
	 }
 }

 // dodanie customowych pozycji w tabelce Nekrologi

	public function my_page_columns($columns) {
	
    $columns = array(
     'cb' => '< input type="checkbox" />',
	 'title' => 'Link do opaski',
     'numer_opaski' => 'Numer opaski',
     'imie_zmarlego' => 'Imię',
	 'nazwisko_zmarlego' => 'Nazwisko',
     'pesel' => 'PESEL',
     'data_odbioru_ciala' => 'Data odbioru',
	 'coauthors' => 'Właściciel',
	 'post_modified' => 'Data modyfikacji',
     'date' => 'Data publikacji'
    );
    return $columns;
   }
  	public function custom_columns( $column, $post_id = null ) {
		switch ( $column ) {
			case "title":
				echo get_post_meta( $post_id, 'title', true);
				break;
			
			case "numer_opaski":
				echo get_field( 'numer_opaski', $post_id, true);
				break;
			
			case "imie_zmarlego":
				echo get_field( 'imie_zmarlego', $post_id, true);
					break;
			
			case "nazwisko_zmarlego":
				echo get_field( 'nazwisko_zmarlego', $post_id, true);
				break;
			
			case "pesel":
				echo get_field( 'pesel', $post_id, true);
				break;
				
			case "data_odbioru_ciala":
				echo get_field( 'data_odbioru_ciala', $post_id, true);
				break;
			case "author":
					echo get_post_meta( $post_id, 'coauthors', true);
					break;
			case "post_modified":
				echo get_the_modified_date();
				break;
			case "date":
				echo get_post_meta( $post_id, 'date', true);
				break;
					
	}
	}

	public function my_column_register_sortable( $columns ) {
		$columns['numer_opaski'] = 'numer_opaski';
		$columns['data_odbioru_ciala'] = 'data_odbioru_ciala';
		$columns['post_modified'] = 'post_modified';
		$columns['coauthors'] = 'coauthors';
		$columns['imie_zmarlego'] = 'imie_zmarlego';
		$columns['nazwisko_zmarlego'] = 'nazwisko_zmarlego';
		$columns['pesel'] = 'pesel';
		return $columns;
		}
	public function ewidencja_columns_orderby( $query ) {
	
			if( ! is_admin() )
				return;
		
			$orderby = $query->get( 'orderby');
	
			switch( $orderby ){
				case 'numer_opaski': 
					$query->set('meta_key','numer_opaski');
					$query->set('orderby','meta_value_num');
					break;
				case 'data_odbioru_ciala': 
					$query->set('meta_key','data_odbioru_ciala');
					$query->set('orderby','meta_value');
					break;
				case 'post_modified': 
					$query->set('meta_key','post_modified');
					$query->set('orderby','meta_value');
					break;
				case 'coauthors': 
					$query->set('meta_key','coauthors');
					$query->set('orderby','meta_value');
					break;
				case 'imie_zmarlego': 
					$query->set('meta_key','imie_zmarlego');
					$query->set('orderby','meta_value');
					break;
				case 'nazwisko_zmarlego': 
					$query->set('meta_key','nazwisko_zmarlego');
					$query->set('orderby','meta_value');
					break;
				case 'pesel': 
					$query->set('meta_key','pesel');
					$query->set('orderby','meta_value');
					break;
				default: break;
			}
		
		}
	public function get_local_avatar($avatar, $author, $size, $default, $alt) {
		// ------------------------------------
		// handle user passed by email or by id
		if(stristr($author,"@")) $autore = get_user_by('email', $author);
		  else $autore = get_user_by('ID', $author);
	   
		$url = get_the_author_meta( 'userpicprofile', $autore->ID);
		if($url) {
		  return "<img class='avatar' alt=\"".$alt."\" src='".$url."' width='".$size."' />";
		} else {
		  return $avatar;
		}
	  }
	  // --------------------------------------
	  // add the field in your user edit profile page
	  public function add_author_image( $contactmethods ) {
		$contactmethods['userpicprofile'] = 'URL for profile image';
		return $contactmethods;
	  }

	  public function my_plugin_rest_route_for_post( $route, $post ) {
		if ( $post->post_type === 'ewidencjazgonow' ) {
			$route = '/wp/v2/ewidencjazgonow/' . $post->ID;
		}
	 
		return $route;
	}

	public function esez_new_zgon_send_email ( $post_id ) {

		if( get_post_type($post_id) !== 'ewidencjazgnonow' && get_post_status($post_id) == 'publicate' ) {
			return;
		}
		$author_id=$post->post_author;
		$userdata = get_userdata( $author_id );

		$post_title = get_the_title( $post_id );
		$post_url 	= get_permalink( $post_id );
		$subject 	= "Wykorzystano opaskę nr: " . get_field('numer_opaski', $post_id);
		$message 	= "Opaska została opublikowana lub edytowana:\n\n";
		$message   .= "Nr. " .get_field('numer_opaski', $post_id) . ": " . $post_url;

		wp_mail( $author_id->user_email , $subject, $message );

	}
	// Function to change email address
	public function wpb_sender_email( $original_email_address ) {
		return 'powiadomienia@esez.pl';
	}
	
	// Function to change sender name
	public function wpb_sender_name( $original_email_from ) {
		return 'ESEZ';
	}

	public function add_login_check()
	{
		if (is_user_logged_in() && !is_admin()) {
			if (is_page('login')){
				wp_redirect( home_url( '/konto' ) );
				exit; 
			}
		}
	}
}
