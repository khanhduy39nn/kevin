<?php
// [current-year]
if( !function_exists('kwayy_sc_current_year') ){
function kwayy_sc_current_year( $atts, $content=NULL ){
	return date("Y");
}
}
add_shortcode( 'current-year', 'kwayy_sc_current_year' );