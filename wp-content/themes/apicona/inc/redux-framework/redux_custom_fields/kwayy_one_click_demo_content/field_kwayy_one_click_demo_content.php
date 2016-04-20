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
if( !class_exists( 'ReduxFramework_kwayy_one_click_demo_content' ) ) {

    /**
     * Main ReduxFramework_kwayy_skin_color class
     *
     * @since       1.0.0
     */
	//class ReduxFramework_kwayy_skin_color extends ReduxFramework {
	class ReduxFramework_kwayy_one_click_demo_content{
	
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
			

			

			echo '<div class="kwayy-one-click-demo-content-wrapper">';
				echo '<input type="button" class="button button-primary" id="kwayy_one_click_demo_content_option" value="Demo Content Setup" />';
				echo '<div id="import-demo-data-results-wrapper" style="display:none;">
					<div id="import-demo-data-results">
						' . __('<strong>NOTE -</strong> This process may overwrite your existing content or settings. So please do this on fresh WordPress setup only. <br /><br />  Also if you already included demo data than this will add multiple menu links and you need to remove the repeated menu items by going to <em>Admin > Appearance > menus</em> section.', 'apicona') . '
						<br /><br />
						<input type="button" class="button button-primary ' . $this->field['id'] . '" id="kwayy_one_click_demo_content" value="I agree, continue demo content setup" /> &nbsp; 
						
						<input type="button" class="button" id="kwayy_one_click_demo_content_cancel" value="Cancel" />
					
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
			/*wp_enqueue_script(
				'redux-field-kwayy-one-click-demo-content-js',
				ReduxFramework::$_url . 'inc/fields/kwayy_one_click_demo_content/field_kwayy_one_click_demo_content.js',
				array( 'jquery' ),
				time(),
				true
			);*/

			wp_enqueue_style(
				'redux-field-kwayyoneclickdemo-css',
				//ReduxFramework::$_url . 'inc/fields/kwayy_one_click_demo_content/field_kwayy_one_click_demo_content.css',
				get_template_directory_uri() . '/inc/redux-framework/redux_custom_fields/kwayy_one_click_demo_content/field_kwayy_one_click_demo_content.css',
				time(),
				true
			);
			
			
		}
		

		
	
		
	
	}
}











