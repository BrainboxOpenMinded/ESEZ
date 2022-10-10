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