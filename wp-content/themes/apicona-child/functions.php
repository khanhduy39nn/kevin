<?php
function wpa_category_nav_class($classes, $item ){
    if( 'category' == $item->object ){
        $category = get_category( $item->object_id );
        $classes[] = 'fil-cat';
        $classes[] =  $category->slug;

    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'wpa_category_nav_class', 10, 2 );


/*
 * Custom PHP code for child theme will be here

 function new_nav_menu_itemss($items) {
    if (function_exists('icl_get_languages')) {
    $languages = icl_get_languages('skip_missing=0');
    if (1 < count($languages)) {
        foreach ($languages as $l) {
            $items = $items . '<li class="menu-item custom-switcher';
                    if ($l['active']) {
                         $items = $items . ' active';
                    }
                    $items = $items . '"><a href="' . $l['url'] . '"><img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" /></a></li>';

        }
    }
    }

    return $items;
}

add_filter('wp_nav_menu_items', 'new_nav_menu_itemss');*/

// load browser detect library
/*
require_once( get_stylesheet_directory() . '/Browser.php' );

// apply css file for safari only
add_action( 'wp_enqueue_scripts', 'custom_load_custom_style_sheet' );
function custom_load_custom_style_sheet() {

	$browser = new Browser();
	if( $browser->getBrowser() == Browser::BROWSER_FIREFOX ) {
		wp_enqueue_style( 'custom-stylesheet', get_stylesheet_directory_uri() . '/style.min-sa-ff.css', array(), PARENT_THEME_VERSION );
		}
	else  {
		wp_enqueue_style( 'custom-stylesheet', get_stylesheet_directory_uri() . '/style.min.css', array(), PARENT_THEME_VERSION );
	}
/* debugging
	echo 'browser : ' . $browser->getBrowser();
	echo '<br />platform : ' . $browser->getPlatform();
	echo '<br />version : ' . $browser->getVersion();
	echo '<br />user agent : ' . $browser->getUserAgent();
*/
//}
