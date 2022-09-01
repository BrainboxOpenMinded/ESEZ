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
