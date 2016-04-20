<?php
// [icontext icon="phone"]Welcome to site[/icontext]
if( !function_exists('kwayy_sc_icontext') ){
function kwayy_sc_icontext( $atts, $content=NULL ){
	extract( shortcode_atts( array(
		'icon'    => '',   // Required
		'package' => 'fa', // Optional
	), $atts ) );
	
	$return = '<span class="kwayy-icontext"><i class="kwicon-'.$package.'-'.$icon.'"></i> '.do_shortcode($content).'</span>';
	return $return;
}
}
add_shortcode( 'icontext', 'kwayy_sc_icontext' );
