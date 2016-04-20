<?php
$args = array();

// For use with a tab example below
$tabs = array();

ob_start();

$ct = wp_get_theme();
$theme_data = $ct;
$item_name = $theme_data->get('Name'); 
$tags = $ct->Tags;
$screenshot = $ct->get_screenshot();
$class = $screenshot ? 'has-screenshot' : '';
$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','apicona' ), $ct->display('Name') );
?>

<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
	<?php if ( $screenshot ) : ?>
		<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
		<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
			<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
		</a>
		<?php endif; ?>
		<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
	<?php endif; ?>

	<h4>
		<?php echo $ct->display('Name'); ?>
	</h4>

	<div>
		<ul class="theme-info">
			<li><?php printf( __('By %s','apicona'), $ct->display('Author') ); ?></li>
			<li><?php printf( __('Version %s','apicona'), $ct->display('Version') ); ?></li>
			<li><?php echo '<strong>'.__('Tags', 'apicona').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
		</ul>
		<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
		<?php if ( $ct->parent() ) {
			printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
				__( 'http://codex.wordpress.org/Child_Themes','apicona' ),
				$ct->parent()->display( 'Name' ) );
		} ?>
		
	</div>

</div>

<?php
$item_info = ob_get_contents();
    
ob_end_clean();

$sampleHTML = '';
if( file_exists( dirname(__FILE__).'/info-html.html' )) {
	/** @global WP_Filesystem_Direct $wp_filesystem  */
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once(ABSPATH .'/wp-admin/includes/file.php');
		WP_Filesystem();
	}  		
	$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
}




/*
 *  Disable tracking for Redux Framework
 */
$options                   = get_option( 'redux-framework-tracking' );
$options['allow_tracking'] = 'no';
update_option( 'redux-framework-tracking', $options );




// BEGIN Sample Config

// Setting dev mode to true allows you to view the class settings/info in the panel.
// Default: true
$args['dev_mode']   = false;
$args['customizer'] = false;

// Set the icon for the dev mode tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['dev_mode_icon'] = 'info-sign';

// Set the class for the dev mode tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['dev_mode_icon_class'] = 'icon-large';

// Set a custom option name. Don't forget to replace spaces with underscores!
$args['opt_name'] = 'apicona';

// Setting system info to true allows you to view info useful for debugging.
// Default: false
//$args['system_info'] = true;


// Set the icon for the system info tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: info-sign
//$args['system_info_icon'] = 'info-sign';

// Set the class for the system info tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
//$args['system_info_icon_class'] = 'icon-large';

$theme = wp_get_theme();

$args['display_name'] = $theme->get('Name');
//$args['database'] = "theme_mods_expanded";
$args['display_version'] = $theme->get('Version');

// If you want to use Google Webfonts, you MUST define the api key.
$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

// Define the starting tab for the option panel.
// Default: '0';
//$args['last_tab'] = '0';

// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
// Default: 'standard'
//$args['admin_stylesheet'] = 'standard';

// Setup custom links in the footer for share icons
$args['share_icons']['twitter'] = array(
	'link' => 'https://twitter.com/thememount',
	'title' => 'Follow us on Twitter', 
	'img' => get_template_directory_uri() . '/inc/images/twitter.png'
);

// Enable the import/export feature.
// Default: true
//$args['show_import_export'] = false;

// Set the icon for the import/export tab.
// If $args['icon_type'] = 'image', this should be the path to the icon.
// If $args['icon_type'] = 'iconfont', this should be the icon name.
// Default: refresh
//$args['import_icon'] = 'refresh';

// Set the class for the import/export tab icon.
// This is ignored unless $args['icon_type'] = 'iconfont'
// Default: null
$args['import_icon_class'] = 'icon-large';

/**
 * Set default icon class for all sections and tabs
 * @since 3.0.9
 */
$args['default_icon_class'] = 'icon-large';


// Set a custom menu icon.
//$args['menu_icon'] = '';

// Set a custom title for the options page.
// Default: Options
$args['menu_title'] = __('Theme Options', 'apicona');

// Set a custom page title for the options page.
// Default: Options
$args['page_title'] = __('Theme Options', 'apicona');

// Set a custom page slug for options page (wp-admin/themes.php?page=***).
// Default: redux_options
$args['page_slug'] = 'kwayy_theme_options';

$args['default_show'] = true;
$args['default_mark'] = '*';

// Set a custom page capability.
// Default: manage_options
//$args['page_cap'] = 'manage_options';

// Set the menu type. Set to "menu" for a top level menu, or "submenu" to add below an existing item.
// Default: menu
//$args['page_type'] = 'submenu';
$args['page_type'] = 'submenu';

// Set the parent menu.
// Default: themes.php
// A list of available parent menus is available at http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
//$args['page_parent'] = 'options_general.php';

// Set a custom page location. This allows you to place your menu where you want in the menu order.
// Must be unique or it will override other items!
// Default: null
//$args['page_position'] = null;

// Set a custom page icon class (used to override the page icon next to heading)
//$args['page_icon'] = 'icon-themes';

// Set the icon type. Set to "iconfont" for Elusive Icon, or "image" for traditional.
// Redux no longer ships with standard icons!
// Default: iconfont
//$args['icon_type'] = 'image';

// Disable the panel sections showing as submenu items.
// Default: true
//$args['allow_sub_menu'] = false;
    
// Set ANY custom page help tabs, displayed using the new help tab API. Tabs are shown in order of definition.
$args['help_tabs'][] = array(
    'id' => 'kwayy-opts-1',
    'title' => __('Help and Support', 'apicona'),
    'content' => __('<h3>Help and Support</h3>
		<ul>
			<li><a href="http://apicona.thememount.com/documentation/index.html" target="_blank">Theme Help Documenation</a></li>
			<li><a href="http://support.thememount.com/" target="_blank">Questions? Ask us here.</a></li>
			<li><a href="http://apicona.thememount.com/" target="_blank">Live Demo</a></li>
		</ul>', 'apicona')
);
/*$args['help_tabs'][] = array(
    'id' => 'kwayy-opts-2',
    'title' => __('Theme Information 2', 'apicona'),
    'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'apicona')
);*/

// Set the help sidebar for the options page.                                        
//$args['help_sidebar'] = __('<p></p>', 'apicona');


// Add HTML before the form.
if (!isset($args['global_variable']) || $args['global_variable'] !== false ) {
	if (!empty($args['global_variable'])) {
		$v = $args['global_variable'];
	} else {
		$v = str_replace("-", "_", $args['opt_name']);
	}
	$args['intro_text'] = sprintf( __('<p>If you have any problem or question than you can <a href="http://apicona.thememount.com/documentation/" target="_blank">read theme documentation online by clicking here</a>. If still not working than you can contact us via our <a href="http://support.thememount.com" target="_blank">support ticket system</a>.</p>', 'apicona' ), $v );
} else {
	$args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'apicona');
}

// Add content after the form.
//$args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'apicona');

// Set footer/credit line.
//$args['footer_credit'] = __('<p>This text is displayed in the options panel footer across from the WordPress version (where it normally says \'Thank you for creating with WordPress\'). This field accepts all HTML.</p>', 'apicona');


$sections = array();              

//Background Patterns Reader
$sample_patterns_path = ReduxFramework::$_dir . '../../../images/patterns/';
$sample_patterns_url  = get_template_directory_uri() . '/images/patterns/';
$sample_patterns      = array();

//var_dump($sample_patterns_path); die();
//var_dump($sample_patterns_path); die();

if ( is_dir( $sample_patterns_path ) ) :
	if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
		$sample_patterns = array();
		while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {
			if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
				$name = explode(".", $sample_patterns_file);
				$name = str_replace('.'.end($name), '', $sample_patterns_file);
				$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
			}
		}
	endif;
endif;

//var_dump($sample_patterns);



/*****************************************************************************/

// Layout Settings
$sections[] = array(
	'title'  => __('Layout Settings', 'apicona'),
	'header' => __('Layout Settings', 'apicona'),
	'desc'   => __('Specify theme pages layout, the skin coloring and background', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-website',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		/*array(
			'id'       => 'coption',
			'type'     => 'custom_field',
			'title'    => __('Custom Opiton', 'apicona'), 
			'subtitle' => __('Specify the layout for the pages', 'apicona'),
			'options'  => array('wide' => 'Wide', 'boxed' => 'Boxed'),//Must provide key => value pairs for radio options
			//'desc'   => __('This is the description field, again good for additional info.', 'apicona'),
			'default'  => 'wide',
			//'value'  => '2'
		),*/
		array(
			'id'         => 'kwayy_one_click_demo_content',
			'type'       => 'kwayy_one_click_demo_content',
			'title'      => __('Demo Content Setup', 'apicona'), 
			'subtitle'   => __('This is one click demo content setup', 'apicona'),
			'customizer' => false,
		),
		/*array(
			'id'       => 'kwayy_pre_color_packages',
			'type'     => 'kwayy_pre_color_packages',
			'title'    => __('Predefined Color Packages', 'apicona'), 
			'subtitle' => __('These are set of different colour packages. This will change: <ul class="kwayy-list"> <li>Topbar background color and text color</li> <li>Header background colours and text colors</li> <li>Skin color</li> <li>footer background colors and text colors</li> </ul>', 'apicona'),
			//'default'  => '#e85e16',
			//'validate' => 'color',
			'customizer'=> false,
			//'compiler' => 'true',
		),*/
		array(
			'id'       => 'layout',
			'type'     => 'radio',
			'title'    => __('Pages Layout', 'apicona'), 
			'subtitle' => __('Specify the layout for the pages', 'apicona'),
			'options'  => array('wide'    => 'Wide',
								'boxed'   => 'Boxed',
								'framed'  => 'Framed',
								'rounded' => 'Rounded',
						),//Must provide key => value pairs for radio options
			//'desc'   => __('This is the description field, again good for additional info.', 'apicona'),
			'default'  => 'wide',
			'customizer'=> false,
			//'value'  => '2'
		),
		array(
			'id'       => 'responsive',
			'type'     => 'switch',
			'title'    => __('Responsive Design', 'apicona'), 
			'subtitle' => __('Check this option to enable responsive design to the theme', 'apicona'),
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
			'default'  => '1', // 1 = on | 0 = off
			'customizer'=> false,
		),
		array(
			'id'       => 'skincolor',
			'type'     => 'kwayy_skin_color',
			'title'    => __('Skin Color', 'apicona'), 
			'subtitle' => __('Custom color for skin. This is color to highlight different elements. Like text links, active tabs, progress bars, active accordion and others.', 'apicona'),
			'default'  => '#ae1010',
			'values'   => array(
				'Tabasco'        => '#ae1010',
				'Cyan'           => '#00abe4',
				'Emerald'        => '#4abe63',
				'Green'          => '#89c355',
				'Tan'            => '#00bdbd',
				'Yellow'         => '#ffbe00',
				'Mountainmeadow' => '#18c08f',
				'Brown'          => '#964b00',
				'Cinnabar'       => '#e64d3b',
				'Mongoose'       => '#b8a279',
			),
			'validate' => 'color',
			'customizer'=> false,
			'compiler' => 'true',
		),
		
		
		
		
		
		
		array(
			'id'    =>'html-backgroundsettings',
			'type'  => 'info',
			'title' => __('Background Settings', 'apicona'), 
			'desc'  => __('Set below background options. Background settings will be applied to Boxed layout only.', 'apicona')
        ),
		array(
			'id'            => 'global_background',
			'type'          => 'background',
			'title'         => __('Body Background Properties', 'apicona'),
			'subtitle'      => __('Set background for main body. This is for main outer body background. For "Boxed" layout only.', 'apicona'),
			'preview_media' => true,
			'output'        => array('body'),
			'default'       => array( "background-color" => "#f8f8f8", ),
			'customizer'    => false,
		),
		array(
			'id'            => 'inner_background',
			'type'          => 'background',
			'title'         => __('Content Area Background Properties', 'apicona'),
			'subtitle'      => __('Set background for content area.', 'apicona'),
			'preview_media' => true,
			'output'        => array('body #main'),
			'default'       => array( "background-color" => "#ffffff", ),
			'customizer'    => false,
		),
		
		/* Loader Image */
		array(
			'id'    =>'html-pagetranslation',
			'type'  => 'info',
			'title' => __('Page Translation Effect', 'apicona'), 
			'desc'  => __('Select page translation effect for the site. We are using <strong>Animsition</strong> library for page transation and you can <a href="http://git.blivesta.com/animsition/" target="_blank">see preview of each translation here</a>.', 'apicona')
        ),
		array(
			'id'       => 'pagetranslation',
			'type'     => 'radio',
			'title'    => __('Page translation effect', 'apicona'), 
			'subtitle' => __('Select page translation effect here.', 'apicona'),
			'options'  => array(
							'no'                           => 'No effect',
							'fade-in|fade-out'             => 'Fade',
							'fade-in-up|fade-out-down'     => 'Fade up',
							'fade-in-down|fade-out-up'     => 'Fade down',
							'fade-in-left|fade-out-left'   => 'Fade from left',
							'fade-in-right|fade-out-right' => 'Fade from right',
							'rotate-in|rotate-out'         => 'Rotate',
							'flip-in-x|flip-out-x'         => 'Flip X',
							'flip-in-y|flip-out-y'         => 'Flip Y',
							'zoom-in|zoom-out'             => 'Zoom',
						), //Must provide key => value pairs for radio options
			//'desc'   => __('This is the description field, again good for additional info.', 'apicona'),
			'default'  => 'no',
			'customizer'=> false,
			//'value'  => '2'
		),
		
		
		/* Loader Image */
		array(
			'id'    =>'html-loaderimage',
			'type'  => 'info',
			'title' => __('Pre-loader image', 'apicona'), 
			'desc'  => __('Select pre-loader image for the site. This will work on desktop, mobile and tablet devices.', 'apicona')
        ),
		array(
			'id'       => 'loaderimg',
			'type'     => 'image_select',
			'title'    => __('Pre-loader Image', 'apicona'), 
			'subtitle' => __('Please select site pre-loader image. <br /><br /><em><strong>Note: </strong>Please note that if you uploaded pre-loader image (in below option) than this pre-defined loader image will be ignored.</em>', 'apicona'),
			'options'  => array(
				'1' => array(
					'alt' => __('Loader image 1', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader1.gif'
				),
				'2' => array(
					'alt' => __('Loader image 2', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader2.gif'
				),
				'3' => array(
					'alt' => __('Loader image 3', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader3.gif'
				),
				'4' => array(
					'alt' => __('Loader image 4', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader4.gif'
				),
				'5' => array(
					'alt' => __('Loader image 5', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader5.gif'
				),
				'6' => array(
					'alt' => __('Loader image 6', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader6.gif'
				),
				'7' => array(
					'alt' => __('Loader image 7', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader7.gif'
				),
				'8' => array(
					'alt' => __('Loader image 8', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader8.gif'
				),
				'9' => array(
					'alt' => __('Loader image 9', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader9.gif'
				),
				'10' => array(
					'alt' => __('Loader image 10', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader10.gif'
				),
				'11' => array(
					'alt' => __('Loader image 10', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader11.gif'
				),
				'12' => array(
					'alt' => __('Loader image 10', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader12.gif'
				),
				'13' => array(
					'alt' => __('Loader image 10', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader13.gif'
				),
				'14' => array(
					'alt' => __('Loader image 10', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader14.gif'
				),
				'15' => array(
					'alt' => __('Loader image 10', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader15.gif'
				),
				'16' => array(
					'alt' => __('Loader image 10', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader16.gif'
				),
				'17' => array(
					'alt' => __('Loader image 10', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader17.gif'
				),
				'18' => array(
					'alt' => __('Loader image 10', 'apicona'),
					'img' => get_template_directory_uri() . '/images/loader18.gif'
				),
			),
			'default'  => '1',
		),
		array(
			'id'       => 'loaderimage_custom',
			'type'     => 'media', 
			'title'    => __('Upload Pre-loader Image', 'apicona'),
			'subtitle' => __('Custom pre-loader image that you want to show. You can create animated GIF image from your logo from <a href="http://animizer.net/en/animate-static-image" target="_blank">Animizer</a> website. <br /><br /><em><strong>Note: </strong>Please note that if you selected image here than the pre-defined loader image (in above option) will be ignored.</em>', 'apicona'),
		),
		
		
		
		/* NiceScroll Options */
		array(
			'id'    =>'html-NiceScrollOptions',
			'type'  => 'info',
			'title' => __('Scroller Settings', 'apicona'), 
			'desc'  => __('Set options for scrollbar.', 'apicona')
		),
		/*array(
			'id'       => 'scroller_enable',
			'type'     => 'switch',
			'title'    => __('Enalbe NiceScroll', 'apicona'), 
			'subtitle' => __('Select YES to enable NiceScroll (fancy scrollbar).', 'apicona'),
			'on'       => 'Yes',
			'off'      => 'No',
			'default'  => '1', // 1 = on | 0 = off
		),*/
		
		array(
			'id'        => 'scroller_enable',
			'type'      => 'button_set',
			'title'     => __('Page Scrolling Effect', 'apicona'),
			'subtitle'  => __('Select page scrolling effect. ', 'apicona'),
			'desc'      => __('<ul><li><strong>NiceScroll:</strong> Contains fancy scrollbar and smooth page scroll</li><li><strong>SmoothScroll:</strong> contains only smooth page scroll</li><ul>', 'apicona'),
			
			//Must provide key => value pairs for radio options
			'options'   => array(
				'1' => 'NiceScroll', 
				'2' => 'SmoothScroll',
				'3' => 'No effect',
			),
			'default'   => '2'
		),
		
		array(
			'id'       => 'scroller_speed',
			'type'     => 'text',
			'title'    => __('Page Scrolling Speed (mousescrollstep)', 'apicona'),
			'subtitle' => __('Page scrolling speed with mouse wheel, default value is <code>40</code> (pixel)', 'apicona'),
			'required' => array('scroller_enable','equals','1'),
			'customizer' => false,
			'default'  => __('40', 'apicona'),
		),
		
		
		/* NiceScroll Options */
		array(
			'id'    =>'html-fonticonlibrary',
			'type'  => 'info',
			'title' => __('Font Icon Library Selection', 'apicona'), 
			'desc'  => __('Select font-icon library. The more library you select the more loading in your site will be applied.', 'apicona')
		),
		array(
			'id'        => 'fonticonlibrary',
			'type'      => 'checkbox',
			'title'     => __('Select Font Icon Library', 'apicona'),
			'subtitle'  => __('Select font icon library', 'apicona'),
			'desc'      => __('Select font icon library.', 'apicona'),
			
			//Must provide key => value pairs for multi checkbox options
			'options'   => array(
				'fontawesome' => __('Font Awesome (558 icons)', 'apicona'),
				'lineicons'   => __('Lineicons (58 icons)', 'apicona'),
				'entypo'      => __('Entypo (284 icons)', 'apicona'),
				'typicons'    => __('Typicons (308 icons)', 'apicona'),
				'iconic'      => __('Iconic (151 icons)', 'apicona'),
				'mpictograms' => __('Modern Pictograms (91 icons)', 'apicona'),
				'meteocons'   => __('Meteocons (47 icons)', 'apicona'),
				'mfglabs'     => __('MFG Labs (153 icons)', 'apicona'),
				'maki'        => __('Maki (63 icons)', 'apicona'),
				'zocial'      => __('Zocial (103 icons)', 'apicona'),
				'brandico'    => __('Brandico (45 icons)', 'apicona'),
				'elusive'     => __('Elusive (271 icons)', 'apicona'),
				'websymbols'  => __('Web Symbols (85 icons)', 'apicona'),
				'twemojiawesome' => __('Twemoji Awesome (870+ SVG icons)', 'apicona'),
			),
			
			//See how std has changed? you also don't need to specify opts that are 0.
			'default'   => array(
				'fontawesome' => '1',
				'lineicons'   => '0',
				'entypo'      => '0',
				'typicons'    => '0',
				'iconic'      => '0',
				'mpictograms' => '0',
				'meteocons'   => '0',
				'mfglabs'     => '0',
				'maki'        => '0',
				'zocial'      => '0',
				'brandico'    => '0',
				'elusive'     => '0',
				'websymbols'  => '0',
			)
		),
		
	),
);








// Favicon Settings
$sections[] = array(
	'title'  => __('Favicon Settings', 'apicona'),
	'header' => __('Favicon Settings', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Set all Favicon icons. Upload different Favicons for different type of devices. (Click here to <a href="http://en.wikipedia.org/wiki/Favicon" target="_blank"> know more about Favicon</a>). Also you can generate favicon from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-bookmark',
	'fields' => array(
		array(
			'id'     => 'kwayy-favicon-desc',
			'type'   => 'info',
			'style'  => 'success',
			'notice' => true,
			'title'  => __('TIP:', 'apicona'),
			'desc'   => __('You can generate Favicon easily.  Just create a new PNG image with size <strong>260x260 pixel</strong> and upload on <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site. This site will create all required images and you just need to upload each image in each below options.', 'apicona')
		),
		array(
			'id'       => 'favicon',
			'type'     => 'media',
			'url'      => false,
			'customizer'=> false,
			'title'    => __('Favicon image (favicon.ico icon file)', 'apicona'),
			'subtitle' => __('Select or upload <strong>favicon.ico</strong> with size 48x48 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'apicona'),
			'compiler' => 'true',
		),
		array(
			'id'       => 'favicon_16',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image (16x16 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 16x16 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_32',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image (32x32 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 32x32 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_96',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image (96x96 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 96x96 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_160',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image (160x160 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 160x160 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_192',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image (192x192 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 192x192 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		
		array(
			'id'    =>'html-favicon',
			'type'  => 'info',
			'title' => __('Favicon icons for Apple devices', 'apicona'), 
			'desc'  => __('Upload different Favicons for different type of devices. (Click here to <a href="http://en.wikipedia.org/wiki/Favicon" target="_blank"> know more about Favicon</a>). Also you can generate favicon from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'apicona'),
        ),
		array(
			'id'       => 'favicon_57',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (57x57 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 57x57 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_60',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (60x60 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 60x60 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_72',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (72x72 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 72x72 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_76',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (76x76 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 76x76 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_114',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (114x114 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 114x114 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_120',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (120x120 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 120x120 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_144',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (144x144 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 144x144 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_152',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (152x152 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 152x152 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		array(
			'id'       => 'favicon_180',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for Apple devices (180x180 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 180x180 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
		),
		
		array(
			'id'    =>'html-favicon3',
			'type'  => 'info',
			'title' => __('Favicon image and color for Microsoft Tile link (for Microsoft Devices)', 'apicona'), 
			'desc'  => __('Upload different Favicons for different type of devices. (<a href="http://www.buildmypinnedsite.com/en" target="_blank">Click here to know more about Favicon for Microsoft devices</a>).', 'apicona'),
        ),
		array(
			'id'       => 'favicon_ms_tile_color',
			'type'     => 'color',
			'url'      => false,
			'title'    => __('Favicon Background Color for the MS App Tile link', 'apicona'),
			'subtitle' => __('Select background color for Favicon Tile App link.', 'apicona'),
			'compiler' => 'true',
			'default' => '#212c43',
		),
		array(
			'id'       => 'favicon_ms_144',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for MicroSoft App link (144x144 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 144x144 pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'apicona'),
			'compiler' => 'true',
		),
		array(
			'id'       => 'favicon_ms_70',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for MicroSoft App link (70x70 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 70x70 or 128x128 (if with transparent border) pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'apicona'),
			'compiler' => 'true',
		),
		array(
			'id'       => 'favicon_ms_150',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for MicroSoft App link (150x150 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 150x150 or 170x270 (if with transparent border) pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'apicona'),
			'compiler' => 'true',
		),
		array(
			'id'       => 'favicon_ms_310_150',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for MicroSoft App link (310x150 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 310x150 or 558x270 (if with transparent border) pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'apicona'),
			'compiler' => 'true',
		),
		array(
			'id'       => 'favicon_ms_310',
			'type'     => 'media',
			'url'      => false,
			'title'    => __('Favicon Image for MicroSoft App link (310x310 PNG image)', 'apicona'),
			'subtitle' => __('Select or upload Favicon image with size 310x310 or 558x558 (if with transparent border) pixel. You can generate Favicon image from <a href="http://realfavicongenerator.net/" target="_blank">http://realfavicongenerator.net/</a> site.', 'apicona'),
			'compiler' => 'true',
		),
	),
);








// Font Settings
$sections[] = array(
	'title'  => __('Font Settings', 'apicona'),
	'header' => __('Font Settings', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Set different font style', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-text-height',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'          => 'general_font',
			'type'        => 'typography', 
			'title'       => __('General Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => true,
			//'preview'   => false, // Disable the previewer
			'output'      => array('body'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'apicona'),
			'default'     => array(
				'color'       => "#7c7c7c",
				'font-family' => 'Lato',
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'=>'400',
				'font-size'   => '14px', 
				'line-height' => '20px'
			),
		),
		
		
		array(
			'id'          => 'widget_font',
			'type'        => 'typography', 
			'title'       => __('Widget Title Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('body .widget .widget-title, body .widget .widgettitle, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal .mega-sub-menu > li.mega-menu-item > h4.mega-block-title'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select font, color and size for widget title', 'apicona'),
			'default'=> array(
				'color'       => "#2d2d2d",
				'font-family' => 'Raleway',
				'font-weight' => '700',
				'font-backup' => "'Trebuchet MS', Helvetica, sans-serif",
				'font-size'   => '18px', 
				'line-height' => '20px'
			),
		),
		
		array(
			'id'          => 'button_font',
			'type'        => 'typography', 
			'title'       => __('Button Font', 'apicona'),
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			'text-align'  => false,
			'font-size'   => false,
			'line-height' => false,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('.woocommerce button.button, .woocommerce-page button.button, input, .vc_btn, .woocommerce-page a.button, .button, .wpb_button, button, .woocommerce input.button, .woocommerce-page input.button, .tp-button.big'), // An array of CSS selectors
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('This fonts will be applied to all buttons in this site', 'apicona'),
			'default'     => array(
				//'color'       => "#9a9a9a",
				'font-family' => 'Lato',
				//"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'=>'400',
				//'font-size'   => '14px', 
				//'line-height' => '20px'
			),
		),
		
		array(
			'id'          => 'h1_heading_font',
			'type'        => 'typography', 
			'title'       => __('H1 Heading Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=>false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h1'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'apicona'),
			'default'     => array(
				'color'       => "#2d2d2d",
				'font-family' => 'Raleway',
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'=>'400',
				'font-weight' => '700',
				'font-size'   => '28px', 
				'line-height' => '30px'
			),
		),
		array(
			'id'          => 'h2_heading_font',
			'type'        => 'typography', 
			'title'       => __('H2 Heading Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style' => false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h2'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'apicona'),
			'default'     => array(
				'color'       => "#2d2d2d",
				'font-family' => 'Raleway',
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'=>'400',
				'font-weight' => '700',
				'font-size'   => '27px', 
				'line-height' => '28px'
			),
		),
		array(
			'id'          => 'h3_heading_font',
			'type'        => 'typography', 
			'title'       => __('H3 Heading Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h3'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'apicona'),
			'default'     => array(
				'color'       => "#2d2d2d",
				'font-family' => 'Raleway',
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'=>'400',
				'font-weight' => '700',
				'font-size'   => '20px', 
				'line-height' => '25px'
			),
		),
		array(
			'id'          => 'h4_heading_font',
			'type'        => 'typography', 
			'title'       => __('H4 Heading Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h4'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'apicona'),
			'default'     => array(
				'color'       => "#2d2d2d",
				'font-family' => 'Raleway',
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'=>'400',
				'font-size'   => '18px', 
				'line-height' => '23px'
			),
		),
		array(
			'id'          => 'h5_heading_font',
			'type'        => 'typography', 
			'title'       => __('H5 Heading Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h5'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'apicona'),
			'default'     => array(
				'color'       => "#2d2d2d",
				'font-family' => 'Raleway',
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'=>'400',
				'font-size'   => '16px', 
				'line-height' => '18px'
			),
		),
		array(
			'id'          => 'h6_heading_font',
			'type'        => 'typography', 
			'title'       => __('H6 Heading Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			//'color'     => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h6'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select General font, color and size', 'apicona'),
			'default'     => array(
				'color'       => "#2d2d2d",
				'font-family' => 'Raleway',
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'=>'400',
				'font-size'   => '14px', 
				'line-height' => '16px'
			),
		),
		array(
			'id'          => 'mainmenufont',
			'type'        => 'typography', 
			'title'       => __('Main Menu Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('ul.nav-menu li a, div.nav-menu > ul li a, #navbar #site-navigation .mega-menu-wrap .mega-menu.mega-menu-horizontal > li.mega-menu-item > a'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select font, color and size for main menu.', 'apicona'),
			'default'     => array(
				//'color'       => "#303a3b",
				'font-family' => 'Raleway',
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'=>'400',
				'font-weight' => '700',
				'font-size'   => '12px', 
				'line-height' => '12px'
			),
		),
		array(
			'id'          => 'dropdownmenufont',
			'type'        => 'typography', 
			'title'       => __('Dropdown Menu Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => false,
			//'preview'   => false, // Disable the previewer
			'output'      => array('ul.nav-menu li ul li a, div.nav-menu > ul li ul li a'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('Select font, color and size for dropdown menu.', 'apicona'),
			'default'     => array(
				//'color'       => "#303a3b",
				'font-family' => 'Raleway',
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'  =>'400',
				'font-weight' => '400',
				'font-size'   => '13px', 
				'line-height' => '15px'
			),
		),
		array(
			'id'		  => 'elementtitle',
			'type'		  => 'typography', 
			'title'		  => __('Element Title Font', 'apicona'),
			'text-align'  => false,
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			//'font-style'=> false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => true,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'      => false,
			//'preview'  => false, // Disable the previewer
			'output'     => array('.wpb_tabs_nav a.ui-tabs-anchor, .wpb_accordion_header > a, .vc_progress_bar .vc_label'), // An array of CSS selectors to apply this font style to dynamically
			'units'      => 'px', // Defaults to px
			'subtitle'   => __('This will be applied to Tab title, Accordion Title and Progress Bar title text.', 'apicona'),
			'default'    => array(
				//'color'       => "#303a3b",
				'font-family' => 'Raleway',
				"font-backup" => "'Trebuchet MS', Helvetica, sans-serif",
				//'font-style'  =>'400',
				'font-size'   => '13px', 
				'line-height' => '15px'
			),
		),
	),
);



$sections[] = array(
	'title'      => __('Floating Bar Settings', 'apicona'),
	'customizer' => false,
	'header'     => __('Doctor\'s Search Bar Settings', 'apicona'),
	'desc'       => __('This is floating bar and we are using it as Doctor\'s Search Bar.', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'       => 'el-icon-upload',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'topbar_show_team_search',
			'type'     => 'switch',
			'title'    => __('Show Team Member Search Box', 'apicona'), 
			'subtitle' => __('Show Team Member search box in Topbar', 'apicona'),
			'default'  => '1', // 1 = on | 0 = off
			//'required' => array('topbarhide','equals','0'),
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
		),
		array(
			'id'       => 'topbar_handler_icon',
			'type'     => 'kwayy_icon_select',
			'data'     => 'elusive',
			'title'    => __('Open Link Icon', 'apicona'), 
			'subtitle' => __('Select icon for the link to open the Doctor\'s search box', 'apicona'),
			'default'  => 'fa-user-md', // 1 = on | 0 = off
			//'required' => array('topbarhide','equals','0'),
		),
		array(
			'id'       => 'topbar_handler_icon_close',
			'type'     => 'kwayy_icon_select',
			'data'     => 'elusive',
			'title'    => __('Close Link Icon', 'apicona'), 
			'subtitle' => __('Select icon for the link to close the Doctor\'s search box', 'apicona'),
			'default'  => 'fa-times', // 1 = on | 0 = off
			//'required' => array('topbarhide','equals','0'),
		),
		array(
			'id'    =>'html-fbar-texts',
			'type'  => 'info',
			'title' => __('Texts for the Floating Bar Form', 'apicona'), 
			'desc'  => __('Edit texts for the Floating Bar form.', 'apicona'),
		),
		array(
			'id'       => 'fbar-form-title',
			'type'     => 'text',
			'title'    => __('Search Form Title', 'apicona'),
			'subtitle' => __('Insert Search Form title. <br> Default is <code>Doctor\'s Search</code>', 'apicona'),
			'default'  => __('Doctor\'s Search', 'apicona'),
		),
		array(
			'id'       => 'fbar-form-input-text',
			'type'     => 'text',
			'title'    => __('Text for Form Input field', 'apicona'),
			'subtitle' => __('Insert Search Form input text. <br> Default is <code>Search by name</code>', 'apicona'),
			'default'  => __('Search by name', 'apicona'),
		),
		array(
			'id'       => 'fbar-form-select-group',
			'type'     => 'text',
			'title'    => __('Text for Select Section', 'apicona'),
			'subtitle' => __('Insert Search Form input text. <br> Default is <code>All sections</code>', 'apicona'),
			'default'  => __('All sections', 'apicona'),
		),
		array(
			'id'       => 'fbar-form-btn-text',
			'type'     => 'text',
			'title'    => __('Insert form button text', 'apicona'),
			'subtitle' => __('Insert form button text. <br> Default is <code>Search</code>', 'apicona'),
			'default'  => __('Search', 'apicona'),
		),
	),
);


// Topbar Settings
$sections[] = array(
	'title'  => __('Topbar Settings', 'apicona'),
	'customizer'=> false,
	'header' => __('Topbar Settings', 'apicona'),
	'desc'   => __('Topbar settings', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-tasks',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'topbarhide',
			'type'     => 'switch',
			'title'    => __('Hide Topbar', 'apicona'), 
			'subtitle' => __('Check this option to hide the Topbar', 'apicona'),
			'default'  => '0', // 1 = on | 0 = off
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
		),
		
		array(
			'id'       => 'topbarbgcolor',
			'type'     => 'color',
			'title'    => __('Topbar Background Color', 'apicona'),
			'subtitle' => __('Custom background color for Topbar.', 'apicona'),
			'default'  => '#f7f7f7',
			'required' => array('topbarhide','equals','0'),
			'validate' => 'color',
		),
		array(
			'id'       => 'topbar_text_color',
			'type'     => 'select',
			'title'    => __('Topbar Text Color', 'apicona'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option.', 'apicona'),
			'required' => array('topbarhide','equals','0'),
			'options'  => array(
					'white'  => __('White', 'apicona'),
					'dark'   => __('Dark', 'apicona'),
				),
			'default' => 'dark'
		),
		
		array(
			'id'    =>'html-topbarleft',
			'type'  => 'info',
			'title' => __('Topbar Left Area Content', 'apicona'), 
			'desc'  => __('Content for Topbar left side area.', 'apicona'),
        ),
		array(
			'id'       => 'topbartext',
			'type'     => 'textarea',
			'title'    => __('Topbar Text', 'apicona'), 
			'subtitle' => __('Add content for Topbar text', 'apicona'),
			'desc'     => __('HTML tags and shortcodes are allowed', 'apicona'),
			'required' => array('topbarhide','equals','0'),
			//'validate' => 'html',
			'default'  => '<ul class="top-contact"><li><i class="kwicon-fa-phone"></i>Call us now! <strong>0123 444 333</strong></li><li><i class="kwicon-fa-envelope-o"></i>info@example.com</li><li><i class="kwicon-fa-map-marker"></i>Find our Location</li></ul>'
		),
		
		array(
			'id'    =>'html-topbarright',
			'type'  => 'info',
			'title' => __('Topbar Right Area Content', 'apicona'), 
			'desc'  => __('Content for Topbar right side area.', 'apicona'),
        ),
		array(
			'id'       => 'topbarhidesocial',
			'type'     => 'switch',
			'title'    => __('Hide Social Icons in Topbar', 'apicona'), 
			'subtitle' => __('Check this option to hide the Social icons in Topbar', 'apicona'),
			'default'  => '0', // 1 = on | 0 = off
			'required' => array('topbarhide','equals','0'),
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
		),
		array(
			'id'       => 'topbarrighttext',
			'type'     => 'textarea',
			'title'    => __('Topbar Text For Right Area', 'apicona'), 
			'subtitle' => __('This content will appear after social links', 'apicona'),
			'desc'     => __('HTML tags and shortcodes are allowed', 'apicona'),
			'required' => array('topbarhide','equals','0'),
			//'validate' => 'html',
		),
		
	),
);


// Titlebar Settings
$sections[] = array(
	'title'  => __('Titlebar Settings', 'apicona'),
	'header' => __('Titlebar Settings', 'apicona'),
	'desc'   => __('Settings for titlebar', 'apicona'),
	'icon_class' => 'icon-large',
	'customizer' => false,
    'icon'   => 'el-icon-lines',
	'fields' => array(
		array(
			'id'       => 'titlebar_bg_image_type',
			'type'     => 'select',
			'title'    => __('Titlebar Background Type', 'apicona'), 
			'subtitle' => __('Please select background type for the titlebar', 'apicona'),
			'options'  => array(
					'noimg'      => __('Color only', 'apicona'),
					'predefined' => __('Color and predefined image (select from below)', 'apicona'),
					'custom'     => __('Color and custom image (select from below)', 'apicona'),
				),
			'default' => 'predefined'
		),
		array(
			'id'       => 'titlebar_bg_color',
			'type'     => 'color',
			'title'    => __('Titlebar Background Color', 'apicona'),
			'subtitle' => __('Custom color for titlebar background.', 'apicona'),
			'default'  => '#000000',
			'validate' => 'color',
		),
		array(
			'id'       => 'titlebar_text_color',
			'type'     => 'select',
			'title'    => __('Titlebar Text Color', 'apicona'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option.', 'apicona'),
			'options'  => array(
					'white'  => __('White', 'apicona'),
					'dark'   => __('Dark', 'apicona'),
				),
			'default' => 'white'
		),
		array(
			'id'       => 'titlebar_bg_image',
			'type'     => 'image_select',
			'title'    => __('Titlebar Background Image', 'apicona'), 
			'subtitle' => __('Please select image for background of titlebar', 'apicona'),
			'options'  => array(
				'1' => array(
					'alt' => __('Image 1', 'apicona'),
					'img' => get_template_directory_uri() . '/images/titlebg/bg-title1.jpg'
				),
				'2' => array(
					'alt' => __('Image 2', 'apicona'),
					'img' => get_template_directory_uri() . '/images/titlebg/bg-title2.jpg'
				),
				'3' => array(
					'alt' => __('Image 3', 'apicona'),
					'img' => get_template_directory_uri() . '/images/titlebg/bg-title3.jpg'
				),
				'4' => array(
					'alt' => __('Image 4', 'apicona'),
					'img' => get_template_directory_uri() . '/images/titlebg/bg-title4.jpg'
				),
				'5' => array(
					'alt' => __('Image 5', 'apicona'),
					'img' => get_template_directory_uri() . '/images/titlebg/bg-title5.jpg'
				),
			),
			'default'  => '1',
			'required' => array('titlebar_bg_image_type','equals','predefined'),
		),
		array(
			'id'       => 'titlebar_bg_custom_image',
			'type'     => 'media',
			'required' => array('titlebar_bg_image','equals','custom'),
			'url'      => false,
			'title'    => __('Select Custom Titlebar Background Image', 'apicona'),
			'subtitle' => __('Upload your own image that will be used as background for the Titlebar box.', 'apicona'),
			'compiler' => 'true',
			//'default'=>array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
			'required' => array('titlebar_bg_image_type','equals','custom'),
		),
		
		
		array(
			'id'    =>'html-adv_titlebaroptions',
			'type'  => 'info',
			'title' => __('Titlebar Options', 'apicona'), 
			'desc'  => __('Change settings for Titlebar.', 'apicona')
        ),
		array(
			'id'       => 'adv_tbar_catarc',
			'type'     => 'text',
			'title'    => __('Post Category <code>Category Archives:</code> Label Text', 'apicona'),
			//'subtitle' => __('Post <code>Category Archives:</code> Label Text', 'apicona'),
			'default'  => 'Category Archives: ',
		),
		array(
			'id'       => 'adv_tbar_tagarc',
			'type'     => 'text',
			'title'    => __('Post Tag <code>Tag Archives:</code> Label Text', 'apicona'),
			//'subtitle' => __('Post <code>Tag Archives:</code> Label Text', 'apicona'),
			'default'  => 'Tag Archives: ',
		),
		array(
			'id'       => 'adv_tbar_postclassified',
			'type'     => 'text',
			'title'    => __('Post Taxonomy <code>Posts classified under:</code> Label Text', 'apicona'),
			//'subtitle' => __('Post Taxonomy <code>Posts classified under:</code> Label Text', 'apicona'),
			'default'  => 'Posts classified under: ',
		),
		array(
			'id'       => 'adv_tbar_authorarc',
			'type'     => 'text',
			'title'    => __('Post Author <code>Author Archives:</code> Label Text', 'apicona'),
			//'subtitle' => __('Post Author <code>Author Archives:</code> Label Text', 'apicona'),
			'default'  => 'Author Archives: ',
		),
		
	),
);


// Header Settings
$sections[] = array(
	'title'  => __('Header Settings', 'apicona'),
	'header' => __('Header Settings', 'apicona'),
	'desc'   => __('Header settings', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-th-list',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'headerbgcolor',
			'type'     => 'color',
			'title'    => __('Header Background Color', 'apicona'),
			'subtitle' => __('Custom color for header background.', 'apicona'),
			'default'  => '#ffffff',
			'validate' => 'color',
		),
		array(
			'id'       => 'header_text_color',
			'type'     => 'select',
			'title'    => __('Header Text Color', 'apicona'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option.', 'apicona'),
			'options'  => array(
					'white'  => __('White', 'apicona'),
					'dark'   => __('Dark', 'apicona'),
				),
			'default' => 'dark'
		),
		array(
			'id'       => 'logotype',
			'type'     => 'radio',
			'title'    => __('Logo type', 'apicona'), 
			'subtitle' => __('Specify the type of logo. It can be or the text or the image', 'apicona'),
			'options'  => array( 'text' => __('Logo as Text', 'apicona'), 'image' => __('Logo as Image', 'apicona') ),
			'default'  => 'image'
		),
		array(
			'id'       => 'logotext',
			'type'     => 'text',
			'required' => array('logotype','equals','text'),
			'title'    => __('Logo Text', 'apicona'),
			'subtitle' => __('Enter the text to be used instead of the logo image', 'apicona'),
			'default'  => 'Api<span>cona</span>'
		),
		array(
			'id'          => 'logo_font',
			'type'        => 'typography', 
			'required'    => array('logotype','equals','text'),
			'title'       => __('Logo Font', 'apicona'),
			//'compiler'  => true, // Use if you want to hook in your own CSS compiler
			'google'      => true, // Disable google fonts. Won't work if you haven't defined your google api key
			'text-align'  => false,
			'font-backup' => true, // Select a backup non-google font in addition to a google font
			'font-style'  => false, // Includes font-style and weight. Can use font-style or font-weight to declare
			'subsets'     => false, // Only appears if google is true and subsets not set to false
			//'font-size' => false,
			'line-height' => false,
			//'word-spacing' => true, // Defaults to false
			//'letter-spacing' => true, // Defaults to false
			'color'       => true,
			//'preview'   => false, // Disable the previewer
			'output'      => array('h1.site-title a'), // An array of CSS selectors to apply this font style to dynamically
			'units'       => 'px', // Defaults to px
			'subtitle'    => __('This will be applied to logo text only. Select Logo font-style and size', 'apicona'),
			'default'     => array(
				'google'        => true,
				'font-family'   => 'Seaweed Script',
				"font-backup"   => "'Times New Roman', Times,serif",
				//'font-style'  => '700', 
				'font-weight'   => '400',
				'font-size'     => '36px', 
				'color'         => "#303a3b", 
				//'line-height' => '40px'
			),
		),
		array(
			'id'       => 'logoimg',
			'type'     => 'media',
			'required' => array('logotype','equals','image'),
			'url'      => false,
			'title'    => __('Logo Image', 'apicona'),
			'subtitle' => __('Upload own image that will be used as logo for the site', 'apicona'),
			'compiler' => 'true',
			'default'  => array(
							'url'    => get_template_directory_uri() . '/images/logo.png',
							'width'  => 374,
							'height' => 100,
			),
		),
		array(
			'id'       => 'logoimg_sticky',
			'type'     => 'media',
			'required' => array('logotype','equals','image'),
			'url'      => false,
			'title'    => __('Logo Image for Sticky Header', 'apicona'),
			'subtitle' => __('Upload image that will be used as logo for sticky header', 'apicona'),
			'compiler' => 'true',
		),
		array(
			'id'            => 'logo-max-height',
			'type'          => 'slider',
			'title'         => __( 'Logo Max Height', 'apicona' ),
			'subtitle'      => __( 'If you feel your logo looks small than increase this and adjust it.', 'apicona' ),
			'desc'          => __( 'If you feel your logo looks small than increase this and adjust it.', 'apicona' ),
			'default'       => 50,
			'min'           => 30,
			'step'          => 1,
			'max'           => 190,
			'display_value' => 'text',
			'required'      => array('logotype','equals','image'),
		),
		array(
			'id'            => 'logo-max-height-sticky',
			'type'          => 'slider',
			'title'         => __( 'Logo Max Height when Sticky Header', 'apicona' ),
			'subtitle'      => __( 'Set logo when the header is sticky.', 'apicona' ),
			'desc'          => __( 'Set logo when the header is sticky.', 'apicona' ),
			'default'       => 50,
			'min'           => 10,
			'step'          => 1,
			'max'           => 190,
			'display_value' => 'text',
			'required'      => array('logotype','equals','image'),
		),
		array(
			'id'            => 'header-height',
			'type'          => 'slider',
			'title'         => __( 'Header Height (in pixel)', 'apicona' ),
			'subtitle'      => __( 'You can set height of header area from here', 'apicona' ),
			'desc'          => __( 'You can set height of header area from here', 'apicona' ),
			'default'       => 105,
			'min'           => 60,
			'step'          => 1,
			'max'           => 200,
			'display_value' => 'text',
			//'required'      => array( 'headerstyle', 'equals', array('1','2') ),
		),
		array(
			'id'            => 'header-height-sticky',
			'type'          => 'slider',
			'title'         => __( 'Sticky Header Height (in pixel)', 'apicona' ),
			'subtitle'      => __( 'You can set height of header area when it becomes sticky', 'apicona' ),
			'desc'          => __( 'You can set height of header area when it becomes sticky', 'apicona' ),
			'default'       => 76,
			'min'           => 60,
			'step'          => 1,
			'max'           => 160,
			'display_value' => 'text',
			//'required'      => array( 'headerstyle', 'equals', array('1','2') ),
		),
		
		/*array(
			'id'       => 'logoimg_retina',
			'type'     => 'media',
			'required' => array('logotype','equals','image'),
			'url'      => false,
			'title'    => __('Retina Logo Image', 'apicona'),
			'subtitle' => __('Upload retina-ready logo image that will be used as logo for the site. Please note that the image size should be double sized (2x in width and height both) than normal logo (above option). Maximum height should be <strong>200 pixel</strong>.', 'apicona'),
			'compiler' => 'true',
		),*/
		
		array(
			'id'    =>'html-showsearchbtn',
			'type'  => 'info',
			'title' => __('Search Button in Header', 'apicona'), 
			'desc'  => __('Option to show or hide search button in header area.', 'apicona'),
		),
		array(
			'id'       => 'header_search',
			'type'     => 'switch',
			'title'    => __('Show Search Button', 'apicona'), 
			'subtitle' => __('Set this option <code>YES</code> to show search button in header. The icon will be at the right side (after menu).', 'apicona'),
			'default'  => '0', // 1 = on | 0 = off
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
		),
		array(
			'id'       => 'search_title',
			'type'     => 'text',
			'title'    => __('Search Form Title', 'apicona'),
			'subtitle' => __('Write the search form title here. <br> Default: <code>Just type and press \'enter\'</code>', 'apicona'),
			'default'  => __("Just type and press 'enter'", 'apicona'),
		),
		array(
			'id'       => 'search_input',
			'type'     => 'text',
			'title'    => __('Search Form Input Word', 'apicona'),
			'subtitle' => __('Write the search form input word here. <br> Default: <code>WRITE SEARCH WORD...</code>', 'apicona'),
			'default'  => __("WRITE SEARCH WORD...", 'apicona'),
		),
		array(
			'id'       => 'search_close',
			'type'     => 'text',
			'title'    => __('Search Form Close Button Text (SEO purpose)', 'apicona'),
			'subtitle' => __('Write the search form close button text here. This is for SEO purpose only. <br> Default: <code>Close search</code>', 'apicona'),
			'default'  => __("Close search", 'apicona'),
		),
		
		array(
			'id'    =>'html-stickyheader',
			'type'  => 'info',
			'title' => __('Sticky Header', 'apicona'), 
			'desc'  => __('Options for sticky header', 'apicona')
        ),
		array(
			'id'       => 'stickyheader',
			'type'     => 'radio',
			'customizer' => false,
			'title'    => __('Enable Sticky Header', 'apicona'), 
			'subtitle' => __('Select YES if you want the sticky header on page scroll', 'apicona'),
			'options'  => array( 'y' => __('Yes', 'apicona'), 'n' => __('No', 'apicona') ),
			'default'  => 'y'
		),
		array(
			'id'    =>'html-headerstyle',
			'type'  => 'info',
			'title' => __('Header Style', 'apicona'), 
			'desc'  => __('Options to change header style', 'apicona')
        ),
		array(
			'id'       => 'headerstyle',
			'type'     => 'image_select',
			'title'    => __('Select Header Style', 'apicona'), 
			'subtitle' => __('Please select header style', 'apicona'),
			'options' => array(
				'1' => array(
					'alt' => __('Left logo and right menu', 'apicona'),
					'img' => get_template_directory_uri() . '/inc/images/header-style1.png'
				),
				'4' => array(
					'alt' => __('Right logo and left menu', 'apicona'),
					'img' => get_template_directory_uri() . '/inc/images/header-style4.png'
				),
				'2' => array(
					'alt' => __('Centre logo between menu', 'apicona'),
					'img' => get_template_directory_uri() . '/inc/images/header-style2.png'
				),
				'3' => array(
					'alt' => __('Centre logo above menu', 'apicona'),
					'img' => get_template_directory_uri() . '/inc/images/header-style3.png'
				),
			),
			'default' => '1'
		),
		array(
			'id'            => 'center-logo-width',
			'type'          => 'slider',
			'title'         => __( 'Logo Area Width (pixel)', 'apicona' ),
			'subtitle'      => __( 'This is the width of the logo area. This is for centre-logo header style only.', 'apicona' ),
			'desc'          => __( 'You need to change this only when your menu overlays on the logo. This should be bigger that the logo width (ignore this if retina logo). Please set this and check your site for best results.', 'apicona' ),
			'default'       => 350,
			'min'           => 10,
			'step'          => 5,
			'max'           => 500,
			'display_value' => 'text',
			'required'      => array('headerstyle', 'equals', '2'),
		),
		array(
			'id'            => 'first-menu-margin',
			'type'          => 'slider',
			'title'         => __( 'Menu Left margin (pixel)', 'apicona' ),
			'subtitle'      => __( 'This is to set the logo appear at center with the menu. The logo will be always center. This is an advanced option.', 'apicona' ),
			'desc'          => __( 'You need to change this only when you feel your menu is not center aligned with logo. Please set this and check your site for best results.', 'apicona' ),
			'default'       => 0,
			'min'           => -500,
			'step'          => 5,
			'max'           => 500,
			'display_value' => 'text',
			'required'      => array('headerstyle', 'equals', '2'),
		),
		
		// SEO Settings
		array(
			'id'    =>'html-seosettings',
			'type'  => 'info',
			'title' => __('Logo SEO', 'apicona'), 
			'desc'  => __('Options for Logo SEO', 'apicona'),
        ),
		array(
			'id'       => 'logoseo',
			'type'     => 'radio',
			'title'    => __('Logo Tag for SEO', 'apicona'), 
			'subtitle' => __('Select logo tag for SEO purpose.', 'apicona'),
			'options'  => array(
				'h1homeonly' => __('H1 for home, SPAN on other pages', 'apicona'),
				'allh1'      => __('H1 tag everywhere', 'apicona'),
			),
			'default'  => 'h1homeonly',
			'std'      => 'h1homeonly',
		),
		
	),
);


// Footer Settings
$sections[] = array(
	'title'  => __('Footer Settings', 'apicona'),
	'header' => __('Footer Settings', 'apicona'),
	'desc'   => __('Settings of the elements from the page footer area', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-return-key',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'    =>'html-stickyfooter',
			'type'  => 'info',
			'title' => __('Sticky Footer', 'apicona'), 
			'desc'  => __('Make footer sticky and visible on scrolling at bottom.', 'apicona')
        ),
		array(
			'id'    =>'html-footer_column_layout',
			'type'  => 'info',
			'title' => __('Footer Column layout View', 'apicona'), 
			'desc'  => __('Change view of Footer Columns.', 'apicona')
        ),
		array(
			'id'      => 'footer_column_layout',
			'type'    => 'image_select',
			'title'   => __('Select Footer Column layout View', 'apicona'), 
			'desc'    => __('Select Footer Column layout View.', 'apicona'),
			'options' => array(
				'12' => array('title' => __('One Column', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_12.png'),
				'6_6' => array('title' => __('Two Columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_6_6.png'),
				'4_4_4' => array('title' => __('Three Columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_4_4_4.png'),
				'3_3_3_3' => array('title' => __('Four Columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_3_3_3_3.png'),
				
				
				'8_4' => array('title' => __('8 + 4 Columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_8_4.png'),
				'4_8' => array('title' => __('4 + 8 Columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_4_8.png'),
				
				'6_3_3' => array('title' => __('6 + 3 + 3 columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_6_3_3.png'),
				'3_3_6' => array('title' => __('3 + 3 + 6 columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_3_3_6.png'),
				'8_2_2' => array('title' => __('8 + 2 + 2 columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_8_2_2.png'),
				'2_2_8' => array('title' => __('2 + 2 + 8 columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_2_2_8.png'),
				
				'6_2_2_2' => array('title' => __('6 + 2 + 2 + 2 columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_6_2_2_2.png'),
				'2_2_2_6' => array('title' => __('2 + 2 + 2 + 6 columns', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/footer_col_2_2_2_6.png'),
			),
			'default' => '3_3_3_3'
		),
		array(
			'id'         => 'stickyfooter',
			'type'       => 'switch',
			'title'      => __('Sticky Footer', 'apicona'), 
			'subtitle'   => __('Set this option <code>YES</code> to enable sticky footer on scrolling at bottom.', 'apicona'),
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
			'default'    => '0', // 1 = on | 0 = off
			'customizer' => false,
		),

		array(
			'id'    =>'html-footerwidgetarea',
			'type'  => 'info',
			'title' => __('Footer Widget Area', 'apicona'), 
			'desc'  => __('Options to change settings for footer widget area.', 'apicona')
        ),
		array(
			'id'       => 'footerwidget_bgcolor',
			'type'     => 'color',
			'title'    => __('Footer Background Color', 'apicona'),
			'subtitle' => __('Custom color for footer background.', 'apicona'),
			'default'  => '#222222',
			'validate' => 'color',
		),
		array(
			'id'            => 'footerwidget_bgimage',
			'type'          => 'background',
			'title'         => __('Footer Background', 'apicona'),
			'subtitle'      => __('Footer background image', 'apicona'),
			'preview_media' => true,
			'background-color' => false,
			'output'        => array('#page footer.site-footer > div.footer'),
			'default'       => array(
								"background-repeat"   => "no-repeat",
								"background-position" => "center center",
								"background-image"    => get_template_directory_uri() . '/images/map.png',
							),
			'customizer'=> false,
		),
		array(
			'id'       => 'footerwidget_color',
			'type'     => 'select',
			'title'    => __('Text Color', 'apicona'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option.', 'apicona'),
			'options'  => array(
					'white'  => __('White', 'apicona'),
					'dark'   => __('Dark', 'apicona'),
				),
			'default' => 'white'
		),
		array(
			'id'    =>'html-footertextarea',
			'type'  => 'info',
			'title' => __('Footer Text Area', 'apicona'), 
			'desc'  => __('Options to change settings for footer text area. This contains copyright info.', 'apicona')
        ),
		array(
			'id'       => 'footertext_bgcolor',
			'type'     => 'color',
			'title'    => __('Footer Background Color', 'apicona'),
			'subtitle' => __('Custom color for footer background.', 'apicona'),
			'default'  => '#1c1c1c',
			'validate' => 'color',
		),
		array(
			'id'       => 'footertext_color',
			'type'     => 'select',
			'title'    => __('Text Color', 'apicona'), 
			'subtitle' => __('Select <code>Dark</code> color if you are going to select light color in above option.', 'apicona'),
			'options'  => array(
					'white'  => __('White', 'apicona'),
					'dark'   => __('Dark', 'apicona'),
				),
			'default' => 'white'
		),
		array(
			'id'=>'copyrights',
			'type' => 'editor',
			'title' => __('Footer Text', 'apicona'), 
			'subtitle' => __('You can use the following shortcodes in your footer text: <code>[site-url]</code> <code>[site-title]</code> <code>[site-tagline]</code> <code>[current-year]</code>', 'apicona'),
			'default' => 'Copyright &copy; [current-year] <a href="[site-url]">[site-title]</a>. All rights reserved.',
		),
	),
);



// Login Page Settings
$sections[] = array(
	'title'  => __('Login Page Settings', 'apicona'),
	'header' => __('Login Page Settings', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Set options for login page.', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-lock',
	'fields' => array(
		array(
			'id'            => 'login_background',
			'type'          => 'background',
			'title'         => __('Background Properties', 'apicona'),
			'subtitle'      => __('Specify the type of background object.', 'apicona'),
			'preview_media' => true,
			//'output'        => array('body.login'),
			'default'       => array( "background-color"    => "#ffffff",
									  "background-image"    => get_template_directory_uri().'/images/login-bg-image.jpg',
									  "background-repeat"   => "no-repeat",
									  "background-size"     => "contain",
									  "background-position" => "left top",
								),
			'customizer'=> false,
		),
	),
);





// Blog Settings
$sections[] = array(
	'title'  => __( 'Blog Settings', 'apicona'),
	'header' => __( 'Blog Settings', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Settings for Blog section.', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-pencil',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		/*array(
			'id'    =>'html-blogsettings',
			'type'  => 'info',
			'title' => __('Blog Settings', 'apicona'), 
			'desc'  => __('Settings for blog section.', 'apicona')
        ),*/
		array(
			'id'       => 'blog_text_limit',
			'type'     => 'slider',
			'title'    => __('Blog Excerpt Limit (in words)', 'apicona'),
			'subtitle' => __('Set limit for small description. Select how many words you like to show. <br><strong>TIP: </strong> Select <code>0</code> (zero) to show excerpt or content before READ MORE break. <br>  ', 'apicona'),
			//'desc'     => __( 'Select how many products you want to show in the Related prodcuts area on single product page.', 'apicona' ),
			'default'  => 0,
			'min'      => 0,
			'step'     => 1,
			'max'      => 500,
			'display_value' => 'text',
		),
		array(
			'id'       => 'blog_view',
			'type'     => 'select',
			'title'    => __('Blog view', 'apicona'), 
			'subtitle' => __('Select blog view. The default view is classic list view. You can select two, three or four column blog view from here.', 'apicona'),
			'options'  => array(
					'classic' => __('Classic View (default)', 'apicona'),
					'two'     => __('Two Column view', 'apicona'),
					'three'   => __('Three Column view', 'apicona'),
					'four'    => __('Four Column view', 'apicona'),
				),
			'default' => 'classic'
		),
		array(
			'id'         => 'tbar_title',
			'type'       => 'switch',
			'title'      => __('Show Post-Title in Title Bar', 'apicona'), 
			'subtitle'   => __('Set this option <code>YES</code> to show Post-Title in Title bar instead of "Blog" title.', 'apicona'),
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
			'default'    => '0', // 1 = on | 0 = off
			'customizer' => false,
		),
		array(
			'id'         => 'tbar_title_content_hide',
			'type'       => 'switch',
			'title'      => __('Hide Post-Title in Content Area', 'apicona'), 
			'subtitle'   => __('Set this option <code>YES</code> to hide Post-Title in Content area (below the featured image).', 'apicona'),
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
			'default'    => '0', // 1 = on | 0 = off
			'customizer' => false,
		),
	),
);




// Doctors Settings
$sections[] = array(
	'title'  => __( $apicona['team_type_title'].' Settings', 'apicona'),
	'header' => __( $apicona['team_type_title'].' (Team Members) Settings', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Settings for <strong>'.$apicona['team_type_title'].'</strong> custom post type. We are using "Team member" custom post type as <strong>'.$apicona['team_type_title'].'</strong>. Here are some settings for this post type.', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-user',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'team_before_title_text',
			'type'     => 'text',
			'title'    => __('Text Before Name of Member', 'apicona'),
			'subtitle' => __('Text before name of Member (for single page only).', 'apicona'),
			'default'  => 'About',
		),
	),
);



// Portfolio Settings
$sections[] = array(
	'title'  => __('Portfolio Settings', 'apicona'),
	'header' => __('Portfolio Settings', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Portfolio section settings.', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-th-large',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'    =>'html-portfoliobox',
			'type'  => 'info',
			'title' => __('Porftolio Box Settings', 'apicona'), 
			'desc'  => __('Options to change settings for portfolio box which you insert via Visual Composer.', 'apicona')
        ),
		array(
			'id'       => 'portfolio_show_like',
			'type'     => 'switch',
			'title'    => __('Show Like Option', 'apicona'), 
			'subtitle' => __('Select "NO" to hide the like option in the portfolio box.', 'apicona'),
			'default'  => '1', // 1 = on | 0 = off
			'on'       => 'Yes',
			'off'      => 'No',
		),
		array(
			'id'    =>'html-singleportfolio',
			'type'  => 'info',
			'title' => __('Single Porftolio Settings', 'apicona'), 
			'desc'  => __('Options to change settings for single portfolio.', 'apicona')
        ),
		array(
			'id'       => 'portfolio_show_related',
			'type'     => 'switch',
			'title'    => __('Show Related Portfolio', 'apicona'), 
			'subtitle' => __('Select YES to show related portfolio on single portfolio page.', 'apicona'),
			'default'  => '1', // 1 = on | 0 = off
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
		),
		array(
			'id'       => 'portfolio_description',
			'type'     => 'text',
			'title'    => __('Description Title', 'apicona'),
			'subtitle' => __('Title for the "Description" area. (For single portfolio only)', 'apicona'),
			'default'  => __('Details', 'apicona'),
		),
		array(
			'id'       => 'portfolio_project_details',
			'type'     => 'text',
			'title'    => __('Project Details Title', 'apicona'),
			'subtitle' => __('Title for the "Project Details" area. (For single portfolio only)', 'apicona'),
			'default'  => __('Research Details', 'apicona'),
		),
		array(
			'id'       => 'portfolio_related_title',
			'type'     => 'text',
			'title'    => __('Related Portfolio Title', 'apicona'),
			'subtitle' => __('Title for the Releated Portfolio area. (For single portfolio only)', 'apicona'),
			'default'  => __('Related Research', 'apicona'),
		),
	),
);





// Error 404 Page Settings
$sections[] = array(
	'title'  => __('Error 404 Page Settings', 'apicona'),
	'header' => __('Error 404 Page Settings', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Settings that determine how the error page will be looking', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-warning-sign',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'error404',
			'type'     => 'textarea',
			'title'    => __('Error 404 Page Content', 'apicona'), 
			'subtitle' => __('Content of the page if error 404 occurred', 'apicona'),
			'desc'     => __('HTML tags and shortcodes are allowed', 'apicona'),
			//'validate' => 'html',
			'default'  => __('<div class="kwayy-big-icon"><i class="kwicon-fa-warning"></i></div><h1>404 ERROR</h1><p>This file may have been moved or deleted. Be sure to check your spelling.</p><a class="vc_btn vc_btn_skincolor vc_btn_md vc_btn_round" title="Back to Home" href="#">Back to Home</a><br><br><br>', 'apicona'),
		),
		array(
			'id'       => 'error404_search',
			'type'     => 'switch',
			'title'    => __('Show Search Form', 'apicona'), 
			'subtitle' => __('Set this option <code>YES</code> to show search form on the 404 page.', 'apicona'),
			'default'  => '1', // 1 = on | 0 = off
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
		),
	),
);


// Search Page Settings
$sections[] = array(
	'title'  => __('Search Page Settings', 'apicona'),
	'header' => __('Search Page Settings', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Settings that determine how the search results page will be looking', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-search',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'searchnoresult',
			'type'     => 'textarea',
			'title'    => __('Content of the search page if no results found', 'apicona'), 
			'subtitle' => __('Specify the content of the page that will be displayed if while search no results found', 'apicona'),
			'desc'     => __('HTML tags and shortcodes are allowed', 'apicona'),
			//'validate' => 'html',
			'default'  => __('<div class="kwayy-big-icon"><i class="kwicon-fa-search"></i></div><h4>No results were found for your search</h4></br>You may try the search with another query.<br><br><br>', 'apicona'),
		),
	),
);



// Sidebars
$sections[] = array(
	'title'  => __('Sidebar', 'apicona'),
	'customizer'=> false,
	'header' => __('Sidebar', 'apicona'),
	'desc'   => __('Setup some extra sidebars for a page widgets', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-pause',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'sidebars',
			'type'     => 'multi_text',
			'title'    => __('Custom Sidebars', 'apicona'),
			'subtitle' => __('Specify the custom sidebars that can be used in the pages for a widgets', 'apicona'),
		),
		array(
			'id'    =>'html-sidebars',
			'type'  => 'info',
			'title' => __('Sidebar Position', 'apicona'), 
			'desc'  => __('Select sidebar position for different sections.', 'apicona')
        ),
		array(
			'id'      => 'sidebar_page',
			'type'    => 'image_select',
			'title'   => __('Standard Pages Sidebar', 'apicona'), 
			'desc'    => __('Select one of layouts for standard pages', 'apicona'),
			'options' => array(
				'no'        => array('title' => __('No Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_no_side.png'),
				'left'      => array('title' => __('Left Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_left.png'),
				'right'     => array('title' => __('Right Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_right.png'),
				'both'      => array('title' => __('Both Sidebars', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_both.png'),
				'bothleft'  => array('title' => __('Both at Left', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_left_both.png'),
				'bothright' => array('title' => __('Both at Right', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_right_both.png'),
			),
			'default' => 'right'
		),
		array(
			'id'      => 'sidebar_blog',
			'type'    => 'image_select',
			'title'   => __('Blog Page Sidebar', 'apicona'), 
			'desc'    => __('Select one of layouts for blog page', 'apicona'),
			'options' => array(
				'no'        => array('title' => __('No Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_no_side.png'),
				'left'      => array('title' => __('Left Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_left.png'),
				'right'     => array('title' => __('Right Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_right.png'),
				'both'      => array('title' => __('Both Sidebars', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_both.png'),
				'bothleft'  => array('title' => __('Both at Left', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_left_both.png'),
				'bothright' => array('title' => __('Both at Right', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_right_both.png'),
			),
			'default' => 'right'
		),
		array(
			'id'      => 'sidebar_search',
			'type'    => 'image_select',
			'title'   => __('Search Page Sidebar', 'apicona'), 
			'desc'    => __('Select one of layouts for search page', 'apicona'),
			'options' => array(
				'no'        => array('title' => __('No Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_no_side.png'),
				'left'      => array('title' => __('Left Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_left.png'),
				'right'     => array('title' => __('Right Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_right.png'),
				'both'      => array('title' => __('Both Sidebars', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_both.png'),
				'bothleft'  => array('title' => __('Both at Left', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_left_both.png'),
				'bothright' => array('title' => __('Both at Right', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_right_both.png'),
			),
			'default' => 'right'
		),
		array(
			'id'      => 'sidebar_woocommerce',
			'type'    => 'image_select',
			'title'   => __('WooCommerce Sidebar', 'apicona'), 
			'desc'    => __('Select sidebar position for WooCommerce Shop and Single Product page', 'apicona'),
			'options' => array(
				'left'  => array('title' => __('Left Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_left.png'),
				'right' => array('title' => __('Right Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_right.png'),
			),
			'default' => 'right'
		),
		array(
			'id'      => 'sidebar_bbpress',
			'type'    => 'image_select',
			'title'   => __('BBPress Sidebar', 'apicona'), 
			'desc'    => __('Select sidebar position for BBPress pages', 'apicona'),
			'options' => array(
				'left'  => array('title' => __('Left Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_left.png'),
				'right' => array('title' => __('Right Sidebar', 'apicona'), 'img' => get_template_directory_uri() . '/inc/images/layout_right.png'),
			),
			'default' => 'right'
		),
	),
);


// Social Links
$sections[] = array(
	'title'  => __('Social Links', 'apicona'),
	'header' => __('Social Links', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Setup social links to show in header and footer', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-group',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'     => 'kwayy-social-desc',
			'type'   => 'info',
			'style'  => 'success',
			'notice' => true,
			'title'  => __('TIP:', 'apicona'),
			'desc'   => __('Not found your social service? No problem, we are ready to add new social service here. Please send us social service name via our <a href="http://support.thememount.com/" target="_blank">support system</a> and we will add it.', 'apicona'),
		),
		array(
			'id'       => 'twitter',
			'type'     => 'textarea',
			'title'    => __('Twitter Link', 'apicona'), 
			'subtitle' => __('Your Twitter Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'youtube',
			'type'     => 'textarea',
			'title'    => __('YouTube Link', 'apicona'), 
			'subtitle' => __('Your YouTube Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'facebook',
			'type'     => 'textarea',
			'title'    => __('Facebook Link', 'apicona'), 
			'subtitle' => __('Your Facebook Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'linkedin',
			'type'     => 'textarea',
			'title'    => __('LinkedIn Link', 'apicona'), 
			'subtitle' => __('Your LinkedIn Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'googleplus',
			'type'     => 'textarea',
			'title'    => __('Google+ Link', 'apicona'), 
			'subtitle' => __('Your Google+ Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'yelp',
			'type'     => 'textarea',
			'title'    => __('Yelp Link', 'apicona'), 
			'subtitle' => __('Your Yelp Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'dribbble',
			'type'     => 'textarea',
			'title'    => __('Dribbble Link', 'apicona'), 
			'subtitle' => __('Your Dribbble Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'pinterest',
			'type'     => 'textarea',
			'title'    => __('Pinterest Link', 'apicona'), 
			'subtitle' => __('Your Pinterest Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'podcast',
			'type'     => 'textarea',
			'title'    => __('Podcast Link', 'apicona'), 
			'subtitle' => __('Your Podcast Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'instagram',
			'type'     => 'textarea',
			'title'    => __('Instagram Link', 'apicona'), 
			'subtitle' => __('Your Instagram Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'flickr',
			'type'     => 'textarea',
			'title'    => __('Flickr Link', 'apicona'), 
			'subtitle' => __('Your Flickr Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'issuu',
			'type'     => 'textarea',
			'title'    => __('Issuu Link', 'apicona'), 
			'subtitle' => __('Your Issuu Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'tripadvisor',
			'type'     => 'textarea',
			'title'    => __('TripAdvisor Link', 'apicona'), 
			'subtitle' => __('Your TripAdvisor Link', 'apicona'),
			'desc'     => __('Paste URL only', 'apicona'),
		),
		array(
			'id'       => 'rss',
			'type'     => 'switch',
			'title'    => __('Show RSS Link', 'apicona'), 
			'on'       => __('Yes', 'apicona'),
			'off'      => __('No', 'apicona'),
			'subtitle' => __('Check this option to show RSS link with social icons list', 'apicona'),
			'default'  => '1'// 1 = on | 0 = off
		),
	),
);




// WooCommerce Settings
$sections[] = array(
	'title'  => __('WooCommerce Settings', 'apicona'),
	'header' => __('WooCommerce Settings', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Setup for WooCommerce shop section. Please make sure you installed WooCommerce plugin.', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-shopping-cart',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		// WooCommerce settings
		/*array(
			'id'    =>'html-woocommerce-settings',
			'type'  => 'info',
			'title' => __('WooCommerce Settings', 'apicona'), 
			'desc'  => __('Settings for the WooCommerce plugin.', 'apicona')
        ),*/
		
		array(
			'id'       => 'woocommerce-column',
			'type'     => 'radio',
			'title'    => __('WooCommerce Product List Column', 'apicona'), 
			'subtitle' => __('Select how many column you want to show for product list view.', 'apicona'),
			'options'  => array(
				'1' => __('One Column', 'apicona'),
				'2' => __('Two Columns', 'apicona'),
				'3' => __('Three Columns', 'apicona'),
				'4' => __('Four Columns', 'apicona'),
			),
			'default'  => '3'
		),
		array(
			'id'            => 'woocommerce-product-per-page',
			'type'          => 'slider',
			'title'         => __( 'Products Per Page', 'apicona' ),
			'subtitle'      => __( 'Select how many product you want to show on SHOP page.', 'apicona' ),
			'desc'          => __( 'Select how many product you want to show on SHOP page.', 'apicona' ),
			'default'       => 9,
			'min'           => 2,
			'step'          => 1,
			'max'           => 30,
			'display_value' => 'text',
		),
	),
);



// Advanced Settings
$sections[] = array(
	'title'  => __('Advanced Settings', 'apicona'),
	'header' => __('Advanced Settings', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Team Member section settings.', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-wrench',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'    =>'html-teamoptionsadv',
			'type'  => 'info',
			'title' => __('Custom Post Type : Team member (Doctors) Settings', 'apicona'), 
			'desc'  => __('Settings for Team Member custom post type. We are using Team member custom post type as Doctors and you can change SLUG, TITLE etc from here.', 'apicona')
        ),
		array(
			'id'       => 'team_type_title',
			'type'     => 'text',
			'title'    => __('Title for Team Member Post Type', 'apicona'),
			'subtitle' => __('This will change the Title for Team Member post type section.', 'apicona'),
			'default'  => 'Doctors',
		),
		array(
			'id'       => 'team_type_slug',
			'type'     => 'text',
			'title'    => __('URL Slug for Team Member Post Type', 'apicona'),
			'subtitle' => __('This will change the URL slug for Team Member post type section.', 'apicona'),
			'default'  => 'doctors',
		),
		array(
			'id'       => 'team_group_slug',
			'type'     => 'text',
			'title'    => __('URL Slug for Team Group Link', 'apicona'),
			'subtitle' => __('This will change the URL slug for Team Group link.', 'apicona'),
			'default'  => 'section',
		),
		array(
			'id'       => 'team_group_title',
			'type'     => 'text',
			'title'    => __('Title for Team Group List', 'apicona'),
			'subtitle' => __('Title for Team Group list for group page. This will appear at left sidebar.', 'apicona'),
			'default'  => 'Services',
		),
		
		// Portfolio
		array(
			'id'    =>'html-portfoliooptionsadv',
			'type'  => 'info',
			'title' => __('Custom Post Type : Portfolio Settings', 'apicona'), 
			'desc'  => __('Advanced settings for Portfolio custom post type.', 'apicona')
        ),
		array(
			'id'       => 'pf_type_title',
			'type'     => 'text',
			'title'    => __('Title for Portfolio Post Type', 'apicona'),
			'subtitle' => __('This will change the Title for Portfolio post type section.', 'apicona'),
			'default'  => __('Portfolio', 'apicona'),
		),
		array(
			'id'       => 'pf_type_slug',
			'type'     => 'text',
			'title'    => __('URL Slug for Portfolio Post Type', 'apicona'),
			'subtitle' => __('This will change the URL slug for Portfolio post type section.', 'apicona'),
			'desc'     => __('Make sure you save the "Settings > Permalinks" again after changing this option.', 'apicona'),
			'default'  => 'portfolio',
		),
		

		
		array(
			'id'    =>'html-adv_dynamic_style',
			'type'  => 'info',
			'title' => __('Dynamic Style Position', 'apicona'), 
			'desc'  => __('Change how the dynamic-style.php file\'s code will be appear.', 'apicona')
        ),
		array(
			'id'       => 'dynamic-style-position',
			'type'     => 'radio',
			'title'    => __('Dynamic Style Position', 'apicona'), 
			'subtitle' => __('- Select <strong>External</strong> to load the file external (the file name will be <code>dynamic-style.php</code>). <br><br> - Select <strong>Internal</strong> to load the dynamic style on page directly (useful for WPMU server).', 'apicona'),
			'options'  => array( 'external' => __('External', 'apicona'), 'internal' => __('Internal', 'apicona') ),
			'default'  => 'external'
		),
		
		// Minify opitons
		array(
			'id'    =>'html-minify',
			'type'  => 'info',
			'title' => __('Minify Options', 'apicona'), 
			'desc'  => __('Options to minify HTML/JS/CSS files.', 'apicona')
        ),
		array(
			'id'       => 'minify-css-js',
			'type'     => 'switch',
			'title'    => __('Minify JS and CSS files', 'apicona'), 
			'subtitle' => __('Select <code>YES</code> to minify the CSS and JS files.', 'apicona') ,
			'on'       => 'Yes',
			'off'      => 'No',
			'default'  => '1', // 1 = on | 0 = off
			'customizer'=> false,
		),
		array(
			'id'         => 'kwayy_min_generator',
			'type'       => 'kwayy_min_generator',
			'title'      => __('Minify File Generator', 'apicona'), 
			'subtitle'   => __('This will generate MIN version of all CSS and JS files. This will help you to lower the page load time.', 'apicona').'<br><br>'.'<strong>'.__('NOTE','apicona').': </strong>'.__('You must be connected to internet as this process will work from third party server.', 'apicona'),
			
			'customizer' => false,
		),
		
		// Thumb image sizes
		array(
			'id'    =>'html-imagesize',
			'type'  => 'info',
			'title' => __('Thumb Image Size Options', 'apicona'), 
			'desc'  => __('Set Image size for Portfolio and WooCoomerce sizes.', 'apicona')
        ),
		array(
			'id'             => 'img-portfolio-two-column',
			'type'           => 'kwayy_dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => false,  // Allow users to select any type of unit
			'title'          => __( 'Portfolio Two Column - Thumb image size', 'apicona' ),
			'subtitle'       => __( 'Set width and height of the Portfolio Box image in Visual Composer element (on frontend site)', 'apicona' ),
			'desc'           => '<p>' . sprintf( __('%s Click here %s to know more about hard crop.', 'apicona'), '<a href="http://www.davidtan.org/wordpress-hard-crop-vs-soft-crop-difference-comparison-example/" target="_blank">' , '</a>' ) . '</p> ' . '<p>' . sprintf( __('After changing these settings you may need to %s regenerate your thumbnails %s.', 'apicona'), '<a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">' , '</a>' ) . '</p> ',
			'default'        => array(
				'width'  => 1110,
				'height' => 624,
				'crop'   => 'yes',
			)
		),
		array(
			'id'             => 'img-portfolio-three-column',
			'type'           => 'kwayy_dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => false,  // Allow users to select any type of unit
			'title'          => __( 'Portfolio Three Column - Thumb image size', 'apicona' ),
			'subtitle'       => __( 'Set width and height of the Portfolio Box image in Visual Composer element (on frontend site)', 'apicona' ),
			'desc'           => '<p>' . sprintf( __('%s Click here %s to know more about hard crop.', 'apicona'), '<a href="http://www.davidtan.org/wordpress-hard-crop-vs-soft-crop-difference-comparison-example/" target="_blank">' , '</a>' ) . '</p> ' . '<p>' . sprintf( __('After changing these settings you may need to %s regenerate your thumbnails %s.', 'apicona'), '<a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">' , '</a>' ) . '</p> ',
			'default'        => array(
				'width'  => 720,
				'height' => 406,
				'crop'   => 'yes',
			)
		),
		array(
			'id'             => 'img-portfolio-four-column',
			'type'           => 'kwayy_dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => false,  // Allow users to select any type of unit
			'title'          => __( 'Portfolio Four Column - Thumb image size', 'apicona' ),
			'subtitle'       => __( 'Set width and height of the Portfolio Box image in Visual Composer element (on frontend site)', 'apicona' ),
			'desc'           => '<p>' . sprintf( __('%s Click here %s to know more about hard crop.', 'apicona'), '<a href="http://www.davidtan.org/wordpress-hard-crop-vs-soft-crop-difference-comparison-example/" target="_blank">' , '</a>' ) . '</p> ' . '<p>' . sprintf( __('After changing these settings you may need to %s regenerate your thumbnails %s.', 'apicona'), '<a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">' , '</a>' ) . '</p> ',
			'default'        => array(
				'width'  => 750,
				'height' => 422,
				'crop'   => 'yes',
			)
		),
		
		
		// Blog 
		array(
			'id'             => 'img-blog-two-column',
			'type'           => 'kwayy_dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => false,  // Allow users to select any type of unit
			'title'          => __( 'Blog Two Column - Thumb image size', 'apicona' ),
			'subtitle'       => __( 'Set width and height of the Blog Box image in Visual Composer element (on frontend site)', 'apicona' ),
			'desc'           => '<p>' . sprintf( __('%s Click here %s to know more about hard crop.', 'apicona'), '<a href="http://www.davidtan.org/wordpress-hard-crop-vs-soft-crop-difference-comparison-example/" target="_blank">' , '</a>' ) . '</p> ' . '<p>' . sprintf( __('After changing these settings you may need to %s regenerate your thumbnails %s.', 'apicona'), '<a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">' , '</a>' ) . '</p> ',
			'default'        => array(
				'width'  => 1110,
				'height' => 624,
				'crop'   => 'yes',
			)
		),
		array(
			'id'             => 'img-blog-three-column',
			'type'           => 'kwayy_dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => false,  // Allow users to select any type of unit
			'title'          => __( 'Blog Three Column - Thumb image size', 'apicona' ),
			'subtitle'       => __( 'Set width and height of the Blog Box image in Visual Composer element (on frontend site)', 'apicona' ),
			'desc'           => '<p>' . sprintf( __('%s Click here %s to know more about hard crop.', 'apicona'), '<a href="http://www.davidtan.org/wordpress-hard-crop-vs-soft-crop-difference-comparison-example/" target="_blank">' , '</a>' ) . '</p> ' . '<p>' . sprintf( __('After changing these settings you may need to %s regenerate your thumbnails %s.', 'apicona'), '<a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">' , '</a>' ) . '</p> ',
			'default'        => array(
				'width'  => 720,
				'height' => 406,
				'crop'   => 'yes',
			)
		),
		array(
			'id'             => 'img-blog-four-column',
			'type'           => 'kwayy_dimensions',
			'units'          => 'px',    // You can specify a unit value. Possible: px, em, %
			'units_extended' => false,  // Allow users to select any type of unit
			'title'          => __( 'Blog Four Column - Thumb image size', 'apicona' ),
			'subtitle'       => __( 'Set width and height of the Blog Box image in Visual Composer element (on frontend site)', 'apicona' ),
			'desc'           => '<p>' . sprintf( __('%s Click here %s to know more about hard crop.', 'apicona'), '<a href="http://www.davidtan.org/wordpress-hard-crop-vs-soft-crop-difference-comparison-example/" target="_blank">' , '</a>' ) . '</p> ' . '<p>' . sprintf( __('After changing these settings you may need to %s regenerate your thumbnails %s.', 'apicona'), '<a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/" target="_blank">' , '</a>' ) . '</p> ',
			'default'        => array(
				'width'  => 750,
				'height' => 422,
				'crop'   => 'yes',
			)
		),
		
		
		// Responsive Menu Breakpoint
		array(
			'id'    =>'html-responsive_menu_breakpoint',
			'type'  => 'info',
			'title' => __('Responsive Menu Breakpoint', 'apicona'), 
			'desc'  => __('Change options for responsive menu breakpoint.', 'apicona')
        ),
		array(
			'id'       => 'menu_breakpoint',
			'type'     => 'radio',
			'title'    => __('Responsive Menu Breakpoint', 'apicona'), 
			'subtitle' => __('Change options for responsive menu breakpoint.', 'apicona'),
			'options'  => array(
				'1200'   => __('Large devices <small>Desktops (>1200px)</small>', 'apicona'),
				'992'    => __('Medium devices <small>Desktops and Tablets (>992px)</small>', 'apicona'),
				'768'    => __('Small devices <small>Mobile and Tablets (>768px)</small>', 'apicona'),
				'custom' => __('Custom (select pixel below)', 'apicona'),
			),
			'default'  => '1200'
		),
		array(
			'id'            => 'menu_breakpoint_custom',
			'type'          => 'slider',
			'title'         => __( 'Custom Breakpoint for Menu (in pixel)', 'apicona' ),
			'subtitle'      => __( 'Select after how many pixels the menu will become responsive.', 'apicona' ),
			//'desc'          => __( 'Select how many product you want to show on SHOP page.', 'apicona' ),
			'default'       => 1200,
			'min'           => 1,
			'step'          => 1,
			'max'           => 1200,
			'display_value' => 'text',
			'required'      => array('menu_breakpoint','equals','custom'),
		),
		
	),
);



// Custom Code
$sections[] = array(
	'title'  => __('Custom Code', 'apicona'),
	'header' => __('Custom Code', 'apicona'),
	'customizer'=> false,
	'desc'   => __('Add custom JS and CSS code', 'apicona'),
	'icon_class' => 'icon-large',
    'icon'   => 'el-icon-pencil',
    // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
	'fields' => array(
		array(
			'id'       => 'custom_css_code_top',
			'type'     => 'ace_editor',
			'title'    => __('CSS Code (at top of the file)', 'apicona'), 
			'subtitle' => __('Add custom CSS code here. This code will be appear at top of the file. specially for <code>@import</code> style tag.', 'apicona'),
			'mode'     => 'css',
			'theme'    => 'monokai',
			//'desc'     => 'Add custom CSS code here. This code will be appear at top of the file. specially for <code>@import</code> style tag.',
			'default'  => '@import url(http://fonts.googleapis.com/css?family=Raleway:400,100,200,300,500,600,700,800,900);
@import url(http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic);',
		),
		array(
			'id'       => 'custom_css_code',
			'type'     => 'ace_editor',
			'title'    => __('CSS Code (at bottom of file)', 'apicona'), 
			'subtitle' => __('Add custom CSS code here. This code will be appear at bottom of the file so you can override any existing style.', 'apicona'),
			'mode'     => 'css',
			'theme'    => 'monokai',
			'default'  => ""
		),
		array(
			'id'       => 'custom_js_code',
			'type'     => 'ace_editor',
			'title'    => __('JS Code', 'apicona'), 
			'subtitle' => __('Paste your JS code here.', 'apicona'),
			'mode'     => 'javascript',
			'theme'    => 'chrome',
			//'desc'     => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
			'default'  => ""
		),
		
		array(
			'id'    =>'html-logincode',
			'type'  => 'info',
			'title' => __('Custom Code for Login page', 'apicona'), 
			'desc'  => __('Custom Code for Login page only. This will effect only login page and not effect any other pages or admin section.', 'apicona')
        ),
		array(
			'id'       => 'login_custom_css_code',
			'type'     => 'ace_editor',
			'title'    => __('CSS Code for Login Page', 'apicona'), 
			'subtitle' => __('Paste write CSS code here.', 'apicona'),
			'mode'     => 'css',
			'theme'    => 'monokai',
			//'desc'     => __('Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.', 'apicona'),
			//'default'  => ""
		),
		
		array(
			'id'    =>'html-customhtml',
			'type'  => 'info',
			'title' => __('Custom HTML Code', 'apicona'), 
			'desc'  => __('Custom HTML Code for different areas.', 'apicona')
        ),
		array(
			'id'       => 'customhtml_head',
			'type'     => 'textarea',
			'title'    => __( 'Custom Code for &lt;head&gt; tag', 'apicona' ),
			'subtitle' => __( 'This code will appear in &lt;head&gt; tag. You can add your custom tracking code here.', 'apicona' ),
			//'desc'     => __( 'This is the description field, again good for additional info.', 'apicona' ),
			//'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
			//'default'  => ''
		),
		array(
			'id'       => 'customhtml_bodystart',
			'type'     => 'textarea',
			'title'    => __( 'Custom Code after &lt;body&gt; tag', 'apicona' ),
			'subtitle' => __( 'This code will appear after &lt;body&gt; tag. You can add your custom tracking code here.', 'apicona' ),
			//'desc'     => __( 'This is the description field, again good for additional info.', 'apicona' ),
			//'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
			//'default'  => ''
		),
		array(
			'id'       => 'customhtml_bodyend',
			'type'     => 'textarea',
			'title'    => __( 'Custom Code before &lt;/body&gt; tag', 'apicona' ),
			'subtitle' => __( 'This code will appear before &lt;/body&gt; tag. You can add your custom tracking code here.', 'apicona' ),
			//'desc'     => __( 'This is the description field, again good for additional info.', 'apicona' ),
			//'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
			//'default'  => ''
		),
	),
);


$sections[] = array(
	'type' => 'divide',
);

$sections[] = array(
	'icon' => 'el-icon-info-sign',
	'title' => __('Theme Information', 'apicona'),
	'desc' => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'apicona'),
	'fields' => array(
		array(
			'id'=>'raw_new_info',
			'type' => 'raw',
			'content' => $item_info,
		)
	),
);


$sections[] = array(
	'title'     => __('Import / Export', 'apicona'),
	'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'apicona'),
	'icon'      => 'el-icon-refresh',
	'fields'    => array(
		array(
			'id'            => 'opt-import-export',
			'type'          => 'import_export',
			'title'         => 'Import Export',
			'subtitle'      => 'Save and restore your Redux options',
			'full_width'    => false,
		),
	),
); 

/*****************************************************************************/



		

if (function_exists('wp_get_theme')){
	$theme_data = wp_get_theme();
	$theme_uri = $theme_data->get('ThemeURI');
	$description = $theme_data->get('Description');
	$author = $theme_data->get('Author');
	$version = $theme_data->get('Version');
	$tags = $theme_data->get('Tags');
}else{
	$theme_data = wp_get_theme(trailingslashit(get_stylesheet_directory()).'style.css');
	$theme_uri = $theme_data['URI'];
	$description = $theme_data['Description'];
	$author = $theme_data['Author'];
	$version = $theme_data['Version'];
	$tags = $theme_data['Tags'];
}	

$theme_info = '<div class="redux-framework-section-desc">';
$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'apicona').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'apicona').$author.'</p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'apicona').$version.'</p>';
$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$description.'</p>';
if ( !empty( $tags ) ) {
	$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'apicona').implode(', ', $tags).'</p>';	
}
$theme_info .= '</div>';

if(file_exists(dirname(__FILE__).'/README.md')){
$sections['theme_docs'] = array(
			'icon' => get_template_directory_uri().'assets/img/glyphicons/glyphicons_071_book.png',
			'title' => __('Documentation', 'apicona'),
			'fields' => array(
				array(
					'id'=>'17',
					'type' => 'raw',
					'content' => file_get_contents(dirname(__FILE__).'/README.md')
					),				
			),
			
			);
}//if

/*
$tabs['item_info'] = array(
	'icon' => 'el-icon-info-sign',
	'icon_class' => 'icon-large',
    'title' => __('Theme Information', 'apicona'),
    'content' => $item_info
);
*/
/*
if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
    $tabs['docs'] = array(
		'icon' => 'el-icon-book',
		'icon_class' => 'icon-large',
        'title' => __('Documentation', 'apicona'),
        'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
    );
}
*/
global $ReduxFramework;
$ReduxFramework = new ReduxFramework($sections, $args, $tabs);

// END Sample Config


/**
 
 	Custom function for filtering the sections array. Good for child themes to override or add to the sections.
 	Simply include this function in the child themes functions.php file.
 
 	NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
 	so you must use get_template_directory_uri() if you want to use any of the built in icons
 
 **/
function add_another_section($sections){
    //$sections = array();
    $sections[] = array(
        'title' => __('A Section added by hook', 'apicona'),
        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'apicona'),
		'icon' => 'el-icon-paper-clip',
		'icon_class' => 'icon-large',
        // Leave this as a blank section, no options just some intro text set above.
        'fields' => array()
    );

    return $sections;
}
add_filter('redux-opts-sections-redux-sample', 'add_another_section');


/**

	Custom function for filtering the args array given by a theme, good for child themes to override or add to the args array.

**/
function change_framework_args($args){
    //$args['dev_mode'] = false;
    
    return $args;
}
//add_filter('redux-opts-args-redux-sample-file', 'change_framework_args');





/** 

	Custom function for the callback referenced above

 */
function my_custom_field($field, $value) {
    print_r($field);
    print_r($value);
}

/**
 
	Custom function for the callback validation referenced above

**/
function validate_callback_function($field, $value, $existing_value) {
    $error = false;
    $value =  'just testing';
    /*
    do your validation
    
    if(something) {
        $value = $value;
    } elseif(something else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
    }
    */
    
    $return['value'] = $value;
    if($error == true) {
        $return['error'] = $field;
    }
    return $return;
}

/**
	This is a test function that will let you see when the compiler hook occurs. 
	It only runs if a field	set with compiler=>true is changed.

**/
function testCompiler() {
	//echo "Compiler hook!";
}
add_action('redux-compiler-redux-sample-file', 'testCompiler');



/**
	Use this code to hide the activation notice telling users about a sample panel.

**/
if ( class_exists('ReduxFrameworkPlugin') ) {
	//remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );	
}

/**

	Use this code to hide the demo mode link from the plugin page. Only used when Redux is a plugin.

**/
function removeDemoModeLink() {
	if ( class_exists('ReduxFrameworkPlugin') ) {
		remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
	}
}
//add_action('init', 'removeDemoModeLink');



