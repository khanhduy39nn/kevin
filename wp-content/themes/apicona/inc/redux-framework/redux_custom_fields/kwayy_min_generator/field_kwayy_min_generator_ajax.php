<?php

/*
 * NOTE: This file must call in functions.php
 *
 *
 /*

/*** Ajax Callback ***/

if( !class_exists( 'kwayy_min_generator' ) ) {

	class kwayy_min_generator{
		
		
		function __construct(){
			add_action( 'wp_ajax_kwayy_min_generator', array( &$this , 'ajax_process_min_generator' ) );
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
		 * MIN Generator
		 **/
		function ajax_process_min_generator() {
			
			// Maximum execution time
			@ini_set('max_execution_time', 60000);
			@set_time_limit(60000);
			$_POST     = stripslashes_deep( $_POST );
			$subaction = $_POST['subaction'];
			$data      = isset( $_POST['data'] ) ? unserialize( base64_decode( $_POST['data'] ) ) : array();
			$answer    = array();
			echo '';  //Patch for ob_start()   If you remove this the ob_start() will not work.
			
			
			
			switch( $subaction ) {
				
				case( 'start' ):
					
					$answer['answer']         = 'ok';
					$answer['next_subaction'] = 'start_min_css';
					$answer['message']        = __('Minifying CSS files...', 'apicona');
					$answer['data']           = '';
				
					die( json_encode( $answer ) );
				
				break;
				
				case( 'start_min_css' ):
					
					// Minifier Library
					//include('minifier.php');
					
					// Getting all CSS files in /css/ directory.
					$css_dir   = get_template_directory().'/css/';
					$css_files = scandir($css_dir);
					
					// Regenerating dynamic-style.css file
					tm_regenerate_dynamic_css();
					
					// Fontiocn Library
					$ficon_css_dir  = get_template_directory().'/css/fonticon-library/';
					$ficon_css_list = scandir($ficon_css_dir);
					
					
					$css_array = array();
					$css_array[get_template_directory().'/style.css'] = get_template_directory().'/style.min.css'; // style.css
					$css_array[get_template_directory().'/rtl.css'] = get_template_directory().'/rtl.min.css'; // rtl.css
					$css_array[get_template_directory().'/style-login.css'] = get_template_directory().'/style-login.min.css'; // style-login.css
					
					
					foreach($css_files as $css){
						if ($css != "." && $css != ".." && substr($css, -4)=='.css'  && substr($css, -8)!='.min.css' ) {
							$newfileame  = str_replace('.css','.min.css',$css);
							$currentfile = $css_dir.$css;
							$newfile     = $css_dir.$newfileame;
							$css_array[$currentfile] = $newfile;
						}
					}
					
					foreach($ficon_css_list as $library){
						if ($library != "." && $library != ".." && is_dir($ficon_css_dir.$library) ) {
							$currentfile = $ficon_css_dir.$library.'/css/kwayy-'.$library.'.css';
							$newfile     = $ficon_css_dir.$library.'/css/kwayy-'.$library.'.min.css';
							$css_array[$currentfile] = $newfile;
						}
					}
					
					
					// processing all CSS fles
					/*ob_start();
					minifyCSS($css_array);
					ob_get_clean();*/
					tm_minifier('css',$css_array);
					
					
				
					$answer['answer']         = 'ok';
					$answer['next_subaction'] = 'start_min_js';
					$answer['message']        = __('All CSS Files minified successfully. <br> Now minifying JS files...', 'apicona');
					$answer['data']           = '';
				
					die( json_encode( $answer ) );
				
				break;
				
				
				case( 'start_min_js' ):
					
					// Minifier Library
					//include('minifier.php');
					
					// Getting all JS files in /js/ directory.
					$js_dir   = get_template_directory().'/js/';
					$js_files = scandir($js_dir);
					$js_array = array();
					foreach($js_files as $js){
						if ($js != "." && $js != ".." && substr($js, -3)=='.js'  && substr($js, -7)!='.min.js' ) {
							$newfileame  = str_replace('.js','.min.js',$js);
							$currentfile = $js_dir.$js;
							$newfile     = $js_dir.$newfileame;
							$js_array[$currentfile] = $newfile;
						}
					}
					
					// Now processing the files
					/*ob_start();
					minifyJS($js_array);
					ob_get_clean();*/
					tm_minifier('js',$js_array);
					
					
					
					// Output message
					$answer['answer']         = 'finished';
					
					die( json_encode( $answer ) );
				break;
				
			}
			
			die;
		}


	} // END class

} // END if


add_action('admin_init', 'kwayy_call_min_generator');
function kwayy_call_min_generator(){
	// For AJAX callback
	$kwayy_min_generator = new kwayy_min_generator;
}



