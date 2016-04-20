<?php


/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
function kwayy_vc_set_as_theme(){
	if( function_exists('vc_set_as_theme') ) vc_set_as_theme(true);
	//if( function_exists('vc_disable_frontend') ) vc_disable_frontend(); // This is to disable frontend editing
}
//add_action('init', 'kwayy_vc_set_as_theme');
kwayy_vc_set_as_theme();

/**
 * Icon Array
 */
global $kwayy_iconsArray;
$allIcons = array();
foreach($kwayy_iconsArray as $icon ){
	$allIcons[ucwords(str_replace('-',' ',$icon))] = $icon;
}



/**
 * Remove VC Metaboxes
 */
add_action( 'admin_head', 'kwayy_remove_vc_meta_box' );
function kwayy_remove_vc_meta_box() {
	remove_meta_box("vc_teaser", "portfolio", "side");
	remove_meta_box("vc_teaser", "page", "side"); 
	remove_meta_box("vc_teaser", "product", "side"); 
}




/**
 * Sample code to use in future
 */
// Set as Theme
/*
WPBakeryVisualComposerAbstract::$config['USER_DIR_NAME'] = 'inc/shortcodes';
WPBakeryVisualComposerAbstract::$config['default_post_types'] = array('post', 'page', 'portfolio', 'product');
vc_set_as_theme(true);
*/



/**
 * Adding Icon Selector parameter
 */
if( function_exists('add_shortcode_param') ){
	function kwayy_iconselector_func($settings, $value) {
		//var_dump($settings);
		$dependency = vc_generate_dependencies_attributes($settings);
		$optionsList = '';
		//var_dump($settings);
		foreach( $settings['value'] as $val ){
			$selected =  ( $val==$value ) ? 'selected="selected"' : '' ;
			$optionsList .= '<option value="'.$val.'" '.$selected.'>'.$val.'</option>';
		}

		return '<div class="my_param_block">'
				.'<select name="'.$settings['param_name']
				.'" class="wpb_vc_param_value wpb-textinput kwayy-icon-selector '
				.$settings['param_name'].' '.$settings['type'].'_field" '
				.' ' . $dependency . '>'
				.$optionsList
				.'</select>'
			.'</div>';
	}
	add_shortcode_param('kwayy_iconselector', 'kwayy_iconselector_func', get_template_directory_uri().'/inc/admin-custom-select2-runner.js' );
}



	if( !function_exists('kwayy_vc_extraThings') ){
	/**
	 * Getting all Button Size to apply Service Box Buttons in Visual Composer
	 */
	function kwayy_vc_extraThings() {

		/* Button Size */
		if( class_exists('WPBMap') ){
			$param2  = WPBMap::getParam('vc_button', 'size'); //Get current values stored in the color param in "Call to Action" element
			$btnSize = $param2['value'];
		};


		global $kwayy_iconsArray;
		$allIcons = array();
		foreach($kwayy_iconsArray as $icon ){
			$allIcons[ucwords(str_replace('-',' ',$icon))] = $icon;
		}

		$allIconsWithEmpty = array(__('No Icon', 'apicona')=>'NO_ICON');
		$allIconsWithEmpty = $allIconsWithEmpty + $allIcons;

		
		if( class_exists('WPBMap') ){
		
			//global $newColorList;
			/*** Adding more colors in Visual Composer ***/
			$param1 = WPBMap::getParam('vc_button', 'color'); //Get current values stored in the color param in "Call to Action" element
			$oldColors = $param1['value'];
			$newColors = array(
				__('Skin color', 'apicona') => 'skincolor',
				__('White', 'apicona') => 'white',
			);
			$newColorList = $newColors + $oldColors;
			
			$param1['value'] = $newColorList;

			WPBMap::mutateParam('vc_cta_button', $param1);   //Finally "mutate" param with new values of Call To Action
			WPBMap::mutateParam('vc_button', $param1);       //Finally "mutate" param with new values of Button
			
			
			/**
			 * Adding more colors in Visual Composer (2nd version elements)
			 */
			$param2 = WPBMap::getParam('vc_button2', 'color'); //Get current values stored in the color param in "Call to Action" element
			$oldColors = $param2['value'];
			$newColors = array(
				__('Skin color', 'apicona') => 'skincolor',
				__('White', 'apicona') => 'white',
			);
			$newColorList = $newColors + $oldColors;
			
			$param2['value'] = $newColorList;

			WPBMap::mutateParam('vc_cta_button2', $param2);   //Finally "mutate" param with new values of Call To Action
			WPBMap::mutateParam('vc_button2', $param2);       //Finally "mutate" param with new values of Button
			
			
			
			
			/**
			 * Adding more colors in Visual Composer : Progress Bar
			 */
			$param3          = WPBMap::getParam('vc_progress_bar', 'bgcolor'); //Get current values stored in the color param in "Progressbar" element
			$oldColors3      = $param3['value'];
			$newColors3      = array( __('Skin color', 'apicona') => 'skincolor' );
			$newColorList3   = $newColors3 + $oldColors3;
			$param3['value'] = $newColorList3;
			WPBMap::mutateParam('vc_progress_bar', $param3);       //Finally "mutate" param with new values of Button
			
		};
		
		
		if( function_exists('vc_map') ){
			vc_map( array(
				"name"     => __("Apicona Service Box",'apicona'),
				"base"     => "servicebox",
				"class"    => "",
				'category' => __( 'ThemeMount Special Elements', 'apicona' ),
				"icon"     => "icon-thememount-vc",
				"params"   => array(
					
					array(
						"param_name"  => "icon",
						"type"        => "kwayy_iconselector",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Service Box Main Icon",'apicona'),
						"value"       => $allIcons,
						"default"     => 'skype',
						"description" => __("Select icon for the Service Box.",'apicona'),
						"group"       => __( "Content Options", "apicona" ),
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("Title",'apicona'),
						"param_name"	=> "title",
						"description"	=> __("Main title.",'apicona'),
						"group"       => __( "Content Options", "apicona" ),
					),
					array(
						'type'        => 'vc_link',
						"holder"      => "div",
						'heading'     => __("Title Link",'apicona'),
						'param_name'  => 'titlelink',
						"description" => __("Add URL here if you like to add link to the title. If you don't want to add link, than leave this field blank.",'apicona'),
						"group"       => __( "Content Options", "apicona" ),
					),
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => __("Sub Title",'apicona'),
						"param_name" => "subtitle",
						//"value" => '',
						"description" => __("Subtitle.",'apicona'),
						"group"       => __( "Content Options", "apicona" ),
					),
					array(
						"type" => "textarea",
						"holder" => "div",
						"class" => "",
						"heading" => __("Content",'apicona'),
						"param_name" => "contents",
						"value" => "",
						"description" => __("Content in normal text.",'apicona'),
						"group"       => __( "Content Options", "apicona" ),
					),

					array(
						"type"       => "dropdown",
						"holder"     => "div",
						"class"      => "",
						"heading"    => __("Bottom Link Type",'apicona'),
						"param_name" => "buttontype",
						"value" => array(
							__('No link','apicona')                  => 'no',
							__('Text Link without icon','apicona')   => 'text',
							__('Text Link with icon','apicona')      => 'icontext',
							__('Button link without icon','apicona') => 'btn',
							__('Button link with icon','apicona')    => 'iconbtn'
						),
						"description" => __("Select button type.",'apicona'),
						'group'       => __( 'Text/Button Options', 'apicona' ),
					),
					array(
						"type" => "textfield",
						"holder" => "div",
						"class" => "",
						"heading" => __("Button/Link Text",'apicona'),
						"param_name" => "buttontext",
						//"value" => __("Default params value"),
						"description" => __("Write button text here.",'apicona'),
						'dependency'  => array(
							'element'   => 'buttontype',
							'value_not_equal_to' => array( 'no' ),
							//'value'     => array( 'carousel' ),
						),
						'group'       => __( 'Text/Button Options', 'apicona' ),
					),
					array(
						'type'        => 'vc_link',
						"holder"      => "div",
						'heading'     => __("Button Link",'apicona'),
						'param_name'  => 'buttonlink',
						"description" => __("Button link URL.",'apicona'),
						'dependency'    => array(
							'element'   => 'buttontype',
							'value_not_equal_to' => array( 'no' ),
							//'value'       => array( 'btn','iconbtn' ),
						),
						'group'       => __( 'Text/Button Options', 'apicona' ),
					),
					array(
						"type" => "dropdown",
						"holder" => "div",
						"class" => "",
						"heading" => __("Box Style",'apicona'),
						"param_name" => "boxtype",
						"value" => array(
							__('Left Icon (Rounded icon)','apicona')	=> 'lefticon',
							__('Left Icon','apicona')					=> 'lefticonspacing',
							__('Center Icon','apicona')				=> 'centericon',
							__('Center Icon with Border','apicona')	=> 'bordercentericon',
							__('Right Icon (Rounded icon)','apicona')	=> 'righticon',
							__('Right Icon','apicona')					=> 'righticonspacing',
						),
						"description" => __("There are different look of Service Boxes.",'apicona'),
						"group"       => __( "Box Options", "apicona" ),
					),
					array(
						"type" => "dropdown",
						"holder" => "div",
						"class" => "",
						"heading" => __("Box Hover Effect",'apicona'),
						"param_name" => "hover",
						"value" => array(
							__('None','apicona')         => '',
							__('Float Shadow','apicona') => 'float-shadow',
							__('Grow','apicona')         => 'grow',
							__('Shrink','apicona')       => 'shrink',
							__('Skew','apicona')         => 'skew',
							__('Skew Forward','apicona') => 'skew-forward',
							__('Rotate','apicona')       => 'rotate',
							__('Grow Rotate','apicona')  => 'grow-rotate',
							__('Float','apicona')        => 'float',
							__('Sink','apicona')         => 'sink',
						),
						"description" => __("Select hover effect.",'apicona'),
						"group"       => __( "Box Options", "apicona" ),
					),
					array(
						'type'			=> 'dropdown',
						'heading'		=> __( 'Button Style', 'apicona' ),
						'param_name'	=> 'buttonstyle',
						'value'			=> getVcShared( 'button styles' ),
						'description'	=> __( 'Select button style.', 'apicona' ),
						'dependency'    => array(
							'element'   => 'buttontype',
							//'value_not_equal_to' => array( 'no' ),
							'value'       => array( 'btn','iconbtn' ),
						),
						'group'         => __( 'Text/Button Options', 'apicona' ),
					),
					array(
						"type" 				 => "dropdown",
						"holder" 			 => "div",
						"class" 			 => "",
						"heading" 			 => __("Button Color",'apicona'),
						"param_name" 		 => "buttoncolor",
						"value" 			 => $newColorList,
						"description" 		 => __("Select button Color.",'apicona'),
						'param_holder_class' => 'vc-colored-dropdown',
						'dependency'    => array(
							'element'   => 'buttontype',
							//'value_not_equal_to' => array( 'no' ),
							'value'       => array( 'btn','iconbtn' ),
						),
						'group'              => __( 'Text/Button Options', 'apicona' ),
					),
					array(
						'type'			=> 'dropdown',
						"heading"		=> __("Button Size",'apicona'),
						'param_name'	=> 'buttonsize',
						'value'			=> getVcShared( 'sizes' ),
						'std'			=> 'md',
						"description"	=> __("Select button size.",'apicona'),
						'dependency'    => array(
							'element'   => 'buttontype',
							//'value_not_equal_to' => array( 'no' ),
							'value'       => array( 'btn','iconbtn' ),
						),
						'group'         => __( 'Text/Button Options', 'apicona' ),
					),
						array(
						"param_name"  => "buttonicon",
						"type"        => "kwayy_iconselector",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Button Icon",'apicona'),
						"value"       => $allIcons,
						"default"     => 'skype',
						"description" => __("Select icon for the Service Box.",'apicona'),
						'dependency'    => array(
							'element'   => 'buttontype',
							//'value_not_equal_to' => array( 'no' ),
							'value'       => array( 'icontext','iconbtn' ),
						),
						'group'       => __( 'Text/Button Options', 'apicona' ),
					),
					array(
						"type"        => "dropdown",
						"holder"      => "div",
						"class"       => "vc_sb_iconposition",
						"heading"     => __("Icon Position in Button", "apicona"),
						"param_name"  => "btniconposition",
						"value" => array(
							__('Icon at left in Button','apicona')  => 'left',
							__('Icon at right in Button','apicona') => 'right'
						),
						"description" => __("Select position for icon in button.",'apicona'),
												'dependency'    => array(
							'element'   => 'buttontype',
							//'value_not_equal_to' => array( 'no' ),
							'value'       => array( 'icontext','iconbtn' ),
						),
						'group'       => __( 'Text/Button Options', 'apicona' ),
					),
					array(
						"type" => "dropdown",
						"holder" => "div",
						"class" => "",
						"heading" => __("CSS Animation", "apicona"),
						"param_name" => "css_animation",
						"value" => array(__('No','apicona')=>'',__('Top to bottom','apicona')=>'top-to-bottom',__('Bottom to top','apicona')=>'bottom-to-top',__('Left to right','apicona')=>'left-to-right', __('Right to left','apicona')=>'right-to-left',__('Appear from center','apicona')=>'appear' ),
						"description" => __("Select animation type if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.", "apicona"),
						'group'       => __( 'Other Options', 'apicona' ),
					),
				)
			) );




		/**
		 * Apicona: Facts in digits
		**/
		if( function_exists('vc_map') ){
			vc_map( array(
				'name'	   => __( 'Apicona Facts in digits', 'apicona' ),
				'base'	   => 'facts_in_digits',
				'class'	   => '',
				"icon"     => "icon-thememount-vc",
				'category' => __( 'ThemeMount Special Elements', 'apicona' ),
				'params'   => array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __('Header (optional)', 'apicona'),
						'param_name'	=> 'title',
						'value'			=> '',
						'description'	=> __('Enter text which will be used as widget title. Leave blank if no title is needed.', 'apicona')
					),
					array(
						"param_name"  => "icon",
						"type"        => "kwayy_iconselector",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Service Box Main Icon",'apicona'),
						"value"       => $allIcons,
						"default"     => 'skype',
						"description" => __("Select icon for the Facts in Digits Box.",'apicona')
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __('Number', 'apicona'),
						'param_name'	=> 'digit',
						'value'			=> '10',
						'description'	=> __('Enter rotating number digit here.', 'apicona')
					),
				)
			));
		}

		
		
		/**
		 * Apicona: Tweeter box
		 */
		vc_map( array(
				"name"        => __("Apicona Twitter Box",'apicona'),
				"base"        => "twitterbox",
				"description" => 'Twitter BOX',
				"class"       => "",
				'category'    => __( 'ThemeMount Special Elements', 'apicona' ),
				"icon"        => "icon-thememount-vc",
				"params"      => array(
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("(Required) Twitter Consumer Key",'apicona'),
						"param_name"	=> "consumer_key",
						"description"	=> __('Twitter Consumer Key from Twitter site. Fill all the four keys to show Twitter bar in footer. You can get all the keys from <a href="https://dev.twitter.com" target="_blank">https://dev.twitter.com</a> site.','apicona')
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("(Required) Twitter Consumer Secret",'apicona'),
						"param_name"	=> "consumer_secret",
						"description"	=> __('Twitter Consumer Secret from Twitter site.','apicona')
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("(Required) Twitter Oauth Token",'apicona'),
						"param_name"	=> "oauth_token",
						"description"	=> __('Twitter Oauth Token from Twitter site.','apicona')
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("(Required) Twitter Oauth Token Secret",'apicona'),
						"param_name"	=> "oauth_token_secret",
						"description"	=> __('Twitter Oauth Token Secret from Twitter site.','apicona')
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("Twitter Username (optional)",'apicona'),
						"param_name"	=> "username",
						"description"	=> __('(optional) Twitter user name. Example <code>envato</code>. <br> Leave this blank to show tweets from your account.','apicona')
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						"heading"		=> __("Show Tweets",'apicona'),
						"param_name"	=> "show",
						"description"	=> __('how many Tweets you like to show.','apicona'),
						'value' => array(
							__( '1', 'js_composer' ) => '1',
							__( '2', 'js_composer' ) => '2',
							__( '3', 'js_composer' ) => '3',
							__( '4', 'js_composer' ) => '4',
							__( '5', 'js_composer' ) => '5',
							__( '6', 'js_composer' ) => '6',
							__( '7', 'js_composer' ) => '7',
							__( '8', 'js_composer' ) => '8',
							__( '9', 'js_composer' ) => '9',
							__( '10', 'js_composer' ) => '10',
						),
						'std'    => '3',
					),
				)
		) );

			
		/**
		 * Apicona Separator with Icon
		 */
		vc_map( array(
			"name"     => __("Apicona Separator with Icon", "apicona"),
			"base"     => "kwayyiconseparator",
			"icon"     => "icon-thememount-vc",
			'category' => __( 'ThemeMount Special Elements', 'apicona' ),
			"params"   => array(
				array(
					"type"        => "kwayy_iconselector",
					"holder"      => "div",
					"heading"     => __("Icon", "apicona"),
					"param_name"  => "icon",
					"value"       => $allIcons,
					"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'apicona')
				),
				array(
					'type' => 'dropdown',
					'heading' => __( 'Style', 'js_composer' ),
					'param_name' => 'style',
					'value' => array(
						__( 'Border', 'js_composer' ) => '',
						__( 'Double Border', 'js_composer' ) => 'double',
						__( 'Dotted', 'js_composer' ) => 'dotted',
						__( 'Dashed', 'js_composer' ) => 'dashed',
					),
					'description' => __( 'Separator style.', 'js_composer' )
				),
				array(
					'type'       => 'dropdown',
					'heading'    => __( 'Element width', 'js_composer' ),
					'param_name' => 'elewidth',
					'value'      => array(
						__( '100%', 'js_composer' ) => '',
						__( '90%', 'js_composer' ) => '90',
						__( '80%', 'js_composer' ) => '80',
						__( '70%', 'js_composer' ) => '70',
						__( '60%', 'js_composer' ) => '60',
						__( '50%', 'js_composer' ) => '50',
					),
					'description' => __( 'Separator element width in percent.', 'js_composer' )
				),
				/*array(
					'type' => 'textfield',
					'heading' => __( 'Extra class name', 'js_composer' ),
					'param_name' => 'el_class',
					'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' )
				),*/
			),
			//"js_view" => 'VcCallToActionView'
		) );
		
		
		
		
		
		
		if( class_exists('TribeEvents') ){
			/**
			 * Events Calendar list in Visual Composer
			 */
			vc_map( array(
				"name"     => __("Apicona Events Box", "apicona"),
				"base"     => "eventsbox",
				"icon"     => "icon-thememount-vc",
				'category' => __( 'ThemeMount Special Elements', 'apicona' ),
				"params"   => array(
					array(
						"type"        => "textarea",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Box Title",'apicona'),
						"description" => __("Write box title here.",'apicona'),
						"param_name"  => "title",
						//"value"     => __("Our Latest Projects",'apicona'),
					),
					array(
						"type"        => "textarea",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Box Sub-title",'apicona'),
						"description" => __("Write box sub-title here.",'apicona'),
						"param_name"  => "subtitle",
						//"value"       => __("Lorem ipsum dolor sit amet, consectetur adipiscing elit.",'apicona'),
					),
					array(
						"type"        => "dropdown",
						"heading"     => __("Title Align", "apicona"),
						"description" => __("Select align for title and sub-title tag.", "apicona"),
						"param_name"  => "align",
						"value"       => array(
							__("Left", "apicona")   => "left",
							__("Center", "apicona") => "center",
							__("Right", "apicona")  => "right",
						),
					),
					array(
						"type"        => "textfield",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Button Text",'apicona'),
						"description" => __("Write button text here.",'apicona'),
						"group"       => __( "Button Options", "apicona" ),
						"param_name"  => "btntext",
						"value"       => ''
					),
					array(
						"type"        => "textfield",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Button Link (URL)",'apicona'),
						"description" => __("Write URL for the button.",'apicona'),
						"group"       => __( "Button Options", "apicona" ),
						"param_name"  => "btnlink",
						"value"       => ''
					),
					array(
						"type"        => "dropdown",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Show Pagination",'apicona'),
						"description" => __("Show pagination links below portfolio boxes.",'apicona'),
						"param_name"  => "pagination",
						"value"       => array(
							__('No','apicona')  => 'no',
							__('Yes','apicona') => 'yes',
						)
					),
					array(
						"type"        => "dropdown",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Show Events Item",'apicona'),
						"description" => __("How many events you want to show.",'apicona'),
						"param_name"  => "show",
						"value"       => array(
							__('All','apicona') => '-1',
							__('1','apicona')  => '1',
							__('2','apicona') => '2',
							__('3','apicona')=>'3',
							__('4','apicona')=>'4',
							__('5','apicona')=>'5',
							__('6','apicona')=>'6',
							__('7','apicona')=>'7',
							__('8','apicona')=>'8',
							__('9','apicona')=>'9',
							__('10','apicona')=>'10',
							__('11','apicona')=>'11',
							__('12','apicona')=>'12',
							__('13','apicona')=>'13',
							__('14','apicona')=>'14',
							__('15','apicona')=>'15',
							__('16','apicona')=>'16',
							__('17','apicona')=>'17',
							__('18','apicona')=>'18',
							__('19','apicona')=>'19',
							__('20','apicona')=>'20',
							__('21','apicona')=>'21',
							__('22','apicona')=>'22',
							__('23','apicona')=>'23',
							__('24','apicona')=>'24',
						)
					),
					array(
						"type"        => "dropdown",
						"heading"     => __("Box View", "apicona"),
						"description" => __("Select view of the box.", "apicona"),
						"group"       => __( "Box Design", "apicona" ),
						"param_name"  => "design",
						"value"       => array(
							__("Default View", "apicona")   => "default",
							__("Detailed View", "apicona") => "detailed",
						),
					),
					array(
						"type"        => "dropdown",
						"heading"     => __("Column", "apicona"),
						"param_name"  => "column",
						"description" => __("Select column.", "apicona"),
						"group"       => __( "Box Design", "apicona" ),
						"value"       => array(
							__("One Column",    "apicona") => "one",
							__("Two Columns",   "apicona") => "two",
							__("Three Columns", "apicona") => "three",
							__("Four Columns",  "apicona") => "four",
							__("Five Columns",  "apicona") => "five",
							__("Six Columns",   "apicona") => "six",
						),
						"std"        => "three",
					),
					array(
						"type"        => "dropdown",
						"holder"      => "div",
						"class"       => "",
						"heading"     => __("Events View",'apicona'),
						"description" => __("Select events view. Show as normal row and column or show with carousel effect.",'apicona'),
						"group"       => __( "Box Design", "apicona" ),
						"param_name"  => "view",
						"value"       => array(
							__('Row and Column (default)','apicona') => 'default',
							__('Carousel effect','apicona')          => 'carousel',
						)
					),
					array(
						'type'       => 'dropdown',
						'heading'    => __( 'Carousel: Autoplay', 'apicona' ),
						'param_name' => 'carousel_autoplay',
						'value'      => array(
							__( 'Yes', 'apicona' ) => '1',
							__( 'No', 'apicona' )  => '0'
						),
						'description' => __( 'Carousel Effect: Autoplay', 'apicona' ),
						'group'       => __( 'Box Design', 'apicona' ),
						'dependency'  => array(
							'element'   => 'view',
							//'value_not_equal_to' => array( 'ids', 'custom' ),
							'value'     => array( 'carousel' ),
						),
						'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
				),
				//"js_view" => 'VcCallToActionView'
			) );
		}
		
			
			
		} // if( function_exists('vc_map') )	
	}
}
//add_action('init', 'kwayy_vc_extraThings');
kwayy_vc_extraThings();





/**
 * Service BoxIcon
 */
function kwayy_vc_init_servicebox() {
	global $newColorList;
}
//add_action('init', 'kwayy_vc_init_servicebox');
kwayy_vc_init_servicebox();



/**
 * Visual Composer: Heading
 */
if( function_exists('vc_map') ){
	vc_map( array(
		"name"     => __("Apicona Heading", "apicona"),
		"base"     => "heading",
		"icon"     => "icon-thememount-vc",
		'category' => __( 'ThemeMount Special Elements', 'apicona' ),
		"params"   => array(
			array(
				"type"        => "textarea",
				"heading"     => __("Text for heading", "apicona"),
				"description" => __("Write text for heading. Some HTML tags are allowed. <br><strong>Tip:</strong> You can add SPAN tag to add skin color to any text. Example: <code> Welcome to &lt;span&gt;OUR&lt;/span&gt; website. </code> ", "apicona"),
				"param_name"  => "text",
				"value"       => __("Welcome to our site", "apicona"),
			),
			array(
				"type"        => "textarea",
				"heading"     => __("Text for sub-heading", "apicona"),
				"description" => __("Write text for sub-heading. Some HTML tags are allowed. <br><strong>Tip:</strong> You can add SPAN tag to add skin color to any text. Example: <code>Lorem Ipsum is simply &lt;span&gt;DUMMY&lt;/span&gt; text of the printing and typesetting industry.</code> ", "apicona"),
				"param_name"  => "subtext",
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("Heading Tag", "apicona"),
				"description" => __("Select heading tag.", "apicona"),
				"param_name"  => "tag",
				"value"       => array(
					__("H1", "apicona") => "h1",
					__("H2", "apicona") => "h2",
					__("H3", "apicona") => "h3",
					__("H4", "apicona") => "h4",
					__("H5", "apicona") => "h5",
					__("H6", "apicona") => "h6",
				),
			),
			/*array(
				"type"        => "kwayy_iconselector",
				"holder"      => "div",
				"class"       => "vc_heading_sepicon",
				"heading"     => __("Separator Icon", "apicona"),
				"param_name"  => "sepicon",
				"value"       => $allIconsWithEmpty,
				"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'apicona')
			),*/
			array(
				"type"        => "dropdown",
				"heading"     => __("Heading Align", "apicona"),
				"description" => __("Select align for heading tag.", "apicona"),
				"param_name"  => "align",
				"value"       => array(
					__("Left", "apicona") => "left",
					__("Center", "apicona") => "center",
					__("Right", "apicona") => "right",
				),
			),
		),
		//"js_view" => 'VcCallToActionView'
	) );
}



/**
 * Team Member box
 */
function kwayy_team_member_options(){

	$teamGroups           = get_terms( 'team_group', array( 'hide_empty' => false ) );
	$teamGroupList        = array();
	//$teamGroupList['All'] = '';
	foreach($teamGroups as $teamGroup){
		$name                   = $teamGroup->name.' ('.$teamGroup->count.')';
		$teamGroupList[ $name ] = $teamGroup->slug;
	}
	
	if( function_exists('vc_map') ){
		vc_map( array(
			"name"     => __("Apicona Team Members", "apicona"),
			"base"     => "team",
			"icon"     => "icon-thememount-vc",
			'category' => __( 'ThemeMount Special Elements', 'apicona' ),
			"params"   => array(
				array(
					"type"        => "textarea",
					"holder"      => "div",
					"class"       => "",
					"heading"     => __("Box Title",'apicona'),
					"description" => __("Write box title here.",'apicona'),
					"param_name"  => "title",
					//"value"       => '',
				),
				array(
					"type"        => "textarea",
					"holder"      => "div",
					"class"       => "",
					"heading"     => __("Box Sub-title",'apicona'),
					"description" => __("Write box sub-title here.",'apicona'),
					"param_name"  => "subtitle",
					//"value"       => '',
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Title Align", "apicona"),
					"description" => __("Select align for title and sub-title tag.", "apicona"),
					"param_name"  => "align",
					"value"       => array(
						__("Left", "apicona")   => "left",
						__("Center", "apicona") => "center",
						__("Right", "apicona")  => "right",
					),
				),
				array(
					"type"        => "checkbox",
					"heading"     => __("Team Group", "apicona"),
					"param_name"  => "groupslug",
					"description" => __("Select group to show Team Members from selected group only. Select ALL to show all Team Members.", "apicona"),
					"value"       => $teamGroupList,
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Show", "apicona"),
					"param_name"  => "show",
					"description" => __("Total Team Members you want to show.", "apicona"),
					"value"       => array(
						__("All", "apicona") => "-1",
						__("1", "apicona")  => "1",
						__("2", "apicona") => "2",
						__("3", "apicona") => "3",
						__("4", "apicona") => "4",
						__("5", "apicona") => "5",
						__("6", "apicona") => "6",
						__("7", "apicona") => "7",
						__("8", "apicona") => "8",
						__("9", "apicona") => "9",
						__("10", "apicona") => "10",
					),
				),
				
				// Tab: Box Design
				array(
					"type"        => "dropdown",
					"heading"     => __("Column", "apicona"),
					"param_name"  => "column",
					"description" => __("Select button alignment.", "apicona"),
					"value"       => array(
						__("One Column",    "apicona") => "one",
						__("Two Columns",   "apicona") => "two",
						__("Three Columns", "apicona") => "three",
						__("Four Columns",  "apicona") => "four",
						__("Five Columns",  "apicona") => "five",
						__("Six Columns",   "apicona") => "six",
					),
					"std"         => "four",
					'group'       => __( 'Box Design', 'apicona' ),
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => __("View",'apicona'),
					"description" => __("Select the view. Show as normal row and column or show with carousel effect.",'apicona'),
					"param_name"  => "view",
					"value"       => array(
						__('Row and Column (default)','apicona') => 'default',
						__('Carousel effect','apicona')          => 'carousel',
					),
					'group'       => __( 'Box Design', 'apicona' ),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => __( 'Carousel: Autoplay', 'apicona' ),
					'param_name' => 'carousel_autoplay',
					'value'      => array(
						__( 'Yes', 'apicona' ) => '1',
						__( 'No', 'apicona' )  => '0'
					),
					'description' => __( 'Carousel Effect: Autoplay', 'apicona' ),
					'group'       => __( 'Box Design', 'apicona' ),
					'dependency'  => array(
						'element'   => 'view',
						//'value_not_equal_to' => array( 'ids', 'custom' ),
						'value'     => array( 'carousel' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

			),
			//"js_view" => 'VcCallToActionView'
		) );
	}
}
//add_action( 'admin_init', 'kwayy_team_member_options' );
kwayy_team_member_options();



/**
 * Testimonial box
 */
function kwayy_vc_testimonials(){
	if( function_exists('vc_map') ){
	
	
	
		// Fetching all Testmonial group names
		$testimonial_groups = get_terms( 'testimonial_group', array('hide_empty'=>false) );
		//$testimonialGroups = array( __("All", "apicona") => "" );
		foreach( $testimonial_groups as $group ){
			$totalcount = 0;
			if( trim($group->count) > 0 ){
				$totalcount = $group->count;
			}
			$testimonialGroups[ $group->name.' ('.$totalcount.')' ] = $group->slug;
		}
	
	
		vc_map( array(
			"name"     => __("Apicona Testimonial Box", "apicona"),
			"base"     => "testimonial",
			"icon"     => "icon-thememount-vc",
			'category' => __( 'ThemeMount Special Elements', 'apicona' ),
			"params"   => array(
				array(
				  "type"        => "textarea",
				  "heading"     => __("Box Title", "apicona"),
				  "param_name"  => "title",
				  "description" => __("What text use as a title. Leave blank if no title is needed.", "apicona")
				),
				array(
				  "type"        => "textarea",
				  "heading"     => __("Box Sub-title", "apicona"),
				  "param_name"  => "subtitle",
				  "description" => __("What text use as a sub-title. Leave blank if no sub-title is needed.", "apicona")
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Title Align", "apicona"),
					"description" => __("Select align for title and sub-title tag.", "apicona"),
					"param_name"  => "align",
					"value"       => array(
						__("Left", "apicona")   => "left",
						__("Center", "apicona") => "center",
						__("Right", "apicona")  => "right",
					),
				),
				/*array(
					"type"        => "kwayy_iconselector",
					"holder"      => "div",
					"heading"     => __("Separator Icon", "apicona"),
					"param_name"  => "sepicon",
					"value"       => $allIconsWithEmpty,
					"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'apicona')
				),*/
				array(
					"type"        => "checkbox",
					"heading"     => __("From Group", "apicona"),
					"param_name"  => "group",
					"description" => __("Select group so it will show Testimonials from selected group only.", "apicona"),
					"value"       => $testimonialGroups,
					"std"         => "",
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Show", "apicona"),
					"param_name"  => "show",
					"description" => __("Total Team Members you want to show.", "apicona"),
					"value"       => array(
						__("All", "apicona") => "-1",
						__("1", "apicona")  => "1",
						__("2", "apicona") => "2",
						__("3", "apicona") => "3",
						__("4", "apicona") => "4",
						__("5", "apicona") => "5",
						__("6", "apicona") => "6",
						__("7", "apicona") => "7",
						__("8", "apicona") => "8",
						__("9", "apicona") => "9",
						__("10", "apicona") => "10",
						__("11", "apicona") => "11",
						__("12", "apicona") => "12",
						__("13", "apicona") => "13",
						__("14", "apicona") => "14",
						__("15", "apicona") => "15",
						__("16", "apicona") => "16",
						__("17", "apicona") => "17",
						__("18", "apicona") => "18",
						__("19", "apicona") => "19",
						__("20", "apicona") => "20",
					),
				),
				
				// Tab: Box Design
				array(
					"type"        => "dropdown",
					"heading"     => __("Column", "apicona"),
					"param_name"  => "column",
					"description" => __("Select button alignment.", "apicona"),
					"value"       => array(
						__("One Column",    "apicona") => "one",
						__("Two Columns",   "apicona") => "two",
						__("Three Columns", "apicona") => "three",
						__("Four Columns",  "apicona") => "four",
						__("Five Columns",  "apicona") => "five",
						__("Six Columns",   "apicona") => "six",
					),
					"std"         => "three",
					'group'       => __( 'Box Design', 'apicona' ),
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => __("Blog View",'apicona'),
					"description" => __("Select blog view. Show as normal row and column or show with carousel effect.",'apicona'),
					"param_name"  => "view",
					"value"       => array(
						__('Row and Column (default)','apicona') => 'default',
						__('Carousel effect','apicona')          => 'carousel',
					),
					'group'       => __( 'Box Design', 'apicona' ),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => __( 'Carousel: Autoplay', 'apicona' ),
					'param_name' => 'carousel_autoplay',
					'value'      => array(
						__( 'Yes', 'apicona' ) => '1',
						__( 'No', 'apicona' )  => '0'
					),
					'description' => __( 'Carousel Effect: Autoplay', 'apicona' ),
					'group'       => __( 'Box Design', 'apicona' ),
					'dependency'  => array(
						'element'   => 'view',
						//'value_not_equal_to' => array( 'ids', 'custom' ),
						'value'     => array( 'carousel' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

			),
			//"js_view" => 'VcCallToActionView'
		) );
	}
}


//add_action('init', 'kwayy_vc_testimonials');
kwayy_vc_testimonials();



/**
 * Client box
 */
function kwayy_vc_clients(){
	
	global $allIconsWithEmpty;
	
	if( function_exists('vc_map') ){

		// Fetching all client group names
		$client_groups = get_terms( 'client_group', array('hide_empty'=>false) );
		//var_dump($client_groups);
		//$clientGroups = array( __("All", "apicona") => "" );
		foreach( $client_groups as $group ){
			$clientGroups[ $group->name.' ('.$group->count.')' ] = $group->slug;
		}
		
		vc_map( array(
			"name"     => __("Apicona Client's Logo Box", "apicona"),
			"base"     => "clients",
			"icon"     => "icon-thememount-vc",
			'category' => __( 'ThemeMount Special Elements', 'apicona' ),
			"params"   => array(
				array(
				  "type"        => "textarea",
				  "heading"     => __("Box Title", "apicona"),
				  "param_name"  => "title",
				  "description" => __("What text use as a title. Leave blank if no title is needed.", "apicona")
				),
				array(
				  "type"        => "textarea",
				  "heading"     => __("Box Sub-title", "apicona"),
				  "param_name"  => "subtitle",
				  "description" => __("What text use as a sub-title. Leave blank if no sub-title is needed.", "apicona")
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Title Align", "apicona"),
					"description" => __("Select align for title and sub-title tag.", "apicona"),
					"param_name"  => "align",
					"value"       => array(
						__("Left", "apicona")   => "left",
						__("Center", "apicona") => "center",
						__("Right", "apicona")  => "right",
					),
				),
				/*array(
					"type"        => "kwayy_iconselector",
					"holder"      => "div",
					"class"       => "vc_heading_sepicon",
					"heading"     => __("Separator Icon", "apicona"),
					"param_name"  => "sepicon",
					"value"       => $allIconsWithEmpty,
					"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'apicona')
				),*/
				array(
					"type"        => "checkbox",
					"heading"     => __("From Group", "apicona"),
					"param_name"  => "group",
					"description" => __("Select group so it will show client logo from selected group only.", "apicona"),
					"value"       => $clientGroups,
					"std"         => "",
				),
				array(
					"type"        => "dropdown",
					"heading"     => __("Show", "apicona"),
					"param_name"  => "show",
					"description" => __("Total Team Members you want to show.", "apicona"),
					"value"       => array(
						__("All", "apicona") => "-1",
						__("1", "apicona")  => "1",
						__("2", "apicona") => "2",
						__("3", "apicona") => "3",
						__("4", "apicona") => "4",
						__("5", "apicona") => "5",
						__("6", "apicona") => "6",
						__("7", "apicona") => "7",
						__("8", "apicona") => "8",
						__("9", "apicona") => "9",
						__("10", "apicona") => "10",
						__("11", "apicona") => "11",
						__("12", "apicona") => "12",
						__("13", "apicona") => "13",
						__("14", "apicona") => "14",
						__("15", "apicona") => "15",
						__("16", "apicona") => "16",
						__("17", "apicona") => "17",
						__("18", "apicona") => "18",
						__("19", "apicona") => "19",
						__("20", "apicona") => "20",
					),
				),
				
				
				// Tab: Box Design
				array(
					"type"        => "dropdown",
					"heading"     => __("Column", "apicona"),
					"param_name"  => "column",
					"description" => __("Select button alignment.", "apicona"),
					"value"       => array(
						__("One Column",    "apicona") => "one",
						__("Two Columns",   "apicona") => "two",
						__("Three Columns", "apicona") => "three",
						__("Four Columns",  "apicona") => "four",
						__("Five Columns",  "apicona") => "five",
						__("Six Columns",   "apicona") => "six",
					),
					"std"         => "five",
					'group'       => __( 'Box Design', 'apicona' ),
				),
				array(
					"type"        => "dropdown",
					"holder"      => "div",
					"class"       => "",
					"heading"     => __("Box View",'apicona'),
					"description" => __("Select box view. Show as normal row and column or show with carousel effect.",'apicona'),
					"param_name"  => "view",
					"value"       => array(
						__('Row and Column (default)','apicona') => 'default',
						__('Carousel effect','apicona')          => 'carousel',
					),
					'group'       => __( 'Box Design', 'apicona' ),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => __( 'Carousel: Autoplay', 'apicona' ),
					'param_name' => 'carousel_autoplay',
					'value'      => array(
						__( 'Yes', 'apicona' ) => '1',
						__( 'No', 'apicona' )  => '0'
					),
					'description' => __( 'Carousel Effect: Autoplay', 'apicona' ),
					'group'       => __( 'Box Design', 'apicona' ),
					'dependency'  => array(
						'element'   => 'view',
						//'value_not_equal_to' => array( 'ids', 'custom' ),
						'value'     => array( 'carousel' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
			),

			//"js_view" => 'VcCallToActionView'
		) );
	}
}
//add_action('init', 'kwayy_vc_clients');
kwayy_vc_clients();


	
	


/**
 * Portfolio Box
 */
if( function_exists('vc_map') ){
	
	// Getting list of Portfolio Category
	$portfolioCatList_data = get_terms( 'portfolio_category', array( 'hide_empty' => false ) );
	$portfolioCatList      = array();
	//$portfolioCatList[ __('All', 'howes') ] = '';
	foreach($portfolioCatList_data as $cat){
		$portfolioCatList[ __($cat->name, 'howes') . ' (' . $cat->count . ')' ] = $cat->slug;
	}
	
	vc_map( array(
		"name"     => __("Apicona Portfolio Box",'apicona'),
		"base"     => "portfoliobox",
		"class"    => "",
		'category' => __( 'ThemeMount Special Elements', 'apicona' ),
		"icon"     => "icon-thememount-vc",
		"params" => array(
			/*array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Text Position",'apicona'),
				"description" => __("Select where you want to show text details (Title and Sub-title text contents). Select LEFT to show at left side or select TOP CENTER to show at top as center.",'apicona'),
				"param_name"  => "textposition",
				"value"       => array(
					__('Left','apicona')       => 'left',
					__('Top Center','apicona') => 'top',
				)
			),*/
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Box Title",'apicona'),
				"description" => __("Write box title here.",'apicona'),
				"param_name"  => "title",
				//"value"     => __("Our Latest Projects",'apicona'),
			),
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Box Sub-title",'apicona'),
				"description" => __("Write box sub-title here.",'apicona'),
				"param_name"  => "subtitle",
				//"value"       => __("Lorem ipsum dolor sit amet, consectetur adipiscing elit.",'apicona'),
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("Title Align", "apicona"),
				"description" => __("Select align for title and sub-title tag.", "apicona"),
				"param_name"  => "align",
				"value"       => array(
					__("Left", "apicona")   => "left",
					__("Center", "apicona") => "center",
					__("Right", "apicona")  => "right",
				),
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Show Sortable Category Links",'apicona'),
				"description" => __("Show sortable category links above Portfolio items so user can sort by category by just single click.",'apicona'),
				"param_name"  => "sortable",
				"value"       => array(
					__('No','apicona')  => 'no',
					__('Yes','apicona') => 'yes',
				)
			),
			array(
				"type"        => "checkbox",
				"heading"     => __("From Category", "apicona"),
				"description" => __("If you like to show posts from selected category than select the category here.", "apicona") . __("The brecket number shows how many posts there in the category.", "apicona"),
				"param_name"  => "category",
				"value"       => $portfolioCatList,
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Show Pagination",'apicona'),
				"description" => __("Show pagination links below portfolio boxes.",'apicona'),
				"param_name"  => "pagination",
				"value"       => array(
					__('No','apicona')  => 'no',
					__('Yes','apicona') => 'yes',
				)
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Button Text",'apicona'),
				"description" => __("Write button text here.",'apicona'),
				"group"       => __( "Button Options", "apicona" ),
				"param_name"  => "btntext",
				"value"       => ''
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Button Link (URL)",'apicona'),
				"description" => __("Write URL for the button.",'apicona'),
				"group"       => __( "Button Options", "apicona" ),
				"param_name"  => "btnlink",
				"value"       => ''
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Show Portfolio Item",'apicona'),
				"description" => __("How many portfolio item you want to show.",'apicona'),
				"param_name"  => "show",
				"std"         => "3",
				"value"       => array(
					__('All', 'apicona') => '-1',
					__('1','apicona')  => '1',
					__('2','apicona') => '2',
					__('3','apicona')=>'3',
					__('4','apicona')=>'4',
					__('5','apicona')=>'5',
					__('6','apicona')=>'6',
					__('7','apicona')=>'7',
					__('8','apicona')=>'8',
					__('9','apicona')=>'9',
					__('10','apicona')=>'10',
					__('11','apicona')=>'11',
					__('12','apicona')=>'12',
					__('13','apicona')=>'13',
					__('14','apicona')=>'14',
					__('15','apicona')=>'15',
					__('16','apicona')=>'16',
					__('17','apicona')=>'17',
					__('18','apicona')=>'18',
					__('19','apicona')=>'19',
					__('20','apicona')=>'20',
					__('21','apicona')=>'21',
					__('22','apicona')=>'22',
					__('23','apicona')=>'23',
					__('24','apicona')=>'24',
				)
			),
			
			// Tab: Box Design
			array(
				"type"        => "dropdown",
				"heading"     => __("Column", "apicona"),
				"param_name"  => "column",
				"description" => __("Select column.", "apicona"),
				"value"       => array(
					__("One Column",    "apicona") => "one",
					__("Two Columns",   "apicona") => "two",
					__("Three Columns", "apicona") => "three",
					__("Four Columns",  "apicona") => "four",
					__("Five Columns",  "apicona") => "five",
					__("Six Columns",   "apicona") => "six",
				),
				"std"         => 'three',
				'group'       => __( 'Box Design', 'apicona' ),
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Portfolio View",'apicona'),
				"description" => __("Select portfolio view. Show as normal row and column or show with carousel effect.",'apicona'),
				"param_name"  => "view",
				"value"       => array(
					__('Row and Column (default)','apicona') => 'default',
					__('Carousel effect','apicona')          => 'carousel',
				),
				'group'       => __( 'Box Design', 'apicona' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Carousel: Autoplay', 'apicona' ),
				'param_name' => 'carousel_autoplay',
				'value'      => array(
					__( 'Yes', 'apicona' ) => '1',
					__( 'No', 'apicona' )  => '0'
				),
				'description' => __( 'Carousel Effect: Autoplay', 'apicona' ),
				'group'       => __( 'Box Design', 'apicona' ),
				'dependency'  => array(
					'element'   => 'view',
					//'value_not_equal_to' => array( 'ids', 'custom' ),
					'value'     => array( 'carousel' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

		)
	) );
} // if( function_exists('vc_map') )


	
	
	
	
	
	
	
/**
 * Apicona Contact Details Box
 */
if( function_exists('vc_map') ){
	vc_map( array(
		"name"     => __("Apicona Contact Details Box",'apicona'),
		"base"     => "contactbox",
		"class"    => "",
		'category' => __( 'ThemeMount Special Elements', 'apicona' ),
		"icon"     => "icon-thememount-vc",
		"params"   => array(
			/*array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Box Title",'apicona'),
				"description" => __("Write box title here.",'apicona'),
				"param_name"  => "title",
				"value"       => __("Get in touch",'apicona'),
			),*/
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Phone",'apicona'),
				"description" => __("Write phone number here. Example: <code>(+01) 123 456 7890</code>",'apicona'),
				"param_name"  => "phone",
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Email",'apicona'),
				"description" => __("Write email here. Example: <code>info@example.com</code>",'apicona'),
				"param_name"  => "email",
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Website",'apicona'),
				"description" => __("Write website URL here. Example: <code>www.example.com</code>",'apicona'),
				"param_name"  => "website",
			),
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Address",'apicona'),
				"description" => __("Write address here. <br> Example: <code>Honey Business <br> 24 Fifth st., Los Angeles, <br> USA</code>",'apicona'),
				"param_name"  => "address",
			),
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Time",'apicona'),
				"description" => __("Write time here. <br> Example: <code>Mon to Sat - 9:00am to 6:00pm<br>(Sunday Closed)</code>",'apicona'),
				"param_name"  => "time",
			),
		)
	) );
}




	
	
	
	
	
	
	
	
/**
 * Apicona Blog Box
 */	
if( function_exists('vc_map') ){
	
	$postCatList = get_categories(array('hide_empty'=>false));
	$catList     = array();
	//$catList[ __('All', 'apicona') ] = '';
	foreach($postCatList as $cat){
		$catList[ __($cat->name, 'apicona') . ' (' . $cat->count . ')' ] = $cat->slug;
	}
	
	
	vc_map( array(
		"name"     => __("Apicona Blog Box",'apicona'),
		"base"     => "blogbox",
		"class"    => "",
		'category' => __( 'ThemeMount Special Elements', 'apicona' ),
		"icon"     => "icon-thememount-vc",
		"params"   => array(
			/*array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Text Position",'apicona'),
				"description" => __("Select where you want to show text details (Title and Sub-title text contents). Select LEFT to show at left side or select TOP CENTER to show at top as center.",'apicona'),
				"param_name"  => "textposition",
				"value"       => array(
					__('Left','apicona')       => 'left',
					__('Top Center','apicona') => 'top',
				)
			),*/
			array(
				"type" => "textarea",
				"holder" => "div",
				"class" => "",
				"heading" => __("Box Title",'apicona'),
				"description" => __("Write box title here.",'apicona'),
				"param_name" => "title",
				//"value" => __("Our Latest Blog",'apicona'),
			),
			array(
				"type"        => "textarea",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Box Sub-title",'apicona'),
				"description" => __("Write box sub-title here.",'apicona'),
				"param_name"  => "subtitle",
				//"value"       => __("Lorem ipsum dolor sit amet, consectetur adipiscing elit.",'apicona'),
			),
			array(
				"type"        => "dropdown",
				"heading"     => __("Title Align", "apicona"),
				"description" => __("Select align for title and sub-title tag.", "apicona"),
				"param_name"  => "align",
				"value"       => array(
					__("Left", "apicona")   => "left",
					__("Center", "apicona") => "center",
					__("Right", "apicona")  => "right",
				),
			),
			/*array(
				"type"        => "kwayy_iconselector",
				"holder"      => "div",
				"class"       => "vc_heading_sepicon",
				"heading"     => __("Separator Icon", "apicona"),
				"param_name"  => "sepicon",
				"value"       => $allIconsWithEmpty,
				"description" => __("Select icon for separator. Only visible if sub-heading is filled.",'apicona')
			),*/
			array(
				"type"        => "checkbox",
				"heading"     => __("From Category", "apicona"),
				"description" => __("If you like to show posts from selected category than select the category here.", "apicona") . __("The brecket number shows how many posts there in the category.", "apicona"),
				"param_name"  => "category",
				"value"       => $catList,
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Button Text",'apicona'),
				"description" => __("Write button text here.",'apicona'),
				'group'       => __( 'Button Options', 'apicona' ),
				"param_name"  => "btntext",
				"value"       => ''
			),
			array(
				"type"        => "textfield",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Button Link (URL)",'apicona'),
				"description" => __("Write URL for the button.",'apicona'),
				'group'       => __( 'Button Options', 'apicona' ),
				"param_name"  => "btnlink",
				"value"       => ''
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Show Posts",'apicona'),
				"description" => __("How many post you want to show.",'apicona'),
				"param_name"  => "show",
				"std"         => "6",
				"value"       => array(
					__('All','apicona')=>'-1',
					__('1','apicona')=>'1',
					__('2','apicona')=>'2',
					__('3','apicona')=>'3',
					__('4','apicona')=>'4',
					__('5','apicona')=>'5',
					__('6','apicona')=>'6',
					__('7','apicona')=>'7',
					__('8','apicona')=>'8',
					__('9','apicona')=>'9',
					__('10','apicona')=>'10',
					__('11','apicona')=>'11',
					__('12','apicona')=>'12',
					__('13','apicona')=>'13',
					__('14','apicona')=>'14',
					__('15','apicona')=>'15',
					__('16','apicona')=>'16',
					__('17','apicona')=>'17',
					__('18','apicona')=>'18',
					__('19','apicona')=>'19',
					__('20','apicona')=>'20',
					__('21','apicona')=>'21',
					__('22','apicona')=>'22',
					__('23','apicona')=>'23',
					__('24','apicona')=>'24',
					__('25','apicona')=>'25',
					__('26','apicona')=>'26',
					__('27','apicona')=>'27',
					__('28','apicona')=>'28',
					__('29','apicona')=>'29',
					__('30','apicona')=>'30',
					
				)
			),
			
			// Tab: Box Design
			array(
				"type"        => "dropdown",
				"heading"     => __("Column", "apicona"),
				"param_name"  => "column",
				"description" => __("Select column.", "apicona"),
				"value"       => array(
					__("One Column",    "apicona") => "one",
					__("Two Columns",   "apicona") => "two",
					__("Three Columns", "apicona") => "three",
					__("Four Columns",  "apicona") => "four",
					__("Five Columns",  "apicona") => "five",
					__("Six Columns",   "apicona") => "six",
				),
				"std"         => "three",
				'group'       => __( 'Box Design', 'apicona' ),
			),
			array(
				"type"        => "dropdown",
				"holder"      => "div",
				"class"       => "",
				"heading"     => __("Blog View",'apicona'),
				"description" => __("Select blog view. Show as normal row and column or show with carousel effect.",'apicona'),
				"param_name"  => "view",
				"value"       => array(
					__('Row and Column (default)','apicona') => 'default',
					__('Carousel effect','apicona')          => 'carousel',
				),
				'group'       => __( 'Box Design', 'apicona' ),
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __( 'Carousel: Autoplay', 'apicona' ),
				'param_name' => 'carousel_autoplay',
				'value'      => array(
					__( 'Yes', 'apicona' ) => '1',
					__( 'No', 'apicona' )  => '0'
				),
				'description' => __( 'Carousel Effect: Autoplay', 'apicona' ),
				'group'       => __( 'Box Design', 'apicona' ),
				'dependency'  => array(
					'element'   => 'view',
					//'value_not_equal_to' => array( 'ids', 'custom' ),
					'value'     => array( 'carousel' ),
				),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
			),

		)
	) );
}






/**
 * Adding extra parameters in VC
 */	
if( function_exists('vc_add_param') ){
	
	vc_add_param( 'vc_row', array(
		'type'        => 'textfield',
		'heading'     => __('ID (For Anchor link)', 'apicona'),
		'param_name'  => 'anchor',
		"description" => __("Anchor for one-page site navigation link. Technically, this will add <code>id</code> tag to the row <code>div</code>. Example, <code>&lt;div id=&quot;foo&quot;&gt;</code>",'apicona')
	));
	
	vc_add_param( 'vc_row', array(
		'type'	      => 'checkbox',
		'class'       => '',
		'heading'     => __('Full Width ROW', 'apicona'),
		"description" => __("Set full width (100%) of the ROW instead of the boxed ROW.", "apicona"),
		'param_name'  => 'fullwidth',
		'value'       => array(
				'' => 'true'
		)
	));
	
	vc_add_param( 'vc_row', array(
		"type"        => "dropdown",
		"heading"     => __("Text Color", "apicona"),
		"description" => __("Select text color.", "apicona"),
		"param_name"  => "textcolor",
		"value"       => array(
			__("Use color set in \"Font Color\" option (default)", "apicona") => "default",
			__("Dark Color", "apicona") => "dark",
			__("White Color", "apicona") => "white",
			__("Skin Color", "apicona") => "skin",
		),
	));

	vc_add_param( 'vc_row', array(
		"type"        => "dropdown",
		"heading"     => __("Background Color", "apicona"),
		"description" => __("Select Background Color. If you select color and also select background Video or background Image than the color will be overlay with some opacity.", "apicona"),
		"param_name"  => "bgtype",
		"value"       => array(
			__("Background Color & Image set in \"Design Options\" tab (default)", "apicona") => "default",
			__("Skin Color as Background Color", "apicona") => "skin",
			__("Grey Color as Background Color", "apicona") => "grey",
			__("Dark Color as Background Color", "apicona") => "dark",
			//__("Background Video (set video path below) with Skin color overlay", "apicona") => "videoskin",
			//__("Background Video (set video path below) with Dark color overlay", "apicona") => "videogrey",
		),
	));
	
	vc_add_param( 'vc_row', array(
		'type'	      => 'checkbox',
		'class'       => '',
		'heading'     => __('Enable parallax', 'apicona'),
		"description" => __("The background-image is fixed with regard to the ROW. Technically, it will add <code>background-attachment:fixed</code> to the ROW", "apicona"),
		'param_name'  => 'parallax',
		'value'       => array(
				'' => 'true'
		)
	));
	
	/*vc_add_param( 'vc_row', array(
		"type"        => "dropdown",
		"heading"     => __("Predefined Background Color", "apicona"),
		"description" => __("Select predefined background color.", "apicona"),
		"param_name"  => "bgprecolor",
		"value"       => array(
			__("Skin Color as Background Color", "apicona") => "skin",
			__("Grey Color as Background Color", "apicona") => "grey",
			__("Dark Color as Background Color", "apicona") => "dark",
		),
	));*/
	
	/*vc_add_param( 'vc_row', array(
		'type'	      => 'checkbox',
		'class'       => '',
		'heading'     => __('Predefined Background Color Overlay (only for image and video background type)', 'apicona'),
		"description" => __("This will set transparent color layer on video or image background.", "apicona"),
		'param_name'  => 'coloroverlay',
		'value'       => array(
				'' => 'true'
		)
	));*/
	
	// video background
	vc_add_param('vc_row', array(
		'type'        => 'textfield',
		'class'       => '',
		'heading'     => __('Video background (mp4)', 'apicona'),
		'param_name'  => 'bg_video_src_mp4',
		'value'       => '',
		"description" => __("Fill URL of MP4 video that you want to show as background. This will use HTML5 VIDEO tag.",'apicona')
	));

	vc_add_param('vc_row', array(
		'type'        => 'textfield',
		'class'       => '',
		'heading'     => __('Video background (ogg or ogv)', 'apicona'),
		'param_name'  => 'bg_video_src_ogg',
		'value'       => '',
		"description" => __("Fill URL of OGG or OGV video that you want to show as background. This will use HTML5 VIDEO tag.",'apicona')
	));

	vc_add_param('vc_row', array(
		'type'        => 'textfield',
		'class'       => '',
		'heading'     => __('Video background (webm)', 'apicona'),
		'param_name'  => 'bg_video_src_webm',
		'value'       => '',
		"description" => __("Fill URL of WEBM video that you want to show as background. This will use HTML5 VIDEO tag.",'apicona')
	));
	
	global $kwayy_iconsArray;
	foreach($kwayy_iconsArray as $icon ){
		$allIcons[ucwords(str_replace('-',' ',$icon))] = $icon;
	}
	
	
	vc_add_param( 'vc_button2', array(
		"type"        => "dropdown",
		"heading"     => __("Button Icon Position", "apicona"),
		"description" => __("Select icon position in button.", "apicona"),
		"param_name"  => "btniconposition",
		"value"       => array(
			__("No icon", "apicona") => "no",
			__("Left icon", "apicona") => "left",
			__("Right icon", "apicona") => "right",
		),
	));
	
	vc_add_param( 'vc_button2', array(
		"type"        => "kwayy_iconselector",
		"heading"     => __("Button Icon", "apicona"),
		"description" => __("Select button icon.", "apicona"),
		"param_name"  => "btnicon",
		"value"       => $allIcons,
	));
	
	vc_add_param( 'vc_cta_button2', array(
		"type"        => "dropdown",
		"heading"     => __("Button Icon Position", "apicona"),
		"description" => __("Select icon position in button.", "apicona"),
		"param_name"  => "btniconposition",
		"value"       => array(
			__("No icon", "apicona") => "no",
			__("Left icon", "apicona") => "left",
			__("Right icon", "apicona") => "right",
		),
	));
	
	vc_add_param( 'vc_cta_button2', array(
		"type"        => "kwayy_iconselector",
		"heading"     => __("Button Icon", "apicona"),
		"description" => __("Select button icon.", "apicona"),
		"param_name"  => "btnicon",
		"value"       => $allIcons,
	));
	
	
	vc_add_param( 'vc_cta_button2', array(
		"type"        => "dropdown",
		"heading"     => __("Big Font Style", "apicona"),
		"description" => __("Select YES to use big size font for this CTA2.", "apicona"),
		"param_name"  => "bigfont",
		"value"       => array(
			__("No", "apicona") => "",
			__("Yes", "apicona") => "yes",
		),
	));
	
	vc_add_param( 'vc_cta_button2', array(
		"type"        => "dropdown",
		"heading"     => __("Add separator below \"Heading first line\" title", "apicona"),
		"description" => __("Select YES to show a small separator line below \"Heading first line\" title.", "apicona"),
		"param_name"  => "sepline",
		"value"       => array(
			__("No", "apicona")  => "",
			__("Yes", "apicona") => "yes",
		),
	));
	
}




/************************** Custom Template *****************************/
add_filter( 'vc_load_default_templates', 'my_custom_template_for_vc' );
function my_custom_template_for_vc($maindata) {
	
	$maindata = array();
	
	/* ***************** */
	
	
	// Sample Homepage 1
    $data               = array();
    $data['name']       = __( 'Main Homepage', 'apicona' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'apicona_home_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row css=".vc_custom_1406868521706{margin-bottom: 0px !important;padding: 40px 0px !important;}" textcolor="default" bgtype="skin" bgprecolor="skin"][vc_column width="1/1"][vc_cta_button2 h2="IF YOU NEED A DOCTOR ? MAKE AN APPOINMENT NOW!" style="square_outlined" txt_align="left" title="Make an Appoinment" btn_style="square_outlined" color="white" size="md" position="right" btniconposition="no" btnicon="fa-adjust" link="url:http%3A%2F%2Fapicona-data.thememount.com%2Fappointments%2F||"]I am promo text. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit.[/vc_cta_button2][/vc_column][/vc_row][vc_row bgcolor="white" paddingtop="40px" contentalign="center" rowwidth="default" textcolor="default" bgimageposition="fixed" css=".vc_custom_1406193093673{padding-bottom: 40px !important;}" bgtype="default" bgprecolor="skin"][vc_column width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-leaf" buttontype="icontext" title="HEALTH INFORMATION" css_animation="appear" btn_effect="colortoborder" buttontext="Read More" contents="Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et et dolore te feugait nulla facilisi." buttoncolor="black" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" buttonlink="url:%23||" buttonstyle="rounded"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.[/servicebox][/vc_column][vc_column width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-user-md" buttontype="icontext" title="MEDICAL TREATMENT" css_animation="appear" btn_effect="colortoborder" buttontext="Read More" contents="Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et et dolore te feugait nulla facilisi." buttoncolor="black" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" buttonlink="url:%23||" buttonstyle="rounded"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.[/servicebox][/vc_column][vc_column width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-h-square" buttontype="icontext" title="CARDIO MONITORING" css_animation="appear" btn_effect="colortoborder" buttontext="Read More" contents="Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et et dolore te feugait nulla facilisi." buttoncolor="black" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" buttonlink="url:%23||" buttonstyle="rounded"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.[/servicebox][/vc_column][/vc_row][vc_row bgcolor="white" contentalign="default" rowwidth="default" textcolor="default" bgimageposition="fixed" css=".vc_custom_1405938446293{padding-top: 0px !important;}" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][portfoliobox sortable="no" show="8" column="three" view="carousel" viewarea="boxed" title="LATEST HEALTH TIPS"][/vc_column][/vc_row][vc_row bgcolor="dark" bgimage="http://addyson-data.thememount.com/wp-content/uploads/2013/12/parralaxbg.jpg" contentalign="default" rowwidth="wide" textcolor="default" bgimageposition="fixed" css=".vc_custom_1412416320121{padding-bottom: 0px !important;background-image: url(http://apicona-data.thememount.com/wp-content/uploads/2014/07/data-pic-2.jpg?id=1042) !important;}" bgtype="dark" bgprecolor="dark" parallax="true" coloroverlay="true" font_color="#ffffff"][vc_column width="1/3"][vc_single_image image="1057" alignment="center" border_color="grey" img_link_target="_self" img_size="full" css_animation="left-to-right"][/vc_column][vc_column width="2/3"][vc_column_text]
<h2>Take your place And Resereve now in our hospital !</h2>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.[/vc_column_text][vc_row_inner][vc_column_inner width="1/2"][vc_column_text]
<ul class="list-style list-style7 ">
	<li>Lorem ipsum dolor sit amet, consectetur</li>
	<li>Adipisicing elit, sed do eiusmod tempor</li>
	<li>Incididunt ut labore et dolore magna aliqua</li>
	<li>Sed do eiusmod tempor</li>
</ul>
[/vc_column_text][/vc_column_inner][vc_column_inner width="1/2"][vc_column_text]
<ul class="list-style list-style7 ">
	<li>Aliqua. Ut enim ad minim veniam, quis</li>
	<li>Nostrud exercitation ullamco laboris nisi</li>
	<li>Ut aliquip ex ea commodo consequat</li>
	<li>Exercitation ullamco laboris nisi</li>
</ul>
[/vc_column_text][/vc_column_inner][/vc_row_inner][vc_button2 title="Read More" style="square_outlined" color="white" size="md" btniconposition="no" btnicon="fa-adjust" link="url:%23||" el_class="spacer-right-15"][vc_button2 title="Get Started Today" style="square" color="skincolor" size="md" btniconposition="no" btnicon="fa-adjust" link="url:%23||" el_class="margin-left"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="default" bgprecolor="skin" css=".vc_custom_1411479680115{padding-top: 75px !important;padding-bottom: 60px !important;}"][vc_column width="2/3"][blogbox show="2" column="two" view="default" title="LATEST NEWS"][/vc_column][vc_column width="1/3"][testimonial show="-1" column="one" view="carousel" title="TESTIMONIALS"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="dark" bgprecolor="grey" parallax="true" css=".vc_custom_1412416374781{background-image: url(http://apicona-data.thememount.com/wp-content/uploads/2014/07/data-pic-2.jpg?id=1042) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column width="1/4"][facts_in_digits title="AWARD SHOWS" icon="fa-mortar-board" digit="100"][/vc_column][vc_column width="1/4"][facts_in_digits title="CLINIC ROOMS" icon="fa-bars" digit="625"][/vc_column][vc_column width="1/4"][facts_in_digits title="OUR STAFF" icon="fa-user-md" digit="500"][/vc_column][vc_column width="1/4"][facts_in_digits title="MACHINES" icon="fa-anchor" digit="256"][/vc_column][/vc_row][vc_row bgcolor="white" contentalign="default" textcolor="default" bgimageposition="fixed" bgtype="default" bgprecolor="grey"][vc_column width="1/1"][team show="-1" column="four" style="default" title="OUR DOCTORS" view="carousel"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="skin" css=".vc_custom_1413185809181{padding-top: 20px !important;padding-bottom: 30px !important;}"][vc_column width="1/1"][twitterbox show="3" consumer_key="v6t8tY3ZCKyZnZ5J1vBDA" consumer_secret="73K8GXdgriSFlff01t68e608y1sy5gvvuBgmCXlGEQg" oauth_token="198949585-yOkBOaBtYfsBLIgGlgUXRNwkIIWOSCnk3SMOjzKx" oauth_token_secret="wcTRHKILxqcsu0Lka3Vh2J0DGr7oR6pBMLdLtnwo5E" username="envato"][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	
	
	
	// Sample Homepage 1
    $data               = array();
    $data['name']       = __( 'Sample Homepage v1', 'apicona' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page1.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'apicona_home_1_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row bgcolor="white" paddingtop="40px" contentalign="center" rowwidth="default" textcolor="default" bgimageposition="fixed" bgtype="default" bgprecolor="skin" css=".vc_custom_1406118725132{padding-bottom: 40px !important;}"][vc_column width="1/3"][vc_column_text]
<h2>Health Care and Medical WordPress Theme</h2>
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.[/vc_column_text][vc_button2 title="Get Started Today" style="square" color="skincolor" size="sm" btniconposition="no" btnicon="fa-adjust" link="url:%23||"][/vc_column][vc_column width="2/3"][vc_row_inner][vc_column_inner width="1/2"][servicebox boxtype="lefticonspacing" icon="fa-leaf" buttontype="no" title="EMERGENCY HELP" css_animation="appear" btn_effect="colortoborder" buttontext="Read More" contents="Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et et dolore te feugait nulla facilisi." buttoncolor="black" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" buttonlink="#" buttonstyle="rounded"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.[/servicebox][/vc_column_inner][vc_column_inner width="1/2"][servicebox boxtype="lefticonspacing" icon="fa-user-md" buttontype="no" title="CARDIO MONITORING" css_animation="appear" btn_effect="colortoborder" buttontext="Read More" contents="Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et et dolore te feugait nulla facilisi." buttoncolor="black" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" buttonlink="#" buttonstyle="rounded"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.[/servicebox][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/2"][servicebox boxtype="lefticonspacing" icon="fa-h-square" buttontype="no" title="HEALTH CARE" css_animation="appear" btn_effect="colortoborder" buttontext="Read More" contents="Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et et dolore te feugait nulla facilisi." buttoncolor="black" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" buttonlink="#" buttonstyle="rounded"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.[/servicebox][/vc_column_inner][vc_column_inner width="1/2"][servicebox boxtype="lefticonspacing" icon="fa-ambulance" buttontype="no" title="MEDICAL COUNSELING" css_animation="appear" btn_effect="colortoborder" buttontext="Read More" contents="Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et et dolore te feugait nulla facilisi." buttoncolor="black" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" buttonlink="#" buttonstyle="rounded"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod.[/servicebox][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row textcolor="default" bgtype="dark" bgprecolor="dark" css=".vc_custom_1412416466158{background-image: url(http://apicona-data.thememount.com/wp-content/uploads/2014/07/data-pic-2.jpg?id=1042) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" parallax="true" coloroverlay="true"][vc_column width="1/1"][vc_cta_button2 h2="Apicona - Medical &amp; Health Theme by Thememount" style="square" txt_align="center" title="Purchase Now" btn_style="square" color="skincolor" size="md" position="bottom" btniconposition="right" btnicon="fa-angle-right" link="url:%23||" h4="Lorem ipsum dolor sit amet, adipiscing elit. Maecenas neque diam, luctus at laoreet."][/vc_cta_button2][/vc_column][/vc_row][vc_row textcolor="default" bgtype="grey" bgprecolor="grey"][vc_column width="1/1"][blogbox show="6" column="three" view="carousel" title="LATEST NEWS FROM HEALTH AND MEDICAL"][/vc_column][/vc_row][vc_row css=".vc_custom_1411472176790{padding-bottom: 50px !important;}" textcolor="default" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][testimonial show="2" column="two" view="default" title="TESTIMONIALS"][/vc_column][/vc_row][vc_row bgcolor="white" contentalign="default" rowwidth="default" textcolor="default" bgimageposition="fixed" bgtype="dark" bgprecolor="dark" css=".vc_custom_1412416488001{background-image: url(http://apicona-data.thememount.com/wp-content/uploads/2014/07/data-pic-2.jpg?id=1042) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" coloroverlay="true" parallax="true"][vc_column width="1/1"][portfoliobox sortable="no" show="6" column="three" view="carousel" viewarea="boxed" title="WE ARE OFFERING RELIABLE SERVICES" subtitle="Lorem ipsum dolor sit amet, adipiscing elit. Maecenas neque diam, luctus at laoreet." align="center" pagination="no"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="skin" bgprecolor="skin" css=".vc_custom_1412416500062{background-image: url(http://apicona-data.thememount.com/wp-content/uploads/2014/07/data-pic-2.jpg?id=1042) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" coloroverlay="true"][vc_column width="1/4"][facts_in_digits title="MACHINES" icon="fa-anchor" digit="256"][/vc_column][vc_column width="1/4"][facts_in_digits title="AWARD SHOWS" icon="fa-mortar-board" digit="100"][/vc_column][vc_column width="1/4"][facts_in_digits title="OUR STAFF" icon="fa-user-md" digit="500"][/vc_column][vc_column width="1/4"][facts_in_digits title="CLINIC ROOMS" icon="fa-bars" digit="625"][/vc_column][/vc_row][vc_row bgcolor="white" contentalign="default" textcolor="default" bgimageposition="fixed" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][heading text="DOCTORS TEAM" tag="h2" style="normal" align="left" sepicon="NO_ICON"][team show="4" column="four" style="default" view="default"][/vc_column][/vc_row][vc_row css=".vc_custom_1413185875003{padding-top: 20px !important;padding-bottom: 30px !important;}" textcolor="default" bgtype="skin"][vc_column width="1/1"][twitterbox show="3" consumer_key="v6t8tY3ZCKyZnZ5J1vBDA" consumer_secret="73K8GXdgriSFlff01t68e608y1sy5gvvuBgmCXlGEQg" oauth_token="198949585-yOkBOaBtYfsBLIgGlgUXRNwkIIWOSCnk3SMOjzKx" oauth_token_secret="wcTRHKILxqcsu0Lka3Vh2J0DGr7oR6pBMLdLtnwo5E" username="envato"][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	// Sample Homepage 2
    $data               = array();
    $data['name']       = __( 'Sample Homepage v2', 'apicona' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page2.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'apicona_home_2_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row css=".vc_custom_1406636605950{padding-bottom: 40px !important;}" textcolor="default" bgtype="default" bgprecolor="grey"][vc_column width="1/1"][heading text="APICONA THEME FOR MEDICAL AND HEALTH WEBSITES" tag="h2" align="center" subtext="Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat nulla facilisi."][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="centericon" icon="fa-medkit" contents="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis placerat urna. Nulla nulla diam, adipiscing non ornare non, commodo adipiscing elit." buttontype="no" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-adjust" buttoneffect="colortoborder" btniconposition="left" title="ADVANCED TECHNOLOGY" titlelink="#" buttonstyle="rounded"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="centericon" icon="fa-ambulance" contents="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis placerat urna. Nulla nulla diam, adipiscing non ornare non, commodo adipiscing elit." buttontype="no" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-adjust" buttoneffect="colortoborder" btniconposition="left" title="24/7 AVAILABILITY" titlelink="#" buttonstyle="rounded"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="centericon" icon="fa-user-md" contents="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis placerat urna. Nulla nulla diam, adipiscing non ornare non, commodo adipiscing elit." buttontype="no" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-adjust" buttoneffect="colortoborder" btniconposition="left" title="HEALTHCARE SOLUTIONS" titlelink="#" buttonstyle="rounded"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row fullwidth="true" textcolor="default" bgtype="grey" bgprecolor="grey" css=".vc_custom_1406874539647{padding-bottom: 0px !important;}"][vc_column width="1/1"][heading text="WHY CHOOSES OUR RESEARCH?" tag="h2" align="center" subtext="Showcase your work with colorfull hover effect and seperate your works in categories"][portfoliobox sortable="yes" show="8" column="four" view="default" viewarea="fullwidth" align="left" pagination="no"][/vc_column][/vc_row][vc_row bgcolor="dark" bgimage="http://addyson.thememount.com/wp-content/uploads/2013/12/parralaxbg.jpg" contentalign="default" rowwidth="wide" textcolor="default" bgimageposition="fixed" css=".vc_custom_1412417255319{padding-top: 80px !important;padding-bottom: 80px !important;background-image: url(http://apicona-data.thememount.com/wp-content/uploads/2014/07/data-pic-2.jpg?id=1042) !important;}" bgtype="dark" bgprecolor="dark" parallax="true" coloroverlay="true"][vc_column width="1/1"][vc_cta_button2 style="rounded" txt_align="center" title="More" btn_style="square" color="skincolor" size="sm" position="bottom" link="url:%23||" btniconposition="no" btnicon="fa-check" h4="24 HOURS SERVICE" bigfont="yes" sepline="yes" h2="Successful For Evey Patient"][/vc_cta_button2][/vc_column][/vc_row][vc_row textcolor="default" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][team show="-1" column="four" view="carousel" title="OUR AWESOME TEAM" subtitle="We bring you an awesomeness of design, creative skills, thoughts, and ideas" align="center"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="grey" bgprecolor="grey" css=".vc_custom_1411469568567{padding-bottom: 40px !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column width="1/1"][heading text="WHAT OUR PATIENT SAY" tag="h2" align="center" subtext="Mirum est notare quam littera gothica, quam nunc putamus parum claram"][testimonial show="2" column="two" view="default"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][blogbox show="6" column="three" view="carousel" title="OUR LATEST BLOG" subtitle="Mirum est notare quam littera gothica, quam nunc putamus parum claram" align="center"][/vc_column][/vc_row][vc_row css=".vc_custom_1412417276226{background-image: url(http://apicona-data.thememount.com/wp-content/uploads/2014/07/data-pic-2.jpg?id=1042) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" textcolor="default" bgtype="dark" bgprecolor="dark" parallax="true" coloroverlay="true"][vc_column width="1/1"][heading text="ABOUT APICONA" tag="h2" align="center" subtext="Lorem Ipsum is simply dummy text of the printing and dummy."][vc_row_inner][vc_column_inner width="1/4"][facts_in_digits title="TECHNOLOGY" icon="fa-anchor" digit="300"][/vc_column_inner][vc_column_inner width="1/4"][facts_in_digits title="OUR STAFF" icon="fa-user-md" digit="185"][/vc_column_inner][vc_column_inner width="1/4"][facts_in_digits title="CLINIC ROOMS" icon="fa-navicon" digit="1050"][/vc_column_inner][vc_column_inner width="1/4"][facts_in_digits title="MACHINES" icon="fa-paper-plane-o" digit="700"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1413185920996{padding-top: 20px !important;padding-bottom: 30px !important;}" textcolor="default" bgtype="skin"][vc_column width="1/1"][twitterbox show="3" consumer_key="v6t8tY3ZCKyZnZ5J1vBDA" consumer_secret="73K8GXdgriSFlff01t68e608y1sy5gvvuBgmCXlGEQg" oauth_token="198949585-yOkBOaBtYfsBLIgGlgUXRNwkIIWOSCnk3SMOjzKx" oauth_token_secret=" wcTRHKILxqcsu0Lka3Vh2J0DGr7oR6pBMLdLtnwo5E" username="envato"][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	
	// Sample Homepage 3
    $data               = array();
    $data['name']       = __( 'Sample Homepage v3', 'apicona' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page3.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'apicona_home_3_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row css=".vc_custom_1406874639718{margin-bottom: 0px !important;padding: 40px 0px !important;}" textcolor="white" bgtype="skin" bgprecolor="skin"][vc_column width="1/1"][vc_cta_button2 h2="Want to say Hey or find out more?" style="square" txt_align="left" title="Purchase Now" btn_style="square" color="white" size="md" position="right" btniconposition="no" btnicon="fa-adjust" link="url:%23||"]Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur[/vc_cta_button2][/vc_column][/vc_row][vc_row css=".vc_custom_1411472426444{padding-bottom: 50px !important;}" textcolor="default" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][portfoliobox title="LATEST SERVICES" sortable="no" show="3" column="three" view="default" viewarea="boxed"][/vc_column][/vc_row][vc_row css=".vc_custom_1406620302703{padding-top: 0px !important;padding-bottom: 40px !important;}" textcolor="default" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][heading text="WHAT WE OFFER" tag="h2" align="left"][vc_row_inner css=".vc_custom_1406630365660{margin-bottom: 0px !important;}"][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-tint" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="WHAT WE OFFER" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-stethoscope" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="24 HOURS SERVICE" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-user-md" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="TOP DOCTORS" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-bullhorn" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="QUALIFIED DOCTORS" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-eye" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="GYNECOLOGICAL CLINIC" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-thumbs-o-up" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="CARDIO MONITORING" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row bgcolor="dark" bgimage="http://addyson-data.thememount.com/wp-content/uploads/2013/12/parralaxbg.jpg" contentalign="default" rowwidth="wide" textcolor="default" bgimageposition="fixed" css=".vc_custom_1412417358755{padding-top: 70px !important;padding-bottom: 70px !important;background-image: url(http://apicona-data.thememount.com/wp-content/uploads/2014/07/data-pic-2.jpg?id=1042) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" bgtype="dark" bgprecolor="dark" parallax="true" coloroverlay="true" font_color="#ffffff"][vc_column width="1/1"][vc_row_inner][vc_column_inner width="1/4"][facts_in_digits title="CLINIC MACHINES" icon="fa-stethoscope" digit="120"][/vc_column_inner][vc_column_inner width="1/4"][facts_in_digits title="AWARD SHOWS" icon="fa-trophy" digit="101"][/vc_column_inner][vc_column_inner width="1/4"][facts_in_digits title="OUR STAFF" icon="fa-user-md" digit="2000"][/vc_column_inner][vc_column_inner width="1/4"][facts_in_digits title="APICONA ROOMS" icon="fa-tasks" digit="1458"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row][vc_column width="1/2"][heading text="WHO WE ARE" tag="h2" align="left"][vc_column_text]
<h3>Apicona WordPress theme was created to offer a perfect solution for medical websites.</h3>
It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.[/vc_column_text][/vc_column][vc_column width="1/2"][heading text="WE ARE GOOD AT" tag="h2" align="left"][vc_progress_bar values="90|Cardiac Clinic,80|Pediatric Clinic,70|Gynecological Clinic,89|Neurosurgery" bgcolor="skincolor" units="%"][/vc_column][/vc_row][vc_row css=".vc_custom_1406629994254{padding-top: 0px !important;}" textcolor="default" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][team show="5" column="four" view="carousel" title="MEET THE TEAM"][/vc_column][/vc_row][vc_row css=".vc_custom_1413185968965{padding-top: 20px !important;padding-bottom: 30px !important;}" textcolor="default" bgtype="skin"][vc_column width="1/1"][twitterbox show="3" consumer_key="v6t8tY3ZCKyZnZ5J1vBDA" consumer_secret="73K8GXdgriSFlff01t68e608y1sy5gvvuBgmCXlGEQg" oauth_token=" 198949585-yOkBOaBtYfsBLIgGlgUXRNwkIIWOSCnk3SMOjzKx" oauth_token_secret="wcTRHKILxqcsu0Lka3Vh2J0DGr7oR6pBMLdLtnwo5E" username="envato"][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	
	
	// Sample Homepage 4
    $data               = array();
    $data['name']       = __( 'Sample Homepage v4', 'apicona' );
    $data['image_path'] = get_template_directory_uri() . '/inc/images/sample-page4.png' ; // always use preg replace to be sure that "space" will not break logic
    $data['custom_class'] = 'apicona_home_4_template';
    $data['content']    = <<<CONTENTTTTTTTTTTT
        [vc_row bgcolor="dark" bgimage="http://addyson.thememount.com/wp-content/uploads/2013/12/parralaxbg.jpg" contentalign="default" rowwidth="wide" textcolor="white" bgimageposition="fixed" css=".vc_custom_1406875699426{padding-top: 60px !important;padding-bottom: 60px !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" bgtype="skin" bgprecolor="skin"][vc_column width="1/1"][vc_cta_button2 style="rounded" txt_align="center" title="More Info" btn_style="square" color="white" size="md" position="bottom" link="url:%23||" btniconposition="no" btnicon="fa-check" h4="24 HOURS SERVICE" bigfont="yes" sepline="yes" h2="Successful For Evey Patient"][/vc_cta_button2][/vc_column][/vc_row][vc_row css=".vc_custom_1411472821867{padding-bottom: 45px !important;}" textcolor="default" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][vc_row_inner css=".vc_custom_1406630365660{margin-bottom: 0px !important;}"][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-tint" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="MEDICAL TREATMENT" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-stethoscope" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="24 HOURS SERVICE" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-user-md" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="TOP DOCTORS" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][/vc_row_inner][vc_row_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-bullhorn" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="QUALIFIED DOCTORS" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-eye" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="GYNECOLOGICAL CLINIC" buttontext="More Info" buttonlink="url:%23||" buttonstyle="rounded"][/vc_column_inner][vc_column_inner width="1/3"][servicebox boxtype="lefticonspacing" icon="fa-thumbs-o-up" contents="Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil." buttontype="icontext" buttoncolor="skincolor" buttonsize="xs" buttonicon="fa-angle-right" buttoneffect="colortoborder" btniconposition="right" title="CARDIO MONITORING" buttontext="More Info" buttonlink="url:%23||" titlelink="||" buttonstyle="rounded"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row textcolor="default" bgtype="dark" bgprecolor="dark" css=".vc_custom_1412417477000{padding-top: 70px !important;padding-bottom: 50px !important;background-image: url(http://apicona-data.thememount.com/wp-content/uploads/2014/07/data-pic-2.jpg?id=1042) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" coloroverlay="true" parallax="true"][vc_column width="1/1"][heading text="LATEST NEWS FROM HEALTH AND MEDICAL
" tag="h2" align="center" subtext="Orem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy"][portfoliobox sortable="no" show="3" column="three" view="default" viewarea="boxed"][/vc_column][/vc_row][vc_row textcolor="default" bgtype="default" bgprecolor="skin"][vc_column width="1/2"][testimonial show="3" column="one" view="carousel" title="WHAT PATIENTS SAY ABOUT APICONA"][/vc_column][vc_column width="1/2"][heading text="WHY CHOOSE US
" tag="h2" align="left"][vc_accordion][vc_accordion_tab title="Cardiac Clinic"][vc_column_text]Fugiat dapibus, tellus ac cursus commodo, mauris sit condim eser ntumsi nibh, uum a justo vitaes amet risus amets un. Posi sectetut amet fermntum orem ipsum quia dolor sit.[/vc_column_text][/vc_accordion_tab][vc_accordion_tab title="Neurosurgery"][vc_column_text]Fugiat dapibus, tellus ac cursus commodo, mauris sit condim eser ntumsi nibh, uum a justo vitaes amet risus amets un. Posi sectetut amet fermntum orem ipsum quia dolor sit.[/vc_column_text][/vc_accordion_tab][vc_accordion_tab title="Gynecological Clinic"][vc_column_text]Fugiat dapibus, tellus ac cursus commodo, mauris sit condim eser ntumsi nibh, uum a justo vitaes amet risus amets un. Posi sectetut amet fermntum orem ipsum quia dolor sit.[/vc_column_text][/vc_accordion_tab][vc_accordion_tab title="Surgery"][vc_column_text]Fugiat dapibus, tellus ac cursus commodo, mauris sit condim eser ntumsi nibh, uum a justo vitaes amet risus amets un. Posi sectetut amet fermntum orem ipsum quia dolor sit.[/vc_column_text][/vc_accordion_tab][/vc_accordion][/vc_column][/vc_row][vc_row fullwidth="true" textcolor="default" bgtype="default" bgprecolor="skin" css=".vc_custom_1406810526286{padding-top: 10px !important;}"][vc_column width="1/1"][kwayyiconseparator icon="fa-user-md"][/vc_column][/vc_row][vc_row css=".vc_custom_1411472934329{padding-top: 0px !important;}" textcolor="default" bgtype="default" bgprecolor="skin"][vc_column width="1/1"][team show="6" column="four" view="carousel" title="APICONA TEAM MEMBERS" subtitle="Orem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy" align="center"][/vc_column][/vc_row][vc_row bgcolor="dark" bgimage="http://addyson-data.thememount.com/wp-content/uploads/2013/12/parralaxbg.jpg" contentalign="default" rowwidth="wide" textcolor="default" bgimageposition="fixed" css=".vc_custom_1412417493306{padding-top: 70px !important;padding-bottom: 70px !important;background-image: url(http://apicona-data.thememount.com/wp-content/uploads/2014/07/data-pic-2.jpg?id=1042) !important;background-position: center !important;background-repeat: no-repeat !important;background-size: cover !important;}" bgtype="dark" bgprecolor="dark" parallax="true" coloroverlay="true" font_color="#ffffff"][vc_column width="1/1"][vc_row_inner][vc_column_inner width="1/4"][facts_in_digits title="CLINIC MACHINES" icon="fa-stethoscope" digit="120"][/vc_column_inner][vc_column_inner width="1/4"][facts_in_digits title="AWARD SHOWS" icon="fa-trophy" digit="101"][/vc_column_inner][vc_column_inner width="1/4"][facts_in_digits title="OUR STAFF" icon="fa-user-md" digit="2000"][/vc_column_inner][vc_column_inner width="1/4"][facts_in_digits title="APICONA ROOMS" icon="fa-tasks" digit="1458"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1413186009948{padding-top: 20px !important;padding-bottom: 30px !important;}" textcolor="default" bgtype="skin"][vc_column width="1/1"][twitterbox show="3" consumer_key="v6t8tY3ZCKyZnZ5J1vBDA" consumer_secret="73K8GXdgriSFlff01t68e608y1sy5gvvuBgmCXlGEQg" oauth_token="198949585-yOkBOaBtYfsBLIgGlgUXRNwkIIWOSCnk3SMOjzKx" oauth_token_secret="wcTRHKILxqcsu0Lka3Vh2J0DGr7oR6pBMLdLtnwo5E" username="envato"][/vc_column][/vc_row]
CONTENTTTTTTTTTTT;
	$maindata[] = $data;
	
	/************* END of Visual Composer Template list ***************/
	
	
	// Return all VC templates
	return $maindata;
	
}




