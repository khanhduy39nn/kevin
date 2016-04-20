<?php
/**
 * Custom Walker
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
class kwayy_custom_menus_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
      {
           global $wp_query;
           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			$class_names .= !empty( $item->color ) ? ' menu-width-color menucolor-' . esc_attr( $item->color ): 'menu-without-color'; // Adding Color Class to A tag
			if( $depth == 0 ){
				$class_names .= !empty( $item->icon ) ? ' menu-with-icon': ' menu-without-icon'; // Adding Color Class to LI tag
			}
			//$class_names .= !empty( $item->bgimage ) ? ' menu-with-bgimage': ' menu-without-bgimage'; // Adding BG Image Class to LI tag
			$class_names = ' class="'. esc_attr( $class_names ) . '"';
		   
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			$attributes .= ! empty( $item->icon )       ? ' class="menuicon-'  . esc_attr( $item->icon   ).'"' : ''; // Adding Icon Class to A tag

			if($depth == 0){
				$prepend = '<span class="kwayy-menu-text">';
				$append  = '</span>';
			} else {
				$prepend = '<span>';
				$append  = '</span>';
			}
			
           
           //$prepend = '';
           //$append  = '';
           
           $description  = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

           if($depth != 0)
           {
	           $description = $append = $prepend = "";
           }

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            if( $depth == 0 ){
				// Icon
				$item_output .= !empty( $item->icon ) ? '<span class="gm-menu-icon menu-with-icon"><i class="kwicon-'  . esc_attr( $item->icon       ) .'"></i></span>' : '<span class="gm-menu-icon menu-without-icon"></span>'; // Adding Icon Class to A tag
				// Image
				$item_output .= !empty( $item->bgimage ) ? '<img src="'.$item->bgimage.'" class="gm-menu-bgimage" />' : '';
			}
			
			
			
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;           
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args, $id );
            }
}
