<?php 
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');


/*****************************************/
/****** generating Custom Post Type *******/

// Slides Section
// Icon List for "menu_icon" : http://melchoyce.github.io/dashicons/
$slide = new Cuztom_Post_Type( 'Slide', array(
	'has_archive'         => true,
	'exclude_from_search' => false, // Whether to exclude posts with this post type from front end search results.
	'publicly_queryable'  => true, // Whether queries can be performed on the front end as part of parse_request().
	'supports'            => array( 'title', 'thumbnail' ),
	'menu_icon'           => 'dashicons-images-alt2',
) );
/*****************************************/


// Move Featured Image box from left to center only on CLIENTS custom_post_type
add_action('do_meta_boxes', 'kwayy_slides_featured_image_box');
function kwayy_slides_featured_image_box() {
	remove_meta_box( 'postimagediv', 'customposttype', 'side' );
	add_meta_box('postimagediv', __('Slide Image','apicona'), 'post_thumbnail_meta_box', 'slide', 'normal', 'high');
}


/*********** Post Meta Box **************/
$slide->add_meta_box(
	'kwayy_slides_options',
	'Slide Options', 
	array(
		array(
			'name'          => 'desc',
			'label'         => __( 'Description', 'apicona'),
			'description'   => __( 'Add description text for this slide', 'apicona'),
			'type'          => 'textarea'
		),
		array(
			'name'          => 'btntext',
			'label'         => __( 'Button Text', 'apicona'),
			'description'   => __( 'Add text for button.', 'apicona'),
			'type'          => 'text'
		),
		array(
			'name'          => 'btnlink',
			'label'         => __( 'Button Link', 'apicona'),
			'description'   => __( 'Add URL for button.', 'apicona'),
			'type'          => 'text'
		),
	)
);
/**********************************************/


/* Category */
// Project Category
$slide->add_taxonomy( 'slide_group' );



