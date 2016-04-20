<?php
// [clients]
if( !function_exists('kwayy_sc_clients') ){
function kwayy_sc_clients($atts, $content=NULL ) {
	extract( shortcode_atts( array(
		'title'    => '',
		'subtitle' => '',
		'align'    => 'left',
		//'sepicon'  => 'NO_ICON',
		'show'     => '4',
		'column'   => 'four',
		'group'    => '',
		'view'     => 'default',
		'carousel_autoplay' => '1',
	), $atts ) );
	
	$return = '';
	$rowClass = ( $view != 'carousel' ) ? 'row' : '' ;
	$rowClass = ( $view == 'carousel' ) ? $rowClass : $rowClass.' multi-columns-row' ;
	
	// adding DATA tags
	$datatags = '';
	if( $view == 'carousel' ){
		// carousel_autoplay
		$datatags = 'data-autoplay="'.$carousel_autoplay.'"';
	}
	
	switch($column){
		case 'two':
			$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
			break;
		case 'three':
		default:
			$boxClass = 'col-lg-4 col-sm-6 col-md-4 col-xs-12';
			break;
		case 'four':
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'five':
			$boxClass = 'col-lg-20percent col-sm-4 col-md-4 col-xs-12';
			break;
		case 'six':
			$boxClass = 'col-lg-2 col-sm-4 col-md-4 col-xs-12';
			break;
	}
	if( $view=='carousel' ){ $boxClass = 'kwayy-full'; }
	
	$args = array(
		'post_type'      => 'client',
		'posts_per_page' => $show,
	);
	
	
	// Creating array for multiple group
	if(strpos($group, ',') !== false) {
		$group = explode(',',$group);
	}
	
	// Group
	if( $group!='' ){
		$return .= '<!-- Group Active -->';
		$args['tax_query'] = array(
								array(
									'taxonomy' => 'client_group',
									'field' => 'slug',
									'terms' => $group
								),
							);
	}
	
	$results = new WP_Query( $args );
	
	//var_dump($results);
	
	// The Loop
	if ( $results->have_posts() ) {
		$return .= "\n\t".'<div class="kwayy-client-wrapper container kwayy-client-view-'.$view.' kwayy-client-column-'.$column.' kwayy-effect-'.$view.' kwayy-carousel-col-'.$column.' kwayy-with-pagination" '.$datatags.'>';
		if( trim($title)!='' ){
			$return .= "\n\t" . do_shortcode('[heading text="'.$title.'" subtext="'.do_shortcode($subtitle).'" tag="h2" style="linedot" align="'.$align.'"]');
		}
		
		$return .= '<div class="'.$rowClass.' kwayy-clients kwayy-'.$view.'-items-wrapper">';
		while ( $results->have_posts() ) {
			$results->the_post();
			$link = trim( get_post_meta( get_the_ID(), '_kwayy_clients_details_clienturl', true ) );
			$link = ( $link!='' ) ? $link : '#' ;
			
			if( has_post_thumbnail() ){
				$return .= '<div class="'.$boxClass.'">';
				$return .= '<a href="'.$link.'" target="_blank" title="'.get_the_title().'">';
				$return .= get_the_post_thumbnail( get_the_ID(), 'full' );
				$return .= '</a>';
				$return .= '</div>';
			} else {
				$return .= '<!-- No Featured Image For this Client -->';
			}
		}
		$return .= "\n\t".'</div></div>';
		
	} else {
		// no posts found
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	
	return $return;
}
}
add_shortcode( 'clients', 'kwayy_sc_clients' );