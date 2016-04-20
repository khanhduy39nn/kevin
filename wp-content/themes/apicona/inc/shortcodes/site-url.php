<?php
// [site-url]
if( !function_exists('kwayy_sc_site_url') ){
function kwayy_sc_site_url( $atts, $content=NULL ){
	return site_url();
}
}
add_shortcode( 'site-url', 'kwayy_sc_site_url' );