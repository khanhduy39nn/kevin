<?php
// [kwayyiconseparator icon="search-1" style="dashed" width="70" el_class="customclass"]
if( !function_exists('kwayy_sc_kwayyiconseparator') ){
function kwayy_sc_kwayyiconseparator( $atts, $content=NULL ){
	extract(shortcode_atts(array(
		'icon'  => '',
		'style' => '',
		'width' => '',
		'class' => '',
	), $atts));
	$class = "kwayy_icon_separator";
	$class .= ($style!='') ? ' kwayy-swi-style-'.$style : '';
	$class .= ($width!='') ? ' kwayy-swi-width-'.$width : '';
	$class .= ($class!='') ? ' '.$class : '';
	
	$return = '<div class="kwayy_swi_wrapper ' . esc_attr(trim($class)) . '">
		<span class="kwayy_swi_holder kwayy_swi_holder_l"><span class="vc_sep_line"></span></span>
		<i class="kwicon-' . $icon . '"></i>
		<span class="kwayy_swi_holder kwayy_swi_holder_r"><span class="vc_sep_line"></span></span>
	</div>';
	return $return;
}
}
add_shortcode( 'kwayyiconseparator', 'kwayy_sc_kwayyiconseparator' );