<?php
// [icon type="ok" size="small" bgcolor="grey" align="center" roundborder="yes"]
if( !function_exists('kwayy_sc_icon') ){
function kwayy_sc_icon( $atts ) {
	extract( shortcode_atts( array(
		'package'     => '',
		'type'        => 'ok',
		'size'        => '',
		'align'       => '',
		'roundborder' => '',
		'bgcolor'     => ''
	), $atts ) );
	
	/* Size */
	$preSize   = array('tiny','small','medium','large','extra-large');
	$extraClass = '';
	if( in_array($size, $preSize) ){
		$extraClass = 'icon-size-'.$size;
	}
	
	if( trim($package)!='' ){
		if( trim($package)=='font-awesome' ){
			$package = '-fa';
		} else {
			$package = '-'.$package;
		}
	}
	
	/* Align */
	$wrap1 = '';
	$wrap2 = '';
	if( $align == 'center' ){
		$wrap1 = '<div class="kwayy-icon-wrapper-center">';
		$wrap2 = '</div>';
	} else if( in_array($align, array('left','right')) ){
		$extraClass .= ' icon-align-'.$align;
	}
	
	/* Background Color */
	$preColor   = array('grey', 'blue', 'turquoise' ,'green', 'orange', 'red', 'black', 'skincolor');
	if( trim($bgcolor) != '' && in_array($bgcolor, $preColor) ){
		$extraClass .= ' kwayy-ibgcolor kwayy-ibgcolor-'.$bgcolor;
	} else {
		/* Rounded */
		if( $roundborder == 'yes'){
			$extraClass .= ' kwayy-icon-rounded';
		}
	}
	
	return $wrap1.'<i class="kwayy-icon kwicon'.$package.'-'.$type.' '.$extraClass.'"></i>'.$wrap2;
}
}
add_shortcode( 'icon', 'kwayy_sc_icon' );