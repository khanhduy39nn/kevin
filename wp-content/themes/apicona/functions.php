<?php
/**
 * Apicona functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */

/*
 * Set up the content width value based on the theme's design.
 *
 * @see apicona_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) ){
	$content_width = 727;
}

/**
 * Apicona only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6-alpha', '<' ) ){
	require get_template_directory() . '/inc/back-compat.php';
}


/*
 * Some functions that help to achive small functionality
 */
require_once('inc/tools.php');



/*
 * Ajax call for MIN file generator
 */
require_once('inc/redux-framework/redux_custom_fields/kwayy_min_generator/field_kwayy_min_generator_ajax.php');




/*
 * Move position of "Add to Cart" button from SHOP page in WooCommerce
 */
if( !function_exists('tm_wc_move_loop_button') ){
function tm_wc_move_loop_button(){
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10 );
}
}
if( function_exists('is_woocommerce') ){
	add_action('init','tm_wc_move_loop_button');
}



// Hook on Redux Save
add_action('redux/options/apicona/validate',      'tm_regenerate_dynamic_css');
add_action('redux/options/apicona/reset',         'tm_regenerate_dynamic_css_reset');
add_action('redux/options/apicona/section/reset', 'tm_regenerate_dynamic_css_reset');
function tm_regenerate_dynamic_css_reset($val){
	tm_regenerate_dynamic_css($val->options);
}


/*
 * Generate dynamic style CSS file on REDUX options are saved.
 */
function tm_redux_save(){
	
	
	// Checking if the dynamic-style.php edit.. If yes than re-generate dynamic-style.css files.
	$dynamicFile  = get_template_directory().'/css/dynamic-style.php';
	$styleFile    = get_template_directory().'/css/dynamic-style.css';
	$styleMinFile = get_template_directory().'/css/dynamic-style.min.css';
	
	// Getting current file in MD5
	$dynamicFileMD5 = md5_file( $dynamicFile );
	
	// Getting value of MD5
	$dynamic_generated = get_option('tm_dynamicstyle_generated');
	
	// Getting Current theme version
	$my_theme = wp_get_theme( 'apicona' );
	$currentThemeVersion = $my_theme->get( 'Version' );
	$storedThemeVersion  = get_option('tm_apicona_version');
	
	// Checking if theme updated
	$regenerateDynamicCSS = false;
	if($dynamic_generated!=$dynamicFileMD5){
		$regenerateDynamicCSS = true;
	}
	if( ($currentThemeVersion!=$storedThemeVersion) && is_array($howes) && count($howes)>0 ){
		tm_reset_tgm_infobox(); // Restting TGM notification box to show if user need to update VC or other plugin
		$regenerateDynamicCSS = true;
		update_option('tm_apicona_version', $currentThemeVersion);
	}
	

	
	// checking and running the dynamic-style.css generator
	if( !file_exists( $styleFile ) || !file_exists( $styleFile ) || $regenerateDynamicCSS==true ){
		tm_regenerate_dynamic_css();
	}
	
	// Updating
	update_option('tm_dynamicstyle_generated', $dynamicFileMD5);
	
}
function tm_regenerate_dynamic_css($val='') {
	//var_dump($val);
	// Overwriting global variable with latest values. By default, currently you will get old data from $apicona variable.
	if( $val!='' && is_array($val) ){
		global $apicona;
		$apicona = $val;
		
		// For reset only
		if( !isset($apicona['compiler']) ){
			$apicona['compiler'] = '';
		}
		if( !isset($apicona['redux-section']) ){
			$apicona['redux-section'] = '0';
		}
		if( !isset($apicona['import_code']) ){
			$apicona['import_code'] = '';
		}
		if( !isset($apicona['import_link']) ){
			$apicona['import_link'] = '';
		}
	
	}
	// Getting dynamic-style.php data
	ob_start();
	$apicona['dynamic-style-position']='internal';
	include('css/dynamic-style.php');
	$csscode = ob_get_clean();
	
	// Writing dynamic-style.css
	file_put_contents( get_template_directory().'/css/dynamic-style.css',$csscode);
	
	// Generating MIN version
	$css_array = array();
	$css_array[get_template_directory().'/css/dynamic-style.css'] = get_template_directory().'/css/dynamic-style.min.css';
	
	ob_start();
	tm_minifier('css',$css_array);
	ob_get_clean();
	
	
}
add_action('init','tm_redux_save');


/*
 *  This function will reset the TGM Activation message box to show if user need to update any plugin or not. This function will call after theme version changed.
 */
function tm_reset_tgm_infobox(){
	//update_user_meta( $user_id, $meta_key, $meta_value, $prev_value );
	update_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice_tgmpa', '0' );
}



/*
 * This will override the default "skin color" set in the page directly.
 */
if( !function_exists('tm_page_change_skincolor') ){
function tm_page_change_skincolor(){
	if( is_page() ){
		global $post;
		global $apicona;
		$skincolor = trim( get_post_meta( $post-ID, '_kwayy_page_customize_skincolor', true ) );
		if($skincolor!=''){
			$apicona['skincolor']=$skincolor;
		}
	}
}
}
add_action('init','tm_page_change_skincolor');




/**
 * To make Breadcrumb NavXT plugin to WPML Ready 
 */
if(function_exists('bcn_display')){
	//Hook into the Breadcrumb NavXT title filter, want the 4.2+ version with 2 args
	add_filter('bcn_breadcrumb_title', 'bcn_ext_title_translater', 10, 2);
	/**
	 * This function is a filter for the bcn_breadcrumb_title filter, it runs through
	 * the SitePress::the_category_name_filter function
	 * 
	 * @param string $title The title to be filtered (translated)
	 * @param array $context The breadcrumb type array
	 * @return string The string filtered through SitePress::the_category_name_filter
	 */
	function bcn_ext_title_translater($title, $context){
		//Need to make sure we have a taxonomy and that the SitePress object is available
		if(is_array($context) && isset($context[0]) && taxonomy_exists($context[0]) && class_exists('SitePress')){
			//This may be a little dangerous due to the internal recursive calls for the function
			$title = SitePress::the_category_name_filter($title);
		}
        if($title=="NHA KHOA PHÚ THỌ")
        {
            $title='';
        }
		return $title;
	}
}




add_action('admin_init', 'tm_change_maxmegamenu_setting');
function tm_change_maxmegamenu_setting() {
	
	global $apicona;
	$breakpoint = '1200';
	if( isset($apicona['menu_breakpoint']) && isset($apicona['menu_breakpoint_custom']) ){
		if( $apicona['menu_breakpoint']=='custom' ){
			$breakpoint = $apicona['menu_breakpoint_custom'];
		} else {
			$breakpoint = $apicona['menu_breakpoint'];
		}
	}
	
	
	$themes['default'] = array(
            'title'                                     => __("Default", "apicona"),
            'container_background_from'                 => '#222',
            'container_background_to'                   => '#222',
            'container_padding_left'                    => '0px',
            'container_padding_right'                   => '0px',
            'container_padding_top'                     => '0px',
            'container_padding_bottom'                  => '0px',
            'container_border_radius_top_left'          => '0px',
            'container_border_radius_top_right'         => '0px',
            'container_border_radius_bottom_left'       => '0px',
            'container_border_radius_bottom_right'      => '0px',
            'arrow_up'                                  => 'dash-f142',
            'arrow_down'                                => 'dash-f140',
            'arrow_left'                                => 'dash-f141',
            'arrow_right'                               => 'dash-f139',
            'menu_item_background_from'                 => 'transparent',
            'menu_item_background_to'                   => 'transparent',
            'menu_item_background_hover_from'           => '#333',
            'menu_item_background_hover_to'             => '#333',
            'menu_item_spacing'                         => '0px',
            'menu_item_link_font'                       => 'inherit',
            'menu_item_link_font_size'                  => '14px',
            'menu_item_link_height'                     => '40px',
            'menu_item_link_color'                      => '#ffffff',
            'menu_item_link_weight'                     => 'normal',
            'menu_item_link_text_transform'             => 'normal',
            'menu_item_link_color_hover'                => '#ffffff',
            'menu_item_link_weight_hover'               => 'normal',
            'menu_item_link_padding_left'               => '10px',
            'menu_item_link_padding_right'              => '10px',
            'menu_item_link_padding_top'                => '0px',
            'menu_item_link_padding_bottom'             => '0px',
            'menu_item_link_border_radius_top_left'     => '0px',
            'menu_item_link_border_radius_top_right'    => '0px',
            'menu_item_link_border_radius_bottom_left'  => '0px',
            'menu_item_link_border_radius_bottom_right' => '0px',
            'panel_background_from'                     => '#f1f1f1',
            'panel_background_to'                       => '#f1f1f1',
            'panel_width'                               => '100%',
			'panel_border_color'                        => '#fff',
            'panel_border_left'                         => '0px',
            'panel_border_right'                        => '0px',
            'panel_border_top'                          => '0px',
            'panel_border_bottom'                       => '0px',
            'panel_border_radius_top_left'              => '0px',
            'panel_border_radius_top_right'             => '0px',
            'panel_border_radius_bottom_left'           => '0px',
            'panel_border_radius_bottom_right'          => '0px',
            'panel_header_color'                        => '#555',
            'panel_header_text_transform'               => 'uppercase',
            'panel_header_font'                         => 'inherit',
            'panel_header_font_size'                    => '16px',
            'panel_header_font_weight'                  => 'bold',
            'panel_header_padding_top'                  => '0px',
            'panel_header_padding_right'                => '0px',
            'panel_header_padding_bottom'               => '5px',
            'panel_header_padding_left'                 => '0px',
            'panel_padding_left'                        => '0px',
            'panel_padding_right'                       => '0px',
            'panel_padding_top'                         => '0px',
            'panel_padding_bottom'                      => '0px',
            'panel_widget_padding_left'                 => '15px',
            'panel_widget_padding_right'                => '15px',
            'panel_widget_padding_top'                  => '15px',
            'panel_widget_padding_bottom'               => '15px',
            'flyout_width'                              => '150px',
			'flyout_border_color'                        => '#ffffff',
            'flyout_border_left'                         => '0px',
            'flyout_border_right'                        => '0px',
            'flyout_border_top'                          => '0px',
            'flyout_border_bottom'                       => '0px',
            'flyout_link_padding_left'                  => '10px',
            'flyout_link_padding_right'                 => '10px',
            'flyout_link_padding_top'                   => '0px',
            'flyout_link_padding_bottom'                => '0px',
            'flyout_link_weight'                        => 'normal',
            'flyout_link_weight_hover'                  => 'normal',
            'flyout_link_height'                        => '35px',
            'flyout_background_from'                    => '#f1f1f1',
            'flyout_background_to'                      => '#f1f1f1',
            'flyout_background_hover_from'              => '#dddddd',
            'flyout_background_hover_to'                => '#dddddd',
            'font_size'                                 => '14px',
            'font_color'                                => '#666',
            'font_family'                               => 'inherit',
            'responsive_breakpoint'                     => $breakpoint.'px',
            'line_height'                               => '1.7',
            'z_index'                                   => '999',
            'custom_css'                                => '
#{$wrap} #{$menu} {
    /** Custom styles should be added below this line **/
}
#{$wrap} { 
    clear: both;
}'
        );
		
	$megamenu_themes = get_option('megamenu_themes');
	//var_dump($megamenu_themes);
	if( is_array($megamenu_themes) && isset($megamenu_themes["default"]['responsive_breakpoint']) ){
		if( $megamenu_themes["default"]['responsive_breakpoint'] != $breakpoint.'px' ){
			$megamenu_themes["default"]['responsive_breakpoint'] = $breakpoint.'px';
			update_option('megamenu_themes', $megamenu_themes);
			
			// Generate Cache CSS of MaxMegaMenu
			if( class_exists('Mega_Menu_Style_Manager') ){
				$Mega_Menu_Style_Manager = new Mega_Menu_Style_Manager;
				$Mega_Menu_Style_Manager->generate_css( 'scss_formatter_compressed' );
			}
		}
	} else {
		update_option('megamenu_themes', $themes);
		
		// Generate Cache CSS of MaxMegaMenu
		if( class_exists('Mega_Menu_Style_Manager') ){
			$Mega_Menu_Style_Manager = new Mega_Menu_Style_Manager;
			$Mega_Menu_Style_Manager->generate_css( 'scss_formatter_compressed' );
		}
	}
	
	
}



/*
 * Team Member search: redirect to archive-search.php
 */
/*function kwayy_template_chooser($template){
	global $wp_query;
	$post_type = get_query_var('post_type');
	if( $wp_query->is_search && $post_type == 'team_member' ){
		return locate_template('archive-team_member.php');
	}
	return $template;
}
add_filter('template_include', 'kwayy_template_chooser');*/



/*
 * Custom option in taxonomy
 */
//include_once('inc/taxonomy-metadata.php');






/*
 * Function to get count of total sidebar
 */
function thememount_get_widgets_count( $sidebar_id ){
	$sidebars_widgets = wp_get_sidebars_widgets();
	if( isset($sidebars_widgets[ $sidebar_id ]) ){
		return (int) count( (array) $sidebars_widgets[ $sidebar_id ] );
	}
}
function thememount_class_for_widgets_count( $count=0 ){
	$return = '';
	if( $count<1 ){ $count = 1; }
	if( $count>4 ){ $count = 4; }
	switch( $count ){
		case 1:
			$return = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
			break;
		case 2:
			$return = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
			break;
		case 3:
			$return = 'col-xs-12 col-sm-6 col-md-4 col-lg-4';
			break;
		case 4:
			$return = 'col-xs-12 col-sm-6 col-md-3 col-lg-3';
			break;
	}
	return $return;
}






/*
 * Wrap DIV to the Read More link in blog
 */
function kwayy_wrap_readmore($more_link) {
    return '<div class="kwayy-post-readmore">'.$more_link.'</div>';
}
add_filter('the_content_more_link', 'kwayy_wrap_readmore', 10, 1);


/*
 * Shortcode list and their calls
 */
$shortcodeList = array(
	'blogbox',
	'clients',
	'contactbox',
	'current-year',
	'facts_in_digits',
	'heading',
	'icon',
	'icontext',
	'kwayyiconseparator',
	'kwayy-social-links',
	'portfoliobox',
	'eventsbox',
	'servicebox',
	'site-tagline',
	'site-title',
	'site-url',
	'skincolor',
	'team',
	'testimonial',
	'twitterbox',
	'languageswitcher',
);
foreach( $shortcodeList as $shortcode ){
	include_once('inc/shortcodes/'.$shortcode.'.php');
}



	

/*
 * Disable dynamic style and echo all style in header
 */
add_action( 'init', 'kwayy_dynamic_style' );
function kwayy_dynamic_style(){
	global $apicona;
	if( isset($apicona['dynamic-style-position']) && $apicona['dynamic-style-position']=='internal' ){
		add_action('wp_head','kwayy_hook_dynamic_css');
	}
}
function kwayy_hook_dynamic_css(){
	/* Fetching dynamic-style.php output and store in a variable */
	ob_start(); // begin collecting output
	include get_template_directory().'/css/dynamic-style.php';
	$css    = ob_get_clean(); // retrieve output from myfile.php, stop buffering
	
	/* Now add the dynamic-style.php style in header */
	$output = "<style> $css </style>";
	echo $output;
}



/*
 *  Dynamic content linking with JS code. Declaring variables.
 */
add_action('wp_head','thememount_js_vars');
function thememount_js_vars(){
	global $apicona;
	$breakpoint = ( isset($apicona['menu_breakpoint']) && trim($apicona['menu_breakpoint'])!='' ) ? trim($apicona['menu_breakpoint']) : '1200' ;
	?>
	
	<script type="text/javascript">
		var tm_breakpoint = <?php echo $breakpoint ?>;
	</script>
	
	<?php
}



/*
 * Add some special classes on <body> tag.
 */
if( !function_exists('kwayy_body_classes') ){
function kwayy_body_classes($bodyClass){
	global $apicona;
	//Responsive ON / OFF
	if($apicona['responsive']=='1'){
		$bodyClass[] = 'kwayy-responsive-on';
	} else {
		$bodyClass[] = 'kwayy-responsive-off';
	}

	// Sticky Fotoer ON/OFF
	if( isset($apicona['stickyfooter']) && $apicona['stickyfooter']=='1' ){
		$bodyClass[] = 'kwayy-sticky-footer';
	}

	// Boxed / Wide
	if( trim($apicona['layout'])!='' ){
		$bodyClass[] = 'kwayy-'.trim($apicona['layout']);
	} else {
		$bodyClass[] = 'kwayy-wide';
	}
	
	// Header Style
	$headerstyle        = '';
	$headerstyle_global = '';
	$headerstyle_page   = '';
	if( isset($apicona['headerstyle']) && trim($apicona['headerstyle'])!='' ){
		$headerstyle_global = trim($apicona['headerstyle']);
	}
	if( is_page() ){
		$headerstyle_page = trim(get_post_meta(get_the_ID(), 'headerstyle', true));
	}
	if( $headerstyle_page!='' ){
		$headerstyle = $headerstyle_page;
	} else {
		$headerstyle = $headerstyle_global;
	}
	
	if( $headerstyle=='4' ){
		$bodyClass[] = 'kwayy-header-style-1 tm-header-invert';
	} else {
		$bodyClass[] = 'kwayy-header-style-'.trim($headerstyle);
	}
	
	

	// Sidebar Class
	$sidebar = $apicona['sidebar_page']; // Global settings
	if( (is_page()) ){
		$sidebarposition = get_post_meta( get_the_ID(), '_kwayy_page_options_sidebarposition', true);
		if( is_array($sidebarposition) ){ $sidebarposition = $sidebarposition[0]; } // Converting to String if Array
		// Page settings
		if( trim($sidebarposition) != '' ){
			$sidebar = $sidebarposition;
		}
	}
	if( (is_home()) || is_single() ){
		
		$pageid   = get_option('page_for_posts');
		$postType = 'page';
		if( is_single() ){
			global $post;
			$pageid   = $post->ID;
			$postType = 'post';
		}
		
		$sidebarposition = get_post_meta( $pageid, '_kwayy_'.$postType.'_options_sidebarposition', true);
		if( is_array($sidebarposition) ){ $sidebarposition = $sidebarposition[0]; } // Converting to String if Array
		// Page settings
		if( trim($sidebarposition) != '' ){
			$sidebar = $sidebarposition;
		}
	}
	
	// BBPress sidebar class
	if( function_exists('is_bbpress') && is_bbpress() ) {
		$sidebar = isset($apicona['sidebar_bbpress']) ? $apicona['sidebar_bbpress'] : 'right' ;
	}
	
	if( $sidebar=='no' ){
		// The page is full width
		$bodyClass[] = 'kwayy-page-full-width';
	} else {
		// Sidebar class for border
		$bodyClass[] = 'kwayy-sidebar-'.$sidebar;
	}

	return $bodyClass;
}
}
add_filter('body_class', 'kwayy_body_classes');



function kwayy_getCSS( $value = array() ) {

	$css = '';

	if ( ! empty( $value ) && is_array( $value ) ) {
		foreach ( $value as $key => $value ) {
			if ( ! empty( $value ) && $key != "media" ) {
				if ( $key == "background-image" ) {
					$css .= $key . ":url('" . $value . "');";
				} else {
					$css .= $key . ":" . $value . ";";
				}
			}
		}
	}

	return $css;
}











/*
 * Login page stylesheet
 */
function kwayy_custom_login_css() {
	global $apicona;
	$bg_size = '';
	
	// Custom CSS Code for login page only
	$login_custom_css_code = '';
	if( isset($apicona['login_custom_css_code']) && trim($apicona['login_custom_css_code'])!='' ){
		$login_custom_css_code = $apicona['login_custom_css_code'];
	}
	
	// Login page background CSS style
	$bgStyle = kwayy_getCSS($apicona['login_background']);
	
	$cssCode  = '';
	$cssCode2 = '';
	
	if( !empty($bgStyle) ){
		$cssCode .= 'body.login{'.$bgStyle.'}';
	}
	
	
	
	
	
	if( isset($apicona['logoimg']["url"]) && trim($apicona['logoimg']["url"])!='' ){
		$cssCode2 .= 'background: transparent url("'.$apicona['logoimg']["url"].'") no-repeat center center;';
	}
	
	if( isset($apicona['logoimg']["width"]) && trim($apicona['logoimg']["width"])!='' ){
		if( $apicona['logoimg']["width"] > 320 ){
			$cssCode2 .= 'width: 320px;';
		} else {
			$cssCode2 .= 'width: '.$apicona['logoimg']["width"].'px;';
		}
	}
	
	if( isset($apicona['logoimg']["height"]) && trim($apicona['logoimg']["height"])!='' ){
		// 320px : max-width
		$width  = $apicona['logoimg']["width"];
		$height = $apicona['logoimg']["height"];
		if( $width > 320 ){
			$bg_size   = 'background-size: 100%;';
			$newheight = ceil( ($height / $width) * 320 );
		} else {
			$newheight = $height;
		}
		
		$cssCode2 .= 'height: '.$newheight.'px;';
	}
	
	// Submit button to skin color
	$otherCSS = '.wp-core-ui #login .button-primary{ background: '.$apicona['skincolor'].';}';
	
	
	echo '<style>
		.login #login form{background-color: #f7f7f7; box-shadow: none;}
		'.$cssCode.'
		.login #login h1 a{
			'.$cssCode2.'
			'.$bg_size.'
			/*max-width:100%;*/
		}
		'.$otherCSS.'
		'.$login_custom_css_code.'
		
		
		.wp-core-ui .button-primary{
			background: #1abc9c;
			height: 34px;	
			padding: 0 18px 2px;
			box-shadow: none;
			border: none;
			-webkit-transition: all 0.2s ease-in-out;
			-moz-transition: all 0.2s ease-in-out;
			-o-transition: all 0.2s ease-in-out;
			-ms-transition: all 0.2s ease-in-out;
			transition: all 0.2s ease-in-out;
		}
		.wp-core-ui #login .button-primary.focus, .wp-core-ui .button-primary:focus{
			box-shadow: none;
			border: none;
		}
		.wp-core-ui #login .button-primary.focus, .wp-core-ui #login .button-primary.hover, .wp-core-ui #login .button-primary:focus, .wp-core-ui #login .button-primary:hover, .wp-core-ui #login .button-primary:hover{
			background: #333;
		}
		</style>';
}
add_action('login_head', 'kwayy_custom_login_css');



















/*
 * Login page stylesheet
 */
/*function kwayy_custom_login_css() {
	global $apicona;
	
	// Custom CSS Code for login page only
	$login_custom_css_code = '';
	if( isset($apicona['login_custom_css_code']) && trim($apicona['login_custom_css_code'])!='' ){
		$login_custom_css_code = $apicona['login_custom_css_code'];
	}
	
	// Login page background CSS style
	$bgStyle = kwayy_getCSS($apicona['login_background']);
	
	$cssCode  = '';
	$cssCode2 = '';
	
	if( !empty($bgStyle) ){
		$cssCode .= 'body.login{'.$bgStyle.'}';
	}
	
	if( isset($apicona['logoimg']["url"]) && trim($apicona['logoimg']["url"])!='' ){
		$cssCode2 .= 'background-image: url("'.$apicona['logoimg']["url"].'");';
	}
	
	if( isset($apicona['logoimg']["width"]) && trim($apicona['logoimg']["width"])!='' ){
		$cssCode2 .= 'width: '.$apicona['logoimg']["width"].'px;';
	}
	
	if( isset($apicona['logoimg']["height"]) && trim($apicona['logoimg']["height"])!='' ){
		$cssCode2 .= 'height: '.$apicona['logoimg']["height"].'px;';
	}
	
	
	
	echo '<style>
		.login #login form{background-color: #f7f7f7; box-shadow: none;}
		'.$cssCode.'
		.login #login h1 a{
			'.$cssCode2.'
			background-size: 100%;
			max-width:100%;
		}
		'.$login_custom_css_code.'
		</style>';
}
add_action('login_head', 'kwayy_custom_login_css');
*/





/**
 * Login page logo link
 */
function tm_loginpage_custom_link() {
	return esc_url( home_url( '/' ) );
}
add_filter('login_headerurl','tm_loginpage_custom_link');


/**
 * Login page logo link title
 */
function tm_change_title_on_logo() {
	return esc_attr( get_bloginfo( 'name', 'display' ) );
}
add_filter('login_headertitle', 'tm_change_title_on_logo');






/**
 * Apicona setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Apicona supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Apicona 1.0
 *
 * @return void
 */
function apicona_setup() {
	/*
	 * Makes Apicona available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Apicona, use a find and
	 * replace to change 'apicona' to the name of your theme in all
	 * template files.
	 */
	$parentPath = dirname( get_template_directory() ).'/apicona-languages';
	if (file_exists($parentPath)) {
		load_theme_textdomain( 'apicona', $parentPath );
	} else {
		load_theme_textdomain( 'apicona', get_template_directory() . '/languages' );
	}
	

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	
	// Adding WooCommerce Support
	add_theme_support( 'woocommerce' );

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'apicona' ) );
	register_nav_menu( 'footer' , __( 'Footer Menu', 'apicona' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 727, 409, true );
	
	// Adding Image sizes
	/*add_image_size( 'portfolio-two-column',   1110, 624, true );
	add_image_size( 'portfolio-three-column', 720, 406, true );
	add_image_size( 'portfolio-four-column',  526, 296, true );
	add_image_size( 'woocommerce-catalog',    520, 520, true );
	add_image_size( 'woocommerce-single',     800, 800, true );
	add_image_size( 'woocommerce-thumbnail',  120, 120, true );*/
	
	
	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
	
	// Run Shortcode in Widget Title
	add_filter('widget_title', 'do_shortcode');
	
	// Run Shortcode in text widget
	add_filter('widget_text', 'do_shortcode');
	
	
	// CF Post Format
	// include_once('inc/plugins/cf-post-formats/cf-post-formats.php');
	
	
	// Widgets
	include_once('inc/widgets/kwayyWidgetRecentPosts.php');
	include_once('inc/widgets/kwayyWidgetFlickr.php');
	include_once('inc/widgets/kwayyWidgetContact.php');
	//include_once('inc/widgets/kwayyWidgetTabs.php');

}
add_action( 'after_setup_theme', 'apicona_setup' );






/*
 *  Check if MIN css or not
 */
function thememount_min_css(){
	global $apicona;
	
	// Checking if MIN enabled
	if(!is_admin()) {
		if( isset($apicona['minify-css-js']) && $apicona['minify-css-js']=='0' ){
			define('TM_MIN', '');
		} else {
			define('TM_MIN', '.min');
		}
	}
}
add_action( 'init', 'thememount_min_css' );



/*
 *  Adding Image sizes
 */
function thememount_imag_sizes(){
	
	global $apicona;
	
	$img_array = array(
		'portfolio-two-column',
		'portfolio-three-column',
		'portfolio-four-column',
		'blog-two-column',
		'blog-three-column',
		'blog-four-column',
		/*'woocommerce-catalog',
		'woocommerce-single',
		'woocommerce-thumbnail'*/
	);
	foreach($img_array as $imgsize){
		$size = array( 'width' => 1110, 'height' => 624, 'crop' => true );
		
		if( $imgsize == 'portfolio-two-column' || $imgsize == 'blog-two-column' ){ // Portfolio - Two Column
			$size = array( 'width' => 1110, 'height' => 624, 'crop' => true );
		
		} else if( $imgsize == 'portfolio-three-column' || $imgsize == 'blog-three-column' ){ // Portfolio - Three Column
			$size = array( 'width' => 720, 'height' => 406, 'crop' => true );
			
		} else if( $imgsize == 'portfolio-four-column' || $imgsize == 'blog-four-column' ){ // Portfolio - Four Column
			$size = array( 'width' => 750, 'height' => 422, 'crop' => true );
		
		/*} else if( $imgsize == 'woocommerce-catalog' ){  // WooCommerce - Catalog
			$size = array( 'width' => 520, 'height' => 520, 'crop' => true );
			
		} else if( $imgsize == 'woocommerce-single' ){ // WooCommerce - Single
			$size = array( 'width' => 800, 'height' => 800, 'crop' => true );
			
		} else if( $imgsize == 'woocommerce-thumbnail' ){ // WooCommerce - Thumb
			$size = array( 'width' => 120, 'height' => 120, 'crop' => true );*/
		
		}
		
		// Getting redux value
		if( isset($apicona['img-'.$imgsize]) && is_array($apicona['img-'.$imgsize]) ){
			$size = $apicona['img-'.$imgsize];
		}
		
		// Convrting to Boolean
		if( $size['crop']=='no' ){
			$size['crop'] = false;
		} else {
			$size['crop'] = true;
		}
		
		add_image_size( $imgsize,   $size['width'], $size['height'], $size['crop'] );
		
	}
	
	/*add_image_size( 'portfolio-two-column',   1110, 624, true );
	add_image_size( 'portfolio-three-column', 720, 406, true );
	add_image_size( 'portfolio-four-column',  750, 422, true );
	add_image_size( 'woocommerce-catalog',    520, 520, true );
	add_image_size( 'woocommerce-single',     800, 800, true );
	add_image_size( 'woocommerce-thumbnail',  120, 120, true );*/
	
}
add_action( 'init', 'thememount_imag_sizes' );







// Visual Composer Theme integration
add_action( 'init', 'kwayy_vcSetAsTheme' );
add_action( 'vc_before_init', 'kwayy_vcSetAsTheme' );
function kwayy_vcSetAsTheme() {
	if( function_exists('vc_set_as_theme') ){ vc_set_as_theme(true); }
	if( function_exists('vc_set_default_editor_post_types') ){ vc_set_default_editor_post_types(array('page', 'portfolio', 'team_member')); }
}
// Slider Revoluiton Theme integration

add_action( 'init', 'kwayy_set_rs_as_theme' );
function kwayy_set_rs_as_theme() {
	// Setting options to hide Revoluiton Slider message
	if(get_option('revSliderAsTheme') != 'true'){
		update_option('revSliderAsTheme', 'true');
	}
	if(get_option('revslider-valid-notice') != 'false'){
		update_option('revslider-valid-notice', 'false');
	}
	if( function_exists('set_revslider_as_theme') ){	
		set_revslider_as_theme();
	}
}





/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Apicona 1.0
 *
 * @return void
 */
function apicona_scripts_styles() {
	global $apicona;
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
		wp_enqueue_script( 'comment-reply' );
	}
	
	/*
	 * Adds RTL CSS file
	 */
	if ( is_rtl() ) {
		wp_enqueue_style(  'apicona-rtl',  get_template_directory_uri() . '/rtl'.TM_MIN.'.css' );
	}
	
	// Add page translation effect
	if( isset($apicona['pagetranslation']) && $apicona['pagetranslation']!='no'){
		wp_enqueue_script( 'animsition', get_template_directory_uri() . '/js/jquery.animsition'.TM_MIN.'.js', array( 'jquery' ) );
		wp_enqueue_style( 'animsition', get_template_directory_uri() . '/css/animsition'.TM_MIN.'.css' );
	}
	
	// Loads JavaScript file with functionality specific to Apicona.
	wp_enqueue_script( 'apicona-script', get_template_directory_uri() . '/js/functions'.TM_MIN.'.js', array( 'jquery', 'isotope' ), '2013-07-18', true );
	
	// Hover effect
	wp_enqueue_style( 'hover', get_template_directory_uri() . '/css/hover'.TM_MIN.'.css' );
	
	// IsoTope
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope'.TM_MIN.'.js', array( 'jquery' ) );
	
	// Flex Slider
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider'.TM_MIN.'.js', array( 'jquery' ) );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider'.TM_MIN.'.css' );
	
	// Tooltip
	wp_enqueue_script( 'bootstrap-tooltip', get_template_directory_uri() . '/js/bootstrap-tooltip'.TM_MIN.'.js', array( 'jquery', 'apicona-script' ) );
	
	// Sticky
	if( $apicona['stickyheader']=='y' ){
		wp_enqueue_script( 'sticky', get_template_directory_uri() . '/js/jquery.sticky'.TM_MIN.'.js', array( 'jquery' ) );
	}
	
	// Load font icon library CSS files
	if( isset($apicona['fonticonlibrary']) && is_array($apicona['fonticonlibrary']) && count($apicona['fonticonlibrary'])>0 ){
		foreach( $apicona['fonticonlibrary'] as $library=>$val ){
			if( $library!='fontawesome' ){
				if( $val == '1' ){
					wp_enqueue_style( $library, get_template_directory_uri() . '/css/fonticon-library/'.$library.'/css/kwayy-'.$library.TM_MIN.'.css' );
				}
				
			}
		}
	}
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/fonticon-library/font-awesome/css/kwayy-font-awesome'.TM_MIN.'.css' ); // Font Awesome
	
	// Nivo Slider
	wp_enqueue_script( 'nivo-slider', get_template_directory_uri() . '/js/jquery.nivo.slider'.TM_MIN.'.js', array( 'jquery' ) );
	wp_enqueue_style( 'nivo-slider-css', get_template_directory_uri() . '/css/nivo-slider'.TM_MIN.'.css' );
	wp_enqueue_style( 'nivo-slider-theme', get_template_directory_uri() . '/css/nivo-default'.TM_MIN.'.css' );
	
	// Numinate plugin
	if ( !wp_script_is( 'waypoints', 'registered' ) ) { // If Waypoints library is not registered
		wp_register_script( 'waypoints', get_template_directory_uri() . '/js/waypoints'.TM_MIN.'.js', array( 'jquery' ) );
	}
	wp_register_script( 'numinate', get_template_directory_uri() . '/js/numinate.1.0.1'.TM_MIN.'.js', array( 'jquery' ) );
	
	// owl carousel CSS
	/*if( wp_style_is('vc_pageable_owl-carousel-css','registered') ){
		wp_enqueue_style( 'vc_pageable_owl-carousel-css' );
	} else {
		if( file_exists(WP_PLUGIN_DIR.'/js_composer/assets/lib/owl-carousel2-dist/assets/owl.carousel.css') ){
			wp_enqueue_style( 'vc_pageable_owl-carousel-css', plugins_url().'/js_composer/assets/lib/owl-carousel2-dist/assets/owl.carousel.css' );
		} else {
			wp_enqueue_style( 'vc_pageable_owl-carousel-css', get_template_directory_uri() . '/css/owl.carousel.css' );
		}
	}*/
	if( wp_style_is('vc_pageable_owl-carousel-css','registered') ){
		wp_enqueue_style( 'vc_pageable_owl-carousel-css' );
	} else {
		wp_enqueue_style( 'vc_pageable_owl-carousel-css', get_template_directory_uri() . '/css/owl.carousel'.TM_MIN.'.css' );
	}
	
	
	// owl carousel JS
	/*if( wp_script_is('vc_pageable_owl-carousel','registered') ){
		wp_enqueue_script( 'vc_pageable_owl-carousel' );
	} else {
		if( file_exists(WP_PLUGIN_DIR.'/js_composer/assets/lib/owl-carousel2-dist/owl.carousel.min.js') ){
			wp_enqueue_script( 'vc_pageable_owl-carousel', plugins_url().'/js_composer/assets/lib/owl-carousel2-dist/owl.carousel.min.js' );
		} else {
			wp_enqueue_script( 'vc_pageable_owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js' );
		}
	}*/
	if( wp_script_is('vc_pageable_owl-carousel','registered') ){
		wp_enqueue_script( 'vc_pageable_owl-carousel' );
	} else {
		wp_enqueue_script( 'vc_pageable_owl-carousel', get_template_directory_uri() . '/js/owl.carousel'.TM_MIN.'.js' );
	}
	 
	
	
	
	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'apicona-ie', get_template_directory_uri() . '/css/ie'.TM_MIN.'.css' );
	wp_style_add_data( 'apicona-ie', 'conditional', 'lt IE 9' );
	
	// Swipebox
	wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto'.TM_MIN.'.js', array( 'jquery' ) );
	wp_enqueue_style( 'prettyphoto', get_template_directory_uri() . '/css/prettyPhoto'.TM_MIN.'.css' );
	
	// Pace Loader
	//wp_enqueue_script( 'pace', get_template_directory_uri() . '/js/pace'.TM_MIN.'.js', array( 'jquery' ) );
	//wp_enqueue_style( 'pace', get_template_directory_uri() . '/css/prettyPhoto'.TM_MIN.'.css' );
	
	global $apicona;
	if( isset($apicona['scroller_enable']) ){
		if( $apicona['scroller_enable']=='1'){
			// NiceScroll
			wp_enqueue_script( 'nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll'.TM_MIN.'.js', array( 'jquery' ) );
			wp_enqueue_script( 'nicescroll-plus', get_template_directory_uri() . '/js/jquery.nicescroll.plus'.TM_MIN.'.js', array( 'jquery' , 'nicescroll' ) );
		} else if( $apicona['scroller_enable']=='2'){
			// SmoothScroll
			wp_enqueue_script( 'SmoothScroll', get_template_directory_uri() . '/js/SmoothScroll'.TM_MIN.'.js', array( 'jquery' ) );
		}
	}
	
}
add_action( 'wp_enqueue_scripts', 'apicona_scripts_styles', 10 );




function apicona_scripts_styles_14() {
	/*@import url("css/bootstrap.css");
	@import url("css/multi-columns-row.css");
	@import url("css/bootstrap-theme.css");
	*/

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap'.TM_MIN.'.css' );
	wp_enqueue_style( 'multi-columns-row', get_template_directory_uri() . '/css/multi-columns-row'.TM_MIN.'.css', array('bootstrap') );
	wp_enqueue_style( 'bootstrap-theme', get_template_directory_uri() . '/css/bootstrap-theme'.TM_MIN.'.css', array('bootstrap') );
}
add_action( 'wp_enqueue_scripts', 'apicona_scripts_styles_14', 14 );




function apicona_scripts_styles_15() {
	if( defined( 'WPB_VC_VERSION' ) ){
		wp_enqueue_style( 'apicona-main-style', get_stylesheet_directory_uri() . '/style'.TM_MIN.'.css' , array('js_composer_front') );
	} else {
		wp_enqueue_style( 'apicona-main-style', get_stylesheet_directory_uri() . '/style'.TM_MIN.'.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'apicona_scripts_styles_15', 15 );


function apicona_scripts_styles_16() {
	global $apicona;
	// Dynamic Stylesheet
	if( isset($apicona['dynamic-style-position']) && $apicona['dynamic-style-position']=='internal' ){
		// Do nothing
	} else {
		wp_enqueue_style( 'apicona-dynamic-style', get_template_directory_uri() . '/css/dynamic-style'.TM_MIN.'.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'apicona_scripts_styles_16', 16 );


function apicona_scripts_styles_17() {
	// Responsive
	global $apicona;
	
	if($apicona['responsive']=='1'){
		wp_enqueue_style( 'apicona-responsive-style', get_template_directory_uri() . '/css/responsive.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'apicona_scripts_styles_17', 17 );





/******************* Order Testimonials by date *******************/
/* Sort posts in wp_list_table by column in ascending or descending order. */
function kwayy_custom_post_order($query){
	/* 
	Set post types.
	_builtin => true returns WordPress default post types. 
	_builtin => false returns custom registered post types. 
	*/
	$post_types = get_post_types(array('_builtin' => false), 'names');
	
	/* The current post type. */
	$post_type = $query->get('testimonial');
	
	/* Check post types. */
	if(in_array($post_type, $post_types)){
		/* Post Column: e.g. title */
		if($query->get('orderby') == ''){
			$query->set('orderby', 'date');
		}
		/* Post Order: ASC / DESC */
		if($query->get('order') == ''){
			$query->set('order', 'DESC');
		}
	}
}
if(is_admin()){
	add_action('pre_get_posts', 'kwayy_custom_post_order');
}
/******************************************************/



/**
 * Enqueue scripts and styles for the admin section.
 *
 * @since Apicona 1.0
 *
 * @return void
 */
function apicona_custom_wp_admin_style() {
	wp_register_script('custom-select2-js', get_template_directory_uri() . '/inc/custom-select2/custom-select2.js', array( 'jquery' ), time(), true);
	wp_register_style('custom-select2-css', get_template_directory_uri() . '/inc/custom-select2/custom-select2.css', array(), time(), 'all');
		
		
	// Load font icon library CSS files
	global $apicona;
	if( isset($apicona['fonticonlibrary']) && is_array($apicona['fonticonlibrary']) && count($apicona['fonticonlibrary'])>0 ){
		foreach( $apicona['fonticonlibrary'] as $library=>$val ){
			if( $library!='fontawesome' ){
				if( $val == '1' ){
					wp_enqueue_style( $library, get_template_directory_uri() . '/css/fonticon-library/'.$library.'/css/kwayy-'.$library.'.css' );
				}
			}
		}
	}
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/fonticon-library/font-awesome/css/kwayy-font-awesome.css' ); // Font Awesome
		
		
	wp_enqueue_script('custom-select2-js');
	wp_enqueue_style('custom-select2-css');
	wp_enqueue_style('kwayy-font-css');
	
	wp_enqueue_style( 'apicona_custom_wp_admin_css', get_template_directory_uri() . '/inc/admin-style.css', false, '1.0.0' );
	wp_enqueue_script( 'apicona_custom_js', get_template_directory_uri() . '/inc/admin-custom.js', array( 'jquery' ) );
}
add_action( 'admin_enqueue_scripts', 'apicona_custom_wp_admin_style' );


/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Apicona 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function apicona_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'apicona' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'apicona_wp_title', 10, 2 );

/**
 * Register two widget areas.
 *
 * @since Apicona 1.0
 *
 * @return void
 */
function apicona_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Left Sidebar for Blog', 'apicona' ),
		'id' => 'sidebar-left-blog',
		'description' => __( 'This is left sidebar for blog section', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Right Sidebar for Blog', 'apicona' ),
		'id' => 'sidebar-right-blog',
		'description' => __( 'This is right sidebar for blog section', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Left Sidebar for Pages', 'apicona' ),
		'id' => 'sidebar-left-page',
		'description' => __( 'This is left sidebar for pages', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Right Sidebar for Pages', 'apicona' ),
		'id' => 'sidebar-right-page',
		'description' => __( 'This is right sidebar for pages', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Left Sidebar for Search', 'apicona' ),
		'id' => 'sidebar-left-search',
		'description' => __( 'This is left sidebar for search', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Right Sidebar for search', 'apicona' ),
		'id' => 'sidebar-right-search',
		'description' => __( 'This is right sidebar for search', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// WooCommerce
	register_sidebar( array(
		'name' => __( 'WooCommerce Shop', 'apicona' ),
		'id' => 'sidebar-woocommerce',
		'description' => __( 'This is sidebar for WooCommerce shop pages.', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// BBPress
	register_sidebar( array(
		'name'          => __( 'BBPress Sidebar', 'apicona' ),
		'id'            => 'sidebar-bbpress',
		'description'   => __( 'This is sidebar for BBPress.', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	
	
	
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'apicona' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'This is first footer widget area.', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'apicona' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'This is second footer widget area.', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'apicona' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'This is third footer widget area.', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'apicona' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'This is fourth footer widget area.', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	// Floating bar widgets
	$class = thememount_class_for_widgets_count( thememount_get_widgets_count( 'floating-header-widgets' ) );
	register_sidebar( array(
		'name'          => __( 'Floating Header Widgets', 'apicona' ),
		'id'            => 'floating-header-widgets',
		'description'   => __( 'Set widgets for Floating Header area.', 'apicona' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s '.$class.'">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	
	// Dynamic Sidebars (Unlimited Sidebars)
	global $apicona;
	if( isset($apicona['sidebars']) && is_array($apicona['sidebars']) && count($apicona['sidebars'])>0 ){
		foreach( $apicona['sidebars'] as $custom_sidebar ){
			if( trim($custom_sidebar)!='' ){
				$custom_sidebar_key = str_replace('-','_',sanitize_title($custom_sidebar));
				register_sidebar( array(
					'name'          => $custom_sidebar,
					'id'            => $custom_sidebar_key,
					'description'   => __( 'This is custom widget developed from "Appearance > Theme Options".', 'apicona' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				) );
			}
		}
	}
	
}
add_action( 'widgets_init', 'apicona_widgets_init' );



/*
 * Display pagination to set of posts when applicable.
 */
if ( ! function_exists( 'apicona_paging_nav' ) ) :
	function apicona_paging_nav($return = false, $wp_query_data=false) {
		if( $wp_query_data==false ){
			global $wp_query;
		} else {
			$wp_query = $wp_query_data;
		}
		
		$result = '';
		$big = 999999999; // need an unlikely integer
		$result .= '<div class="kwayy-pagination">';
		$result .= paginate_links( array(
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var('paged') ),
			'total'     => $wp_query->max_num_pages,
			'prev_text' => __(' <i class="kwicon-fa-angle-left"></i> '),
			'next_text' => __(' <i class="kwicon-fa-angle-right"></i> '),
		) );
		$result .= '</div>';
		
		if( $return==true ){
			return $result;
		} else {
			echo $result;
		}
	}
endif;





if ( ! function_exists( 'apicona_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
*
* @since Apicona 1.0
*
* @return void
*/
function apicona_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links">
			<?php previous_post_link( '%link', __( '<span class="meta-nav"></span> Previous', 'apicona' ) ); ?>
			<?php next_post_link( '%link', __( 'Next <span class="meta-nav"></span>', 'apicona' ) ); ?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'kwayy_entry_meta' ) ) :
/**
 * Print HTML with meta information for current post: categories, tags, permalink and author.
 *
 * Create your own kwayy_entry_meta() to override in a child theme.
 *
 * @since Apicona 1.0
 *
 * @return void
 */
function kwayy_entry_meta($echo = true) {
	$return = '';
	
	global $post;
	
	if( isset($post->post_type) && $post->post_type=='page' ){
		return;
	}
	
	
	$postFormat = get_post_format();
	
	// Post author
	$categories_list = get_the_category_list( __( ', ', 'apicona' ) ); // Translators: used between list items, there is a space after the comma.
	$tag_list        = get_the_tag_list( '', __( ', ', 'apicona' ) ); // Translators: used between list items, there is a space after the comma.
	$num_comments    = get_comments_number();
	
	$return .= '<div class="kwayy-meta-details">';
		if ( 'post' == get_post_type() ) {
			if( !is_single() ){
				$return .= sprintf( '<div class="kwayy-post-user"><span class="author vcard"><i class="kwicon-fa-user"></i> <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></div>',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr( sprintf( __( 'View all posts by %s', 'apicona' ), get_the_author() ) ),
					get_the_author()
				);
				$return .= sprintf( '<div class="date-time-album"><span class="date-time-album-child"><time class="entry-date" datetime="%1$s" >%3$s , %2$s %4$s</time></span></div>',
                    get_the_date( 'c' ),
                    get_the_date( 'j' ),
                    get_the_date( 'M' ),
                    get_the_date( ', Y' ),
                    kwayy_entry_icon()
                );
			}
		}
		if ( $tag_list ) { $return .= '<span class="tags-links"><i class="kwicon-fa-tags"></i> ' . $tag_list . '</span>'; };
		if ( $categories_list ) { $return .= '<span class="categories-links"><i class="kwicon-fa-folder-open"></i> ' . $categories_list . '</span>'; };
		if( !is_sticky() && comments_open() && ($num_comments>0) ){
			$return .= '<span class="comments"><i class="kwicon-fa-comments"></i> ';
			$return .= $num_comments;
			$return .= '</span>';
		}
	$return .= '</div>';
	
	if( $echo == true ){
		echo $return;
	} else {
		return $return;
	}
	
	
}
endif;


if ( ! function_exists( 'kwayy_entry_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own kwayy_entry_date() to override in a child theme.
 *
 * @since Apicona 1.0
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function kwayy_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) ){
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'apicona' );
	} else {
		$format_prefix = '%2$s';
	}
	
	
	$date = '<div class="kwayy-post-date-wrapper">';
		$date .= sprintf( '<div class="kwayy-entry-date-wrapper"><span class="kwayy-entry-date"><time class="entry-date" datetime="%1$s" >%2$s<span class="entry-month entry-year">%3$s<span class="entry-year">%4$s</span></span></time></span><div class="kwayy-entry-icon">%5$s</div></div>',
			get_the_date( 'c' ),
			get_the_date( 'j' ),
			get_the_date( 'M' ),
			get_the_date( ', Y' ),
			kwayy_entry_icon()
		);
	$date .= '</div>';
	
	if ( $echo ){
		echo $date;
	} else {
		return $date;
	}
}
endif;





if ( ! function_exists( 'kwayy_entry_box_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own kwayy_entry_box_date() to override in a child theme.
 *
 * @since Apicona 1.0
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function kwayy_entry_box_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) ){
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'apicona' );
	} else {
		$format_prefix = '%2$s';
	}
	
	
	$date = '<div class="kwayy-post-box-date-wrapper">';
		$date .= sprintf( '<div class="kwayy-entry-date-wrapper">
								<span class="kwayy-entry-date">
									<time class="entry-date" datetime="%1$s" >
										<span class="entry-date">%2$s</span> 
										<span class="entry-month">%3$s</span> 
										<span class="entry-year">%4$s</span> 
									</time>
								</span>
							</div>',
			get_the_date( 'c' ),
			get_the_date( 'j' ),
			get_the_date( 'M' ),
			get_the_date( ', Y' )
		);
	$date .= '</div>';
	
	if ( $echo ){
		echo $date;
	} else {
		return $date;
	}
}
endif;









if ( ! function_exists( 'kwayy_entry_icon' ) ) :
/**
 * Print HTML with icon for current post.
 *
 * Create your own kwayy_entry_icon() to override in a child theme.
 *
 * @since Apicona 1.0
 *
 */
function kwayy_entry_icon( $echo = false ) {
	$postFormat = get_post_format();
	if( is_sticky() ){ $postFormat = 'sticky'; }
	$icon = 'pencil';
	switch($postFormat){
		case 'sticky':
			$icon = 'thumb-tack';
			break;
		case 'aside':
			$icon = 'thumb-tack';
			break;
		case 'audio':
			$icon = 'music';
			break;
		case 'chat':
			$icon = 'comments';
			break;
		case 'gallery':
			$icon = 'files-o';
			break;
		case 'image':
			$icon = 'photo';
			break;
		case 'link':
			$icon = 'link';
			break;
		case 'quote':
			$icon = 'quote-left';
			break;
		case 'status':
			$icon = 'envelope-o';
			break;
		case 'video':
			$icon = 'film';
			break;
	}
	
	$iconCode = '<div class="kwayy-post-icon-wrapper">';
		$iconCode .= '<i class="kwicon-fa-'.$icon.'"></i>';
	$iconCode .= '</div>';
	
	
	
	
	
	if ( $echo ){
		echo $iconCode;
	} else {
		return $iconCode;
	}
}
endif;




/**
 * Adding DIV to show loading effect after clicking on any link.
 * @since Apicona 1.7
 * @return void
 */
/*function kwayy_footer_code() {
    echo '<div class="pageoverlay-static"></div>';
}
add_action('wp_footer', 'kwayy_footer_code', 30);*/





if ( ! function_exists( 'apicona_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Apicona 1.0
 *
 * @return void
 */
function apicona_the_attached_image() {
	/**
	 * Filter the image attachment size to use.
	 *
	 * @since Apicona 1.0
	 *
	 * @param array $size {
	 *     @type int The attachment height in pixels.
	 *     @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'apicona_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Apicona 1.0
 *
 * @return string The Link format URL.
 */
function apicona_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

if ( ! function_exists( 'apicona_body_class' ) ) :
/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since Apicona 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function apicona_body_class( $classes ) {
	global $apicona;
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';
	
	if($apicona['responsive']=='1'){
		$classes[] = 'kwayy-responsive-on';
	} else {
		$classes[] = 'kwayy-responsive-off';
	}
	
	return $classes;
}
endif;
add_filter( 'body_class', 'apicona_body_class' );

/**
 * Adjust content_width value for video post formats and attachment templates.
 *
 * @since Apicona 1.0
 *
 * @return void
 */
function apicona_content_width() {
	global $content_width;

	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 484;
}
add_action( 'template_redirect', 'apicona_content_width' );








/*************** Icon List *****************/
require_once( dirname( __FILE__ ) . '/inc/icons-list.php' );


/*************** Cuztom Framework: Custom Post Type, Texonomy etc. *****************/
require_once( dirname( __FILE__ ) . '/inc/posttype-slides.php' );
require_once( dirname( __FILE__ ) . '/inc/cuztom-helper-framework/cuztom.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-portfolio.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-page.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-team.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-post.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-testimonial.php' );
require_once( dirname( __FILE__ ) . '/inc/posttype-client.php' );



/*************** Extra addons in Visual Composer *****************/

function kwayy_visual_composer(){
	require_once( dirname( __FILE__ ) . '/inc/visual-composer.php' );
}
if( function_exists('vc_map') && class_exists('WPBMap') ){
	add_action('admin_init', 'kwayy_visual_composer');
}

/*************** Redux Framework: Theme Options *****************/
if ( !class_exists( 'ReduxFramework' ) ) {
    require_once( dirname( __FILE__ ) . '/inc/redux-framework/ReduxCore/framework.php' );
	//require_once( dirname( __FILE__ ) . '/inc/extension-boilerplate-master/custom_field/extension_custom_field.php' );
}

/* Add custom field */
add_action('admin_init', 'tm_redux');
function tm_redux(){
	add_filter( "redux/apicona/field/class/kwayy_skin_color", "kwayy_redux_skin_color" ); // Adds the local field
	add_filter( "redux/apicona/field/class/kwayy_one_click_demo_content", "kwayy_redux_one_click_demo_content" ); // Adds the local field
	add_filter( "redux/apicona/field/class/kwayy_icon_select", "kwayy_redux_icon_select" ); // Adds the local field
	add_filter( "redux/apicona/field/class/kwayy_min_generator", "kwayy_min_generator" ); // Adds the local field
	add_filter( "redux/apicona/field/class/kwayy_dimensions", "kwayy_dimensions" ); // Adds the local field
}
function kwayy_redux_skin_color($field) {
	return get_template_directory().'/inc/redux-framework/redux_custom_fields/kwayy_skin_color/field_kwayy_skin_color.php';
}
function kwayy_redux_one_click_demo_content($field) {
	return get_template_directory().'/inc/redux-framework/redux_custom_fields/kwayy_one_click_demo_content/field_kwayy_one_click_demo_content.php';
}
function kwayy_redux_icon_select($field) {
	return get_template_directory().'/inc/redux-framework/redux_custom_fields/kwayy_icon_select/field_kwayy_icon_select.php';
}
function kwayy_min_generator($field) {
	return get_template_directory().'/inc/redux-framework/redux_custom_fields/kwayy_min_generator/field_kwayy_min_generator.php';
}
function kwayy_dimensions($field) {
	return get_template_directory().'/inc/redux-framework/redux_custom_fields/kwayy_dimensions/field_kwayy_dimensions.php';
}

require_once( dirname( __FILE__ ) . '/inc/redux-options.php' );

/***************************** END Redux Framework **********************************/


add_filter( 'admin_body_class', 'admin_interface_version_body_class' );
function admin_interface_version_body_class( $classes ) {
	// check wp_version
	if ( version_compare( $GLOBALS['wp_version'], '3.8-alpha', '>' ) ) {
		// check admin_color
		//var_dump(get_user_option( 'admin_color' )); die;
		if ( get_user_option( 'admin_color' ) === 'light' ) {
			$classes .= 'light-admin-ui'; // custom new admin interface
		} else {
			$classes .= 'dark-admin-ui'; // new admin interface
		}
	} else {
		$classes .= 'light-admin-ui'; // old admin interface
	}
	$classes .= ' admin-color-fresh'; // new admin interface
	return $classes;
}








/********************** Custom Menus Icon ***********************/
//require_once( dirname( __FILE__ ) . '/inc/custom-menus-icon/custom-menus-icon.php');



/** Post Like ajax **/
add_action('wp_ajax_kwayy-portfolio-likes', 'kwayy_ajax_callback' );
add_action('wp_ajax_nopriv_kwayy-portfolio-likes', 'kwayy_ajax_callback' );

function kwayy_ajax_callback(){
	if(isset($_POST['likes_id'])){
		$post_id = str_replace('pid-', '', $_POST['likes_id']);
		echo kwayy_update_like( $post_id );
	}/*else{
		$post_id = str_replace('stag-likes-', '', $_POST['post_id']);
		echo $this->like_this($post_id, 'get');
	}*/
	exit;
}



function kwayy_update_like( $post_id ){
	if(!is_numeric($post_id)) return;

	$return = '';
	$likes = get_post_meta($post_id, 'kwayy_likes', true);
	if(!$likes){ $likes = 0; }
	$likes++;
	update_post_meta($post_id, 'kwayy_likes', $likes);
	setcookie('kwayy_likes_'.$post_id, $post_id, time()*20, '/');
	return '<i class="kwicon-fa-heart"></i> '.$likes.'</i>';
	break;
}






/*** Theme Customizer: Write inline style for live customizer ****/

function kwayy_customizer_script(){
	global $wp_customize;
	if ( isset( $wp_customize ) ) {
		global $apicona;
		?>
		<style type="text/css">
		header .kwayy-topbar{
			background-color: <?php echo $apicona['topbarbgcolor']; ?>;
		}
		header .headerblock .header-inner, #stickable-header-sticky-wrapper{
			background-color: <?php echo $apicona['headerbgcolor']; ?>;
		}
		footer.site-footer > div.footer{
			background-color: <?php echo $apicona['footerwidget_bgcolor']; ?>;
		}
		footer.site-footer > div.site-info{
			background-color: <?php echo $apicona['footertext_bgcolor']; ?>;
		}
		</style>
		
		<?php
	}
}
add_action('wp_head','kwayy_customizer_script');




/*********** Required Plugins *************/
// Plugin auto-installer
require_once('inc/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'apicona_register_required_plugins' );

// Install Plugins when activate theme
function apicona_register_required_plugins(){
	
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     				=> 'Revolution Slider', // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/inc/plugins/revslider.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '4.6.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'WPBakery Visual Composer', // The plugin name
			'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/inc/plugins/js_composer.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '4.4.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'CF Post Formats', // The plugin name
			'slug'     				=> 'cf-post-formats', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/inc/plugins/cf-post-formats.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Envato WordPress Toolkit', // The plugin name
			'slug'     				=> 'envato-wordpress-toolkit', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/inc/plugins/envato-wordpress-toolkit.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name' => 'Breadcrumb NavXT',
			'slug' => 'breadcrumb-navxt',
			'required' => true,
		),
		array(
			'name' => 'Contact Form 7',
			'slug' => 'contact-form-7',
			'required' => true,
		),
		array(
			'name' => 'Max Mega Menu',
			'slug' => 'megamenu',
			'required' => false,
		),
	);

	// Change this to your theme text domain, used for internationalising strings
	//$theme_text_domain = 'apicona';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'apicona',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'apicona' ),
			'menu_title'                       			=> __( 'Install Plugins', 'apicona' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'apicona' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'apicona' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'apicona' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'apicona' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'apicona' ), // %1$s = dashboard link
		)
	);
	tgmpa( $plugins, $config );
}
/********************************************************/



/**************** WooCommerce Settings ******************/
if( function_exists('is_woocommerce') ){  /* Check if WooCommerce plugin activated */
	
	// Remove breadcrumb from woocommerce_before_main_content
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
	remove_action( 'woocommerce_before_main_content', 'woocommerce_page_title', 20);
	
	// Remove Page Title
	function kwayy_wc_title(){return '';}
	add_action( 'woocommerce_show_page_title', 'kwayy_wc_title' );
	
	
	// Change number or products per row to 3
	add_filter('loop_shop_columns', 'loop_columns');
	if (!function_exists('loop_columns')) {
		function loop_columns() {
			return 3; // 3 products per row
		}
	}
	
	
	// Remove "product" class from product thumb LI
	if( !function_exists('kwayy_wc_remove_product_class') ){
		function kwayy_wc_remove_product_class($classes) {
			$classes = array_diff($classes, array("product"));
			return $classes;
		}
	}
	
	
	/**
	 * WooCommerce Extra Feature
	 * --------------------------
	 *
	 * Change number of related products on product page
	 * Set your own value for 'posts_per_page'
	 *
	 */ 
	function woo_related_products_limit() {
		//$posts_per_page = 4;
		global $product, $woocommerce_loop;
		$related = $product->get_related();
		if ( sizeof( $related ) == 0 ) return;
		
		$args = array(
			'post_type'        		=> 'product',
			'no_found_rows'    		=> 1,
			'posts_per_page'   		=> 4,
			'ignore_sticky_posts' 	=> 1,
			'orderby'             	=> 'rand',
			'post__in'            	=> $related,
			'post__not_in'        	=> array($product->id)
		);
		return $args;
	}
	add_filter( 'woocommerce_related_products_args', 'woo_related_products_limit' );
	
	
	
	// Display 24 products per page. Goes in functions.php
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 );


}




/**
 * Define image sizes
 */
function kwayy_woocommerce_image_dimensions() {
	
	$tm_wc_sizeadded = get_option('tm_wc_sizeadded');
	
	if( $tm_wc_sizeadded!='yes' ){
		
		$catalog = array(
			'width' 	=> '520',	// px
			'height'	=> '520',	// px
			'crop'		=> 1 		// true
		);

		$single = array(
			'width' 	=> '800',	// px
			'height'	=> '800',	// px
			'crop'		=> 1 		// true
		);

		$thumbnail = array(
			'width' 	=> '120',	// px
			'height'	=> '120',	// px
			'crop'		=> 0 		// false
		);

		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
		
		update_option('tm_wc_sizeadded','yes');
		
	}
}
add_action( 'init', 'kwayy_woocommerce_image_dimensions', 1 );


// Add SPAN to numbers in Categories widget
function kwayy_add_span_cat_count($links) {
	$links = str_replace('</a> (', '</a> <span>(', $links);
	$links = str_replace(')', ')</span>', $links);
	return $links;
}
add_filter('wp_list_categories', 'kwayy_add_span_cat_count');



// Add NiceScroll Options in header
if( isset($apicona['scroller_enable']) && $apicona['scroller_enable']=='1'){
	add_action('wp_head','kwayy_nicescroll');
	if( !function_exists('kwayy_nicescroll') ){
		function kwayy_nicescroll() {
			global $apicona;
			?>
			<script type="text/javascript">
				jQuery( document ).ready(function($) {
					jQuery("html").niceScroll({
						styler:"fb",
						cursorcolor:'#616b74',
						cursorborder:'0',
						zindex:9999,
						horizrailenabled:false,
						mousescrollstep:<?php echo $apicona['scroller_speed']; ?>,
						cursorwidth:10
					});
				});
			</script>
			<?php
		}
	}
}



// Add page translation effect
if( isset($apicona['pagetranslation']) && $apicona['pagetranslation']!='no'){
	add_action('wp_head','kwayy_pagetranslation');
	if( !function_exists('kwayy_pagetranslation') ){
		function kwayy_pagetranslation() {
			global $apicona;
			$pagetranslation = explode('|',$apicona['pagetranslation']);
			$starteffect = $pagetranslation[0];
			$endeffect   = $pagetranslation[1];
			?>
			<script type="text/javascript">
				jQuery( document ).ready(function($) {
					$(".animsition").animsition({
						inClass               :   '<?php echo $starteffect; ?>',
						outClass              :   '<?php echo $endeffect; ?>',
						inDuration            :    1500,
						outDuration           :    800,
						//linkElement         :   '.animsition-link', 
						linkElement           :   'a:not([target="_blank"]):not([href^=#]):not("a.comment-reply-link"):not("#cancel-comment-reply-link"):not([rel^="prettyPhoto"]):not([data-rel^="prettyPhoto"]):not([rel^="lightbox"]):not([href^="javascript:void(0)"]):not([href^="mailto"]):not(".button.add_to_cart_button"):not(".tribe-events-ical.tribe-events-button"):not(".lang_sel_sel")',
						// e.g. linkElement   :   'a:not([target="_blank"]):not([href^=#])'
						touchSupport          :    true, 
						loading               :    true,
						loadingParentElement  :   'body', //animsition wrapper element
						loadingClass          :   'pageoverlay',
						unSupportCss          : [ 'animation-duration',
												  '-webkit-animation-duration',
												  '-o-animation-duration'
						]
						//"unSupportCss" option allows you to disable the "animsition" in case the css property in the array is not supported by your browser. 
						//The default setting is to disable the "animsition" in a browser that does not support "animation-duration". 
					});
				});
			</script>
			<?php
		}
	}
}



/* ajaxurl */add_action('wp_head','pluginname_ajaxurl');function pluginname_ajaxurl() { ?>	<script type="text/javascript">	var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';	</script><?php }



/* Custom HTML code */
if( isset($apicona['customhtml_head']) && trim($apicona['customhtml_head'])!='' ){
	add_action('wp_head','thememount_customhtmlhead', 20);
	function thememount_customhtmlhead(){
		global $apicona;
		echo $apicona['customhtml_head'];
	}
}

if( isset($apicona['customhtml_bodyend']) && trim($apicona['customhtml_bodyend'])!='' ){
	add_action('wp_footer','thememount_customhtmlbodyend', 20);
	function thememount_customhtmlbodyend(){
		global $apicona;
		echo $apicona['customhtml_bodyend'];
	}
}

add_filter( 'wpcf7_support_html5_fallback', '__return_true' );
