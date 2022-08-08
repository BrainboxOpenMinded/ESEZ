<?php 
	 add_action( 'wp_enqueue_scripts', 'esez_child_enqueue_styles' );
	 function esez_child_enqueue_styles() {
 		  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' ); 
 		  } 
		add_action( 'wp_enqueue_scripts', 'my_custom_script_load' );
		function my_custom_script_load(){
			wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/assets/main-child.js', array( 'jquery' ) );
		}

		   function bb_login_logo() { ?>
			<style type="text/css">
				#login h1 a, .login h1 a {
					background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/bb.png);
					background-size:180px;
					width:180px;
					height:150px;
				}
			</style>
		<?php }
		add_action( 'login_enqueue_scripts', 'bb_login_logo' );
		
		function bb_login_logo_url() {
			return 'http://brainbox.com.pl';
		}
		add_filter( 'login_headerurl', 'bb_login_logo_url' );		  
		
		function wpb_custom_logo() {
		
				echo '
			  
				<style type="text/css">
			  
				#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
			  
				background-image: url(' . get_bloginfo('stylesheet_directory') . '/img/bb-admin-img.png) !important;
			  
				background-position: 0 0;
			  
				color:rgba(0, 0, 0, 0);
			  
				}
			  
				#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
			  
				background-position: 0 0;
			  
				}
			  
				</style>
			  
				';
			  
				}
			  
				add_action('wp_before_admin_bar_render', 'wpb_custom_logo');
		
				add_filter( 'login_headerurl', 'bb_login_logo_url' );
		
		function bb_footer_admin () {
			echo '<i>Strona administrowana z przyjemnością przez <a href="https://brainbox.com.pl/" style="text-decoration: none;"><strong>BRAINBOX</strong></a>.</i>';
		}
		add_filter('admin_footer_text', 'bb_footer_admin');
		
		function add_file_types_to_uploads($file_types){
			$new_filetypes = array();
			$new_filetypes['svg'] = 'image/svg+xml';
			$file_types = array_merge($file_types, $new_filetypes );
			return $file_types;
			}
			add_filter('upload_mimes', 'add_file_types_to_uploads');
		
		
		  add_action('admin_init', function () {
			// Redirect any user trying to access comments page
			global $pagenow;
			
			if ($pagenow === 'edit-comments.php') {
				wp_redirect(admin_url());
				exit;
			}
		
			// Remove comments metabox from dashboard
			remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
		
			// Disable support for comments and trackbacks in post types
			foreach (get_post_types() as $post_type) {
				if (post_type_supports($post_type, 'comments')) {
					remove_post_type_support($post_type, 'comments');
					remove_post_type_support($post_type, 'trackbacks');
				}
			}
		});
		
		// Close comments on the front-end
		add_filter('comments_open', '__return_false', 20, 2);
		add_filter('pings_open', '__return_false', 20, 2);
		
		// Hide existing comments
		add_filter('comments_array', '__return_empty_array', 10, 2);
		
		// Remove comments page in menu
		add_action('admin_menu', function () {
			remove_menu_page('edit-comments.php');
		});
		
		// Remove comments links from admin bar
		add_action('init', function () {
			if (is_admin_bar_showing()) {
				remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
			}
		});
		
		add_action( 'add_attachment', 'my_set_image_meta_upon_image_upload' );
		function my_set_image_meta_upon_image_upload( $post_ID ) {
		
			// Check if uploaded file is an image, else do nothing
		
			if ( wp_attachment_is_image( $post_ID ) ) {
		
				$my_image_title = get_post( $post_ID )->post_title;
		
				// Sanitize the title:  remove hyphens, underscores & extra spaces:
				$my_image_title = preg_replace( '%\s*[-_\s]+\s*%', ' ',  $my_image_title );
		
				// Sanitize the title:  capitalize first letter of every word (other letters lower case):
				$my_image_title = ucwords( strtolower( $my_image_title ) );
		
				// Create an array with the image meta (Title, Caption, Description) to be updated
				// Note:  comment out the Excerpt/Caption or Content/Description lines if not needed
				$my_image_meta = array(
					'ID'		=> $post_ID,			// Specify the image (ID) to be updated
					'post_title'	=> $my_image_title,		// Set image Title to sanitized title
					'post_content'	=> $my_image_title,		// Set image Description (Content) to sanitized title
				);
		
				// Set the image Alt-Text
				update_post_meta( $post_ID, '_wp_attachment_image_alt', $my_image_title );
		
				wp_update_post( $my_image_meta );
		
			} 
		}
				
		// Remove side menu
		add_action( 'admin_menu', 'remove_default_post_type' );
		
		function remove_default_post_type() {
			remove_menu_page( 'edit.php' );
		
		}
		
		// Remove Quick Draft Dashboard Widget
		add_action( 'wp_dashboard_setup', 'remove_draft_widget', 999 );
		
		function remove_draft_widget(){
			remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		}
		   		   
		   // // Remove rss feed links
		   remove_action( 'wp_head', 'feed_links_extra', 3 );
		   
		   // // remove wp-embed
		   add_action( 'wp_footer', function(){
			   wp_dequeue_script( 'wp-embed' );
		   });
		   
		   
		   add_action( 'wp_enqueue_scripts', function(){
			   // // remove block library css
			   wp_dequeue_style( 'wp-block-library' );
			   // // remove comment reply JS
			   wp_dequeue_script( 'comment-reply' );
		   } );
		
				   // Usuń funkcje
			remove_action('wp_head', 'rsd_link');
			remove_action('wp_head', 'wp_generator');
			remove_action('wp_head', 'feed_links', 2);
			remove_action('wp_head', 'index_rel_link');
			remove_action('wp_head', 'wlwmanifest_link');
			remove_action('wp_head', 'feed_links_extra', 3);
			remove_action('wp_head', 'start_post_rel_link', 10);
			remove_action('wp_head', 'parent_post_rel_link', 10);
			remove_action('wp_head', 'adjacent_posts_rel_link', 10);
			// --------------------------------------------
				// Usuń Emoji
			remove_action('wp_head', 'print_emoji_detection_script', 7);
			remove_action('wp_print_styles', 'print_emoji_styles');
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			// --------------------------------------------
			// Wyłącz pomiar stanu witryny
			add_action( 'init', 'my_deregister_heartbeat', 1 );
			function my_deregister_heartbeat() {
				global $pagenow;
		
				if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow )
					wp_deregister_script('heartbeat');
			}
			
			// --------------------------------------------
			function my_custom_pagination_base() {
				global $wp_rewrite;
				$wp_rewrite->pagination_base = 's';
				$wp_rewrite->flush_rules();
			}
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