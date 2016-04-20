<?php
// [portfoliobox]
if( !function_exists('kwayy_sc_portfoliobox') ){
function kwayy_sc_portfoliobox( $atts, $content=NULL ){
	extract( shortcode_atts( array(
		//'textposition' => 'left',
		'title'        => '',
		'subtitle'     => '',
		'align'        => 'left',
		'sortable'     => '',
		//'sepicon'      => 'NO_ICON',
		'btntext'      => '',
		'btnlink'      => '',
		'show'         => '',
		'column'       => '',
		'view'         => '',
		'category' 	   => '', // CeP: (1)
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
								<a class="kwayy-carousel-prev"><span class="wpb_button"><i class="kwicon-fa-angle-left"></i></span></a>
								<a class="kwayy-carousel-slideshow"><span class="wpb_button"><i class="kwicon-fa-pause"></i></span></a>
								<a title="Play Slideshow" class="kwayy-carousel-next"><span class="wpb_button"><i class="kwicon-fa-angle-right"></i></span></a>
							</div>
						</div>';*/
	
	// Generating Button Code
	$btnCode = '';
	if( trim($btntext)!='' && trim($btnlink)!='' ){
		$btnCode = '<div class="kwayy-pf-btn kwayy-center">' . do_shortcode('[vc_button title="'.$btntext.'" target="_self" color="skincolor" size="wpb_regularsize" href="'.$btnlink.'" btn_effect="colortoborder" showicon="withouticon" iconposition="left"]') . '</div>';
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
			//'post_status'    => 'published',
			'post_type'      => 'portfolio',
			'posts_per_page' => $show,
			'paged'          => $paged,
		);
		
		// Creating array for multiple category
		if(strpos($category, ',') !== false) {
			$category = explode(',',$category);
		}
		
		if ( $category ) { // CeP: (2)
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'slug',
					'terms' => $category,
				),
			);
		}
		$wp_query = new WP_Query( $args );
		
		
		
		// The Loop
		if ( $wp_query->have_posts() ) {
		
			$return          .= $portfolioWrapperStart;
			$pagination_class = ( $pagination=='yes' ) ? ' kwayy-with-pagination' : '' ; // Pagination
			$portfolioBoxes   = '<div class="kwayy-items-wrapper '.$itemWrapper.' kwayy-portfolio-boxes-inner portfolio-wrapper row'.$pagination_class.'">';
			
			// If sorting is enabled
			$cat_list = array();
			
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
				$portfolioBoxes .= kwayy_portfoliobox( $boxwidth );
				
				if ( $sortable == 'yes' ){
					$cat_name = get_the_terms( get_the_ID() , 'portfolio_category' );
					if( is_array($cat_name) && count($cat_name)>0 ){
						foreach( $cat_name as $cat ){
							$cat_list[ $cat->slug ] = $cat->name;
						}
					}
				} // if
				
			} // while
			
			//var_dump($cat_list);
			//die;
			
			$portfolioBoxes .= '</div>';
			if( is_array($cat_list) && count($cat_list)>0 ){
				$cat_list = array_unique( $cat_list );  // Category Filter list
				ksort($cat_list);  // Sort array by name
			}
			
			if( is_array($cat_list) && count($cat_list)>0 ){
				$return .= '<nav class="portfolio-sortable-list container">';
				$return .= '<ul>';
				$return .= '<li><a class="selected" href="#" data-filter="*">'.__('All', 'apicona').'</a></li>';
				foreach( $cat_list as $slug=>$name ){
					$return .= '<li><a class="" href="#" data-filter=".'.$slug.'">'.$name.'</a></li>';
				}
				$return .= '</ul>';
				$return .= '</nav>';
			}
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
add_shortcode( 'portfoliobox', 'kwayy_sc_portfoliobox' );