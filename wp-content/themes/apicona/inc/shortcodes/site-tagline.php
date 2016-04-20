<?php
// [site-tagline]
if( !function_exists('kwayy_sc_site_tagline') ){
function kwayy_sc_site_tagline( $atts, $content=NULL ){
	return get_bloginfo('description');
}
}
add_shortcode( 'site-tagline', 'kwayy_sc_site_tagline' );