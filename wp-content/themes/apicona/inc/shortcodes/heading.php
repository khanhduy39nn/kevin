<?php
// [heading tag="h1" text="This is heading text"]
if( !function_exists('kwayy_sc_heading') ){
function kwayy_sc_heading( $atts, $content=NULL ){
	extract( shortcode_atts( array(
		'tag'         => 'h1',
		'text'        => 'Welcome to our site',
		//'sepicon'   => 'NO_ICON',
		'subtext'     => '',
		'carouselbtn' => "",
		'align'      => 'left',
	), $atts ) );
	$centerCarouselbtnCode = '';
	$carouselbtnCode       = ( $carouselbtn == 'yes' ) ? '<div class="kwayy-carousel-controls-inner"><a href="javascript:void(0)" class="kwayy-carousel-prev"><span class="wpb_button"><i class="kwicon-fa-angle-left"></i></span></a><a href="javascript:void(0)" class="kwayy-carousel-next"><span class="wpb_button"><i class="kwicon-fa-angle-right"></i></span></a></div>' : '' ;
	
	if( $align=='center' ){
		$centerCarouselbtnCode = $carouselbtnCode;
		$carouselbtnCode       = '';
	}
	
	
	
	$heading = '<'.$tag.' class="kwayy-heading-align-'.$align.'"><span>'.do_shortcode($text).'</span></'.$tag.'>';
	//$sep     = ( trim($sepicon)!='NO_ICON' ) ? '<span class="kwayy-heading-sepicon"><i class="kwicon-'.$sepicon.'"></i></span>' : '' ;
	$subtext = ( trim($subtext)!='' ) ? '<p class="kwayy-subheading">'.do_shortcode(trim($subtext)).'</p>' : '' ;
	
	$topWrapper    = '<header class="kwayy-heading-wrapper kwayy-heading-wrapper-align-'.$align.'">';
	$subWrapperStart = '<div class="kwayy-heading-wrapper-inner">';
	$subWrapperEnd   = '</div>';
	$bottomWrapper = '</header>';
	
	$return = $topWrapper.$subWrapperStart.$heading.$carouselbtnCode.$subWrapperEnd.$subtext.$centerCarouselbtnCode.$bottomWrapper;
	
	return $return;
}
}
add_shortcode( 'heading', 'kwayy_sc_heading' );