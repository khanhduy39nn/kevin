<?php
/**
 * Redux Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Redux Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Redux Framework. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ReduxFramework
 * @subpackage  Field_Color
 * @author      Daniel J Griffiths (Ghost1227)
 * @author      Dovy Paukstys
 * @version     3.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')){
    exit;
}

// Don't duplicate me!
if( !class_exists( 'ReduxFramework_kwayy_min_generator' ) ) {

    /**
     * Main ReduxFramework_kwayy_skin_color class
     *
     * @since       1.0.0
     */
	//class ReduxFramework_kwayy_skin_color extends ReduxFramework {
	class ReduxFramework_kwayy_min_generator{
	
		/**
		 * Field Constructor.
		 *
		 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
		 *
	 	 * @since 		1.0.0
	 	 * @access		public
	 	 * @return		void
		 */
		function __construct( $field = array(), $value ='', $parent ) {
        
			//parent::__construct( $parent->sections, $parent->args );
			$this->parent = $parent;
			$this->field = $field;
			$this->value = $value;
			
			/******************* One Click Demo Content PHP codes **********************/
			//require_once('one-click-demo/demo-content.php');
			
		}
	
		/**
		 * Field Render Function.
		 *
		 * Takes the vars and outputs the HTML for the field in the settings
	 	 *
	 	 * @since 		1.0.0
	 	 * @access		public
	 	 * @return		void
		 */
		function render() {
			

			

			echo '<div class="kwayy-min-generator-wrapper">';
				echo '<input type="button" class="button button-primary" id="kwayy_min_generator_btn" value="Generate MIN file for CSS and JS files" />';
				echo '<div id="min-generator-wrapper" style="display:none;">
					<div id="min-generator-results">
					
						<div class="min-generator-layout">
							<h3>'.__('Select demo data type <small>( by clicking on the thumbnail)</small> :', 'apicona').'</h3>
						</div><!-- .import-demo-data-layout -->
					
					</div>
				</div>
				';
			echo '<div class="clear"></div></div>';
		
		}
	
		/**
		 * Enqueue Function.
		 *
		 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
		 *
		 * @since		1.0.0
		 * @access		public
		 * @return		void
		 */
		public function enqueue() {

			// Function for demo content setup
			wp_enqueue_script(
				'redux-field-kwayy-min-generator-js',
				get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/kwayy_min_generator/field_kwayy_min_generator.js',
				array( 'jquery' ),
				time(),
				true
			);

			wp_enqueue_style(
				'redux-field-kwayy-min-generator-css',
				get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/kwayy_min_generator/field_kwayy_min_generator.css',
				time(),
				true
			);
			
		}
	
	}
}







/*
add_action( 'wp_ajax_my_action', 'my_action_callback' );

function my_action_callback() {
	global $wpdb; // this is how you get access to the database

	$whatever = intval( $_POST['whatever'] );

	$whatever += 10;

        echo $whatever;

	wp_die(); // this is required to terminate immediately and return a proper response
}
*/























//add_action( 'admin_footer', 'kwayy_min_generator_js' ); // Write our JS below here

function kwayy_min_generator_js() { ?>
	<script type="text/javascript" >

		
	jQuery( document ).ready(function($) {
		
		
		/*jQuery( 'a.import-demo-thumb' ).click(function() {
			
			jQuery('.import-demo-data-layout a').removeClass('import-demo-thumb-active');
			jQuery(this).addClass('import-demo-thumb-active');
			
			var layout = jQuery(this).data('layout');
			jQuery( 'input#import-layout-color' ).val(layout);
			return false;
		});*/
		
		
		jQuery('#kwayy_min_generator_btn').click(function() {
			
			if( $(this).attr('disabled') == 'disabled' ) {
				return false;
			}
			
			//$(this).attr('disabled', 'disabled');
			
			$('#min-generator-wrapper').slideDown();
			
			var button = $(this);
			var resultDiv = $('#min-generator-results');
			
			resultDiv.addClass('kwayy-min-generator-progress'); // Adding loader class
			
			
			
			// Layout Color
			//var color = jQuery('#import-layout-color').val();
			
			$.ajax({
				url: ajaxurl,
				type: "POST",
				dataType: "json",
				data: {
					'action'    : 'kwayy_min_generator',
					//'color'     : color,
					'subaction' : 'start'
				},
				beforeSend: function() {
					//resultDiv.html('<p id="install-demo-data-started">' + apiconaVars.strInstallingDemoData + '</p>').show().removeClass('error');
					resultDiv.html('<p id="install-demo-data-started">Starting MIN generator...</p>').show().removeClass('error');
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
										'action'    : 'kwayy_min_generator',
										//'color'     : color,
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
								
								
								/*if( color == 'dark' ){
									resultDiv.append('<p><strong>All finished :) ... Please wait while we are saving the settings... </strong></p>');
									resultDiv.addClass('kwayy-import-demo-success');
									
									// Saving the Theme Options now
									jQuery('li.kwayy-pre-color-link-2 a').trigger( "click" );
									setTimeout(function() { jQuery('#redux_save').trigger( "click" ); }, 1200);
									
								} else {
									resultDiv.append('<p><strong>All finished... Enjoy :) </strong></p><div class="tm-import-done">The next step is to insert Slider and some small changes. <a href="http://apicona.kwayy.com/documentation/democontent.html" target="_blank">Click here for next steps</a>.</div>');
									resultDiv.addClass('kwayy-import-demo-success');
								}*/
								
								resultDiv.append('<p><strong>All finished... Enjoy :) </strong></p>');
								resultDiv.addClass('kwayy-import-demo-success');
								
								//button.removeAttr('disabled');
							}
						
						} /*else {
						
							resultDiv.append( '<p><strong style="color: red">Error:</strong> Something wrong</p>' ).addClass('error');
							button.removeAttr('disabled');
							$('#install-demo-data-started').remove();
							
						}*/
						
					}

					demoInstallerStep( result );
			
				},
				error: function(request, status, error) {
					//resultDiv.html( '<p><strong style="color: red">' + apiconaVars.strError + ": " + request.status + '</p>' );
					resultDiv.html( '<p><strong style="color: red">: ERRRRROR' + request.status + '</p>' );
					//button.removeAttr('disabled');
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





		
		
	}); // document.ready END
		
		
	</script> <?php
}

