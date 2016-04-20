<?php
// [tm_eventsbox]
if( !function_exists('kwayy_sc_eventsbox') ){
function kwayy_sc_eventsbox( $atts, $content=NULL ){
	extract( shortcode_atts( array(
		//'textposition' => 'left',
		'title'        => '',
		'subtitle'     => '',
		'align'        => 'left',
		'design'       => 'default',
		'sortable'     => '',
		//'sepicon'    => 'NO_ICON',
		'btntext'      => '',
		'btnlink'      => '',
		'show'         => '',
		'column'       => '',
		'view'         => '',
		'carousel_autoplay' => '1',
		'pagination'   => 'no',
	), $atts ) );
	
	global $wp_query;
	$old_wp_query = $wp_query;
	
	// Box width
	$boxwidth       = ( $view == 'carousel' ) ? 'fix' : $column ;
	$headerCarslBtn = ( $view == 'carousel' ) ? 'carouselbtn="yes"' : '' ;
	$itemWrapper    = ( $view == 'carousel' ) ? 'kwayy-carousel-items-wrapper' : '' ;
	$itemCol        = ( $view == 'carousel' ) ? 'kwayy-carousel-col-'.$column : '' ;
	$rowFix         = ( $view == 'carousel' ) ? '' : 'multi-columns-row' ;
	
	// adding DATA tags
	$datatags = '';
	if( $view == 'carousel' ){
		// carousel_autoplay
		$datatags = 'data-autoplay="'.$carousel_autoplay.'"';
	}
	
	$rand = mt_rand(1000, 9999);
	$rand .= mt_rand(1000, 9999);
	
	/*$carouselControls = '<div class="kwayy-carousel-controls">
							<div class="kwayy-carousel-controls-inner">
								<a class="kwayy-carousel-prev"><span class="wpb_button"><i class="tmicon-fa-angle-left"></i></span></a>
								<a class="kwayy-carousel-slideshow"><span class="wpb_button"><i class="tmicon-fa-pause"></i></span></a>
								<a title="Play Slideshow" class="kwayy-carousel-next"><span class="wpb_button"><i class="tmicon-fa-angle-right"></i></span></a>
							</div>
						</div>';*/
	
	// Generating Button Code
	$btnCode = '';
	if( trim($btntext)!='' && trim($btnlink)!='' ){
		$btnCode = '<div class="kwayy-pf-btn kwayy-center">' . do_shortcode('[vc_button title="'.$btntext.'" target="_self" color="skincolor" size="wpb_regularsize" href="'.$btnlink.'" btn_effect="colortoborder" showicon="withouticon" iconposition="left"]') . '</div>';
	}
	
	
	if( !function_exists('tribe_get_start_date') ){
		//return '<br> <strong>Events plugin is disabled or not installed. Please install "The Events Calendar" pluign first.</strong> <br>';
		return;
	}
	
	
	$return = '<div class="row '.$rowFix.' kwayy-portfolio-boxes-wrapper kwayy-portfolio-view-'.$view.' kwayy-effect-'.$view.' kwayy-items-col-'.$column.' '.$itemCol.'" id="kwayy-portfolio-id-'.$rand.'" '.$datatags.'>';
		
		$portfolioWrapperStart = '<div class="kwayy-portfolio-boxes col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		$portfolioWrapperEnd   = '</div>';
		$contentWrapperStart = '<div class="kwayy-portfolio-text col-xs-12 col-sm-12 col-md-12 col-lg-12">';
		$contentWrapperEnd   = '</div>';
		
		/*if( $textposition=='left' ){
			$portfolioWrapperStart = '<div class="kwayy-portfolio-boxes col-xs-12 col-sm-9 col-md-9 col-lg-9">';
			$portfolioWrapperEnd   = '</div>';
			$contentWrapperStart = '<div class="kwayy-portfolio-text col-xs-12 col-sm-12 col-md-3 col-lg-3">';
			$contentWrapperEnd   = '</div>';
		}*/
		
		$return .= $contentWrapperStart;
			if( trim($title)!='' ) {
				// Title and Subtitle
				$return .= do_shortcode('[heading text="'.$title.'" tag="h2" '.$headerCarslBtn.' style="linedot" align="'.$align.'" subtext="'.$subtitle.'"]');
			}
			
			// Carousel Buttons
			//if( $view == 'carousel' ){ $return .= $carouselControls; }
			
		$return .= $contentWrapperEnd;
		
		//Protect against arbitrary paged values
		$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		
		$args = array(
			'post_type'      => 'tribe_events',
			//'post_type'    => TribeEvents::POSTTYPE,
			'order'          => 'ASC',
			'meta_key'       => '_EventStartDate',
			'meta_type'      => 'DATE',
			'orderby'        => 'meta_value',
			'posts_per_page' => $show,
		);
		$wp_query = new WP_Query( $args );
		
		
		// The Loop
		if ( $wp_query->have_posts() ) {
		
			$return          .= $portfolioWrapperStart;
			
			$pagination_class = ( $pagination=='yes' ) ? ' kwayy-with-pagination' : '' ; // Pagination
			$portfolioBoxes   = '<div class="kwayy-items-wrapper '.$itemWrapper.' kwayy-portfolio-boxes-inner portfolio-wrapper row'.$pagination_class.'">';
			
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
				$portfolioBoxes .= kwayy_eventsbox( $boxwidth, $design );
			} // while
			
			$portfolioBoxes .= '</div>';

			$return .= $portfolioBoxes;  // Portfolio Boxes
			if( $pagination=='yes' ){ $return .= apicona_paging_nav(true); }  // Pagination
			$return .= $btnCode;  // Button
			
			$return .= $portfolioWrapperEnd;
		} // if
		
		/* Restore original Post Data */
		wp_reset_postdata();
		
		$wp_query = $old_wp_query;
		
	$return .= '</div>';
	
	return $return;
}
}
add_shortcode( 'eventsbox', 'kwayy_sc_eventsbox' );
