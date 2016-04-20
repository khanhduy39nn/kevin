<?php



/*************** Demo Content Settings *******************/
function kwayy_action_rss2_head(){
	// Get theme configuration
	$sidebars = get_option('sidebars_widgets');
	// Get Widgests configuration
	$sidebars_config = array();
	foreach ($sidebars as $sidebar => $widget) {
		if ($widget && is_array($widget)) {
			foreach ($widget as $name) {
				$name = preg_replace('/-\d+$/','',$name);
				$sidebars_config[$name] = get_option('widget_'.$name);
			}
		}
	}
	
	// Get Menus
	$locations = get_nav_menu_locations();
	$menus     = wp_get_nav_menus();
	$menuList  = array();
	foreach( $locations as $location => $menuid ){
		if( $menuid!=0 && $menuid!='' && $menuid!=false ){
			if( is_array($menus) && count($menus)>0 ){
				foreach( $menus as $menu ){
					if( $menu->term_id == $menuid ){
						$menuList[$location] = $menu->name;
					}
				}
			}
		}
	}
	
	$config = array(
			'page_for_posts'   => get_the_title( get_option('page_for_posts') ),
			'show_on_front'    => get_option('show_on_front'),
			'page_on_front'    => get_the_title( get_option('page_on_front') ),
			'posts_per_page'   => get_option('posts_per_page'),
			'sidebars_widgets' => $sidebars,
			'sidebars_config'  => $sidebars_config,
			'menu_list'        => $menuList,
		);            
	if ( defined('KWAYY_THEME_DEVELOPMENT') ) {
		echo sprintf('<wp:theme_custom>%s</wp:theme_custom>', base64_encode(serialize($config)));
	}
}

if ( defined('KWAYY_THEME_DEVELOPMENT') ) {
	add_action('rss2_head', 'kwayy_action_rss2_head');
}

/**********************************************************/




/********************* Ajax Callback Init **************************/
add_action( 'admin_footer', 'kwayy_one_click_js_code' );
function kwayy_one_click_js_code() {
	$images   = array();
	$images[] = get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/kwayy_one_click_demo_content/import-alert.jpg';
	$images[] = get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/kwayy_one_click_demo_content/import-loader.gif';
	$images[] = get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/kwayy_one_click_demo_content/import-success.jpg';
	
	?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
		
		
		/*********** Preload images **************/
		function preload(arrayOfImages) {
			$(arrayOfImages).each(function(){
				$('<img/>')[0].src = this;
				// Alternatively you could use:
				// (new Image()).src = this;
			});
		}
		preload([
			<?php
			$total = count($images);
			$x     = 1;
			foreach( $images as $image ){
				echo '"'. $image . '"' ;
				if( $total != $x ){
					echo ',';
				}
				$x++;
			}
			?>
		]);
		/*****************************************/
		
		
		jQuery('#kwayy_one_click_demo_content_option').click(function() {
			jQuery('#import-demo-data-results-wrapper').slideDown();
			$(this).attr('disabled', 'disabled');
		});
		
		jQuery('#kwayy_one_click_demo_content_cancel').click(function() {
			jQuery('#import-demo-data-results-wrapper').slideUp(function(){
				$('#kwayy_one_click_demo_content_option').prop("disabled", false);
			});
			
		});
		
		
		
		jQuery('#kwayy_one_click_demo_content').click(function() {
			
			if( $(this).attr('disabled') == 'disabled' ) {
				return false;
			}
			
			$(this).attr('disabled', 'disabled');
			
			var button = $(this);
			var resultDiv = $('#import-demo-data-results');
			
			resultDiv.addClass('kwayy-import-demo-progress'); /* Adding loader class */
			
			$.ajax({
				url: ajaxurl,
				type: "POST",
				dataType: "json",
				data: {
					'action' : 'apicona_install_demo_data',
					'subaction' : 'start'
				},
				beforeSend: function() {
					//resultDiv.html('<p id="install-demo-data-started">' + apiconaVars.strInstallingDemoData + '</p>').show().removeClass('error');
					resultDiv.html('<p id="install-demo-data-started">Starting Demo Content Setup</p>').show().removeClass('error');
				},
				success: function( result ) {

					function demoInstallerStep( result ) {
						
						if( result != null && typeof( result ) == 'object' ) {
						
							if( result.answer == 'ok' ) {
							
								resultDiv.append('<p>' + result.message + '</p>');
								
								/*** Extra data for next processing ***/
								var missing_menu_items = '';
								if( typeof result.missing_menu_items != "undefined" ){
									missing_menu_items = result.missing_menu_items;
								}
								
								var processed_terms = '';
								if( typeof result.processed_terms != "undefined" ){
									processed_terms = result.processed_terms;
								}
								
								var processed_posts = '';
								if( typeof result.processed_posts != "undefined" ){
									processed_posts = result.processed_posts;
								}
								
								var processed_menu_items = '';
								if( typeof result.processed_menu_items != "undefined" ){
									processed_menu_items = result.processed_menu_items;
								}
								
								var menu_item_orphans = '';
								if( typeof result.menu_item_orphans != "undefined" ){
									menu_item_orphans = result.menu_item_orphans;
								}
								
								var url_remap = '';
								if( typeof result.url_remap != "undefined" ){
									url_remap = result.url_remap;
								}
								
								var featured_images = '';
								if( typeof result.featured_images != "undefined" ){
									featured_images = result.featured_images;
								}
								/***********************************/
								
								
								
								
								$.ajax({
									url: ajaxurl,
									type: "POST",
									dataType: "json",
									data: {
										'action'    : 'apicona_install_demo_data',
										'subaction' : result.next_subaction,
										'data'      : result.data,
										'missing_menu_items'   : result.missing_menu_items,
										'processed_terms'      : result.processed_terms,
										'processed_posts'      : result.processed_posts,
										'processed_menu_items' : result.processed_menu_items,
										'menu_item_orphans'    : result.menu_item_orphans,
										'url_remap'            : result.url_remap,
										'featured_images'      : featured_images
									},
									success: function( result ) {
										demoInstallerStep( result );
									},
									error: function(request, status, error) {
										//resultDiv.html( '<p><strong style="color: red">' + apiconaVars.strError + ": " + request.status + '</p>' );
										resultDiv.html( '<p><strong style="color: red"> Error: ' + request.status + '</p>' );
										button.removeAttr('disabled');
									}
								});
							
							}
						
							if( result.answer == 'finished' ) {
								//$('#install-demo-data-started').remove();
								resultDiv.append('<p><strong>All finished... Enjoy :) </strong></p>');
								resultDiv.addClass('kwayy-import-demo-success');
								//button.removeAttr('disabled');
							}
						
						} else {
						
							resultDiv.append( '<p><strong style="color: red">' + apiconaVars.strError + ":</strong> " + apiconaVars.strWrongServerAnswer + '</p>' ).addClass('error');
							button.removeAttr('disabled');
							$('#install-demo-data-started').remove();
							
						}
						
					}

					demoInstallerStep( result );
			
				},
				error: function(request, status, error) {
					//resultDiv.html( '<p><strong style="color: red">' + apiconaVars.strError + ": " + request.status + '</p>' );
					resultDiv.html( '<p><strong style="color: red">: ERRRRROR' + request.status + '</p>' );
					button.removeAttr('disabled');
				}
			});
			
			return false;
		
		
		
		
			/*
			var data = {
				'action'                : 'kwayy_one_click_demo',
				'startdemoinstallation' : 'true'
			};

			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			$.post(ajaxurl, data, function(response) {
			
				//console.log('Ajax URL: ' + ajaxurl);
				console.log('Got this from the server: ' + response);
				//alert('Got this from the server: ' + response);
			});
			*/
		});
	});
	</script>
	<?php
}




if( !class_exists( 'kwayy_one_click_demo_setup' ) ) {

	class kwayy_one_click_demo_setup{
		
		
		function __construct(){
			add_action( 'wp_ajax_apicona_install_demo_data', array( &$this , 'ajax_install_demo_data' ) );
			/*include_once('demo-content-scripts.php');
			global $kwayy_demo_installation;
			$kwayy_demo_installation = new kwayy_demo_installation;*/
		}
		
		
		/**
		 * Decide if the given meta key maps to information we will want to import
		 *
		 * @param string $key The meta key to check
		 * @return string|bool The key if we do want to import, false if not
		 */
		function is_valid_meta_key( $key ) {
			// skip attachment metadata since we'll regenerate it from scratch
			// skip _edit_lock as not relevant for import
			if ( in_array( $key, array( '_wp_attached_file', '_wp_attachment_metadata', '_edit_lock' ) ) )
				return false;
			return $key;
		}
		
		
		
		
		/**
		 * Added to http_request_timeout filter to force timeout at 60 seconds during import
		 * @return int 60
		 */
		function bump_request_timeout() {
			return 600;
		}
		
		
		
		/**
		 * Map old author logins to local user IDs based on decisions made
		 * in import options form. Can map to an existing user, create a new user
		 * or falls back to the current user in case of error with either of the previous
		 */
		function get_author_mapping() {
			if ( ! isset( $_POST['imported_authors'] ) )
				return;

			$create_users = $this->allow_create_users();

			foreach ( (array) $_POST['imported_authors'] as $i => $old_login ) {
				// Multisite adds strtolower to sanitize_user. Need to sanitize here to stop breakage in process_posts.
				$santized_old_login = sanitize_user( $old_login, true );
				$old_id = isset( $this->authors[$old_login]['author_id'] ) ? intval($this->authors[$old_login]['author_id']) : false;

				if ( ! empty( $_POST['user_map'][$i] ) ) {
					$user = get_userdata( intval($_POST['user_map'][$i]) );
					if ( isset( $user->ID ) ) {
						if ( $old_id )
							$this->processed_authors[$old_id] = $user->ID;
						$this->author_mapping[$santized_old_login] = $user->ID;
					}
				} else if ( $create_users ) {
					if ( ! empty($_POST['user_new'][$i]) ) {
						$user_id = wp_create_user( $_POST['user_new'][$i], wp_generate_password() );
					} else if ( $this->version != '1.0' ) {
						$user_data = array(
							'user_login' => $old_login,
							'user_pass' => wp_generate_password(),
							'user_email' => isset( $this->authors[$old_login]['author_email'] ) ? $this->authors[$old_login]['author_email'] : '',
							'display_name' => $this->authors[$old_login]['author_display_name'],
							'first_name' => isset( $this->authors[$old_login]['author_first_name'] ) ? $this->authors[$old_login]['author_first_name'] : '',
							'last_name' => isset( $this->authors[$old_login]['author_last_name'] ) ? $this->authors[$old_login]['author_last_name'] : '',
						);
						$user_id = wp_insert_user( $user_data );
					}

					if ( ! is_wp_error( $user_id ) ) {
						if ( $old_id )
							$this->processed_authors[$old_id] = $user_id;
						$this->author_mapping[$santized_old_login] = $user_id;
					} else {
						printf( __( 'Failed to create new user for %s. Their posts will be attributed to the current user.', 'wordpress-importer' ), esc_html($this->authors[$old_login]['author_display_name']) );
						if ( defined('IMPORT_DEBUG') && IMPORT_DEBUG )
							echo ' ' . $user_id->get_error_message();
						echo '<br />';
					}
				}

				// failsafe: if the user_id was invalid, default to the current user
				if ( ! isset( $this->author_mapping[$santized_old_login] ) ) {
					if ( $old_id )
						$this->processed_authors[$old_id] = (int) get_current_user_id();
					$this->author_mapping[$santized_old_login] = (int) get_current_user_id();
				}
			}
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/**
		 * Install demo data
		 **/
		function ajax_install_demo_data() {
			/*global $kwayy_demo_content;
			include_once('wordpress-importer/parsers.php');
			$WXR_Parser         = new WXR_Parser;
			$kwayy_demo_content = $WXR_Parser->parse( dirname( __FILE__ ).'/demo.xml' );*/
			
			/*if( !is_array($kwayy_demo_content) ){
				$kwayy_demo_content = $this->setup_demo_content_array();
			}*/
			
			// Maximum execution time
			ini_set('max_execution_time', 60000);
			set_time_limit(60000);
			
			define('WP_LOAD_IMPORTERS', true);
			include_once( dirname( __FILE__ ).'/wordpress-importer/wordpress-importer.php' );
			$WP_Import = new kwayy_WP_Import;
			$WP_Import->fetch_attachments = true;
			$WP_Import->import_start( dirname( __FILE__ ).'/demo.xml' );
			
			
			$_POST     = stripslashes_deep( $_POST );
			$subaction = $_POST['subaction'];
			$data      = isset( $_POST['data'] ) ? unserialize( base64_decode( $_POST['data'] ) ) : array();
			$answer    = array();
			echo '';  //Patch for ob_start()   If you remove this the ob_start() will not work.
			
			
			switch( $subaction ) {
				
				case( 'start' ):
				
					$answer['answer']         = 'ok';
					$answer['next_subaction'] = 'install_demo_cat';
					$answer['message']        = __('Inserting Categories...', 'apicona');
					$answer['data']           = '';
				
					die( json_encode( $answer ) );
				
				break;
				
				
				case( 'install_demo_cat' ):
					wp_suspend_cache_invalidation( true );
					$WP_Import->process_categories();
					wp_suspend_cache_invalidation( false );
					
					// Output message
					$answer['answer']         = 'ok';
					$answer['next_subaction'] = 'install_demo_tags';
					$answer['message']        = __('All Categories were inserted successfully. Inserting Tags...', 'apicona');
					$answer['data']           = base64_encode( serialize( $data ) );
					
					die( json_encode( $answer ) );
				break;
				
				case( 'install_demo_tags' ):
					wp_suspend_cache_invalidation( true );
					$WP_Import->process_tags();
					wp_suspend_cache_invalidation( false );
					
					// Output message
					$answer['answer']         = 'ok';
					$answer['next_subaction'] = 'install_demo_terms';
					$answer['message']        = __('All Tags were inserted successfully. Inserting Terms...', 'apicona');
					$answer['data']           = base64_encode( serialize( $data ) );
					
					die( json_encode( $answer ) );
				break;
				
				case( 'install_demo_terms' ):
					
					wp_suspend_cache_invalidation( true );
					ob_start();
					$WP_Import->process_terms();
					ob_end_clean();
					wp_suspend_cache_invalidation( false );
					
					// Output message
					$answer['answer']         = 'ok';
					$answer['next_subaction'] = 'install_demo_posts';
					$answer['message']        = __('All Terms were inserted successfully. Inserting Posts...', 'apicona');
					$answer['data']           = base64_encode( serialize( $data ) );
					
					die( json_encode( $answer ) );
				break;
				
				
				case( 'install_demo_posts' ):
					//wp_suspend_cache_invalidation( true );
					echo '';  //Patch for ob_start()   If you remove this the ob_start() will not work.
					ob_start();
					echo '';  //Patch for ob_start()   If you remove this the ob_start() will not work.
					$WP_Import->process_posts();
					ob_end_clean();
					//wp_suspend_cache_invalidation( false );
					
					// Output message
					$answer['answer']         = 'ok';
					$answer['next_subaction'] = 'install_demo_images';
					$answer['message']        = __('All Posts were inserted successfully. Importing images...', 'apicona');
					$answer['data']           = base64_encode( serialize( $data ) );
					$answer['missing_menu_items']   = base64_encode( serialize( $WP_Import->missing_menu_items ) );
					$answer['processed_terms']      = base64_encode( serialize( $WP_Import->processed_terms ) );
					$answer['processed_posts']      = base64_encode( serialize( $WP_Import->processed_posts ) );
					$answer['processed_menu_items'] = base64_encode( serialize( $WP_Import->processed_menu_items ) );
					$answer['menu_item_orphans']    = base64_encode( serialize( $WP_Import->menu_item_orphans ) );
					$answer['url_remap']            = base64_encode( serialize( $WP_Import->url_remap ) );
					$answer['featured_images']      = base64_encode( serialize( $WP_Import->featured_images ) );
					
					die( json_encode( $answer ) );
				break;
				
				
				
				case( 'install_demo_images' ):
					$WP_Import->missing_menu_items   = unserialize( base64_decode( $_POST['missing_menu_items'] ) );
					$WP_Import->processed_terms      = unserialize( base64_decode( $_POST['processed_terms'] ) );
					$WP_Import->processed_posts      = unserialize( base64_decode( $_POST['processed_posts'] ) );
					$WP_Import->processed_menu_items = unserialize( base64_decode( $_POST['processed_menu_items'] ) );
					$WP_Import->menu_item_orphans    = unserialize( base64_decode( $_POST['menu_item_orphans'] ) );
					$WP_Import->url_remap            = unserialize( base64_decode( $_POST['url_remap'] ) );
					$WP_Import->featured_images      = unserialize( base64_decode( $_POST['featured_images'] ) );
					
					//var_dump($WP_Import->missing_menu_items);
					//var_dump($WP_Import->processed_terms);
					//var_dump($WP_Import->processed_posts);
					//var_dump($WP_Import->processed_menu_items);
					//var_dump($WP_Import->menu_item_orphans);
					
					ob_start();
					$WP_Import->backfill_parents();
					$WP_Import->backfill_attachment_urls();
					$WP_Import->remap_featured_images();
					$WP_Import->import_end();
					ob_end_clean();
					
					// Output message
					$answer['answer']         = 'ok';
					$answer['next_subaction'] = 'install_demo_settings';
					$answer['message']        = __('All Images were inserted successfully. Setting the widgets and options...', 'apicona');
					$answer['data']           = base64_encode( serialize( $data ) );
					
					die( json_encode( $answer ) );
				break;
				
				
				
				case( 'install_demo_settings' ):
				
			        // Import custom configuration
					$content = file_get_contents( dirname( __FILE__ ).'/demo.xml' );
					
					if ( false !== strpos( $content, '<wp:theme_custom>' ) ) {
						preg_match('|<wp:theme_custom>(.*?)</wp:theme_custom>|is', $content, $config);
						//var_dump($config);
						if ($config && is_array($config) && count($config) > 1){
							$config = unserialize(base64_decode($config[1]));
							//var_dump($config);
							if (is_array($config)){
								$configs = array(
										'page_for_posts',
										'show_on_front',
										'page_on_front',
										'posts_per_page',
										'sidebars_widgets',
									);
								foreach ($configs as $item){
									if (isset($config[$item])){
										if( $item=='page_for_posts' || $item=='page_on_front' ){
											$page = get_page_by_title( $config[$item] );
											if( isset($page->ID) ){
												$config[$item] = $page->ID;
											}
										}
										update_option($item, $config[$item]);
									}
								}
								if (isset($config['sidebars_widgets'])){
									$sidebars = $config['sidebars_widgets'];
									update_option('sidebars_widgets', $sidebars);
									// read config
									$sidebars_config = array();
									if (isset($config['sidebars_config'])){
										$sidebars_config = $config['sidebars_config'];
										if (is_array($sidebars_config)){
											foreach ($sidebars_config as $name => $widget){
												update_option('widget_'.$name, $widget);
											}
										}
									}
								}
								
								if ( isset($config['menu_list']) && is_array($config['menu_list']) && count($config['menu_list'])>0 ){
									foreach( $config['menu_list'] as $location=>$menu_name ){
										$locations = get_theme_mod('nav_menu_locations'); // Get all menu Locations of current theme
										
										// Get menu name by id
										$term = get_term_by('name', $menu_name, 'nav_menu');
										$menu_id = $term->term_id;
										
										$locations[$location] = $menu_id;  //$foo is term_id of menu
										set_theme_mod('nav_menu_locations', $locations); // Set menu locations
									}
								}
								
							}
						}
					}
					
					$answer['answer'] = 'finished';
					die( json_encode( $answer ) );
					
				break;
				
			}
			die;
		}
		
		
		
		/**
		 * Fetch and save image
		 **/
		function grab_image($url,$saveto){
			$ch = curl_init ($url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
			$raw=curl_exec($ch);
			curl_close ($ch);
			if(file_exists($saveto)){
				unlink($saveto);
			}
			$fp = fopen($saveto,'x');
			fwrite($fp, $raw);
			fclose($fp);
		}



	} // END class

} // END if



// For AJAX callback
$kwayy_one_click_demo_setup = new kwayy_one_click_demo_setup;



