<?php
// [site-title]
if( !function_exists('kwayy_sc_site_title') ){
function kwayy_sc_site_title( $atts, $content=NULL ){
	return get_bloginfo('name');
}
}
add_shortcode( 'site-title', 'kwayy_sc_site_title' );