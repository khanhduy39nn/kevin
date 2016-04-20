<?php
// [skincolor]This text will be in skin color[/skincolor]
if( !function_exists('kwayy_sc_skincolor') ){
function kwayy_sc_skincolor( $atts, $content=NULL ) {
	return '<span class="kwayy-skincolor">'.$content.'</span>';
}
}
add_shortcode( 'skincolor', 'kwayy_sc_skincolor' );