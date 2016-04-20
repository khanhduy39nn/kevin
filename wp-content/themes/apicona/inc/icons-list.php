<?php

/* 
 * This icon list is created by Kwayy Infotech
 * 
 */

$apicona = get_option('apicona');
$kwayy_iconsArray = array();

// Load font icon library CSS files

// Adding FontAwesome List by default
include_once('icons-list-fontawesome.php');
$kwayy_iconsArray = array_merge($kwayy_iconsArray, $fontawesome_array );

if( isset($apicona['fonticonlibrary']) && is_array($apicona['fonticonlibrary']) && count($apicona['fonticonlibrary'])>0 ){
	foreach( $apicona['fonticonlibrary'] as $library=>$val ){
		if( $library!='fontawesome' ){
			if( $val == '1' ){
				include_once('icons-list-'.$library.'.php');
				$kwayy_iconsArray = array_merge($kwayy_iconsArray, ${$library.'_array'} );
			}
			
		}
	}
}
