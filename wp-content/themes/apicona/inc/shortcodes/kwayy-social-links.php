<?php
// [kwayy-social-links]
if( !function_exists('kwayy_sc_kwayy_social_links') ){
function kwayy_sc_kwayy_social_links( $atts, $content=NULL ){
	$wrapperStart = '<div class="kwayy-social-links-wrapper">';
	$wrapperEnd   = '</div>';
	return $wrapperStart.kwayy_get_social_links().$wrapperEnd;
}
}
add_shortcode( 'kwayy-social-links', 'kwayy_sc_kwayy_social_links' );