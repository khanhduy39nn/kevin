<?php 
// Including Framework Master File
include_once('cuztom-helper-framework/cuztom.php');

/*
 * SLUG settings
 */
global $apicona;
//var_dump($apicona['team_type_slug']);
//var_dump($apicona['team_group_slug']);

/******************************************/
/****** generating Custom Post Type *******/

// Team Member section
// Icon List for "menu_icon" : http://melchoyce.github.io/dashicons/
$team = new Cuztom_Post_Type( 'Team Member', array(
	'has_archive'         => true,
	'exclude_from_search' => false, // Whether to exclude posts with this post type from front end search results.
	'publicly_queryable'  => true, // Whether queries can be performed on the front end as part of parse_request().
	'supports'            => array( 'title', 'thumbnail', 'editor', 'excerpt' ),
	'labels'              => array( 'name' => __( $apicona['team_type_title'], 'apicona'), 'singular_name' => __( 'Doctor', 'apicona') ),
	'menu_icon'           => 'dashicons-groups',
	'rewrite'             => array( 'slug' => $apicona['team_type_slug'] ),
	'query_var'           => $apicona['team_type_slug'],
) );
/*****************************************/



//'slug' =>



// Move Featured Image box from left to center only on CLIENTS custom_post_type
add_action('do_meta_boxes', 'team_featured_image_box');
function team_featured_image_box() {
	remove_meta_box( 'postimagediv', 'customposttype', 'side' );
	add_meta_box('postimagediv', __('Doctor\'s Image','apicona'), 'post_thumbnail_meta_box', 'team_member', 'normal', 'high');
}


/*********** Post Meta Box **************/
$team->add_meta_box(
	'kwayy_team_member_details',
	'Doctor\'s Details', 
	array(
		array(
			'name'          => 'position',
			'label'         => __( 'Position', 'apicona'),
			'description'   => __( '(Optional) Add doctor\'s position. Example: <code>Project Manager</code>', 'apicona'),
			'type'          => 'text'
		),
		array(
			'name'          => 'email',
			'label'         => __( 'Email', 'apicona'),
			'description'   => __( '(Optional) Add doctor\'s email address. Example: <code>member@example.com</code>', 'apicona'),
			'type'          => 'text'
		),
	)
);

$team->add_meta_box(
	'kwayy_team_member_social_links',
	'Doctor\'s Social Links', 
	array(
		array(
			'name'          => 'facebook',
			'label'         => __( 'Facebook Link', 'apicona'),
			'description'   => __( '(Optional) Please fill Facebook link', 'apicona'),
			'type'          => 'text'
		),
		array(
			'name'          => 'twitter',
			'label'         => __( 'Twitter Link', 'apicona'),
			'description'   => __( '(Optional) Please fill Twitter link', 'apicona'),
			'type'          => 'text'
		),
		array(
			'name'          => 'linkedin',
			'label'         => __( 'LinkedIn Link', 'apicona'),
			'description'   => __( '(Optional) Please fill LinkedIn link', 'apicona'),
			'type'          => 'text'
		),
		array(
			'name'          => 'googleplus',
			'label'         => __( 'Google+ Link', 'apicona'),
			'description'   => __( '(Optional) Please fill Google+ link', 'apicona'),
			'type'          => 'text'
		),
	)
);
/**********************************************/



/* Team Group */
$team->add_taxonomy( 'team_group', array(
	'rewrite'             => array( 'slug' => $apicona['team_group_slug'] ),
) );









/********** Adding featured image URL path ***********/



// A callback function to add a custom field to our "presenters" taxonomy
function kwayy_team_group_taxonomy_custom_fields($tag) {
   // Check for existing taxonomy meta for the term you're editing
    $t_id = $tag->term_id; // Get the ID of the term you're editing
    $term_meta = get_option( "taxonomy_term_$t_id" ); // Do the check
?>

<tr class="form-field">
	<th scope="row" valign="top">
		<label for="kwayy_img_url"><?php _e('Featured Image URL', 'apicona'); ?></label>
	</th>
	<td>
		<input type="text" name="term_meta[kwayy_img_url]" id="term_meta[kwayy_img_url]" size="40" value="<?php echo $term_meta['kwayy_img_url'] ? $term_meta['kwayy_img_url'] : ''; ?>"><br />
		<span class="description"><?php _e('Paste featured image URL for this group. Please upload first in media section.' ,'apicona'); ?></span>
	</td>
</tr>

<?php
}







// A callback function to save our extra taxonomy field(s)
function kwayy_save_taxonomy_custom_fields( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_term_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
            foreach ( $cat_keys as $key ){
            if ( isset( $_POST['term_meta'][$key] ) ){
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        //save the option array
        update_option( "taxonomy_term_$t_id", $term_meta );
    }
}






// Add the fields to the "presenters" taxonomy, using our callback function
add_action( 'team_group_edit_form_fields', 'kwayy_team_group_taxonomy_custom_fields', 10, 2 );

// Save the changes made on the "presenters" taxonomy, using our callback function
add_action( 'edited_team_group', 'kwayy_save_taxonomy_custom_fields', 10, 2 );