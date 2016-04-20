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
if( !class_exists( 'ReduxFramework_kwayy_skin_color' ) ) {

    /**
     * Main ReduxFramework_kwayy_skin_color class
     *
     * @since       1.0.0
     */
	//class ReduxFramework_kwayy_skin_color extends ReduxFramework {
	class ReduxFramework_kwayy_skin_color{
	
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

			/*$colorList = array(
				'Orange'         => '#e85e16',
				'Cyan'           => '#00abe4',
				'Emerald'        => '#4abe63',
				'Green'          => '#89c355',
				'Tan'            => '#00bdbd',
				'Yellow'         => '#ffbe00',
				'Mountainmeadow' => '#18c08f',
				'Brown'          => '#964b00',
				'Cinnabar'       => '#e64d3b',
				'Mongoose'       => '#b8a279',
			);*/
			
			$colorList = $this->field['values'];
			
			echo '<div class="kwayy-skin-color-list">';
			foreach( $colorList as $name=>$color ){ echo '<a href="#" title="'.$name.'" style="background-color:'.$color.'">'.$name.'</a>'; }
			echo '<div class="clear"></div></div>';
			
			
			echo '<div class="kwayy-or-text-wrapper"><span></span><div class="kwayy-or-text">OR</div></div>';
		
		
			echo '<input data-id="'.$this->field['id'].'" name="' . $this->field['name'] . $this->field['name_suffix'] . '" id="' . $this->field['id'] . '-color" class="redux-color redux-color-init ' . $this->field['class'] . '"  type="text" value="' . $this->value . '"  data-default-color="' . ( isset($this->field['default']) ? $this->field['default'] : "" ) . '" />';

			if ( !isset( $this->field['transparent'] ) || $this->field['transparent'] !== false ) {
				$tChecked = "";
				if ( $this->value == "transparent" ) {
					$tChecked = ' checked="checked"';
				}
				

				
				echo '<label for="' . $this->field['id'] . '-transparency" class="color-transparency-check"><input type="checkbox" class="checkbox color-transparency ' . $this->field['class'] . '" id="' . $this->field['id'] . '-transparency" data-id="'.$this->field['id'] . '-color" value="1"'.$tChecked.'> '.__('Transparent', 'redux-framework').'</label>';				
			}

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

			wp_enqueue_style( 'wp-color-picker' );
			
			
			// We already inserted code in /inc/admin-custom.js and /inc/admin-style.css files.
			/*wp_enqueue_script(
				'redux-field-kwayy-skin-color-js', 
				ReduxFramework::$_url . 'inc/fields/kwayy_skin_color/field_kwayy_skin_color.js', 
				array( 'jquery', 'wp-color-picker' ),
				time(),
				true
			);

			wp_enqueue_style(
				'redux-field-kwayy-skin-color-css', 
				ReduxFramework::$_url . 'inc/fields/kwayy_skin_color/field_kwayy_skin_color.css', 
				time(),
				true
			);*/
		
		}

		
		
		
		
		/*public function output() {

			$style = '';
			if ( !empty( $this->value ) ) {
				$mode = ( isset( $this->field['mode'] ) && !empty( $this->field['mode'] ) ? $this->field['mode'] : 'color' );

				$style .= $mode.':'.$this->value.';';

				if ( !empty( $this->field['output'] ) && is_array( $this->field['output'] ) ) {
					$keys = implode(",", $this->field['output']);
					$this->parent->outputCSS .= $keys . "{" . $style . '}';
				}

				if ( !empty( $this->field['compiler'] ) && is_array( $this->field['compiler'] ) ) {
					$keys = implode(",", $this->field['compiler']);
					$this->parent->compilerCSS .= $keys . "{" . $style . '}';  
				}
			}
		}*/
		
	
	}
}