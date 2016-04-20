<?php
// [testimonial]
if( !function_exists('kwayy_sc_testimonial') ){
function kwayy_sc_testimonial($atts, $content=NULL ) {
	extract( shortcode_atts( array(
		'title'    => '',
		'subtitle' => '',
		'align'    => 'left',
		'show'     => '3',
		'column'   => 'three',
		'view'     => '',
		'carousel_autoplay' => '1',
		'group'    => '',
	), $atts ) );
	
	// Box width
	$boxwidth       = ( $view == 'carousel' ) ? 'fix' : $column ;
	$rowClass       = ( $view != 'carousel' ) ? 'row' : '' ;
	$headerCarslBtn = ( $view == 'carousel' ) ? 'carouselbtn="yes"' : '' ;
	$itemWrapper    = ( $view == 'carousel' ) ? 'kwayy-carousel-items-wrapper' : '' ;
	$itemCol        = ( $view == 'carousel' ) ? 'kwayy-carousel-col-'.$column : '' ;
	$rowClass       = ( $view == 'carousel' ) ? '' : $rowClass.' multi-columns-row' ;
	
	// adding DATA tags
	$datatags = '';
	if( $view == 'carousel' ){
		// carousel_autoplay
		$datatags = 'data-autoplay="'.$carousel_autoplay.'"';
	}
	
	$carouselControls = '<div class="kwayy-carousel-controls">
							<div class="kwayy-carousel-controls-inner">
								<a href="javascript:void(0)" class="kwayy-carousel-prev"><span class="wpb_button"><i class="kwicon-fa-angle-left"></i></span></a>
								<a href="javascript:void(0)" class="kwayy-carousel-next"><span class="wpb_button"><i class="kwicon-fa-angle-right"></i></span></a>
							</div>
						</div>';
	
	
	
	$return = '';
	//$width  = kwayy_translateColumnWidthToSpan($column);
	
	$args = array(
		'post_type'      => 'testimonial',
		'posts_per_page' => $show,
	);
	
	// Creating array for multiple group
	if(strpos($group, ',') !== false) {
		$group = explode(',',$group);
	}
	
	// Group
	if( $group!='' ){
		$args['tax_query'] = array(
								array(
									'taxonomy' => 'testimonial_group',
									'field' => 'slug',
									'terms' => $group
								),
							);
	}
	
	
	$results = new WP_Query( $args );
	
	// The Loop
	if ( $results->have_posts() ) {
		$return .= "\n\t".'<div class="kwayy-testimonial-wrapper kwayy-effect-'.$view.' kwayy-items-col-'.$column.' '.$itemCol.'" '.$datatags.'>';
		if( trim($title)!='' ){
			$return .= "\n\t" . do_shortcode('[heading text="'.$title.'" subtext="'.do_shortcode($subtitle).'" tag="h2" '.$headerCarslBtn.' style="linedot" align="'.$align.'"]');
		}
		
		// Carousel Buttons
		//if( $view == 'carousel' ){ $return .= $carouselControls; }
		
		
		$return .= '<div class="'.$rowClass.' kwayy-items-wrapper '.$itemWrapper.'">';
		
		while ( $results->have_posts() ) {
			$results->the_post();
			
			$return .= kwayy_testimonialbox( $boxwidth );
			
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
add_shortcode( 'testimonial', 'kwayy_sc_testimonial' );