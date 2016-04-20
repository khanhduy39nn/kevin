<?php
if( !function_exists('kwayy_sc_contactbox') ){
function kwayy_sc_contactbox( $atts, $content=NULL ){
	extract( shortcode_atts( array(
		//'title'   => '',
		'phone'   => '',
		'email'   => '',
		'website' => '',
		'address' => '',
		'time'    => '',
	), $atts ) );
	
	$return = '<ul class="kwayy_vc_contact_wrapper">';
	
	/*if( trim($title)!='' ) {
		// Title and Subtitle
		$return .= do_shortcode('[heading text="'.$title.'" tag="h2" align="left"]');
	}*/
	
	if( trim($phone)!='' ) {
		$return .= '<li class="kwayy-contact-phonenumber kwicon-fa-phone">'.trim($phone).'</li>';
	}
	
	if( trim($email)!='' ) {
		$return .= '<li class="kwayy-contact-email kwicon-fa-envelope-o"><a href="mailto:'.trim($email).'">'.trim($email).'</a></li>';
	}
	
	if( trim($website)!='' ) {
		$return .= '<li class="kwayy-contact-website kwicon-fa-globe"><a href="'.kwayy_addhttp($website).'">'.trim($website).'</a></li>';
	}
	
	if( trim($address)!='' ) {
		$return .= '<li class="kwayy-contact-address  kwicon-fa-map-marker">'.$address.'</li>';
	}
	
	if( trim($time)!='' ) {
		$return .= '<li class="kwayy-contact-time kwicon-fa-clock-o">'.$time.'</li>';
	}
	
	$return .= '</ul>';
	
	return $return;
}
}
add_shortcode( 'contactbox', 'kwayy_sc_contactbox' );