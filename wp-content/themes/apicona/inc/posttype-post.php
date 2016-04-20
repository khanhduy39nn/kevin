<?php 
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');



// This must bein INIT action otherwise it will not call and return empty data.
function kwayy_post_meta_options(){
	
	// Including Framework Master File
	include_once('cuztom-helper-framework/cuztom.php');

	// Declaring Posts variable
	$post = new Cuztom_Post_Type('post');
	
	
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
	
	
	// All options as tabs: Titlebar Opitons, Slider Area Options, Sidebar Widget Options
	$post->add_meta_box(
		'kwayy_post_options',
		'Apicona: Post Options',
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
						'label'         => __('Post Title', 'apicona'),
						'description'   => __('(Optional) Replace current page title with this title. So Search results will show the original page title and the page will show this title.', 'apicona'),
						'type'          => 'textarea'
					),
					array(
						'name'          => 'subtitle',
						'label'         => __('Post Subtitle', 'apicona'),
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
			
				
				__('Sidebar Widget Options','apicona') => array(
					array(
						'name'          => 'leftsidebar',
						'label'         => __('Left Sidebar', 'apicona'),
						'description'   => __('(Optional) Select left sidebar', 'apicona'),
						'type'          => 'select',
						'options'       => $sidebars
					),
					array(
						'name'          => 'rightsidebar',
						'label'         => __('Right Sidebar', 'apicona'),
						'description'   => __('(Optional) Select right sidebar', 'apicona'),
						'type'          => 'select',
						'options'       => $sidebars
					),
					array(
						'name'          => 'sidebarposition',
						'label'         => __('Sidebar Position', 'apicona'),
						'description'   => __('(Optional) Select position for sidebars', 'apicona'),
						'type'          => 'select',
						'options'       => array(
							''         => __('Global', 'apicona'),
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
	
	
	
	
	
	
	
	
	
	
$post->add_meta_box(
	'kwayy_post_gallery',
	'Apicona: Gallery Post Format Images for Slider', 
	array(
		/* Image Slider */
		array(
			'name'          => 'slideimage1',
			'label'         => __('1st Slider Image', 'apicona'),
			'description'   => __('Select 1st image for slider here. You can select your featured image here to show the featured image as first image in slider.', 'apicona'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage2',
			'label'         => __('2nd Slider Image', 'apicona'),
			'description'   => __('(optional) Select 2nd image for slider here.', 'apicona'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage3',
			'label'         => __('3rd Slider Image', 'apicona'),
			'description'   => __('(optional) Select 3rd image for slider here.', 'apicona'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage4',
			'label'         => __('4th Slider Image', 'apicona'),
			'description'   => __('(optional) Select 4th image for slider here.', 'apicona'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage5',
			'label'         => __('5th Slider Image', 'apicona'),
			'description'   => __('(optional) Select 5th image for slider here.', 'apicona'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage6',
			'label'         => __('6th Slider Image', 'apicona'),
			'description'   => __('(optional) Select 6th image for slider here.', 'apicona'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage7',
			'label'         => __('7th Slider Image', 'apicona'),
			'description'   => __('(optional) Select 7th image for slider here.', 'apicona'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage8',
			'label'         => __('8th Slider Image', 'apicona'),
			'description'   => __('(optional) Select 8th image for slider here.', 'apicona'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage9',
			'label'         => __('9th Slider Image', 'apicona'),
			'description'   => __('(optional) Select 9th image for slider here.', 'apicona'),
			'type'          => 'image',
		),
		array(
			'name'          => 'slideimage10',
			'label'         => __('10th Slider Image', 'apicona'),
			'description'   => __('(optional) Select 10th image for slider here.', 'apicona'),
			'type'          => 'image',
		),
	)
);
	
	
	
	
	
	
	
	


	
	
}  // Function: kwayy_slider_options_setup()

add_action( 'init', 'kwayy_post_meta_options' );