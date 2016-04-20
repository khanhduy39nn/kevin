<?php
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');

global $apicona;
$pf_title = 'Portfolio';
$pf_slug  = 'portfolio';
if( isset($apicona['pf_type_title']) && trim($apicona['pf_type_title'])!='' ){
	$pf_title = trim($apicona['pf_type_title']);
}
if( isset($apicona['pf_type_slug']) && trim($apicona['pf_type_slug'])!='' ){
	$pf_slug = sanitize_text_field($apicona['pf_type_slug']);
}


/******************************************/
/****** generating Custom Post Type *******/

// Portfolio section
// Icon List for "menu_icon" : http://melchoyce.github.io/dashicons/
$portfolio = new Cuztom_Post_Type( __('Portfolio','apicona'),
	array(
		'has_archive' => false,
		'supports'    => array( 'title', 'editor', 'thumbnail' ),
		'menu_icon'   => 'dashicons-screenoptions',
		'rewrite'     => array( 'slug' => $pf_slug ),
	), array(
		'name'               => __($pf_title,'apicona'),
		'singular_name'      => __($pf_title,'apicona'),
		'add_new'            => __('Add New','apicona'),
		'add_new_item'       => __('Add New '.$pf_title,'apicona'),
		'edit_item'          => __('Edit '.$pf_title,'apicona'),
		'new_item'           => __('New '.$pf_title,'apicona'),
		'all_items'          => __('All '.$pf_title,'apicona'),
		'view_item'          => __('View '.$pf_title,'apicona'),
		'search_items'       => __('Search '.$pf_title,'apicona'),
		'not_found'          => __('No '.$pf_title.' found','apicona'),
		'not_found_in_trash' => __('No '.$pf_title.' found in Trash','apicona'),
		'parent_item_colon'  => '',
		'menu_name'          => __($pf_title,'apicona')
  ) );

$portfolio->add_meta_box(
	'kwayy_portfolio_data',
	__('Apicona: Portfolio Options','apicona'),
	array(
		array(
			'name'        => 'clientname',
			'label'       => __('Doctor/Team Name','apicona'),
			'description' => __('(Optional) Please fill docotor or team name','apicona'),
			'type'        => 'text'
		),
		
		
		array(
			'name'        => 'clientlink',
			'label'       => __('Doctor/Team Link','apicona'),
			'description' => __('(Optional) Please fill doctor or team website link','apicona'),
			'type'        => 'text'
		),
		array(
			'name'        => 'skills',
			'label'       => __('Skills','apicona'),
			'description' => __('(Optional) Please fill special skills','apicona'),
			'type'        => 'text'
		),
		array(
			'name'        => 'linktext',
			'label'       => __('Project Link Text','apicona'),
			'description' => __('(Optional) Please fill project link text. Example <code>Read More</code>','apicona'),
			'type'        => 'text'
		),
		array(
			'name'        => 'linkurl',
			'label'       => __('Project Link URL','apicona'),
			'description' => __('(Optional) Please fill project link URL. This will become the link for the "Project Link Text" word.','apicona'),
			'type'        => 'text'
		),
		
		
	)
);



$portfolio->add_meta_box(
	'kwayy_portfolio_featured',
	'Apicona: Featured Image / Video / Slider', 
	array(
		array(
			'name'          => 'featuredtype',
			'label'         => __('Featured Image/Video', 'apicona'),
			'description'   => __('Select what you want to show as featured. Image or Video', 'apicona'),
			'type'          => 'radios',
			'options'       => array(
				'image'       => __('Featured Image', 'apicona'),
				'video'       => __('Video (YouTube or Vimeo)', 'apicona'),
				//'videoplayer' => __('Video (MP4, WEBM, OGG or OGV video file)', 'apicona'),
				'audioembed'  => __('Audio (SoundCloud embed code)', 'apicona'),
				//'audioplayer' => __('Audio (MP3, WAV or OGG audio file)', 'apicona'),
				'slider'	  => __('Image Slider', 'apicona'),
			),
			'default_value' => 'image'
		),
		
		/* Video (YouTube or Vimeo) */
		array(
			'name'          => 'videourl',
			'label'         => __('YouTube or Vimeo URL', 'apicona'),
			'description'   => __('Paste YouTube or Vimeo URL here.', 'apicona'),
			'type'          => 'textarea',
		),
		
		/* Video (MP4, WEBM, OGG or OGV video file) */
		/*array(
			'name'          => 'videofile_mp4',
			'label'         => __('Select MP4 file for video player', 'apicona'),
			'description'   => __('Upload and select MP4 file for video player', 'apicona'),
			'type'          => 'file',
		),
		array(
			'name'          => 'videofile_webm',
			'label'         => __('Select WEBM file for video player', 'apicona'),
			'description'   => __('Upload and select WEBM file for video player', 'apicona'),
			'type'          => 'file',
		),
		array(
			'name'          => 'videofile_ogv',
			'label'         => __('Select OGV (or OGG video) file for video player', 'apicona'),
			'description'   => __('Upload and select OGV (or OGG video) file for video player', 'apicona'),
			'type'          => 'file',
		), */
		
		/* Audio (SoundCloud embed code) */
		array(
			'name'          => 'audiocode',
			'label'         => __('SoundCloud (or any other service) Embed Code', 'apicona'),
			'description'   => __('Paste SoundCloud or any other service embed code here.', 'apicona'),
			'type'          => 'textarea',
		),
		
		/* Audio (MP3, WAV or OGG audio file) */
		/*array(
			'name'          => 'audiofile_mp3',
			'label'         => __('Select MP3 file for audio player', 'apicona'),
			'description'   => __('Upload and select MP3 file for audio player', 'apicona'),
			'type'          => 'file',
		),
		array(
			'name'          => 'audiofile_wav',
			'label'         => __('Select WAV file for audio player', 'apicona'),
			'description'   => __('Upload and select WAV file for audio player', 'apicona'),
			'type'          => 'file',
		),
		array(
			'name'          => 'audiofile_oga',
			'label'         => __('Select OGA (or OGG audio) file for audio player', 'apicona'),
			'description'   => __('Upload and select OGA (or OGG audio) file for audio player', 'apicona'),
			'type'          => 'file',
		), */
		
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

// Project Category
$portfolio->add_taxonomy( 'portfolio_category' );