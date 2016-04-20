<?php 
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');







// This must bein INIT action otherwise it will not call and return empty data.
function kwayy_slider_options_setup(){
	
	// Including Framework Master File
	include_once('cuztom-helper-framework/cuztom.php');

	// Declaring Pages variable
	$pages = new Cuztom_Post_Type('page');
	
	
	// Retriving Custom Sidebars for use as option for dropdown
	global $apicona;
	$sidebars = array(''=>'Default');
	if( isset($apicona['sidebars']) && is_array($apicona['sidebars']) && count($apicona['sidebars'])>0 ){
		foreach($apicona['sidebars'] as $sidebar){
			if( !empty($sidebar) && trim($sidebar)!='' ){
				$sidebar_key = str_replace('-','_',sanitize_title($sidebar));
				$sidebars[$sidebar_key] = $sidebar;
			}
		}
	}
	
		
	// Getting Slider Type
	$sliderType         = array();
	$sliderType['']     = __('No slider', 'apicona');
	if ( is_plugin_active( 'revslider/revslider.php' ) ) { $sliderType['revslider'] = __('Slider Revolution', 'apicona'); }
	$sliderType['nivo'] = __('Nivo Slider', 'apicona');
	$sliderType['flex'] = __('Flex Slider', 'apicona');
	
	if ( is_plugin_active( 'revslider/revslider.php' ) ) {
		
		/* Slider Revolution plugin is activated */
		global $wpdb;
		$sliders    = $wpdb->get_results("SELECT id,title,alias FROM ".$wpdb->prefix."revslider_sliders");
		$revSliders = array();
		if( $sliders!=false && count($sliders)>0 ){
			foreach($sliders as $slider) {$revSliders[ $slider->alias ] = $slider->title;}
		}
		
		$sliderOptions = array(
			array(
				'name'          => 'slidertype',
				'label'         => __('Select Slider', 'apicona'),
				'description'   => __('Select slider which you want to show on this page. The slider will appear in header area.', 'apicona'),
				'type'          => 'radios',
				'options'       => $sliderType,
				'default_value' => ''
			),
			array(
				'name'          => 'revslider_slider',
				'label'         => __('Select Slider for Slider Revolution', 'apicona'),
				'description'   => __('Select slider for Slider Revolution.', 'apicona'),
				'type'          => 'select',
				'options'       => $revSliders,
			),
		);
		
	} else {

		/* Slider Revolution plugin is not activated */
		$sliderOptions = array(
			array(
				'name'          => 'slidertype',
				'label'         => __('Select Slider', 'apicona'),
				'description'   => __('Select slider which you want to show on this page. The slider will appear in header area.', 'apicona'),
				'type'          => 'select',
				'options'       => $sliderType,
			),
		);
	}
	
	
	$allCat = get_terms( 'slide_group', 'hide_empty=0' );
	if( count($allCat)>0 ){
		
		// Preparing array of category list
		$catList = array();
		foreach( $allCat as $cat ){ $catList[$cat->slug] = $cat->name.' ('.$cat->count.')'; }
		$sliderOptions[] = array(
			'name'          => 'slidercat',
			'label'         => __('Select Slider Group', 'apicona'),
			'description'   => __('Select slider group to fetch all slides. Please note that only selected group\'s slides will be shown in FLEX or NIVO slider.', 'apicona'),
			'type'          => 'select',
			'options'       => $catList,
		);
	
	}
	
	// Wide or Boxed slider
	$sliderOptions[] = array(
			'name'          => 'slidersize',
				'label'         => __('Slide Size', 'apicona'),
				'description'   => __('Select slider width size.', 'apicona'),
				'type'          => 'radios',
				'options'       => array( 'wide'=>'Wide Slider', 'boxed'=>'Boxed Slider' ),
				'default_value' => 'wide'
		);
	
	
	// All options as tabs: Title Box Opitons, Slider Area Options, Sidebar Widget Options
	$pages->add_meta_box(
		'kwayy_page_options',
		'Apicona: Page Options',
		array(
			'tabs',
			array(
				__('Titlebar Options', 'apicona') => array(
					array(
						'name'          => 'hidetitlebar',
						'label'         => __('Hide Titlebar', 'apicona'),
						'description'   => __('If you want to hide title box than check this option', 'apicona'),
						'type'          => 'checkbox'
					),
					array(
						'name'          => 'title',
						'label'         => __('Page Title', 'apicona'),
						'description'   => __('(Optional) Replace current page title with this title. So Search results will show the original page title and the page will show this title.', 'apicona'),
						'type'          => 'textarea'
					),
					array(
						'name'          => 'subtitle',
						'label'         => __('Page Subtitle', 'apicona'),
						'description'   => __('(Optional) Please fill page subtitle', 'apicona'),
						'type'          => 'textarea'
					),
					array(
						'name'          => 'hidebreadcrumb',
						'label'         => __('Hide Breadcrumb', 'apicona'),
						'description'   => __('If you want to hide breadcrumb than check this option', 'apicona'),
						'type'          => 'checkbox'
					),
					array(
						'name'          => 'titlebar_bg_image',
						'label'         => __('Titlebar Background Image', 'apicona'),
						'description'   => __('(Optional) Please select background image.', 'apicona'),
						'type'          => 'select',
						'options'       => array(
									'global' => __('Global', 'apicona'),
									'1'      => __('Image 1', 'apicona'),
									'2'      => __('Image 2', 'apicona'),
									'3'      => __('Image 3', 'apicona'),
									'4'      => __('Image 4', 'apicona'),
									'5'      => __('Image 5', 'apicona'),
									'custom' => __('Custom image (selected below)', 'apicona'),
						),
					),
					array(
						'name'        => 'titlebar_bg_image_custom',
						'label'       => __('Upload Titlebar Background Image', 'apicona'),
						'description' => __('(Optional) Please upload image for background of Titlebar. Image size should be <code>1700px X 500px</code>.', 'apicona'),
						'type'        => 'image',
					),
				),
			
				__('Slider Area Options','apicona') => $sliderOptions,
				
				__('Sidebar Options','apicona') => array(
					array(
						'name'          => 'leftsidebar',
						'label'         => __('Left Sidebar', 'apicona'),
						'description'   => __('(Optional) Select left sidebar Widget position', 'apicona'),
						'type'          => 'select',
						'options'       => $sidebars
					),
					array(
						'name'          => 'rightsidebar',
						'label'         => __('Right Sidebar', 'apicona'),
						'description'   => __('(Optional) Select right sidebar Widget position', 'apicona'),
						'type'          => 'select',
						'options'       => $sidebars
					),
					array(
						'name'          => 'sidebarposition',
						'label'         => __('Sidebar Position', 'apicona'),
						'description'   => __('(Optional) Select position for sidebars', 'apicona'),
						//'type'        => 'select',
						'type'          => 'radios',
						'options'       => array(
							''         => __('Global', 'apicona'),
							'no'       => __('No Sidebar', 'apicona'),
							'left'     => __('Left Sidebar only', 'apicona'),
							'right'    => __('Right Sidebar only', 'apicona'),
							'both'     => __('Both Left and Right Sidebars', 'apicona'),
							'bothleft' => __('Both sidebars at Left side', 'apicona'),
							'bothright'=> __('Both sidebars at Right side', 'apicona'),
						)
					)
				)
			)
		)
	);




	
	
	$pages->add_meta_box(
		'kwayy_page_customize',
		'Apicona: Customize Options',
		array(
						array(
				'name'          => 'skincolor',
				'label'         => __('Skin Color', 'apicona'),
				'description'   => __('Select Skin Color for this page only. This will override Skin color set under "Theme Options" section. ', 'apicona').'<br><br> <strong>' . __( 'NOTE: ' ,'apicona') . '</strong> ' . __( 'Leave this empty to use "Skin Color" set in the "Theme Options" directly. ' ,'apicona') . '<br><br><strong>' . __( 'NOTE: ' ,'apicona') . '</strong> ' . __( 'Also make sure you select "Internal" in the "Dynamic Style Position" option which you can find in "Theme Options > Advanced Settings" section.' ,'apicona') ,
				'type'          => 'color',
				'default_value' => '',
			),
		)
	);
	
	
	
	
	
	
		
		
	// Topbar
	$pages->add_meta_box(
		'kwayy_page_topbar',
		'Apicona: Topbar Options',
		array(
			array(
				'name'          => 'topbarhide',
				'label'         => __('Hide Topbar', 'apicona'),
				'description'   => __('If you want to hide Topbar than check this option', 'apicona'),
				'type'          => 'select',
				'options'       => array(
					''           => __('Global', 'apicona'),
					'1'          => __('Yes, hide Topbar', 'apicona'),
					'0'          => __('No, show Topbar', 'apicona'),
				),
				//'default_value' => '',
			),
			array(
				'name'          => 'topbarbgcolor',
				'label'         => __('Background Color', 'apicona'),
				'description'   => __('Please select color for background', 'apicona'),
				'type'          => 'select',
				'options'       => array(
					''           => __('Global', 'apicona'),
					'darkgrey'   => __('Dark grey', 'apicona'),
					'grey'       => __('Grey', 'apicona'),
					'white'      => __('White', 'apicona'),
					'skincolor'  => __('Skincolor', 'apicona'),
				),
				//'default_value' => 'default',
			),
			array(
				'name'          => 'topbarhidesocial',
				'label'         => __('Hide Social Icons in Topbar', 'apicona'),
				'description'   => __('Check this option to hide the Social icons in Topbar', 'apicona'),
				'type'          => 'select',
				'options'       => array(
					''           => __('Global', 'apicona'),
					'1'          => __('Yes, hide Social icon', 'apicona'),
					'0'          => __('No, show Social icon', 'apicona'),
				),
				//'default_value' => 'default',
			),
			/*array(
				'name'          => 'topbarsocialposition',
				'label'         => __('Social Icon Position', 'apicona'),
				'description'   => __('Select where you want to show the social icons', 'apicona'),
				'type'          => 'select',
				'options'       => array(
					''           => __('Global', 'apicona'),
					'right'      => __('Right', 'apicona'),
					'left'       => __('Left', 'apicona'),
				),
				'default_value' => 'right',
			),*/
			array(
				'name'          => 'topbartext',
				'label'         => __('Topbar Text (overwrite default text)', 'apicona'),
				'description'   => __('Add content for Topbar text. This will overwrite default text set in Theme Options.', 'apicona'),
				'type'          => 'textarea'
			),
		)
	);
	
	
	
	
	
	
	
	// Show Template options if template selected
	$template_file = '';
	$post_id       = (isset($_GET['post']) && $_GET['post']!='') ? $_GET['post'] : '';
	if( $post_id=='' ){
		if( isset($_POST['post_ID']) && $_POST['post_ID']!='' ){
			$post_id = $_POST['post_ID'];
		}
	}
	if( $post_id!='' ){
		$template_file = get_post_meta($post_id,'_wp_page_template',true);
		$showPosts     = get_post_meta($post_id, '_kwayy_page_template_show_posts', true);
		// Setting default show numbers
		$defaultShowPosts = '10';
		switch($template_file){
			case 'template-blog-2-columns.php': 
				$defaultShowPosts = '10';
				break;
			case 'template-blog-3-columns.php': 
				$defaultShowPosts = '9';
				break;
			case 'template-blog-4-columns.php': 
				$defaultShowPosts = '8';
				break;
		}
	}
	if(    $template_file == 'template-blog-2-columns.php'
		|| $template_file == 'template-blog-3-columns.php'
		|| $template_file == 'template-blog-4-columns.php'
	){
		$pages->add_meta_box(
			'kwayy_page_template',
			'Apicona: Template Options',
			array(
				array(
					'name'        => 'show_posts',
					'label'       => __('Show Posts', 'apicona'),
					'description' => __('How many posts you like to show on Two, Thee or Four column blog view.', 'apicona'),
					'type'        => 'select',
					'options'     => array(
						'global'     => __('Global', 'apicona'),
						'1'          => __('1', 'apicona'),
						'2'          => __('2', 'apicona'),
						'3'          => __('3', 'apicona'),
						'4'          => __('4', 'apicona'),
						'5'          => __('5', 'apicona'),
						'6'          => __('6', 'apicona'),
						'7'          => __('7', 'apicona'),
						'8'          => __('8', 'apicona'),
						'9'          => __('9', 'apicona'),
						'10'          => __('10', 'apicona'),
						'11'          => __('11', 'apicona'),
						'12'          => __('12', 'apicona'),
						'13'          => __('13', 'apicona'),
						'14'          => __('14', 'apicona'),
						'15'          => __('15', 'apicona'),
						'16'          => __('16', 'apicona'),
						'17'          => __('17', 'apicona'),
						'18'          => __('18', 'apicona'),
						'19'          => __('19', 'apicona'),
						'20'          => __('20', 'apicona'),
					),
					'default_value' => $defaultShowPosts,
				),
				
			)
		);
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	


	// Portfolio Options
	/*$pages->add_meta_box(
		'kwayy_portfolio_options',
		'Apicona: Portfolio Options',
		array(
			array(
				'name'          => 'portfolio',
				'label'         => __('Portfolio Columns', 'apicona'),
				'description'   => __('Please select how many columns you want to show', 'apicona'),
				'type'          => 'select',
				'options'       => array(
					//'metro' => __('Metro Style', 'apicona'),
					'two'   => __('Two Columns', 'apicona'),
					'three' => __('Three Columns', 'apicona'),
					'four'  => __('Four Columns', 'apicona'),
					//'mix'   => __('Mix Columns', 'apicona')
				)
			),
			array(
				'name'          => 'projectperpage',
				'label'         => __('Projects on the page', 'apicona'),
				'description'   => __('Enter the maximum number of projects to be shown on page', 'apicona'),
				'type'          => 'select',
				'default_value' => '9',
				'options'       => array(
					'-1'  => 'All',
					'2'  => '2',
					'3'  => '3',
					'4'  => '4',
					'5'  => '5',
					'6'  => '6',
					'7'  => '7',
					'8'  => '8',
					'9'  => '9',
					'10' => '10',
					'11' => '11',
					'12' => '12',
					'13' => '13',
					'14' => '14',
					'15' => '15',
					'16' => '16',
					'17' => '17',
					'18' => '18',
					'19' => '19',
					'20' => '20',
					'21' => '21',
					'22' => '22',
					'23' => '23',
					'24' => '24',
					'25' => '25',
					'26' => '26',
					'27' => '27',
					'28' => '28',
					'29' => '29',
					'30' => '30'
				)
			),
			
			// Show Sortable Category Links
			array(
				'name'          => 'sortablecategory',
				'label'         => __('Show Sortable Category Links', 'apicona'),
				'description'   => __('Show sortable category links above Portfolio items so user can sort by category by just single click', 'apicona'),
				'type'          => 'radios',
				'default_value' => 'yes',
				'options'       => array(
					'yes' => __('Yes', 'apicona'),
					'no'  => __('No', 'apicona')
				)
			),
			// Show Sortable Category Links
			array(
				'name'          => 'categorylist',
				'label'         => __('Selected Category Only', 'apicona'),
				'description'   => __('If you want to show only selected category than select the categories from here. <br> <strong>Note:</strong> If you want to show all categories than don\'t select any category', 'apicona'),
				'type'          => 'term_checkboxes',
				'args'          => array(
					'taxonomy'   => 'portfolio_category',
					'hide_empty' => false,
				)
			),
		)
	);*/
	
	
	
	
	


}  // Function: kwayy_slider_options_setup()

add_action( 'admin_init', 'kwayy_slider_options_setup' );







