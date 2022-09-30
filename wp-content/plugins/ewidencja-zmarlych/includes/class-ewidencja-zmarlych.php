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
		$this->loader->add_action( 'init', $plugin_admin, 'esez_post_type' );
		$this->loader->add_action( 'init', $plugin_admin, 'dokumenty_post_type' );
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
		$this->loader->add_filter( 'template_include', $plugin_public, 'ewidencjazgonow_template' ) ;
		$this->loader->add_filter( 'single_template', $plugin_public, 'my_custom_ewidencjazgonow_template' ) ;
		$this->loader->add_filter( 'template_include', $plugin_public, 'dokumenty_esez_template' ) ;
		$this->loader->add_filter( 'single_template', $plugin_public, 'my_custom_dokumenty_esez_template' ) ;
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

add_action('init', 'my_custom_pagination_base', 1);

function ace_block_wp_admin() {
	if ( is_admin() && ! current_user_can( 'administrator' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
		wp_safe_redirect( home_url('/konto') );
		exit;
	}
}
add_action( 'admin_init', 'ace_block_wp_admin' );
				

add_action( 'show_user_profile', 'ns_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'ns_show_extra_profile_fields' );
function ns_show_extra_profile_fields( $user ) { ?>
<h3>Dodaj logo zakładu</h3>
<table class="form-table">
<tr>
<th><label for="image">Logo</label></th>
<td>
<img src="<?php echo esc_attr( get_the_author_meta( 'image', $user->ID ) ); ?>" style="height:50px;">
<input type="text" name="image" id="image" value="<?php echo esc_attr( get_the_author_meta( 'image', $user->ID ) ); ?>" class="regular-text" /><input type='button' class="button-primary" value="Upload Image" id="uploadimage"/><br />
<span class="description">Prześlij swój obraz do swojego profilu.</span>
</td>
</tr>
</table>
<?php 
}

/**
* Enqueue a script in the WordPress admin user-edit.php.
*
* @param int $pagenow Hook suffix for the current admin page.
*/
function ns_selectively_enqueue_admin_script( $hook ) {
global $pagenow;
if ($pagenow != 'user-edit.php') {
return;
}
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox');
wp_register_script( 'profile-image', get_template_directory_uri().'/assets/profile-image.js', array('jquery-core'), false, true );
wp_enqueue_script( 'profile-image' );
}
add_action( 'admin_enqueue_scripts', 'ns_selectively_enqueue_admin_script' );

add_image_size( 'ewidencja-zdjecie', 400, 400, true );

/*
* Save custom user profile data
*
*/
add_action( 'personal_options_update', 'ns_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'ns_save_extra_profile_fields' );
function ns_save_extra_profile_fields( $user_id ) {

if ( !current_user_can( 'edit_user', $user_id ) )
return false;

if(isset($_POST['image'])) {
$imageprofile = sanitize_text_field( wp_unslash( $_POST['image'] ) );
update_user_meta( $user_id, 'image', $imageprofile );
}
}


add_filter( 'wp_sitemaps_enabled', '__return_false' );

add_action( 'init', function() {
remove_action( 'init', 'wp_sitemaps_get_server' );
}, 5 );

add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
?>
<script type="text/javascript">
function fetch(){

jQuery.ajax({
url: '<?php echo admin_url('admin-ajax.php'); ?>',
type: 'post',
data: { action: 'data_fetch', keyword: jQuery('#keyword').val() },
success: function(data) {
jQuery('#datafetch').html( data );
}
});

}
</script>

<?php
}

add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){
global $current_user;
wp_get_current_user();
$authorID = $current_user->ID;
$the_query = new WP_Query( array( 'posts_per_page' => 3, 'author' => $authorID, 's' => esc_attr( $_POST['keyword'] ), 'no_found_rows' => true, 'update_post_meta_cache' => false, 'update_post_term_cache' => false, 'fields' => 'ids', 'post_type' => array('ewidencjazgonow')) );
if( $the_query->have_posts() ) :
echo '<ul class="search-lists">';
while( $the_query->have_posts() ): $the_query->the_post(); ?>

<li class="search-list" ><a href="<?php echo esc_url( post_permalink() ); ?>"><?php echo get_field('numer_opaski'); if(get_field('imie_zmarlego')) : echo ' | ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego'); endif; ?></a></li>

<?php endwhile;
echo '</ul>';
wp_reset_postdata();  
endif;

die();
}

function mukto_post_type_include( $query ) {
if ( $query->is_main_query() && $query->is_search() && ! is_admin() ) {
$query->set( 'post_type', array( 'ewidencjazgonow' ) );
}
}
add_action( 'pre_get_posts', 'mukto_post_type_include' );

add_filter( 'intermediate_image_sizes_advanced', 'prefix_remove_default_images' );

function prefix_remove_default_images( $sizes ) {
unset( $sizes['medium']); // 300px
unset( $sizes['large']); // 1024px
return $sizes;
}

function esez_features() {
register_nav_menu( 'headerMenuLocation', 'Menu Główne' );
}

add_action( 'after_setup_theme', 'esez_features' );

if (!wp_next_scheduled('cron_url_aktywne_opaski')) {
wp_schedule_event(time(), 'hourly', 'cron_url_aktywne_opaski');
}

add_action('cron_url_aktywne_opaski', 'call_url_heron_cron');

function call_url_heron_cron() {
wp_remote_get('https://esez.pl/wp-load.php?export_key=fmHZyIzLwvzW&export_id=1&action=trigger');
wp_remote_get('https://esez.pl/wp-load.php?export_key=fmHZyIzLwvzW&export_id=1&action=processing');
}

add_action('cron_url_aktywne_opaski', 'call_url_demo_cron');

function call_url_demo_cron() {
wp_remote_get('https://esez.pl/wp-load.php?export_key=fmHZyIzLwvzW&export_id=4&action=trigger');
wp_remote_get('https://esez.pl/wp-load.php?export_key=fmHZyIzLwvzW&export_id=4&action=processing');
}

add_action('cron_url_aktywne_opaski', 'call_url_kallandm_cron');

function call_url_kallandm_cron() {
wp_remote_get('https://esez.pl/wp-load.php?export_key=fmHZyIzLwvzW&export_id=7&action=trigger');
wp_remote_get('https://esez.pl/wp-load.php?export_key=fmHZyIzLwvzW&export_id=7&action=processing');
}

add_action('cron_url_aktywne_opaski', 'call_url_funeralkety_cron');

function call_url_funeralkety_cron() {
wp_remote_get('https://esez.pl/wp-load.php?export_key=fmHZyIzLwvzW&export_id=8&action=trigger');
wp_remote_get('https://esez.pl/wp-load.php?export_key=fmHZyIzLwvzW&export_id=8&action=processing');
}

function shapeSpace_disable_medium_images($sizes) {

unset($sizes['medium']); // disable medium size
return $sizes;

}
add_action('intermediate_image_sizes_advanced', 'shapeSpace_disable_medium_images');

function shapeSpace_disable_large_images($sizes) {

unset($sizes['large']); // disable large size
return $sizes;

}
add_action('intermediate_image_sizes_advanced', 'shapeSpace_disable_large_images');

function shapeSpace_disable_medium_large_images($sizes) {

unset($sizes['medium_large']); // disable 768px size images
return $sizes;

}
add_filter('intermediate_image_sizes_advanced', 'shapeSpace_disable_medium_large_images');

function shapeSpace_disable_2x_medium_large_images($sizes) {

unset($sizes['1536x1536']); // disable 2x medium-large size
return $sizes;

}
add_filter('intermediate_image_sizes_advanced', 'shapeSpace_disable_2x_medium_large_images');

function shapeSpace_disable_2x_large_images($sizes) {

unset($sizes['2048x2048']); // disable 2x large size
return $sizes;

}
add_filter('intermediate_image_sizes_advanced', 'shapeSpace_disable_2x_large_images');

function shapeSpace_disable_thumbnail_images($sizes) {

unset($sizes['thumbnail']); // disable thumbnail size
return $sizes;

}
add_action('intermediate_image_sizes_advanced', 'shapeSpace_disable_thumbnail_images');

function restrict_manage_authors() {
if (isset($_GET['post_type']) && post_type_exists($_GET['post_type']) && in_array(strtolower($_GET['post_type']), array('ewidencjazgonow'))) {
wp_dropdown_users(array(
'show_option_all'   => 'Wszyscy użytkownicy',
'show_option_none'  => false,
'name'          => 'author',
'selected'      => !empty($_GET['author']) ? $_GET['author'] : 0,
'include_selected'  => false
));
}
}
add_action('restrict_manage_posts', 'restrict_manage_authors');

function custom_columns_author($columns) {
$columns['author'] = 'Author';
return $columns;
}

add_filter('user_contactmethods', 'yoast_seo_admin_user_remove_social', 99);

function yoast_seo_admin_user_remove_social ( $contactmethods ) {
unset( $contactmethods['facebook'] );
unset( $contactmethods['instagram'] );
unset( $contactmethods['linkedin'] );
unset( $contactmethods['myspace'] );
unset( $contactmethods['pinterest'] );
unset( $contactmethods['soundcloud'] );
unset( $contactmethods['tumblr'] );
unset( $contactmethods['twitter'] );
unset( $contactmethods['youtube'] );
unset( $contactmethods['wikipedia'] );
unset( $contactmethods['facebook_profile'] );
unset( $contactmethods['twitter_profile'] );
unset( $contactmethods['linkedin_profile'] );
unset( $contactmethods['xing_profile'] );
unset( $contactmethods['github_profile'] );
unset( $contactmethods['userpicprofile'] );

return $contactmethods;
}

add_filter( 'wp_is_application_passwords_available', '__return_false' );

add_action( 'personal_options', array ( 'T5_Hide_Profile_Bio_Box', 'start' ) );

/**
 * Captures the part with the biobox in an output buffer and removes it.
 */
class T5_Hide_Profile_Bio_Box
{
    /**
     * Called on 'personal_options'.
     *
     * @return void
     */
    public static function start()
    {
        $action = ( IS_PROFILE_PAGE ? 'show' : 'edit' ) . '_user_profile';
        add_action( $action, array ( __CLASS__, 'stop' ) );
        ob_start();
    }

    /**
     * Strips the bio box from the buffered content.
     *
     * @return void
     */
    public static function stop()
    {
        $html = ob_get_contents();
        ob_end_clean();

        // remove the headline
        $headline = __( IS_PROFILE_PAGE ? 'About Yourself' : 'About the user' );
        $html = str_replace( '<h2>' . $headline . '</h2>', '', $html );

        // remove the table row
        $html = preg_replace( '~<tr>\s*<th><label for="description".*</tr>~imsUu', '', $html );
        print $html;
    }
}

add_filter( 'option_show_avatars', '__return_false' );

	function imie_zmarlego() {
		if(get_field('imie_zmarlego')) : return get_field('imie_zmarlego');  else : return '-'; endif;
	}

	function nazwisko_zmarlego() {
		if(get_field('nazwisko_zmarlego')) : return get_field('nazwisko_zmarlego');  else : return '-'; endif;
	}

function datatables_scripts_in_head(){
	wp_enqueue_script('datatables', 'https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js', array('jquery') );
	wp_localize_script( 'datatables', 'datatablesajax', array('url' => admin_url('admin-ajax.php')) );
	wp_enqueue_style('datatables', 'https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css' );
  }
  add_action('wp_enqueue_scripts', 'datatables_scripts_in_head');

  add_action( 'wp_ajax_getpostsfordatatables', 'my_ajax_getpostsfordatatables' );
  add_action( 'wp_ajax_nopriv_getpostsfordatatables', 'my_ajax_getpostsfordatatables' );
  
  function my_ajax_getpostsfordatatables() {
	global $wpdb;
	global $post;
	global $current_user;
	$post_id = $post->ID;
	wp_get_current_user();
	$authorID = $current_user->ID;
	$user_info = get_userdata($authorID);
	$first_name = $user_info->first_name;
	$user = wp_get_current_user();
	$allowed_roles = array( 'firma', 'firmapro', 'administrator' );

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$query = new WP_Query( array(
		'post_type' => array( 'post', 'ewidencjazgonow' ),
		'posts_per_page'=> 2,
		'paged' => $paged,
		'author' => $authorID,
		'meta_key'			=> 'data_odbioru_ciala',
		'orderby'			=> 'meta_value',
		'order'				=> 'DESC',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'imie_zmarlego',
				'value'   => array(''),
				'compare' => 'NOT IN'
			),
			array(
				'key'     => 'kto_organizuje_pogrzeb',
				'value'   => true,
				'compare' => '=',
			),
		),
	),
	);

	function dateV($format,$timestamp=null){
		$to_convert = array(
			'l'=>array('dat'=>'N','str'=>array('Pn','Wt','Śr','Cz','Pt','Sb','Nd')),
			'F'=>array('dat'=>'n','str'=>array('styczeń','luty','marzec','kwiecień','maj','czerwiec','lipiec','sierpień','wrzesień','październik','listopad','grudzień')),
			'f'=>array('dat'=>'n','str'=>array('stycznia','lutego','marca','kwietnia','maja','czerwca','lipca','sierpnia','września','października','listopada','grudnia'))
		);
		if ($pieces = preg_split('#[:/.\-, ]#', $format)){	
			if ($timestamp === null) { $timestamp = time(); }
			foreach ($pieces as $datepart){
				if (array_key_exists($datepart,$to_convert)){
					$replace[] = $to_convert[$datepart]['str'][(date($to_convert[$datepart]['dat'],$timestamp)-1)];
				}else{
					$replace[] = date($datepart,$timestamp);
				}
			}
			$result = strtr($format,array_combine($pieces,$replace));
			return $result;
		}
	}

	function typ_kremacji() { 
		if(get_field('rodzaj_pogrzebu_zmarly') == 'Kremacyjny' and get_field('kremacja_wykonana') == false) : return '<span class="tooltip-right" data-tooltip="Kremacja w toku"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/pogrzeb-kremacyjny-w-toku.svg" /><span style="visibility: hidden; display: none; width: 0;">kremacja w toku</span></span>'; endif; if(get_field('rodzaj_pogrzebu_zmarly') == 'Kremacyjny' and get_field('kremacja_wykonana') == true) : return '<span class="tooltip-right" data-tooltip="Kremacja zakończona" style="color:green;"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/pogrzeb-kremacyjny-zakonczony.svg"/><span style="visibility: hidden; width: 0; display: none;">kremacja zakończona</span></span>'; endif; if(get_field('rodzaj_pogrzebu_zmarly')=='Tradycyjny') : return '<span class="tooltip-right" data-tooltip="Pogrzeb tradycyjny"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/pogrzeb-tradycyjny.svg" /><span style=" width: 0; display: none; visibility: hidden;">pogrzeb tradycyjny</span></span>'; endif; if(get_field('rodzaj_pogrzebu_zmarly')=='Nieokreślony') : return '-'; endif;
	}

	function data_eksportacji() {
		if( !empty(get_field('data_odbioru_ciala'))) : return date("d.m", strtotime(get_field('data_odbioru_ciala'))) . ' (' . dateV('l',strtotime(get_field('data_odbioru_ciala'))) . ") " . date("H:i", strtotime(get_field('data_odbioru_ciala'))); endif;
	}

	function calendar_google_simple() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];
	
		if(current_user_can('firmapro') || current_user_can('administrator')) : return '<a class="tooltip-right" data-tooltip="Dodaj do kalendarza" style="margin-left:5px;" href="https://www.google.com/calendar/event?action=TEMPLATE&text=E | ' .  get_field('numer_opaski') . ' - ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '&dates=' . $data_odbioru_ciala. '/' . $data_odbioru_ciala_po_godzinie . '&details=Odebrać ciało zmarłego.<br><br><u><strong>DANE ZGŁASZAJĄCEGO</strong></u><br><strong>Miejsce:</strong> ' . get_field('miejsce_odbioru') . '<br><strong>Waga:</strong> ' . get_field('waga') . ' kg<br><strong>Zgłaszający:</strong> ' . get_field('imie_nazwisko_zglaszajacego') . '<br><strong>Tel:</strong> ' . get_field('telefon_zglaszajacego') . '<br>' . get_field('notatka') . '<br><br>________<br>' .  get_permalink() . '&location=' . $adres_odbioru_dom_miasto . $adres_odbioru_inne_miasto . ', ' . $adres_odbioru_dom_ulica . $adres_odbioru_inne_ulica . '" target="_blank" rel="nofollow"><i class="fa-solid fa-calendar-days"></i></a>';endif; if(empty(get_field('data_odbioru_ciala'))) : return '-'; endif;
	}

	function calendar_google_home() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];

		if(current_user_can('firmapro') || current_user_can('administrator')) :
			if(get_field('miejsce_odbioru') == 'Dom' && $adres_odbioru_dom_miasto) :
			return '<a class="qrcode-icon" target="_blank"
				href="https://www.google.com/maps/dir//' .  $adres_odbioru_dom_ulica . ', ' . $adres_odbioru_dom_miasto . '"><i
					class="fa-solid fa-route"></i></a>';
			endif; endif;
	}

	function calendar_google_another() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];
	
		if(current_user_can('firmapro') || current_user_can('administrator')) :
		if($adres_odbioru_inne_miasto && get_field('miejsce_odbioru') != 'Dom') :
			return '<a class="qrcode-icon" target="_blank"
				href="https://www.google.com/maps/dir//' . $adres_odbioru_inne_ulica . ', ' . $adres_odbioru_inne_miasto . ', ' . $adres_odbioru_inne_nazwa . '"><i
					class="fa-solid fa-route"></i></a>';
			endif; endif;
	}

	function kreamcja_date() {
		if(get_field('rodzaj_pogrzebu_zmarly') == 'Kremacyjny' && !empty(get_field('data_kremacji'))) : return date("d.m", strtotime(get_field('data_kremacji'))) . ' (' . dateV('l',strtotime(get_field('data_kremacji'))) . ") " . date("H:i", strtotime(get_field('data_kremacji'))); else : return '-'; endif;
	}

	function calendar_google_kremacja() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];
	
		if(current_user_can('firmapro') || current_user_can('administrator')) : if(get_field('rodzaj_pogrzebu_zmarly') == 'Kremacyjny' && !empty(get_field('data_kremacji'))) : 
			return '<a class="tooltip-right" data-tooltip="Dodaj do kalendarza" style="margin-left:5px;" href="https://www.google.com/calendar/event?action=TEMPLATE&text=K | ' .  get_field('numer_opaski') . ' - ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '&dates=' . $data_kremacja . '/' . $data_kremacja_po_godzinie . '&details=Kremacja zwłok.<br><br>________<br>' .  get_permalink() . '" target="_blank" rel="nofollow"><i class="fa-solid fa-calendar-days"></i></a>'; endif; endif;
	}
	function odebranie_urny_date() {
		if(get_field('rodzaj_pogrzebu_zmarly') == 'Kremacyjny' && !empty(get_field('data_odebrania_urny'))) : return date("d.m", strtotime(get_field('data_odebrania_urny'))) . ' (' . dateV('l',strtotime(get_field('data_odebrania_urny'))) . ") " . date("H:i", strtotime(get_field('data_odebrania_urny'))); else : return '-'; endif;
	}

	function calendar_google_odbior_urny() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];
	
		if(current_user_can('firmapro') || current_user_can('administrator')) : if(get_field('rodzaj_pogrzebu_zmarly') == 'Kremacyjny' && !empty(get_field('data_odebrania_urny'))) : 
			return '<a class="tooltip-right" data-tooltip="Dodaj do kalendarza" style="margin-left:5px;" href="https://www.google.com/calendar/event?action=TEMPLATE&text=KO | ' .  get_field('numer_opaski') . ' - ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '&dates=' . $data_kremacja_odbior_urny . '/' . $data_kremacja_odbior_urny_po_godzinie . '&details=Odebrać urnę z krematorium.<br><br>________<br>' .  get_permalink() . '" target="_blank" rel="nofollow"><i class="fa-solid fa-calendar-days"></i></a>'; endif; endif;
	}

	function pozegnanie_date() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];
	
		if (!empty($ceremonia_pogrzegnalna_data)) : return date("d.m", strtotime($ceremonia_pogrzegnalna_data)) . ' (' . dateV('l',strtotime($ceremonia_pogrzegnalna_data)) . ") " . date("H:i", strtotime($ceremonia_pogrzegnalna_godzina)); else : return '-'; endif;
	}

	function calendar_google_pozegnanie() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];
	
		if (!empty($ceremonia_pogrzegnalna_data)) : if(current_user_can('firmapro') || current_user_can('administrator')) : return '<a class="tooltip-right" data-tooltip="Dodaj do kalendarza" style="margin-left:5px;" href="https://www.google.com/calendar/event?action=TEMPLATE&text=KO | ' .  get_field('numer_opaski') . ' - ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '&dates=' . $data_kremacja_odbior_urny . '/' . $data_kremacja_odbior_urny_po_godzinie . '&details=Odebrać urnę z krematorium.<br><br>________<br>' .  get_permalink() . '" target="_blank" rel="nofollow"><i class="fa-solid fa-calendar-days"></i></a>'; endif; endif;
	}

	function wprowadzenie_date() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];
	
		if(get_field('godzina_pogrzebu')) : return date("d.m", strtotime(get_field('data_pogrzebu'))) . ' (' . dateV('l',strtotime(get_field('data_pogrzebu'))) . ") " . date("H:i", strtotime(get_field('godzina_pogrzebu'))); else : return '-'; endif;
	}

	function calendar_google_wprowadznie() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];

		if(get_field('godzina_pogrzebu')) : if(current_user_can('firmapro') || current_user_can('administrator')) : return '<a data-tooltip="Dodaj do kalendarza" class="tooltip-top" style="margin-left:5px;" href="https://www.google.com/calendar/event?action=TEMPLATE&text=W | ' .  get_field('numer_opaski') . ' - ' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '&dates=' . $data_wyprowadzenie . '/' . $data_wyprowadzenie_po_godzinie . '&details=Wyprowadzenie do grobu.<br><br>________<br>' .  get_permalink() . '&location=' . get_field('adres_cmentarza') . '" target="_blank" rel="nofollow"><i class="fa-solid fa-calendar-days"></i></a>'; endif; endif;
	}

	function drukowanie_zestawienia() {
		return '<a class="tooltip-top" title="Drukowanie zestawienia" target="_blank" href="/drukuj?ewidencja_id=' . get_the_ID() . '"><i class="fa fa-print" aria-hidden="true"></i></a>';
	}

	function drukowanie_etykiety() {
		return '<a title="Drukowanie etykiety" class="qrcode-icon tooltip-top" target="_blank" href="/etykieta?ewidencja_id=' . get_the_ID() . '"><i class="fa-solid fa-barcode"></i></a>';
	}



	function akcje_sms_body_dom() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];
	
		$text_adres_inne = get_field('numer_opaski') . '-' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . ' | Adres odbioru: ' . $adres_odbioru_inne_nazwa . ' ' . $adres_odbioru_inne_miasto . ' ' . $adres_odbioru_inne_ulica . ' | Data odbioru: ' . $data_odbioru_ciala_wiadomosc . ' | ' . get_permalink();
		$text_adres_dom = get_field('numer_opaski') . '-' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . ' | Adres odbioru: ' . $adres_odbioru_dom_nazwa . ' ' . $adres_odbioru_dom_miasto . ' ' . $adres_odbioru_dom_ulica . ' | Data odbioru: ' . $data_odbioru_ciala_wiadomosc . ' | ' . get_permalink();
	
		$nastepna_klasa_css++;
		if(get_field('miejsce_odbioru') == 'Dom' && $adres_odbioru_dom_miasto) : return $text_adres_dom; endif;
	}

	function akcje_sms_body_inne() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];
	
		$text_adres_inne = get_field('numer_opaski') . '-' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . ' | Adres odbioru: ' . $adres_odbioru_inne_nazwa . ' ' . $adres_odbioru_inne_miasto . ' ' . $adres_odbioru_inne_ulica . ' | Data odbioru: ' . $data_odbioru_ciala_wiadomosc . ' | ' . get_permalink();
		$text_adres_dom = get_field('numer_opaski') . '-' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . ' | Adres odbioru: ' . $adres_odbioru_dom_nazwa . ' ' . $adres_odbioru_dom_miasto . ' ' . $adres_odbioru_dom_ulica . ' | Data odbioru: ' . $data_odbioru_ciala_wiadomosc . ' | ' . get_permalink();
	
		if($adres_odbioru_inne_miasto && get_field('miejsce_odbioru') != 'Dom') : return $text_adres_inne; endif;
	}

	function udostepnij_opaske() {
		wp_get_current_user();
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];
		$data_pozegnania = $ceremonia_pogrzegnalna_data . $ceremonia_pogrzegnalna_godzina;
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	
		$data_odbioru_ciala = date("Ymd\THis", strtotime(get_field('data_odbioru_ciala')));
		$data_odbioru_ciala_wiadomosc = date("d.m.Y H:i", strtotime($data_odbioru_ciala));
		$data_odbioru_ciala_po_godzinie = date("Ymd\THis", strtotime($data_odbioru_ciala.'+1 hour'));
		$data_pozegnania = date("Ymd\THis", strtotime($data_pozegnania));
		$data_pozegnania_po_godzinie = date("Ymd\THis", strtotime($data_pozegnania.'+1 hour'));
		$data_wyprowadzenie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$data_wyprowadzenie = date("Ymd\THis", strtotime($data_wyprowadzenie));
		$data_wyprowadzenie_po_godzinie = date("Ymd\THis", strtotime($data_wyprowadzenie.'+1 hour'));
		$data_kremacja = date("Ymd\THis", strtotime(get_field('data_kremacji')));
		$data_kremacja_po_godzinie = date("Ymd\THis", strtotime($data_kremacja.'+1 hour'));
		$data_kremacja_odbior_urny = date("Ymd\THis", strtotime(get_field('data_odebrania_urny')));
		$data_kremacja_odbior_urny_po_godzinie = date("Ymd\THis", strtotime($data_kremacja_odbior_urny.'+1 hour'));
		
		$adres_odbioru_inne = get_field('adres_odbioru_inne');
		$adres_odbioru_inne_nazwa = $adres_odbioru_inne['adres_odbioru_inne-nazwa'];
		$adres_odbioru_inne_miasto = $adres_odbioru_inne['adres_odbioru_inne-miasto'];
		$adres_odbioru_inne_ulica = $adres_odbioru_inne['adres_odbioru_inne-ulica-nr-domu'];
	
		$adres_odbioru_dom = get_field('adres_odbioru_dom');
		$adres_odbioru_dom_miasto = $adres_odbioru_dom['adres_odbioru_dom-miasto'];
		$adres_odbioru_dom_ulica = $adres_odbioru_dom['adres_odbioru_dom-ulica-nr-domu'];
	
		$adres_ceremoni_pozegnalnej = get_field('ceremonia_pozegnalna');
		$adres_ceremoni_pozegnalnej_adres = $adres_ceremoni_pozegnalnej['adres'];
	
		$text_adres_inne = get_field('numer_opaski') . '-' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . ' | Adres odbioru: ' . $adres_odbioru_inne_nazwa . ' ' . $adres_odbioru_inne_miasto . ' ' . $adres_odbioru_inne_ulica . ' | Data odbioru: ' . $data_odbioru_ciala_wiadomosc . ' | ' . get_permalink();
		$text_adres_dom = get_field('numer_opaski') . '-' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . ' | Adres odbioru: ' . $adres_odbioru_dom_nazwa . ' ' . $adres_odbioru_dom_miasto . ' ' . $adres_odbioru_dom_ulica . ' | Data odbioru: ' . $data_odbioru_ciala_wiadomosc . ' | ' . get_permalink();
			
		if(current_user_can('firmapro') || current_user_can('administrator')) :
			return '<a title="Udostępnij opaskę" class="qr-download qrcode-icon tooltip-top share-button' .  $nastepna_klasa_css . '"><i class="fa-solid fa-share-nodes"></i></a>';
		endif;
	}
	
	$return_json = array();
	while($query->have_posts()) {
	$query->the_post();
	$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
	$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
	$nastepna_klasa_css++;
	if(strtotime(date('d-m-Y H:i')) < strtotime($dzien_po_pogrzebie) || empty(get_field('data_pogrzebu'))) :
	$row = array(
		'nr' => '<a class="number-link" href="' . get_permalink() . '">' . get_field('numer_opaski') . '</a>',
		'typ' => typ_kremacji(),
		'imie' => imie_zmarlego(),
		'nazwisko' => nazwisko_zmarlego(),
		'eksportacja' => data_eksportacji() . calendar_google_simple() . calendar_google_home() . calendar_google_another() ,
		'kremacja' => kreamcja_date() . calendar_google_kremacja(),
		'odbior_urny' => odebranie_urny_date() . calendar_google_odbior_urny(),
		'pozegnanie' => pozegnanie_date() . calendar_google_pozegnanie(),
		'wyprowadzenie' => wprowadzenie_date() . calendar_google_wprowadznie(),
		'akcje' => drukowanie_zestawienia() . drukowanie_etykiety() . '<a title="Wyślij SMSa" class="qr-download qrcode-icon tooltip-top" href="sms:?&body=' . akcje_sms_body_dom() . akcje_sms_body_inne() . '"><i class="fa-solid fa-comment-sms"></i></a><a title="Udostępnij opaskę" class="qr-download qrcode-icon tooltip-top share-button' .  $nastepna_klasa_css . '"><i class="fa-solid fa-share-nodes"></i></a><script> const shareButton' . $nastepna_klasa_css . ' = document.querySelector(".share-button' . $nastepna_klasa_css . '"); if (shareButton' . $nastepna_klasa_css . ' ) { shareButton' . $nastepna_klasa_css . '.addEventListener("click", event => { if (navigator.share) { navigator.share({ title: "' . get_field('numer_opaski') . '-' . get_field('imie_zmarlego') . ' ' . get_field('nazwisko_zmarlego') . '", text: "' . akcje_sms_body_dom() . akcje_sms_body_inne() . '" }).then(() => { console.log("Udostępniłeś nekrolog!");}).catch(console.error);}});}</script>'
	);
	$return_json[] = $row;
	endif;
	}
	//return the result to the ajax request and die
	echo json_encode(array('data' => $return_json));
	wp_die();
  }


  add_action( 'wp_ajax_getpostsfordatatableswolne', 'my_ajax_getpostsfordatatableswolne' );
  add_action( 'wp_ajax_nopriv_getpostsfordatatableswolne', 'my_ajax_getpostsfordatatableswolne' );
  function my_ajax_getpostsfordatatableswolne() {
	global $wpdb;
	global $post;
	global $current_user;
	$post_id = $post->ID;
	wp_get_current_user();
	$authorID = $current_user->ID;
	$user_info = get_userdata($authorID);
	$first_name = $user_info->first_name;
	$user = wp_get_current_user();
	$allowed_roles = array( 'firma', 'firmapro', 'administrator' );

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $query = new WP_Query( array(
            'post_type' => array( 'post', 'ewidencjazgonow' ),
            'posts_per_page'=> -1,
            'paged' => $paged,
            'author' => $authorID,
            'post_status' => 'publish',
            'fields' => 'ids',
            'cache_results' => false,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'orderby'			=> 'meta_value',
            'order'				=> 'DESC',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'imie_zmarlego',
                    'compare' => 'NOT EXISTS'
                ),
                array(
                    'key' => 'nazwisko_zmarlego',
                    'compare' => 'NOT EXISTS'
                ),
            ),
            )
        );

	$return_json = array();
	while($query->have_posts()) {

	$query->the_post();
	$row = array(
		'nr' => '<a class="number-link" href="' . get_permalink() . '">' . get_field('numer_opaski') . '</a>',
		'aktywacja' => '<a class="number-link" href="' . get_permalink() . '">Aktywuj opaskę</a>',
	  );
	  $return_json[] = $row;
	}
	//return the result to the ajax request and die
	echo json_encode(array('data' => $return_json));
	wp_die();
  }

  add_action( 'wp_ajax_getpostsfordatatableszrealizowane', 'my_ajax_getpostsfordatatableszrealizowane' );
  add_action( 'wp_ajax_nopriv_getpostsfordatatableszrealizowane', 'my_ajax_getpostsfordatatableszrealizowane' );

  function my_ajax_getpostsfordatatableszrealizowane() {
	global $wpdb;
	global $current_user;
	$post_id = $post->ID;
	wp_get_current_user();
	$authorID = $current_user->ID;
	$user_info = get_userdata($authorID);
	$first_name = $user_info->first_name;
	$user = wp_get_current_user();
	$allowed_roles = array( 'firma', 'firmapro', 'administrator' );

	function zasilek_pogrzebowy_odebrany_zus() {
		$zasilek_pogrzebowy = get_field('zasilek_pogrzebowy_inne');
		$zasilek_pogrzebowy_odebrany = $zasilek_pogrzebowy['odebrac_zasilek_pogrzebowy'];
		$zasilek_pogrzebowy_zaksiegowany = $zasilek_pogrzebowy['zasilek_zaksiegowany'];

		if($zasilek_pogrzebowy_odebrany == true and $zasilek_pogrzebowy_zaksiegowany == 'tak') : return '<span class="tooltip-right" data-tooltip="Zasiłek odebrany"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/zus-zielony.svg" /><span style="display: none;">zus zielony</span></span>'; endif;
	}

	function zasilek_pogrzebowy_nieodebrany_zus() {
		$zasilek_pogrzebowy = get_field('zasilek_pogrzebowy_inne');
		$zasilek_pogrzebowy_odebrany = $zasilek_pogrzebowy['odebrac_zasilek_pogrzebowy'];
		$zasilek_pogrzebowy_zaksiegowany = $zasilek_pogrzebowy['zasilek_zaksiegowany'];

		if($zasilek_pogrzebowy_odebrany == true and $zasilek_pogrzebowy_zaksiegowany == 'nie') : return '<span class="tooltip-right" data-tooltip="Zasiłek niezaksięgowany"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/zus-czerwony.svg" /><span style="display: none;">zus czerwony</span></span>'; endif;
	}

	function zaislek_gotowka() {
		$zasilek_pogrzebowy = get_field('zasilek_pogrzebowy_inne');
		$zasilek_pogrzebowy_odebrany = $zasilek_pogrzebowy['odebrac_zasilek_pogrzebowy'];
		$zasilek_pogrzebowy_zaksiegowany = $zasilek_pogrzebowy['zasilek_zaksiegowany'];

		if($zasilek_pogrzebowy_odebrany == false) : return '<span  class="tooltip-right" data-tooltip="Pogrzeb opłacony gotówką"><img src="/wp-content/plugins/ewidencja-zmarlych/public/img/dolar-zielony.svg" /><span style="display: none;">dolar</span></span>'; endif;
	}

	function data_pogrzebu() {
		$ceremonia_pogrzegnalna = get_field('ceremonia_pozegnalna');
		$ceremonia_pogrzegnalna_data = $ceremonia_pogrzegnalna['data'];
		$ceremonia_pogrzegnalna_godzina = $ceremonia_pogrzegnalna['godzina'];

		if (!empty($ceremonia_pogrzegnalna_data)) : return $ceremonia_pogrzegnalna_data . ' ' . $ceremonia_pogrzegnalna_godzina; else : return '-'; endif;
	}

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $query = new WP_Query( array(
        'post_type' => array( 'post', 'ewidencjazgonow' ),
        'posts_per_page'=> -1,
        'paged' => $paged,
        'author' => $authorID,
        'fields' => 'ids',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'imie_zmarlego',
                'value'   => array(''),
                'compare' => 'NOT IN'
            ),
            array(
                'key' => 'kto_organizuje_pogrzeb',
                'value'   => true,
                'compare' => '=',
            ),
        ),
    ),
    );
	$return_json = array();
	while($query->have_posts()) {
		$query->the_post();
		$dzien_po_pogrzebie = get_field('data_pogrzebu') .  get_field('godzina_pogrzebu');
		$dzien_po_pogrzebie = date('d-m-Y H:i', strtotime("+1 day", strtotime($dzien_po_pogrzebie)));
		if(strtotime(date('d-m-Y H:i')) > strtotime($dzien_po_pogrzebie) && !empty(get_field('data_pogrzebu'))) : 
	$row = array(
		'nr' => '<a class="number-link" href="' . get_permalink() . '">' . get_field('numer_opaski') . '</a>',
		'zasilek' => zasilek_pogrzebowy_nieodebrany_zus() . zasilek_pogrzebowy_odebrany_zus() . zaislek_gotowka(),
		'imie' => imie_zmarlego(),
		'nazwisko' => nazwisko_zmarlego(),
		'pogrzeb' => data_pogrzebu()
	  );
	  $return_json[] = $row;
	endif;
	}
	//return the result to the ajax request and die
	echo json_encode(array('data' => $return_json));
	wp_die();
  }


  add_action( 'wp_ajax_getpostsfordatatablesobce', 'my_ajax_getpostsfordatatablesobce' );
  add_action( 'wp_ajax_nopriv_getpostsfordatatablesobce', 'my_ajax_getpostsfordatatablesobce' );
  function my_ajax_getpostsfordatatablesobce() {
	global $wpdb;
	global $current_user;
	$post_id = $post->ID;
	wp_get_current_user();
	$authorID = $current_user->ID;
	$user_info = get_userdata($authorID);
	$first_name = $user_info->first_name;
	$user = wp_get_current_user();
	$allowed_roles = array( 'firma', 'firmapro', 'administrator' );

	function wydanie_ciala() {
		if(get_field('data_wydania_ciala')) : return get_field('data_wydania_ciala'); else : return '-'; endif;
	}

	function firma_odbierajaca_cialo() {
		if(get_field('firma_organizujaca_pogrzeb')) : return get_field('firma_organizujaca_pogrzeb'); else : return '-'; endif;
	}

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $query = new WP_Query( array(
            'post_type' => array( 'post', 'ewidencjazgonow' ),
            'posts_per_page'=> -1,
            'paged' => $paged,
            'author' => $authorID,
            'fields' => 'ids',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'     => 'kto_organizuje_pogrzeb',
                    'value'   => true,
                    'compare' => '!=',
                )
            )
        )
    );
	$return_json = array();
	while($query->have_posts()) {
	$query->the_post();
	$row = array(
		'nr' => '<a class="number-link" href="' . get_permalink() . '">' . get_field('numer_opaski') . '</a>',
		'imie' => imie_zmarlego(),
		'nazwisko' => nazwisko_zmarlego(),
		'wydanie_ciala' => wydanie_ciala(),
		'firma' => firma_odbierajaca_cialo()
	  );
	  $return_json[] = $row;
	}
	//return the result to the ajax request and die
	echo json_encode(array('data' => $return_json));
	wp_die();
  }