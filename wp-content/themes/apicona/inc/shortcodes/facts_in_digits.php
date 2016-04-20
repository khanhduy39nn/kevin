<?php
// [facts_in_digits]
if( !function_exists('kwayy_sc_facts_in_digits') ){
function kwayy_sc_facts_in_digits($atts, $content=NULL ) {
	extract( shortcode_atts( array(
		'title'	=> '',
		'icon'	=> '',
		'digit'	=> '10',
	), $atts ) );
	
	// Required JS files
	wp_enqueue_script( 'waypoints', array( 'jquery' ) );
	wp_enqueue_script( 'numinate', array( 'jquery' ) );
	
	
	$return   = '';
	$iconcode = ( $icon!='' ) ? '<div class="kwayy-fid-wrapper"><i class="kwicon-'.$icon.'"></i></div>' : '' ;
	$return  .= '
			<div class="inside">
				'.$iconcode.'
				<h4 data-appear-animation="animateDigits" data-from="0" data-to="'.$digit.'">'.$digit.'</h4>
				<h3><span>'.$title.'<br></span></h3>
			</div>';
	return $return;
}
}
add_shortcode( 'facts_in_digits', 'kwayy_sc_facts_in_digits' );