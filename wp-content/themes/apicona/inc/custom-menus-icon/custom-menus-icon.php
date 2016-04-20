<?php

class kwayy_custom_menus_icon {

	/*--------------------------------------------*
	 * Constructor
	 *--------------------------------------------*/

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	function __construct() {

		// load the plugin translation files
		add_action( 'init', array( $this, 'textdomain' ) );
		
		// add custom menu fields to menu
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'kwayy_add_custom_nav_fields' ) );

		// save menu custom fields
		add_action( 'wp_update_nav_menu_item', array( $this, 'kwayy_update_custom_nav_fields'), 10, 3 );
		
		// edit menu walker
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'kwayy_edit_walker'), 10, 2 );

	} // end constructor
	
	
	/**
	 * Load the plugin's text domain
	 *
	 * @since 1.0
	 *
	 * @return void
	 */
	public function textdomain() {
		load_plugin_textdomain( 'rc_scm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
	
	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function kwayy_add_custom_nav_fields( $menu_item ) {
	
	    $menu_item->icon  = get_post_meta( $menu_item->ID, '_menu_item_icon', true );
		//$menu_item->color = get_post_meta( $menu_item->ID, '_menu_item_color', true );
		//$menu_item->bgimage = get_post_meta( $menu_item->ID, '_menu_item_bgimage', true );
	    return $menu_item;
	    
	}
	
	/**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function kwayy_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {

		// Check if element is properly sent
		if ( isset( $_REQUEST['menu-item-icon']) && is_array($_REQUEST['menu-item-icon']) ) {
			if( isset($_REQUEST['menu-item-icon'][$menu_item_db_id]) ) {
				$icon_value = $_REQUEST['menu-item-icon'][$menu_item_db_id];
				update_post_meta( $menu_item_db_id, '_menu_item_icon', $icon_value );
			}
			
			
			//$color_value = $_REQUEST['menu-item-color'][$menu_item_db_id];
	        //update_post_meta( $menu_item_db_id, '_menu_item_color', $color_value );
			
			//$bgimage_value = $_REQUEST['menu-item-bgimage'][$menu_item_db_id];
	        //update_post_meta( $menu_item_db_id, '_menu_item_bgimage', $bgimage_value );
	    }
	    
	}
	
	/**
	 * Define new Walker edit
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function kwayy_edit_walker($walker,$menu_id) {
	
	    return 'Kwayy_Walker_Nav_Menu_Edit';
	    
	}

}

// instantiate plugin's class
$GLOBALS['sweet_custom_menu'] = new kwayy_custom_menus_icon();


include_once( 'edit_custom_walker.php' );
include_once( 'custom_walker.php' );
