<?php



/******************** YouTube embed code from URL ***********************/
//  Usage:
//  echo kwayy_YoutubeEmbedCodeFromURL( 'http://www.youtube.com/watch?v=fHBFvlQ3JGY' );
if( !function_exists('kwayy_YoutubeEmbedCodeFromURL') ){
function kwayy_YoutubeEmbedCodeFromURL( $url ){
	//$url = 'http://www.youtube.com/watch?v=fHBFvlQ3JGY';
	preg_match(
			'/[\\?\\&]v=([^\\?\\&]+)/',
			$url,
			$matches
		);
	$id = $matches[1];
	 
	$width = '640';
	$height = '385';
	return '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>';
}
}


/********************** One Click Demo Content Install *************************/
include_once( dirname( __FILE__ ).'/one-click-demo/demo-content.php' );



/********************** Topbar *************************/
if( !function_exists('kwayy_topbar') ){
function kwayy_topbar(){
	

	global $apicona;
	
	// Getting options
	$topbarhide              = $apicona['topbarhide'];
	$topbarbgcolor           = $apicona['topbarbgcolor'];
	$topbarhidesocial        = $apicona['topbarhidesocial'];
	$topbartext              = $apicona['topbartext'];
	$text_color              = $apicona['topbar_text_color'];
	$topbarrighttext         = ( isset($apicona['topbarrighttext']) && trim($apicona['topbarrighttext'])!='' ) ? '<div class="tm-tb-right-content">'.do_shortcode(trim($apicona['topbarrighttext'])).'</div>' : '' ;
	
	if( is_page() ){
		$p_topbarhide           = trim( get_post_meta( get_the_ID(), '_kwayy_page_topbar_topbarhide', true ) );
		$p_topbarbgcolor        = trim( get_post_meta( get_the_ID(), '_kwayy_page_topbar_topbarbgcolor', true ) );
		$p_topbarhidesocial     = trim( get_post_meta( get_the_ID(), '_kwayy_page_topbar_topbarhidesocial', true ) );
		$p_topbarsocialposition = trim( get_post_meta( get_the_ID(), '_kwayy_page_topbar_topbarsocialposition', true ) );
		$p_topbartext           = trim( get_post_meta( get_the_ID(), '_kwayy_page_topbar_topbartext', true ) );
		
		$topbarhide           = ($p_topbarhide!='')       ? $p_topbarhide : $topbarhide ;
		$topbarbgcolor        = ($p_topbarbgcolor!='')    ? $p_topbarbgcolor : $topbarbgcolor ;
		$topbarhidesocial     = ($p_topbarhidesocial!='') ? $p_topbarhidesocial : $topbarhidesocial ;
		//$topbarsocialposition = ($p_topbarsocialposition!='') ? $p_topbarsocialposition : $topbarsocialposition ;
		$topbartext           = ($p_topbartext!='') ? $p_topbartext : $topbartext ;
	}
	
	
	if( $topbarhide!='1' ){
		global $apicona;
		$return       = '';
		$leftContent  = do_shortcode($topbartext);
		if( $topbarhidesocial!='1' ){
			$rightContent = kwayy_get_social_links(); // Right: Social Icons
		} else {
			$rightContent = ''; // Right: Social Icons
		}
		
		// Adding right content
		$rightContent = $rightContent.$topbarrighttext;
		
		if( trim($rightContent) == '' ){
			$return .= '<div class="kwayy-tb-content kwayy-center">'.$leftContent.'</div>';
		} else {
			$return .= '<div class="kwayy-tb-content kwayy-flexible-width-left">'.$leftContent.'</div>';
			$return .= '<div class="kwayy-tb-social kwayy-flexible-width-right">'.$rightContent.'</div>';
		}
		
		
		echo '
			<div class="kwayy-topbar kwayy-topbar-textcolor-'.$text_color.' ">
				<div class="container">
					<div class="table-row">
						'.$return.'
					</div>
				</div>
			</div>';
	}
}
}
/*****************************************************************/





// Team Member search box
if( !function_exists('kwayy_floatingbar') ){
function kwayy_floatingbar(){
	global $apicona;
	$topbar_show_team_search = $apicona['topbar_show_team_search'];
	$topbar_handler_icon = (isset($apicona['topbar_handler_icon']) && trim($apicona['topbar_handler_icon'])!='') ? trim($apicona['topbar_handler_icon']) : 'fa-user-md' ;
	$topbar_handler_icon_close = (isset($apicona['topbar_handler_icon_close']) && trim($apicona['topbar_handler_icon_close'])!='') ? trim($apicona['topbar_handler_icon_close']) : 'fa-times' ;
	
	
	$aboveContent = '';
	$class        = 'tm-fbar-no-search';
	if( $topbar_show_team_search=='1' ){
		//$aboveContent .= '<span class="kwayy-team-search-btn"><a href="#" data-closeicon="'.$topbar_handler_icon_close.'" data-openicon="'.$topbar_handler_icon.'"><i class="kwicon-'.$topbar_handler_icon.'"></i> <span>' . __('Search', 'apicona') . '</span></a></span>';
		$aboveContent .= kwayy_team_search_form();
		$class = '';
	}
	
	
	if ( is_active_sidebar( 'floating-header-widgets' ) ) {
		ob_start();
		dynamic_sidebar( 'floating-header-widgets' );
		$sidebar = ob_get_contents();
		ob_end_clean();
		$aboveContent .= '<div class="kwayy-fbar-widgets-area multi-columns-row">' . $sidebar . '</div>';
	}
	
	if( trim($aboveContent)!='' ){
		$aboveContent = '<span class="kwayy-team-search-btn"><a href="#" data-closeicon="'.$topbar_handler_icon_close.'" data-openicon="'.$topbar_handler_icon.'"><i class="kwicon-'.$topbar_handler_icon.'"></i> <span>' . __('Search', 'apicona') . '</span></a></span><div class="kwayy-tbar-team-search-box-w '.$class.'"><div class="container kwayy-tbar-team-search-box" style="">' . $aboveContent . '</div></div>';
	}
	echo $aboveContent;
	
}
}




/********************** Team Search Form ************************/
if( !function_exists('kwayy_team_search_form') ){
function kwayy_team_search_form(){
	$return = '';
	
	global $apicona;
	$fbar_form_title = (isset($apicona['fbar-form-title']) && trim($apicona['fbar-form-title'])!='') ? trim($apicona['fbar-form-title']) : 'Doctor&#39;s Search';
	
	$fbar_form_input_text = (isset($apicona['fbar-form-input-text']) && trim($apicona['fbar-form-input-text'])!='') ? trim($apicona['fbar-form-input-text']) : 'Search by name';
	
	$fbar_form_select_group = (isset($apicona['fbar-form-select-group']) && trim($apicona['fbar-form-select-group'])!='') ? trim($apicona['fbar-form-select-group']) : 'All sections';
	
	$fbar_form_btn_text = (isset($apicona['fbar-form-btn-text']) && trim($apicona['fbar-form-btn-text'])!='') ? trim($apicona['fbar-form-btn-text']) : 'Search';
	
	
	
	// Team Group as Dropdown
	$dropDown     = '';
	$inputClass   = 'col-lg-3 col-md-3 col-sm-6 col-xs-12';
	$termList     = get_terms( 'team_group', array('hide_empty'=>false) );
	//$termList   = '';
	$noGroupClass = '';
	if( is_array($termList) && count($termList)>0 ){
		$inputClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
		$dropDown .= '<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12"> <div class="search_field by_treatment"> <i class="kwicon-fa-tags"></i> <select name="team_group"> <option value="" class="select-empty">' . __($fbar_form_select_group, 'apicona') . '</option>';
		foreach( $termList as $term ){
			$selected = ( get_query_var('team_group') == $term->slug ) ? 'selected="selected"' : '' ;
			$dropDown .= '<option value="'.$term->slug.'" '.$selected.'>'.$term->name.'</option>'."\n";
		}
		$dropDown .= '</select></div></div>';
	} else {
		$noGroupClass = ' kwayy-team-form-no-group';
		$inputClass   = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
	}
	
	$wpmlHdn = '';
	if (defined('ICL_LANGUAGE_CODE')){
		$wpmlHdn = '<input type="hidden" name="lang" value="'.ICL_LANGUAGE_CODE.'"/>';
	}
	
	// Form
	$return .= '<form role="search" method="get" class="team-search-form'.$noGroupClass.'" action="'.esc_url( home_url( '/' ) ).'">
					<input type="hidden" name="teamsearch" value="1">
					<input type="hidden" name="post_type" value="team_member" />
					'.$wpmlHdn.'
					<div class="row">
						
						<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12">
							<h2>'.__($fbar_form_title, 'apicona').': </h2>
						</div>
						
						<div class="'.$inputClass.'">
							<div class="search_field by_name">
								<i class="kwicon-fa-user-md"></i>
								<input type="text" placeholder="'.__($fbar_form_input_text,'apicona').'" name="s" value="'.get_search_query().'">
							</div>
						</div>
						
						'.$dropDown.'
						
						<div class="col-lg-3 col-sm-6 col-md-3 col-xs-12">
							<div class="submit_field">
								<button type="submit">' . __($fbar_form_btn_text , 'apicona') . '</button>
							</div>
						</div>
						
					</div><!-- .row -->
					
				</form><!-- form end --> ';
				
	return $return;
}
}
/*****************************************************************/





/********************** Portfolio Details ************************/
if( !function_exists('kwayy_favicon_code') ){
function kwayy_favicon_code(){
	global $apicona;
	$return = '';
	/*
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
	
	
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="160x160" href="/favicon-160x160.png">
	<link rel="icon" type="image/png" sizes="196x196" href="/favicon-196x196.png">
	
	<meta name="apple-mobile-web-app-title" content="Kwayy Infotech">
	<meta name="application-name" content="Kwayy Infotech">
	
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="/mstile-144x144.png">
	*/
	
	/*
	<meta name="application-name" content="Kwayy Infotech"/>
	<meta name="msapplication-TileColor" content="#00ff00"/>
	
	<meta name="msapplication-square70x70logo" content="tiny.png"/>
	<meta name="msapplication-square150x150logo" content="square.png"/>
	<meta name="msapplication-wide310x150logo" content="wide.png"/>
	<meta name="msapplication-square310x310logo" content="large.png"/>
	*/
	
	$faviconarray = array(
		'favicon'     => 'rel="shortcut icon" type="image/x-icon"',
		'favicon_57'  => 'rel="apple-touch-icon" sizes="57x57"',
		'favicon_60'  => 'rel="apple-touch-icon" sizes="60x60"',
		'favicon_72'  => 'rel="apple-touch-icon" sizes="72x72"',
		'favicon_76'  => 'rel="apple-touch-icon" sizes="76x76"',
		'favicon_114' => 'rel="apple-touch-icon" sizes="114x114"',
		'favicon_120' => 'rel="apple-touch-icon" sizes="120x120"',
		'favicon_144' => 'rel="apple-touch-icon" sizes="144x144"',
		'favicon_152' => 'rel="apple-touch-icon" sizes="152x152"',
		'favicon_180' => 'rel="apple-touch-icon" sizes="180x180"',
		'favicon_16'  => 'rel="icon" type="image/png" sizes="16x16"',
		'favicon_32'  => 'rel="icon" type="image/png" sizes="32x32"',
		'favicon_96'  => 'rel="icon" type="image/png" sizes="96x96"',
		'favicon_160' => 'rel="icon" type="image/png" sizes="160x160"',
		'favicon_192' => 'rel="icon" type="image/png" sizes="192x192"',
	);
	$favicon_meta_array = array(
		'favicon_ms_144'      => 'name="msapplication-TileImage"',
		'favicon_ms_70'      => 'name="msapplication-square70x70logo"',
		'favicon_ms_150'     => 'name="msapplication-square150x150logo"',
		'favicon_ms_310_150' => 'name="msapplication-wide310x150logo"',
		'favicon_ms_310'     => 'name="msapplication-square310x310logo"',
	);
	
	// <link>
	foreach( $faviconarray as $id => $code ){
		if( !empty( $apicona[$id]['url'] ) ){
			$return .= '<link '.$code.' href="'.$apicona[$id]['url'].'">'."\n";
		}
	}
	
	// <meta>
	foreach( $favicon_meta_array as $id => $code ){
		if( !empty( $apicona[$id]['url'] ) ){
			$return .= '<meta '.$code.' content="'.$apicona[$id]['url'].'" />'."\n";
		}
	}
	
	
	$return .= '<meta name="apple-mobile-web-app-title" content="'.get_bloginfo( 'name' ).'">'."\n";
	$return .= '<meta name="application-name" content="'.get_bloginfo( 'name' ).'">'."\n";
	if( !empty($apicona['favicon_ms_tile_color']) ){
		$return .= '<meta name="msapplication-TileColor" content="'.$apicona['favicon_ms_tile_color'].'">'."\n";
	}
	
	echo $return;
}
}
// Adding Favicon icon code in head
add_action('wp_head','kwayy_favicon_code');


/*****************************************************************/





/********************** Portfolio Details ************************/
if( !function_exists('kwayy_portfolio_detailsbox') ){
function kwayy_portfolio_detailsbox(){

	$clientName = trim( get_post_meta( get_the_ID(), '_kwayy_portfolio_data_clientname', true ) );
	$clientLink = trim( get_post_meta( get_the_ID(), '_kwayy_portfolio_data_clientlink', true ) );
	$skills     = trim( get_post_meta( get_the_ID(), '_kwayy_portfolio_data_skills', true ) );
	$linkText   = trim( get_post_meta( get_the_ID(), '_kwayy_portfolio_data_linktext', true ) );
	$linkUrl    = trim( get_post_meta( get_the_ID(), '_kwayy_portfolio_data_linkurl', true ) );
	global $apicona;
	
	echo '<div class="kwayy-portfolio-details">';
	
	echo do_shortcode('[heading tag="h2" text="' . __($apicona['portfolio_project_details'], 'apicona') . '"]');
	
	echo '<ul class="kwayy-portfolio-details-list">';
		
		// Date
		echo '<li class="kwayy-portfolio-date"> <i class="kwicon-fa-calendar-o"></i> ' . get_the_date( 'd M Y' ) . '</li>';
		
		// Category
		$catList = wp_get_post_terms( get_the_ID(), 'portfolio_category' );
		if( is_array($catList) && count($catList)>0 ){
			echo '<li class="kwayy-portfolio-cat"> <i class="kwicon-fa-folder-open-o"></i> ';
			$x = 0;
			foreach( $catList as $cat ){
				if( $x!=0 ){ echo ', '; }
				echo '<span>' . $cat->name . '</span>';
				$x++;
			}
			echo '</li>';
		}
		
		// Client Name w/o link
		if( $clientName!='' ){
			if( $clientLink!='' ){
				$client = '<a href="' . $clientLink . '" target="_blank">' . $clientName . '</a>';
			} else {
				$client = $clientName;
			}
			echo '<li class="kwayy-portfolio-client"> <i class="kwicon-fa-user"></i> ' . $client . '</li>';
		}
		
		// Skills
		if( $skills!='' ){
			echo '<li class="kwayy-portfolio-skills"> <i class="kwicon-fa-star-o"></i> ' . $skills . '</li>';
		}
		
		// Project Link
		if( $linkUrl!='' ){
			echo '<li class="kwayy-portfolio-link"> <i class="kwicon-fa-link"></i> <a href="' . $linkUrl . '" target="_blank">' . $linkText . '</a></li>';
		}
		
	echo '</ul>';
	echo '</div> <!-- .portfolio-details --> ';
}	
}
/*****************************************************************/






if( !function_exists('kwayy_get_social_links') ){
function kwayy_get_social_links(){
	global $apicona;
	$socialArray = array(
		'twitter'    => array( 'fa-twitter', 'Twitter' ),
		'youtube'    => array( 'fa-youtube', 'YouTube' ),
		'facebook'   => array( 'fa-facebook', 'Facebook' ),
		'linkedin'   => array( 'fa-linkedin', 'LinkedIn' ),
		'googleplus' => array( 'fa-google-plus', 'Google+' ),
		'yelp'       => array( 'fa-yelp', 'Yelp' ),
		'dribbble'   => array( 'fa-dribbble', 'Dribbble' ),
		'pinterest'  => array( 'fa-pinterest', 'Pinterest' ),
		'podcast'    => array( 'fa-wifi', 'Podcast' ),
		'instagram'  => array( 'fa-instagram', 'Instagram' ),
		'flickr'     => array( 'fa-flickr', 'Flickr' ),
		'issuu'      => array( 'fa-issuu', 'Issuu' ),
		'tripadvisor'=> array( 'fa-tripadvisor', 'TripAdvisor' ),
		'rss'        => array( 'fa-rss', 'RSS' ),
	);
	
	$return = '';
	foreach( $socialArray as $key=>$value ){
		
		if( $key == 'rss' ){
			if( isset($apicona['rss']) && $apicona['rss']=='1' ){
				$return .= '<li class="'.$key.'"><a target="_blank" href="'.get_bloginfo('rss2_url').'" title="'.$value[1].'" data-toggle="tooltip"><i class="kwicon-'.$value[0].'"></i></a></li>';
			}
		} else {
			if( isset($apicona[$key]) && trim($apicona[$key])!='' ){
				$return .= '<li class="'.$key.'"><a target="_blank" href="'.trim($apicona[$key]).'" title="'.$value[1].'" data-toggle="tooltip"><i class="kwicon-'.$value[0].'"></i></a></li>';
			}
		}
	}
	
	if( $return!='' ){
		$return = '<ul class="social-icons">'.$return.'</ul>';
	}
	
	return $return;
}
}






/*************** Set primary Class for #primary ******************/
if( !function_exists('setPrimaryClass') ){
function setPrimaryClass($sidebar){
	$primaryclass = 'col-md-12 col-lg-12 col-sm-12 col-xs-12';
	switch($sidebar){
		case 'left':
		case 'right':
			$primaryclass = 'col-md-9 col-lg-9 col-xs-12';
			break;
		case 'both':
		case 'bothleft':
		case 'bothright':
			$primaryclass = 'col-md-6 col-lg-6 col-xs-12';
			break;
	}
	return $primaryclass;
}
}
/*****************************************************************/



/************************* Header Slider ************************/
if( !function_exists('kwayy_header_slider') ){
function kwayy_header_slider(){
	$sliderWrapperStart = '<div class="kwayy-slider-wrapper">';
	$sliderWrapperEnd   = '</div>';
	if( is_page() ){
		// check if any slider setup on page
		$sliderType = get_post_meta(get_the_ID(), '_kwayy_page_options_slidertype', true);
		if(isset($sliderType) && is_array($sliderType) ){ $sliderType = $sliderType[0]; }
		
		
		// If Boxed Slider set
		$sliderSize = get_post_meta(get_the_ID(), '_kwayy_page_options_slidersize', true);
		if(isset($sliderSize) && is_array($sliderSize) ){ $sliderSize = $sliderSize[0]; }
		if( $sliderSize=='boxed' ){
			$sliderWrapperStart .= '<div class="container"><div class="row"><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			$sliderWrapperEnd   .= '</div></div></div>';
		}
		
		if( $sliderType!='' ){
			switch($sliderType){
				case 'revslider':
					// **** Slider Revolution **** //
					$revSliderAlias = trim(get_post_meta(get_the_ID(), '_kwayy_page_options_revslider_slider', true));
					if( $revSliderAlias!='' ){
						echo do_shortcode('[rev_slider '.$revSliderAlias.']');
					}
					
					/*global $wpdb;
					$alias = $wpdb->get_results("SELECT alias FROM ".$wpdb->prefix."revslider_sliders WHERE id='".$revSliderID."' ");
					if( $alias!=false && isset($alias[0]->alias) ){
						$alias = $alias[0]->alias;
						if( function_exists('putRevSlider') ){
							echo $sliderWrapperStart.'<div class="kwayy-rev-slider-wrapper">';
							//putRevSlider( $alias );
							//$shortcode = '[rev_slider '.$alias.']';
							//var_dump( $shortcode );
							echo do_shortcode('[rev_slider '.$alias.']');
							echo '</div>'.$sliderWrapperEnd;
						}
					}*/
					
					break;
				
				
				case 'nivo':
				case 'flex':	
					
					$slidercat = get_post_meta( get_the_ID() ,'_kwayy_page_options_slidercat', true );
					//var_dump($slidercat);
					
					$args = array(
						'post_type'      => 'slide',
						'posts_per_page' => 9999,
						'tax_query'      => array(
							array(
								'taxonomy' => 'slide_group',
								'field' => 'slug',
								'terms' => $slidercat
							),
						)
					);
					$loop = new WP_Query( $args );
					
					if( isset($loop->posts) && count($loop->posts)>0 ){
						echo $sliderWrapperStart;
						if( $sliderType=='flex' ){
							echo '<div class="flexslider"><ul class="slides">';
						} else {
							echo '<div class="kwayy-slider kwayy-'.$sliderType.'-slider-wrapper"> <div class="slider-wrapper theme-default"> <div id="slider" class="nivoSlider">';
						}
						
						$x = 1;
						$descText = '';
						while ( $loop->have_posts() ) : $loop->the_post();
							
							// Getting data
							$title   = trim(get_the_title());
							$desc    = trim(get_post_meta( get_the_ID(), '_kwayy_slides_options_desc', true ));
							$btntext = trim(get_post_meta( get_the_ID(), '_kwayy_slides_options_btntext', true ));
							$btnlink = trim(get_post_meta( get_the_ID(), '_kwayy_slides_options_btnlink', true ));
							
							$desc    = ( $desc!='' ) ? '<div class="kwayy-slider-desc">'.$desc.'</div>' : '' ;
							//$btntext = ( $btntext!='' ) ? '<div class="kwayy-slider-btn"><a href="'.$btnlink.'">'.$btntext.'</a></div>' : '' ;
							
							$btntext = ( $btntext!='' ) ? do_shortcode('[vc_button title="'.$btntext.'" icon="right-open" color="white" size="big" href="'.$btnlink.'" el_class="" btn_effect="bordertocolor" iconposition="right" showicon="withicon"]') : '' ;
							
							
							if( has_post_thumbnail() ){
								$url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
							} else {
								$url = 'no-image.jpg';
							}
							
							
							if( $sliderType=='nivo' ){
								// **** Nivo Slider **** //
								echo '<img src="'.$url.'" alt="" title="#nivoslidetext'.$x.'" />';
								$descText .= '<div id="nivoslidetext'.$x.'" class="nivo-html-caption"><h2>'.$title.'</h2>'.$desc.$btntext.'</div>';
								
							} else {
								// **** Flex Slider **** //
								echo '<li><img src="'.$url.'" />';
								if( $title!='' ){ echo '<div class="flex-caption"><div class="flex-caption-inner"><h3 class="flex-caption-title">'.$title.'</h3><div class="flex-caption-desc">'.$desc.'</div><div class="flex-caption-btn">'.$btntext.'</div></div></div>'; }
								echo '</li>';
								
							}
							
							$x++;
							
						endwhile;
						
						
						
						
						if( $sliderType=='flex' ){
							echo '</ul><!-- .slides --> </div><!-- .flexslider -->';
						} else {
							echo '</div><!-- #slider.nivoSlider -->';
							// Echo Decription of each slide
							echo '<div id="htmlcaption" class="nivo-html-caption">'.$descText.'</div>';
							echo '</div><!-- .slider-wrapper --> </div><!-- .kwayy-slider --> ';
						}
						
						
							
							
						echo $sliderWrapperEnd;
						
					}  // if( count($loop->posts)>0 )
					
					break;
			}
		}
	}
	
}
}
/*****************************************************************/


/************* Check if color is dark or light ****************/
if( !function_exists('get_brightness') ){
function get_brightness($hex) {
	// returns brightness value from 0 to 255

	// strip off any leading #
	$hex = str_replace('#', '', $hex);

	$c_r = hexdec(substr($hex, 0, 2));
	$c_g = hexdec(substr($hex, 2, 2));
	$c_b = hexdec(substr($hex, 4, 2));

	return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}
}
/*****************************************************************/



/************* HEX to RGB converter for CSS color ****************/
if( !function_exists('hex2rgb') ){
function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	return implode(",", $rgb); // returns the rgb values separated by commas
	//return $rgb; // returns an array with the rgb values
}
}
/*****************************************************************/





/*********** Getting Featured Slider / Video or Image ***********/
if( !function_exists('kwayy_get_featured_content') ){
function kwayy_get_featured_content($postid, $size='blog-slider-small', $postBoxTitle='kwayy_post_featured_area' , $noVideo=false , $showNoImage=false ){
	
	$featuredContent = '';
	$featuredtype    = get_post_meta($postid, '_'.$postBoxTitle.'_featuredtype', true);
	$featuredtype    = $featuredtype[0];
	$featuredtype    = ($size=='blog-slider-small') ? 'image' : $featuredtype ;
	$noWrapper       = false;
	
	
	if($noVideo){
		$featuredtype = ($featuredtype=='video' || $featuredtype=='audio') ? 'image' : $featuredtype;
	}
	
	
	switch($featuredtype){
		case 'video':
			$featuredContent = '<div class="fluid-video">'.get_post_meta($postid, '_'.$postBoxTitle.'_videocode', true).'</div>';
			break;
		case 'audio':
			$featuredContent = '';
			if( is_single() ){
				if( has_post_thumbnail($postid) ){
					$featuredContent = get_the_post_thumbnail( $postid, $size );
				}
			}
			$featuredContent .= '<div class="fluid-audio">'.get_post_meta($postid, '_'.$postBoxTitle.'_audiocode', true).'</div>';
			break;
		case 'slider':
			$slideImages = array();
			for($a=1; $a<=10; $a++){
				$slideImages[] = wp_get_attachment_image(get_post_meta($postid, '_'.$postBoxTitle.'_slideimage'.$a, true), $size);
			}
			$slideImages = array_filter($slideImages); // Removing empty array
			if( count($slideImages)>0 ){
				$featuredContent = '<div class="flexslider"><ul class="slides"><li>';
				$featuredContent .= implode('</li><li>',$slideImages);
				$featuredContent .= '</li></ul></div>';
			}
			break;
		default:
			if( has_post_thumbnail($postid) ){
				$featuredContent = get_the_post_thumbnail( $postid, $size );
			} else {
				if( !is_single() ){
					if($showNoImage==true){
						//if($noVideo==true){
						//	$featuredContent = '<i class="fa fa-picture kwayy-proj-noimage-icon"></i>';
						//} else {
							$featuredContent = '<div class="kwayy-proj-noimage"><i class="fa fa-picture"></i></div>';
						//}
					}
				} else {
					$featuredContent = '';
				}
				$noWrapper = true;
			}
			break;
	}
	if($featuredContent!=''){
		if( $noWrapper==true ){
			return $featuredContent;
		} else {
			return '<div class="featured-content-wrapper featured-type-'.$featuredtype.'">'.$featuredContent.'</div>';
		}
		
	} else {
		return '';
	}
	
}
}
/*******************************************************************/











/*********** Portfolio: Getting Featured Slider / Video or Image ***********/
if( !function_exists('kwayy_get_portfolio_featured_content') ){
function kwayy_get_portfolio_featured_content(){
	$featuredtype    = get_post_meta(get_the_ID(), '_kwayy_portfolio_featured_featuredtype', true);
	$featuredtype    = $featuredtype[0];
	$startDiv = '<div>';
	$endDiv   = '</div>';
	
	switch($featuredtype){
		case 'image':
		default:
			if( has_post_thumbnail(get_the_ID()) ){
				echo $startDiv;
				the_post_thumbnail('full');
				echo $endDiv;
			} else {
				echo $startDiv;
				echo '<div class="kwayy-no-image"><i class="kwicon-fa-image"></i></div>';
				echo $endDiv;
			}
			break;
			
		case 'video':
			echo $startDiv;
			echo '<div class="fluid-video">' . kwayy_get_embed_code( get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_videourl', true) ) . '</div>';
			echo $endDiv;
			break;
			
		case 'audioembed':
			echo $startDiv;
			echo '<div class="fluid-audio">' . get_post_meta(get_the_ID(), '_kwayy_portfolio_featured_audiocode', true).'</div>';
			echo $endDiv;
			break;
			
		case 'slider':
			echo $startDiv;
			echo kwayy_featured_gallery_slider( 'portfolio' );
			echo $endDiv;
			
			
			break;
	}

}
}
/*******************************************************************/






/********************** Get YouTube/Vimeo embed code *************************/
if( !function_exists('kwayy_get_embed_code') ){
	function kwayy_get_embed_code($url){
		$width  = '853';
		$height = '480';
		$embed_code = wp_oembed_get($url);
		echo $embed_code;
		
		/*if (strpos($url, 'youtube') > 0) {
			preg_match(
					'/[\\?\\&]v=([^\\?\\&]+)/',
					$url,
					$matches
				);
			$id     = $matches[1];
			
			
			echo '<iframe width="' . $width . '" height="' . $height . '" src="//www.youtube.com/embed/' . $id . '" frameborder="0" allowfullscreen></iframe>';
			
		} elseif (strpos($url, 'vimeo') > 0) {
		
			$id = (int) substr(parse_url($url, PHP_URL_PATH), 1);
			global $apicona;
			echo '<iframe src="//player.vimeo.com/video/' . $id . '?title=0&amp;byline=0&amp;portrait=0&amp;color='.$apicona['skincolor'].'" width="' . $width . '" height="' . $height . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}*/
	}
}
/*****************************************************************************/




/********************* Slider ***********************/
if( !function_exists('kwayy_featured_gallery_slider') ){
function kwayy_featured_gallery_slider( $postType='post' ){
	
	$wrapperClass = '';
	$metaPrefix   = '_kwayy_post_gallery_';
	$wrapperClass = 'kwayy-blog-media';
	
	if( 'portfolio' == $postType ){
		$metaPrefix   = '_kwayy_portfolio_featured_';
		$wrapperClass = 'kwayy-portfolio-media';
	} else if( 'post' == $postType ){
		$metaPrefix   = '_kwayy_post_gallery_';
		$wrapperClass = 'kwayy-blog-media';
	}
	$return = '';
	if( $metaPrefix!='' ){
		for($a=1; $a<=10; $a++){
			$slideImage = get_post_meta(get_the_ID(), $metaPrefix . 'slideimage'.$a, true);
			if( $slideImage!='' ){
				$return .= '<li>'.wp_get_attachment_image( $slideImage, 'full').'</li>';
			}
		}
		if( $return!='' ){
			$return = '<div class="'.$wrapperClass.' kwayy-blog-media kwayy-slider-wrapper"><div class="flexslider"><ul class="slides">' . $return . '</ul></div></div>';
		}
	}
	return $return;
}
}
/**************************************************/




/*********************** kwayy_header_titlebar ****************************/
if( !function_exists('kwayy_header_titlebar') ){
function kwayy_header_titlebar(){
	global $apicona;
	$hidetitlebar   = false;
	$hidebreadcrumb = false;
	//$icon           = 'arrow-right';
	$subtitle       = '';
	$titlebar_bg_image_type   = $apicona['titlebar_bg_image_type'];
	$titlebar_bg_color        = $apicona['titlebar_bg_color'];
	$titlebar_text_color      = $apicona['titlebar_text_color'];
	$titlebar_bg_image        = $apicona['titlebar_bg_image'];
	$titlebar_bg_custom_image = ( isset($apicona['titlebar_bg_custom_image']['url']) ) ? $apicona['titlebar_bg_custom_image']['url'] : '' ;
	
	
	
	if( is_page() ){ // Page
		$hidetitlebar   = get_post_meta( get_the_ID(), '_kwayy_page_options_hidetitlebar', true );
		$title          = trim(get_post_meta( get_the_ID(), '_kwayy_page_options_title', true));
		$subtitle       = trim(get_post_meta( get_the_ID(), '_kwayy_page_options_subtitle', true));
		$hidebreadcrumb = trim(get_post_meta( get_the_ID(), '_kwayy_page_options_hidebreadcrumb', true));
		//$icon           = trim(get_post_meta( get_the_ID(), '_kwayy_page_options_icon', true));
		$title  = ( $title != '' ? $title : get_the_title( get_the_ID() ) );
		
		
		$page_titlebar_bg_image = trim(get_post_meta( get_the_ID(), '_kwayy_page_options_titlebar_bg_image', true));
		$page_titlebar_bg_custom_image = wp_get_attachment_image_src(get_post_meta( get_the_ID(), '_kwayy_page_options_titlebar_bg_image_custom', true) , 'full' );
		
		// Page option overriding global options : Predefined image
		if( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' && $page_titlebar_bg_image!='custom' ){
			$titlebar_bg_image_type = 'image';
			$titlebar_bg_image      = $page_titlebar_bg_image;
		}
		
		// Page option overriding global options : Custom image
		if( $page_titlebar_bg_image == 'custom' ){
			$titlebar_bg_image_type   = 'custom';
			$titlebar_bg_custom_image = @$page_titlebar_bg_custom_image[0];
		}
		
		
	} else if( function_exists('is_woocommerce')  && is_woocommerce() ){ // WooCommerce
		$hidetitlebar   = '';
		$title          = '';
		$subtitle       = '';
		$hidebreadcrumb = '';
		//$icon           = '';
		
		if ( is_search() ) {
			$title = sprintf( __( 'Search Results: &ldquo;%s&rdquo;', 'apicona' ), get_search_query() );
			if ( get_query_var( 'paged' ) ){
				$title .= sprintf( __( '&nbsp;&ndash; Page %s', 'apicona' ), get_query_var( 'paged' ) );
			}
		} elseif ( is_tax() ) {
			$title = single_term_title( "", false );
		} else {
			$shop_page_id = wc_get_page_id( 'shop' ); // Getting shop page ID
			
			$hidetitlebar   = get_post_meta( $shop_page_id, '_kwayy_page_options_hidetitlebar', true );
			$title          = trim(get_post_meta( $shop_page_id, '_kwayy_page_options_title', true));
			$subtitle       = trim(get_post_meta( $shop_page_id, '_kwayy_page_options_subtitle', true));
			$hidebreadcrumb = trim(get_post_meta( $shop_page_id, '_kwayy_page_options_hidebreadcrumb', true));
			//$icon           = trim(get_post_meta( $shop_page_id, '_kwayy_page_options_icon', true));
			$title  = ( $title != '' ? $title : get_the_title( $shop_page_id ) );
			
			$page_titlebar_bg_image        = trim(get_post_meta( $shop_page_id, '_kwayy_page_options_titlebar_bg_image', true));
			$page_titlebar_bg_custom_image = wp_get_attachment_image_src(get_post_meta( $shop_page_id, '_kwayy_page_options_titlebar_bg_image_custom', true) , 'full' );
			//$titlebar_bg_image        = ( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' ) ? $page_titlebar_bg_image : $titlebar_bg_image;
			//$titlebar_bg_custom_image = ( $page_titlebar_bg_custom_image[0]!='' ) ? $page_titlebar_bg_custom_image[0] : $titlebar_bg_custom_image ;
			
			// Page option overriding global options : Predefined image
			if( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' && $page_titlebar_bg_image!='custom' ){
				$titlebar_bg_image_type = 'image';
				$titlebar_bg_image      = $page_titlebar_bg_image;
			}
			
			// Page option overriding global options : Custom image
			if( $page_titlebar_bg_image == 'custom' ){
				$titlebar_bg_image_type   = 'custom';
				$titlebar_bg_custom_image = @$page_titlebar_bg_custom_image[0];
			}
			
		}
		$woocommerce_Active = true;
		
	} else if( is_home() ){ // Blogroll
		if( get_option('page_for_posts') == 0 ){
			$hidetitlebar   = true;
		} else {
			$page_id        = get_option('page_for_posts');
			$hidetitlebar   = get_post_meta( $page_id, '_kwayy_page_options_hidetitlebar', true );
			$title          = trim(get_post_meta( $page_id, '_kwayy_page_options_title', true));
			$subtitle       = trim(get_post_meta( $page_id, '_kwayy_page_options_subtitle', true));
			$hidebreadcrumb = get_post_meta( $page_id, '_kwayy_page_options_hidebreadcrumb', true );
			//$icon           = trim(get_post_meta( $page_id, '_kwayy_page_options_icon', true));
			$title          = ( $title != '' ? $title : get_the_title( $page_id ) );
			
			$page_titlebar_bg_image        = trim(get_post_meta( $page_id, '_kwayy_page_options_titlebar_bg_image', true));
			$page_titlebar_bg_custom_image = wp_get_attachment_image_src(get_post_meta( $page_id, '_kwayy_page_options_titlebar_bg_image_custom', true) , 'full' );
			
			//$titlebar_bg_image        = ( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' ) ? $page_titlebar_bg_image : $titlebar_bg_image ;
			//$titlebar_bg_custom_image = ( $page_titlebar_bg_image_custom[0]!='' ) ? $page_titlebar_bg_image_custom[0] : $titlebar_bg_custom_image ;
			
			// Page option overriding global options : Predefined image
			if( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' && $page_titlebar_bg_image!='custom' ){
				$titlebar_bg_image_type = 'image';
				$titlebar_bg_image      = $page_titlebar_bg_image;
			}
			
			// Page option overriding global options : Custom image
			if( $page_titlebar_bg_image == 'custom' ){
				$titlebar_bg_image_type   = 'custom';
				$titlebar_bg_custom_image = @$page_titlebar_bg_custom_image[0];
			}
			
		}
	} else if( is_single() ){ // Single Post
		$postType = get_post_type( get_the_ID() );
		switch($postType){
			case 'post':
				$page_for_posts = get_option('page_for_posts');
				$post_type      = 'page';
				
				if( isset($apicona['tbar_title']) && $apicona['tbar_title']=='1' ) {
					global $post;
					$page_for_posts = $post->ID;
					$post_type      = 'post';
				}
			
				
				$hidetitlebar   = get_post_meta( get_the_ID(), '_kwayy_post_options_hidetitlebar', true );
				$customtitle    = trim(get_post_meta( $page_for_posts, '_kwayy_'.$post_type.'_options_title', true));
				$rawtitle       = get_the_title( $page_for_posts );
				$title          = ($customtitle=='') ? $rawtitle : $customtitle ;
				$subtitle       = trim(get_post_meta( $page_for_posts, '_kwayy_'.$post_type.'_options_subtitle', true));
				$hidebreadcrumb = trim(get_post_meta( get_the_ID(), '_kwayy_post_options_hidebreadcrumb', true));
				//$icon           = trim(get_post_meta( get_the_ID(), '_kwayy_post_options_icon', true));
				$title          = ( $title != '' ? $title : get_the_title( get_the_ID() ) );
				
				/*
				$page_titlebar_bg_image        = trim(get_post_meta( get_the_ID(), '_kwayy_post_options_titlebar_bg_image', true));
				$page_titlebar_bg_image_custom = wp_get_attachment_image_src(get_post_meta( get_the_ID(), '_kwayy_post_options_titlebar_bg_image_custom', true) , 'full' );
				
				$titlebar_bg_image        = ( $page_titlebar_bg_image!='' && $page_titlebar_bg_image!='global' ) ? $page_titlebar_bg_image : $titlebar_bg_image ;
				$titlebar_bg_custom_image = ( $page_titlebar_bg_image_custom[0]!='' ) ? $page_titlebar_bg_image_custom[0] : $titlebar_bg_custom_image ;
				*/
				
				
				
				$post_titlebar_bg_image = trim(get_post_meta( get_the_ID(), '_kwayy_post_options_titlebar_bg_image', true));
				$post_titlebar_bg_custom_image = wp_get_attachment_image_src(get_post_meta( get_the_ID(), '_kwayy_post_options_titlebar_bg_image_custom', true) , 'full' );
				
				// Page option overriding global options : Predefined image
				if( $post_titlebar_bg_image!='' && $post_titlebar_bg_image!='global' && $post_titlebar_bg_image!='custom' ){
					$titlebar_bg_image_type = 'image';
					$titlebar_bg_image      = $post_titlebar_bg_image;
				}
				
				// Page option overriding global options : Custom image
				if( $post_titlebar_bg_image == 'custom' ){
						$titlebar_bg_image_type   = 'custom';
						$titlebar_bg_custom_image = @$post_titlebar_bg_custom_image[0];
				}
				
				
				
				
				break;

			case 'portfolio':
				$title          = get_the_title();
				$hidebreadcrumb = 'off';
				break;
				
			default:
				$title          = get_the_title();
				$hidebreadcrumb = 'off';
				break;
		}
		
	} else if( is_category() ){ // Category
		$adv_tbar_catarc = isset( $apicona['adv_tbar_catarc'] ) ? $apicona['adv_tbar_catarc'] : 'Category Archives: ' ;
		$title           = sprintf( __( $adv_tbar_catarc.' %s', 'apicona' ), '<span>' . single_cat_title( '', false ) . '</span>' );
		$subtitle        = category_description();
		
	} else if( is_tag() ){ // Tag
		$adv_tbar_tagarc = isset( $apicona['adv_tbar_tagarc'] ) ? $apicona['adv_tbar_tagarc'] : 'Tag Archives: ' ;
		$title           = sprintf( __( $adv_tbar_tagarc.' %s', 'apicona' ), '<span>' . single_tag_title( '', false ) . '</span>' );
		$subtitle        = tag_description();
		
	} else if( is_tax() ){ // Taxonomy
		global $wp_query;
		$adv_tbar_postclassified = isset( $apicona['adv_tbar_postclassified'] ) ? $apicona['adv_tbar_postclassified'] : 'Posts classified under: ' ;
		$tax                     = $wp_query->get_queried_object();
		if( is_tax('team_group') ){
			$title = sprintf( __( '%s', 'apicona' ), '<span>' . $tax->name . '</span>' );
		} else {
			$title = sprintf( __( $adv_tbar_postclassified.' %s', 'apicona' ), '<span>' . $tax->name . '</span>' );
		}
		
	} else if( is_author() ){ // Author
		if ( have_posts() ){
			the_post();
			$adv_tbar_authorarc = isset( $apicona['adv_tbar_authorarc'] ) ? $apicona['adv_tbar_authorarc'] : 'Author Archives: ' ;
			$title              = sprintf( __( $adv_tbar_authorarc.' %s', 'apicona' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
		}

	} else if( is_search()  ){ // Search Results
		$title    = sprintf( __( 'Search Results for <strong>%s</strong>', 'apicona' ), '<span>' . get_search_query() . '</span>' );		
	
	} else if( is_404() ){ // 404
		$hidetitlebar   = true;  // Hide Titlebox on 404 error page
		//$title    = __( 'Page Not Found', 'apicona' );
		//$hidebreadcrumb = 'on';
	
	} else if( is_archive() ){ // Archive
		if ( is_day() ){
			$title = sprintf( __( 'Daily Archives: %s', 'apicona' ), '<span>' . get_the_date() . '</span>' );
		} elseif( is_month() ){
			$title = sprintf( __( 'Monthly Archives: %s', 'apicona' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'apicona' ) ) . '</span>' );
		} elseif( is_year() ){
			$title = sprintf( __( 'Yearly Archives: %s', 'apicona' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'apicona' ) ) . '</span>' );
		} else {
			if( function_exists('is_bbpress') && is_bbpress() ) {
				$title = __( 'Forum', 'apicona' );
			} else {
				$title = __( 'Archives', 'apicona' );
			}
		};
		
	} else if( function_exists('tribe_is_past') && function_exists('tribe_is_upcoming') && (tribe_is_past() || tribe_is_upcoming() || tribe_is_month() || tribe_is_day() && !is_tax()) ){
		$title = __( 'EVENTS', 'apicona' );
		$hidebreadcrumb = 'on';
	
	} else {
		$title          = get_the_title();
		$hidebreadcrumb = 'on';
		
	}
	
	// Storing BG Image in another variable
	$bgimg = $titlebar_bg_image;
	
	//var_dump($titlebar_bg_image);
	
	
	if( $hidetitlebar != 'on' ){
		$e_class  = ( $subtitle != '' ? 'kwayy-with-subtitle' : 'kwayy-without-subtitle' );
		$e_class .= ( $hidebreadcrumb == 'on' ? ' kwayy-no-breadcrumb' : ' kwayy-with-breadcrumb' );
		$e_class .= ( isset($titleNavigation) ? ' kwayy-with-proj-navigation' : ' kwayy-without-proj-navigation' );
		
		$subtitle = ($subtitle!='') ? '<br><span class="kwayy-subtitle">'.do_shortcode(esc_attr($subtitle)).'</span>' : '' ;
		
			
		// Breadcrumb Class
		$e_class   .= ' kwayy-header-without-breadcrumb';
		$h1Class    = 'headingblock';
		$bcClass    = 'breadcrumbblock';
		//$breadcrumb = true;  // Temporary patch
		if ( $hidebreadcrumb!='on' ) {
			$e_class .= ' kwayy-header-with-breadcrumb';
			//$h1Class  = 'headingblock';
			//$bcClass  = 'breadcrumbblock';
		}
		
		// Custom Background Image
		$inlineCSS = '';
		if( $titlebar_bg_image_type=='custom' ){
			$inlineCSS = ( $titlebar_bg_custom_image!='' ) ? ' style="background-image:url(\''.$titlebar_bg_custom_image.'\');" ' : '' ;
		} else if( $titlebar_bg_image_type=='noimg' ){
			$bgimg = 'No';
		}
		
		
		?>
		

		<?php //var_dump($inlineCSS); ?>
		<div class="kwayy-titlebar-wrapper entry-header <?php echo $e_class; ?> kwayy-titlebar-bgimg-img<?php echo $bgimg; ?> kwayy-titlebar-textcolor-<?php echo $titlebar_text_color; ?>" <?php echo $inlineCSS; ?>>
			<div class="kwayy-titlebar-inner-wrapper">
				<div class="kwayy-titlebar-main container">
					<div class="entry-title-wrapper <?php //echo $h1Class; ?>">
						<h1 class="entry-title"><?php echo do_shortcode($title); echo $subtitle; ?></h1>
					</div>
					<?php if($hidebreadcrumb!='on'){ ?>
						
						<?php
						
						echo '<div class="breadcrumb-wrapper">';
						
						if( 'portfolio' == get_post_type( get_the_ID() ) ){
							
							echo '<div class="kwayy-pf-navbar-wrapper">';
							
							// Prev Link
							$prevPost = get_adjacent_post( false, '', true);
							if( $prevPost!=NULL && isset($prevPost) ){
								echo '<a href="'.get_permalink($prevPost->ID).'" title="'.$prevPost->post_title.'"><i class="kwicon-fa-chevron-circle-left"></i></a>';
							} else {
								echo '<span class="kwayy-dim"><i class="kwicon-fa-chevron-circle-left"></i></span>';
							}
							
							// Next Link
							$nextPost = get_adjacent_post( false, '', false);
							if( $nextPost!=NULL && isset($nextPost) ){
								echo '<a href="'.get_permalink($nextPost->ID).'" title="'.$nextPost->post_title.'"><i class="kwicon-fa-chevron-circle-right"></i></a>';
							} else {
								echo '<span class="kwayy-dim"><i class="kwicon-fa-chevron-circle-right"></i></span>';
							}
							
							echo '</div> <!-- .kwayy-pf-navbar-wrapper -->';
							
						} else {
							
							if(function_exists('bcn_display')){
								echo '<!-- Breadcrumb NavXT output -->';
								bcn_display();
							} else if( function_exists('is_woocommerce') && is_woocommerce() ) {
								echo '<!-- woocommerce_breadcrumb -->';
								woocommerce_breadcrumb();
							} else {
								echo '<!-- kwayy_get_breadcrumb_navigation -->';
								kwayy_get_breadcrumb_navigation();
							}
						
						}
						
						echo '</div><!-- .breadcrumb-wrapper -->';
						
						?>
				
					<?php } // if($hidebreadcrumb!='on')  ?>
				</div><!-- .kwayy-titlebar-main -->
			</div><!-- .kwayy-titlebar-inner-wrapper -->
		</div><!-- .kwayy-titlebar-wrapper -->

		
		<?php
	}
}
}
/***********************************************************************/










/********************  Darken/Lighten HEX color ***********************/
if( !function_exists('adjustBrightness') ){
function adjustBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + $steps));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}
}
/**********************************************************************/






/********************** Bootstrap 3 based columns *********************/
if( !function_exists('kwayy_translateColumnWidthToSpan') ){
	function kwayy_translateColumnWidthToSpan($width, $front = true) {
		switch ( $width ) {
			case "1/12" :
				$w = "col-xs-12 col-sm-1 col-md-1 col-lg-1";
				break;
			case "1/6" :
				$w = "col-xs-12 col-sm-2 col-md-2 col-lg-2";
				break;    
			case "1/4" :
				$w = "col-xs-12 col-sm-3 col-md-3 col-lg-3";
				break;
			case "1/3" :
				$w = "col-xs-12 col-sm-4 col-md-4 col-lg-4";
				break;
			case "5/12" :
				$w = "col-xs-12 col-sm-5 col-md-5 col-lg-5";
				break;
			case "1/2" :
				$w = "col-xs-12 col-sm-6 col-md-6 col-lg-6";
				break;
			case "7/12" :
				$w = "col-xs-12 col-sm-7 col-md-7 col-lg-7";
				break;
			case "2/3" :
				$w = "col-xs-12 col-sm-8 col-md-8 col-lg-8";
				break;    
			case "3/4" :
				$w = "col-xs-12 col-sm-9 col-md-9 col-lg-9";
				break;    
			case "5/6" :
				$w = "col-xs-12 col-sm-10 col-md-10 col-lg-10";
				break;
			case "11/12" :
				$w = "col-xs-12 col-sm-11 col-md-11 col-lg-11";
				break;
			case "1/1" :
				$w = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
				break;
			default :
			$w = $width;
		}
		$custom = $front ? get_custom_column_class($w): false;
		return $custom ? $custom : $w;
	}
}
/**********************************************************************/






/************************ Breadcrumb Function **************************/
if( !function_exists('kwayy_get_breadcrumb_navigation') ){
function kwayy_get_breadcrumb_navigation() {

	/* === OPTIONS === */
	$text['home']     = 'Home'; // text for the 'Home' link
	$text['category'] = 'Archive by Category "%s"'; // text for a category page
	$text['search']   = 'Search Results for "%s" Query'; // text for a search results page
	$text['tag']      = 'Posts Tagged "%s"'; // text for a tag page
	$text['author']   = 'Articles Posted by %s'; // text for an author page
	$text['404']      = 'Error 404'; // text for the 404 page

	$show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
	$show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
	$show_title     = 1; // 1 - show the title for the links, 0 - don't show
	$delimiter      = ' / '; // delimiter between crumbs
	$before         = '<span class="current">'; // tag before the current crumb
	$after          = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$home_link    = home_url('/');
	$link_before  = '<span typeof="v:Breadcrumb">';
	$link_after   = '</span>';
	$link_attr    = ' rel="v:url" property="v:title"';
	$link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
	$parent_id = NULL;
	if( isset($post) ){
		$parent_id    = $parent_id_2 = $post->post_parent;
	}
	$frontpage_id = get_option('page_on_front');

	if (is_home() || is_front_page()) {

		if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
		if ($show_home_link == 1) {
			echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
			if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
		}

		if ( is_category() ) {
			$this_cat = get_category(get_query_var('cat'), false);
			if ($this_cat->parent != 0) {
				$cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
			}
			if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

		} elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;

		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
				$cats = str_replace('</a>', '</a>' . $link_after, $cats);
				if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
				echo $cats;
				if ($show_current == 1) echo $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($parent_id);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
			$cats = str_replace('</a>', '</a>' . $link_after, $cats);
			if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && !$parent_id ) {
			if ($show_current == 1) echo $before . get_the_title() . $after;

		} elseif ( is_page() && $parent_id ) {
			if ($parent_id != $frontpage_id) {
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					if ($parent_id != $frontpage_id) {
						$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					}
					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
			}
			if ($show_current == 1) {
				if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
				echo $before . get_the_title() . $after;
			}

		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;

		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page', 'apicona') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</div><!-- .breadcrumbs -->';

	}
} // end kwayy_get_breadcrumb_navigation()
}
/***********************************************************************/









/*************************** Portfolio Box ****************************/
if( !function_exists('kwayy_portfoliobox') ){
function kwayy_portfoliobox( $column='' ){
	global $apicona;
	$return = '';
	
	// Getting all values
	$featuredtype = get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_featuredtype', true );
	$featuredtype = $featuredtype[0];

	// YouTube or Vimeo
	$videourl     = get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_videourl', true );

	// Video Player (HTML5)
	$videofile_mp4 =  get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_videofile_mp4', true );
	$videofile_webm = get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_videofile_webm', true );
	$videofile_ogv =  get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_videofile_ogv', true );

	// SoundCloud or other Audio embed code
	$audiocode = get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_audiocode', true );

	// Audio Player (HTML5)
	$audiofile_mp3 = get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_audiofile_mp3', true );
	$audiofile_wav = get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_audiofile_wav', true );
	$audiofile_oga = get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_audiofile_oga', true );

	$embedCodeDiv = '';

	
	switch($column){
		case 'two':
			$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
			break;
		case 'three':
			$boxClass = 'col-lg-4 col-sm-6 col-md-4 col-xs-12';
			break;
		case 'four':
		default:
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'five':
			$boxClass = 'col-lg-20percent col-sm-4 col-md-4 col-xs-12';
			break;
		case 'six':
			$boxClass = 'col-lg-2 col-sm-4 col-md-4 col-xs-12';
			break;
		case 'mix':
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'fix':
			$boxClass = 'portfolio-slider-box-width';
			break;
	}

	



	$term_slugs = wp_get_post_terms( get_the_ID(), 'portfolio_category', array("fields" => "all") );
	$slugs = array();
	$terms = array();
	foreach( $term_slugs as $term ){
		$slugs[] = $term->slug;
		$terms[] = $term->name;
	}

	$likes = get_post_meta( get_the_ID(), 'kwayy_likes', true );
	if( !$likes ){ $likes='0'; }

	$likeActiveClass = ( isset($_COOKIE["kwayy_likes_".get_the_ID()]) ) ? 'like-active' : '' ;
	$likeIconClass   = ( isset($_COOKIE["kwayy_likes_".get_the_ID()]) ) ? 'kwicon-fa-heart' : 'kwicon-fa-heart-o' ;

	$featuredLink = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
	$featuredImgURL = $featuredLink[0];

	// Featured type link
	switch($featuredtype){
		case 'image':
		default:
			$featuredLink = '<a href="' . $featuredImgURL . '" class="kwayy_pf_featured" title="' . get_the_title() . '" data-rel="prettyPhoto"><i class="kwicon-fa-image"></i></a>';
			break;
		case 'video':
			$featuredLink = '<a href="' . $videourl . '" class="kwayy_pf_featured" title="' . get_the_title() . '" data-rel="prettyPhoto"><i class="kwicon-fa-video-camera"></i></a>';
			break;
			
		/*case 'videoplayer':
			$embedCodeDiv = '';
			if($videofile_mp4!=''){  $embedCodeDiv .= '<source src="'.$videofile_mp4.'" type="video/mp4">'; }
			if($videofile_webm!=''){ $embedCodeDiv .= '<source src="'.$videofile_webm.'" type="video/webm">'; }
			if($videofile_ogv!=''){  $embedCodeDiv .= '<source src="'.$videofile_ogv.'" type="video/ogg">'; }
			
			if( $embedCodeDiv != '' ){
				$embedCodeDiv = '<div id="kwayy-embed-code-'.get_the_ID().'" class="kwayy-hide"><video width="320" height="240" controls>' . $embedCodeDiv . __('Your browser does not support the video tag.','apicona').' </video></div>';
			} else {
				$embedCodeDiv = '<div id="kwayy-embed-code-'.get_the_ID().'" class="kwayy-hide">' . __('Please add video file in this portfolio.','apicona').'</div>';
			}
			$featuredLink = '<a href="#" class="kwayy_pf_featured" title="' . get_the_title() . '" data-rel="prettyPhoto"><i class="kwicon-videocam-2"></i></a>';
			break;*/
			
		case 'audioembed':
			$embedCodeDiv = '<div id="kwayy-embed-code-'.get_the_ID().'" class="kwayy-hide">'.$audiocode.'</div>';
			$featuredLink = '<a href="#kwayy-embed-code-' . get_the_ID() . '" class="kwayy_pf_featured" title="' . get_the_title() . '" data-rel="prettyPhoto"><i class="kwicon-fa-volume-down"></i></a>';
			break;
			
		/*case 'audioplayer':
			$featuredLink = '#kwayy-embed-code-'.get_the_ID();
			
			$embedCodeDiv = '';
			if($audiofile_mp3!=''){ $embedCodeDiv .= '<source src="'.$videofile_mp3.'" type="video/mp3">'; }
			if($videofile_wav!=''){ $embedCodeDiv .= '<source src="'.$videofile_wav.'" type="video/wav">'; }
			if($videofile_oga!=''){ $embedCodeDiv .= '<source src="'.$videofile_oga.'" type="video/ogg">'; }
			
			if( $embedCodeDiv != '' ){
				$embedCodeDiv = '<div id="kwayy-embed-code-'.get_the_ID().'" class="kwayy-hide"><audio width="320" height="240" controls>' . $embedCodeDiv . __('Your browser does not support the audio element.','apicona').' </audio></div>';
			} else {
				$embedCodeDiv = '<div id="kwayy-embed-code-'.get_the_ID().'" class="kwayy-hide">' . __('Please add video file in this portfolio.','apicona') . '</div>';
			}
			
			$featuredIcon = 'music';  // icon
			break; */
			
		case 'slider':
			$embedCodeDiv = '<div id="#kwayy-embed-code-' . get_the_ID() . '" class="kwayy-hide">';
			$api_images = $api_titles = $api_desc = array();
			for($i=1; $i<=10; $i++){
				$img = get_post_meta( get_the_ID(), '_kwayy_portfolio_featured_slideimage'.$i, true );
				if( $img != '' ){
					$imgdesc      = wp_get_attachment_image_src( $img, 'full' );
					$api_images[] = '"'.$imgdesc[0].'"';
					$api_titles[] = '"' . get_the_title() . '"';
					$api_desc[]   = '""';
				}
			}
			if( count($api_images)>0 ){
				$embedCodeDiv .= '<div class="kwayy-hide kwayy-pf-gallery-content"><script type="text/javascript">';
				//$api_images = implode(',',$api_images);
				$embedCodeDiv .= 'api_images_' . get_the_ID() . ' = [' . implode(',',$api_images) . '];';
				$embedCodeDiv .= 'api_titles_' . get_the_ID() . ' = [' . implode(',',$api_titles) . '];';
				$embedCodeDiv .= 'api_desc_' . get_the_ID() . '   = [' . implode(',',$api_desc) . '];';
				$embedCodeDiv .= '</script></div>';
			}
			$embedCodeDiv .= '</div>';

			$featuredLink = '<a href="#kwayy-embed-code-' . get_the_ID() . '" class="kwayy_pf_featured kwayy-open-gallery" title="' . get_the_title() . '"><i class="kwicon-fa-image"></i></a>';

			break;
	}
	
	
	if( has_post_thumbnail() ){
		$featuredImg = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
	} else {
		$featuredImg = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-image"></i></div>';
	}
	
	$termList = ( is_array($terms) && count($terms)>0 ) ? '<p>'. implode(', ',$terms) .'</p>' : '' ;

	$like = '<!-- Like -->
				<div class="kwayy-portfolio-likes-wrapper">
					<a class="kwayy-portfolio-likes ' . $likeActiveClass . '" href="#" id="pid-' . get_the_ID() . '">
						<i class="'.$likeIconClass.'"></i>&nbsp;' . $likes . '
					</a>
				</div>';
	if( isset($apicona['portfolio_show_like']) && trim($apicona['portfolio_show_like'])=='0' ){
		$like = '';
	}
	
	$return .= '
		<article class="portfolio-box ' . $boxClass . ' ' . implode(' ',$slugs) . ' kwayy-box">
			<div class="item">
				<div class="item-thumbnail">
					' . $featuredImg . '
					<div class="overthumb"></div>
					<div class="icons">
						' . $featuredLink . '
						<a href="' . get_permalink() . '" class="kwayy_pf_link"><i class="kwicon-fa-link"></i></a>
					</div>
				</div>
				<div class="item-content">					
					'.$like.'
					<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>
					' . $termList . '
				</div>
			</div>
			' . $embedCodeDiv . '
		</article>
	';
	
	return $return;
	
}// Function End
}
/**********************************************************************/





/*
 *  Events Box
 */
 if( !function_exists('kwayy_eventsbox') ){
function kwayy_eventsbox( $column='', $design="default" ){
	
	$return = '';
	
	if( !function_exists('tribe_get_start_date') ){
		//return '<br> Events plugin is disabled or not installed. Please install "The Events Calendar" pluign first. <br>';
		return;
	}
	
	
	if( $design=="detailed" ){
		$start_date       = tribe_get_start_date( null, false, 'c' );
		$start_date_date  = tribe_get_start_date( null, false, 'j' );
		$start_date_month = tribe_get_start_date( null, false, 'M' );
		$start_date_year  = tribe_get_start_date( null, false, ', Y' );
		
		
		
		// Date Box
		$title            = '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
		
		$date = '<div class="kwayy-postbox-small-date"><div class="kwayy-post-box-date-wrapper">';
		$date .= sprintf( '<div class="kwayy-entry-date-wrapper">
								<span class="kwayy-entry-date">
									<time class="entry-date" datetime="%1$s" >
										<span class="entry-date">%2$s</span> 
										<span class="entry-month">%3$s</span> 
										<span class="entry-year">%4$s</span> 
									</time>
								</span>
							</div>',
			$start_date,
			$start_date_date,
			$start_date_month,
			$start_date_year
		);
		$date .= '</div></div>';
		
		$featuredLink     = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
		$featuredImgURL   = $featuredLink[0];
		$featuredLinkArea = '';
		$featuredContent  = '';
		
		if( has_post_thumbnail() ){
			$featuredContent = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
		} else {
			$featuredContent = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-image"></i></div>';
		}
		
		
		
		switch($column){
			case 'one':
				$boxClass = 'col-lg-12 col-sm-12 col-md-12 col-xs-12';
				break;
			case 'two':
				$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
				break;
			case 'three':
				$boxClass = 'col-lg-4 col-sm-6 col-md-4 col-xs-12';
				break;
			case 'four':
			default:
				$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
				break;
			case 'five':
				$boxClass = 'col-lg-20percent col-sm-4 col-md-4 col-xs-12';
				break;
			case 'six':
				$boxClass = 'col-lg-2 col-sm-4 col-md-4 col-xs-12';
				break;
			case 'mix':
				$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
				break;
			case 'fix':
				$boxClass = 'blog-slider-box-width';
				break;
		}
		
		
		
		/***************************/
		
		if( has_post_thumbnail() ){
			$featuredImg = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
		} else {
			$featuredImg = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-image"></i></div>';
		}
		
		$slugs = wp_get_post_terms( get_the_ID(), 'category', array("fields" => "slug"));
		$slugs   = implode( ' ', $slugs );
		
		
		/* Short Description */
		$description = '';
		$readMore    = __('See Event', 'apicona') . ' <i class="kwicon-fa-angle-right"></i>';
		if( has_excerpt() ){
			$description  = get_the_excerpt();
			$description .= kwayy_wrap_readmore('<a href="'.get_permalink().'">'.$readMore.'</a>');
		} else {
			//$description = kwayy_string_shorten( get_the_content(), 130 );
			global $more;
			$more = 0;
			$description = get_the_content( $readMore );
			/*$description = apply_filters( 'the_content', get_the_content() );
			$description = str_replace( ']]>', ']]&gt;', $description );*/
		}
		
		$categories_list = get_the_category_list( __( ', ', 'apicona' ) ); // Translators: used between list items, there is a space after the comma.
		$categories_list = ( $categories_list ) ? '<span class="categories-links"><i class="kwicon-fa-folder-open"></i> ' . $categories_list . '</span>' : '' ;
		
		$comments = wp_count_comments(); $comments = $comments->approved; //Get Total Comments
		$commentsCode = '';
		if( $comments > 0 ){
			$commentsCode  = '<span class="comments"><i class="kwicon-fa-comment"></i> '.get_comments_number( 'no comments', '1', '%' ).'</span>';
		}
		 
		 $metaDetails = '';
		 if( $column != 'one' && ($categories_list!='' || $comments!='') ){
			$metaDetails = '<div class="entry-meta kwayy-eventbox-entry-meta"><div class="kwayy-meta-details">' . $categories_list . '</div></div>';
		 }
		
		if( $featuredContent == '' ){
			$featuredContent = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-image"></i></div>';
		}
		
		$return .= '
			<article class="post-box ' . $boxClass . ' ' . $slugs . '">
				<div class="post-item">
					<div class="post-item-thumbnail">
						<div class="post-item-thumbnail-inner">
							'.$date.'
							' . $featuredContent . '
						</div>
						<div class="overthumb"></div>
						' . $featuredLinkArea . '
					</div>
					<div class="item-content">
						'.$title.'
						'.kwayy_event_meta().'
						<div class="kwayy-eventbox-desc">' . $description . '</div>
					</div>
				</div>
			</article>
		';

		
	
	
	
	
	
	
	
	
	
	
	
	
	} else {
		
		
		
		
		
		
		
		
		
		
		switch($column){
			case 'two':
				$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
				break;
			case 'three':
				$boxClass = 'col-lg-4 col-sm-6 col-md-4 col-xs-12';
				break;
			case 'four':
			default:
				$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
				break;
			case 'mix':
				$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
				break;
			case 'fix':
				$boxClass = 'portfolio-slider-box-width';
				break;
		}

		//  Featured Image
		if( has_post_thumbnail() ){
			$featuredImg = '<a href="' . get_permalink() . '">'.get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' ).'</a>';
		} else {
			$featuredImg = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-image"></i></div>';
		}
		
		$price = '';
		if( function_exists('tribe_get_formatted_cost') ){
			$cost = tribe_get_formatted_cost();
			if ( ! empty( $cost ) ){
				$price = '<div class="tribe-events-event-cost"> ' . esc_html( tribe_get_formatted_cost() ) . ' </div>';
			}
		}

		$return .= '
			<article class="events-box ' . $boxClass . ' kwayy-box">
				<div class="item">
					<div class="item-thumbnail">
						' . $price . '
						' . $featuredImg . '
						<!--<div class="overthumb"></div>
						<div class="icons">
							<a href="' . get_permalink() . '" class="kwayy_pf_link"><i class="kwicon-fa-link"></i></a>
						</div> -->
					</div>
					<div class="item-content">					
						<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>
					</div>
				</div>
			</article>
		';
		
		
	
	}
	
	return $return;
	
}// Function End
}





if( !function_exists('kwayy_event_meta') ){
function kwayy_event_meta(){
	$return = '';
	$price = '';
	
	
	$time_format = get_option( 'time_format', TribeDateUtils::TIMEFORMAT );
	$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );

	$start_datetime = tribe_get_start_date();
	$start_date = tribe_get_start_date( null, false );
	$start_time = tribe_get_start_date( null, false, $time_format );
	$start_ts = tribe_get_start_date( null, false, TribeDateUtils::DBDATEFORMAT );

	$end_datetime = tribe_get_end_date();
	$end_date = tribe_get_end_date( null, false );
	$end_time = tribe_get_end_date( null, false, $time_format );
	$end_ts = tribe_get_end_date( null, false, TribeDateUtils::DBDATEFORMAT );
	
	if( function_exists('tribe_get_formatted_cost') ){
		$cost = tribe_get_formatted_cost();
		if ( ! empty( $cost ) ){
			$price = '<span class="tribe-events-event-cost"> ' . esc_html( tribe_get_formatted_cost() ) . ' </span>';
		}
	}
	
	
	
	
	
	$return .= '<div class="kwayy-meta-details kwayy-event-meta-details">';
		
		
		$return .= '<span class="kwayy-event-meta-item kwayy-event-date"> ';
		
			$return .= '<i class="kwicon kwicon-fa-clock-o"></i> ';
			// All day (multiday) events
			if ( tribe_event_is_all_day() && tribe_event_is_multiday() ){
				

				$return .= '
					<span class="kwayy-event-meta-dtstart" title="' . esc_attr__( $start_ts ) . '"> ' .  esc_html__( $start_date ) . ' </span> - 
					<span class="kwayy-event-meta-dtend" title="' . esc_attr__( $end_ts ) . '"> ' . esc_html__( $end_date ) . ' </span>';

			
			// All day (single day) events
			} elseif ( tribe_event_is_all_day() ){
				$return .= '<span class="kwayy-event-meta-onedate" title="'. esc_attr__( $start_ts ) . '"> ' . esc_html__( $start_date ) . '</span>';

			
			// Multiday events
			} elseif ( tribe_event_is_multiday() ){
				
				$return .= '<span class="kwayy-event-meta-dtstart" title="' . esc_attr__( $start_ts ) . '"> ' . esc_html__( $start_datetime ) . ' </span> - ';
				$return .= '<span class="kwayy-event-meta-dtend" title="' . esc_attr__( $end_ts ) . '"> ' .  esc_html__( $end_datetime ) .' </span>';


			// Single day events
			} else {
				
				$return .= '<span class="kwayy-event-meta-dtstart" title="' . esc_attr__( $start_ts ) . '"> ' . esc_html__( $start_date ) . ' </span> - ';

				$return .= '<span class="kwayy-event-meta-dtend" title="' . esc_attr__( $end_ts ) . '">';
					if ( $start_time == $end_time ) {
						$return .= esc_html__( $start_time );
					} else {
						$return .= esc_html__( $start_time . $time_range_separator . $end_time );
					}

				$return .=' </span>';
			}
			
		$return .=' </span>';
		
		
		
		
		
		
		
		$return .= '
			&nbsp;&nbsp; <span class="kwayy-event-meta-item kwayy-event-price">
				'.$price.'
			</span>';
		
		
		
		
	$return .= '</div>';
	
	return $return;
}
}





/************************ Sortable List for IsoTOPE *****************************/
if( !function_exists('kwayy_create_sortable_menu') ){
function kwayy_create_sortable_menu( $list = array() ){
	if( is_array($list) && count($list)>0 ){
		
		$sortablelist = '<div class="container"><nav class="portfolio-sortable-list container"><ul class="col-xs-12">';
		$sortablelist .= '<li><a class="selected" href="#" data-filter="*">'._('All').'</a></li>';
		
		foreach($list as $slug=>$name){
			//var_dump($slug);
			$sortablelist .= '<li><a href="#" data-filter=".'.$slug.'">'.$name.'</a></li>';
		}
		
		$sortablelist .= '</ul></nav></div>';
		
		return $sortablelist;
		
	}
}
}
/********************************************************************************/










/************************ Testimonial Box *****************************/
if( !function_exists('kwayy_testimonialbox') ){
function kwayy_testimonialbox( $column='' ){
	$return      = '';
	$clienturl   = trim(get_post_meta( get_the_id(), '_kwayy_testimonials_details_clienturl', true ));
	$designation = trim(get_post_meta( get_the_id(), '_kwayy_testimonials_details_designation', true ));
	
	$boxClass = '';
	
	switch($column){
		case 'one':
			$boxClass = 'col-lg-12 col-sm-12 col-md-12 col-xs-12';
			break;
		case 'two':
			$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
			break;
		case 'three':
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
	
	$return .= "\n\t".'<div class="kwayy-testimonial-box '.$boxClass.'">';
		
		$return .= '<div class="kwayy-testimonial-data">';
		
		$iconCode = ( has_post_thumbnail() ) ? '<div class="kwayy-testimonial-img">'.get_the_post_thumbnail( get_the_id(), 'thumbnail' ).'</div>'  :  '<span class="kwayy-testimonial-icon"><i class="kwicon-fa-quote-left"></i></span>';
		
		$return .= '<blockquote class="kwayy-testimonial-text">
				<div class="contarea">					
					<div class="kwayy-tst-contarea-text">'.get_the_content('').'</div>
					
				</div>';
		$return .= '<footer>';
		
		$return .= ' '.$iconCode.' ';
		$return .= '<cite class="kwayy-testimonial-title">';
		$return .= ( $clienturl!='' ) ? '<a href="' . $clienturl . '" target="_blank">' . get_the_title() . '</a>' : get_the_title() ;
		$return .= ( $designation!='' ) ? '<span class="kwayy-testimonial-designation">'.$designation.'</span>' : '' ;
		$return .= '</cite></footer>';
		$return .= '</blockquote>';
		
		
		
		$return .= '</div>';
	$return .= "\n\t".'</div>';
	
	return $return;
}
}
/**********************************************************************/






/************************ Team Member Box *****************************/
if( !function_exists('kwayy_teammemberbox') ){
function kwayy_teammemberbox( $column='' ){
	global $post;
	$return   = '';
	$position = trim(get_post_meta( get_the_id(), '_kwayy_team_member_details_position', true ));
	
	$content  = trim($post->post_content);
	$excerpt  = trim($post->post_excerpt);
	
	if( $content!='' && $excerpt!='' ){
		$title = '<a href="'.get_permalink( get_the_ID() ).'">'.get_the_title().'</a>';
	} else {
		$title = get_the_title();
	}
	
	$boxClass = '';
	switch($column){
		case 'one':
			$boxClass = 'col-lg-12 col-sm-12 col-md-12 col-xs-12';
			break;
		case 'two':
			$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
			break;
		case 'three':
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
	
	
	if( trim($position)!='' ){ $position = '<h4 class="kwayy-team-position">'.__($position, 'apicona').'</h4>'; }
	//if( trim($email)   !='' ){ $email = '<span class="kwayy-team-email"><a href="mailto:'.$email.'">'.$email.'</a></span>'; }
	//if( trim($email)   !='' ){ $email = '<div class="overthumb"></div><div class="kwayy-team-icons"><a href="mailto:'.$email.'" class="kwayy-team-email"><i class="kwicon-fa-envelope-o"></i></a></div>'; }
	
	
	// NEW
	
	$cat_list = wp_get_post_terms( get_the_ID(), 'team_group' );
	$catHTML = '';
	//var_dump($cat_list);
	$x='1';
	foreach($cat_list as $cat){
		$catHTML .= '<span class="tm-term-group tm-term-'.$cat->slug.'">';
			$catHTML .= '<span class="tm-term-sep"> &nbsp; &middot; &nbsp; </span>';
			$catHTML .= '<a href="'.get_term_link($cat, 'term_group').'">'.$cat->name.'</a>';
		$catHTML .= '</span>';
		$x='2';
	}
	//var_dump($catHTML);
	
	////////////////////////////////////
	
	// Team Group
	$categories_list = get_the_term_list( get_the_ID(), 'team_group', '', __( ' &nbsp; &middot; &nbsp; ', 'apicona' ) );
	
	$categories_list = $catHTML;
	
	if( $categories_list!='' ){
		$categories_list = '<div class="kwayy-team-cat-links">'.$categories_list.'</div>';
	}
	
	
	
	/*$facebook   = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_facebook', true ));
	$twitter    = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_twitter', true ));
	$linkedin   = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_linkedin', true ));
	$googleplus = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_googleplus', true ));
				
	$socialcode = '';
	if($facebook!=''){   $socialcode .= '<li class="kwayy-social-facebook"><a href="'.$facebook.'"><i class="kwicon-fa-facebook"></i></a></li>'; }
	if($twitter!=''){    $socialcode .= '<li class="kwayy-social-twitter"><a href="'.$twitter.'"><i class="kwicon-fa-twitter"></i></a></li>'; }
	if($linkedin!=''){   $socialcode .= '<li class="kwayy-social-linkedin"><a href="'.$linkedin.'"><i class="kwicon-fa-linkedin"></i></a></li>'; }
	if($googleplus!=''){ $socialcode .= '<li class="kwayy-social-gplus"><a href="'.$googleplus.'"><i class="kwicon-fa-google-plus"></i></a></li>'; }
	if($email!=''){      $socialcode .= '<li class="kwayy-social-email"><a href="mailto:'.$email.'"><i class="kwicon-fa-envelope-o"></i></a></li>'; }
	if($socialcode!=''){ $socialcode = '<div class="kwayy-team-social-links"><ul>'.$socialcode.'</ul></div>'; }*/
	
	$socialcode = kwayy_team_social();

	$return .= "\n\t".'<div class="kwayy-team-box '.$boxClass.'">';
		$return .= '<div class="kwayy-team-img">';
			//$return .= $socialcode;
			if( has_post_thumbnail() ){ $return .= get_the_post_thumbnail( get_the_id(), 'full' ); }
		//$return .= '<div class="icons"><a href="#" class="kwayy_pf_featured"><i class="kwicon-mail"></i></a></div></div><!-- .kwayy-team-img -->';
		//$return .= $email;
		$return .= '<div class="overthumb"></div>';
		$return .= $socialcode;
		$return .= '</div><!-- .kwayy-team-img -->';
		$return .= '<div class="kwayy-team-data">';
			$return .= '<h3 class="kwayy-team-title">'.$title.'</h3>';
			$return .= $position;
			$return .= get_the_excerpt();
			$return .= $categories_list;
			
		$return .= '</div>';
	$return .= "\n\t".'</div>';
	return $return;
}
}

if( !function_exists('kwayy_team_social') ){
function kwayy_team_social( $column='' ){
	$facebook   = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_facebook', true ));
	$twitter    = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_twitter', true ));
	$linkedin   = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_linkedin', true ));
	$googleplus = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_googleplus', true ));
	$email      = trim(get_post_meta( get_the_id(), '_kwayy_team_member_details_email', true ));
	
	$socialcode = '';
	if($facebook!=''){   $socialcode .= '<li class="kwayy-social-facebook"><a href="'.$facebook.'" target="_blank"><i class="kwicon-fa-facebook"></i></a></li>'; }
	if($twitter!=''){    $socialcode .= '<li class="kwayy-social-twitter"><a href="'.$twitter.'" target="_blank"><i class="kwicon-fa-twitter"></i></a></li>'; }
	if($linkedin!=''){   $socialcode .= '<li class="kwayy-social-linkedin"><a href="'.$linkedin.'" target="_blank"><i class="kwicon-fa-linkedin"></i></a></li>'; }
	if($googleplus!=''){ $socialcode .= '<li class="kwayy-social-gplus"><a href="'.$googleplus.'" target="_blank"><i class="kwicon-fa-google-plus"></i></a></li>'; }
	if($email!=''){      $socialcode .= '<li class="kwayy-social-email"><a href="mailto:'.$email.'" target="_blank"><i class="kwicon-fa-envelope-o"></i></a></li>'; }
	if($socialcode!=''){ $socialcode = '<div class="kwayy-team-social-links"><ul>'.$socialcode.'</ul></div>'; }
	
	return $socialcode;
}
}
/**********************************************************************/






/*************************** Blog Box ****************************/
if( !function_exists('kwayy_blogbox') ){
function kwayy_blogbox( $column='' ){
	global $apicona;
	$return = '';
	
	// Getting Post Format
	$format = get_post_format();
	
	if( $format == false || $format == '' ){
		$format = 'standard';
	}
	
	// Date Box
	$title            = '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
	$date             = '<div class="kwayy-postbox-small-date">'.kwayy_entry_box_date(false).'</div>';
	$featuredLink     = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );
	$featuredImgURL   = $featuredLink[0];
	$featuredLinkArea = '';
	$featuredContent  = '';
	
	if( has_post_thumbnail() ){
		$featuredContent = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
	} else {
		$featuredContent = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-image"></i></div>';
	}
	
	switch( $format ){
		case 'standard':
		default:
			if( has_post_thumbnail() ){
				$featuredContent = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
			} else {
				$featuredContent = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-image"></i></div>';
			}
			break;
		case 'quote':
			$title = '';
			if( !has_post_thumbnail() ){
				$featuredContent = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-quote-left"></i></div>';
			}
			break;
		case 'video':
			$videocode = trim( get_post_meta( get_the_ID(), '_format_video_embed', true) );
			if( $videocode!='' ){
				$featuredContent = wp_oembed_get($videocode);
				if( $featuredContent!=false ){
					$featuredContent = wp_oembed_get($videocode);
				} else {
					$featuredContent = $videocode;
				}
			}
			$featuredLinkArea = '';
			break;
			
		case 'audio':
			$audiocode = trim( get_post_meta( get_the_ID(), '_format_audio_embed', true) );
			if( $audiocode!='' ){
				$featuredContent = wp_oembed_get($audiocode);
				if( $featuredContent!=false ){
					$featuredContent = wp_oembed_get($audiocode);
				} else {
					$featuredContent = $audiocode;
				}
			}
			$featuredLinkArea = '';
			break;
			
		case 'gallery':
			$featuredContent = kwayy_featured_gallery_slider('post');
			if( $featuredContent=='' ){
				if( has_post_thumbnail() ){
					$featuredContent = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
				} else {
					$featuredContent = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-image"></i></div>';
				}
			} else {
				$featuredLinkArea = '';
			}
			break;
	}
	
	
	switch($column){
		case 'one':
			$boxClass = 'col-lg-12 col-sm-12 col-md-12 col-xs-12';
			break;
		case 'two':
			$boxClass = 'col-lg-6 col-sm-6 col-md-6 col-xs-12';
			break;
		case 'three':
			$boxClass = 'col-lg-4 col-sm-6 col-md-4 col-xs-12';
			break;
		case 'four':
		default:
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'five':
			$boxClass = 'col-lg-20percent col-sm-4 col-md-4 col-xs-12';
			break;
		case 'six':
			$boxClass = 'col-lg-2 col-sm-4 col-md-4 col-xs-12';
			break;
		case 'mix':
			$boxClass = 'col-lg-3 col-sm-6 col-md-3 col-xs-12';
			break;
		case 'fix':
			$boxClass = 'blog-slider-box-width';
			break;
	}
	
	// Adding Post format class to box
	$boxClass .= ' kwayy-blogbox-format-'.$format;
	
	
	
	
	/***************************/
	
	if( has_post_thumbnail() ){
		$featuredImg = get_the_post_thumbnail( get_the_ID(), 'portfolio-'.$column.'-column' );
	} else {
		$featuredImg = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-image"></i></div>';
	}
	
	$slugs = wp_get_post_terms( get_the_ID(), 'category', array("fields" => "slug"));
	$slugs   = implode( ' ', $slugs );
	
	
	/* Short Description */
	$description = '';
	$readMore    = __('Read More', 'apicona') . '<i class="kwicon-fa-angle-right"></i>';
	if( isset( $apicona['blog_text_limit'] ) && $apicona['blog_text_limit']>0 ){
		$description  = kwayy_get_short_desc();
		$description .= kwayy_wrap_readmore('<a href="'.get_permalink().'">'.$readMore.'</a>');
	} else if( has_excerpt() ){
		$description  = get_the_excerpt();
		$description  = do_shortcode($description);
		$description .= kwayy_wrap_readmore('<a href="'.get_permalink().'">'.$readMore.'</a>');
	} else {
		//$description = kwayy_string_shorten( get_the_content(), 130 );
		global $more;
		$more = 0;
		$description = get_the_content( $readMore );
		/*$description = apply_filters( 'the_content', get_the_content() );
		$description = str_replace( ']]>', ']]&gt;', $description );*/
	}
	
	$categories_list = get_the_category_list( __( ', ', 'apicona' ) ); // Translators: used between list items, there is a space after the comma.
	$categories_list = ( $categories_list ) ? '<span class="categories-links"><i class="kwicon-fa-folder-open"></i> ' . $categories_list . '</span>' : '' ;
	
	$comments = wp_count_comments(); $comments = $comments->approved; //Get Total Comments
	$commentsCode = '';
	if( $comments > 0 ){
		$commentsCode  = '<span class="comments"><i class="kwicon-fa-comment"></i> '.get_comments_number( 'no comments', '1', '%' ).'</span>';
	}
	 
	 $metaDetails = '';
	 if( $column != 'one' && ($categories_list!='' || $comments!='') ){
		$metaDetails = '<div class="entry-meta kwayy-blogbox-entry-meta"><div class="kwayy-meta-details">' . $categories_list . '</div></div>';
	 }
	
	if( $featuredContent == '' ){
		$featuredContent = '<div class="kwayy-proj-noimage"><i class="kwicon-fa-image"></i></div>';
	}
	
	$return .= '
		<article class="post-box ' . $boxClass . ' ' . $slugs . '">
			 <a href="'.get_permalink( get_the_ID() ).'" >
			<div class="post-item">
				<div class="post-item-thumbnail">
					<div class="post-item-thumbnail-inner">
						'.$date.'
						<div class="item-thumbnail">
							' . $featuredContent . '
						</div>
					</div>
					<div class="overthumb"></div>
					' . $featuredLinkArea . '
				</div>
				<div class="item-content">
					'.$title.'
					'.kwayy_entry_meta(false).'
					<div class="kwayy-blogbox-desc">' . $description . '</div>
				</div>
			</div>
			</a>
		</article>
	';

	
	return $return;
	
}// Function End
}
/**********************************************************************/





function kwayy_get_short_desc(){
	global $apicona;
	$content = '';
	if( isset( $apicona['blog_text_limit'] ) && $apicona['blog_text_limit']>0 ){
		$content = get_the_content('',FALSE,'');
		$content = wp_strip_all_tags($content);
		$content = strip_shortcodes($content);
		$content = str_replace(']]>', ']]>', $content);
		$content = substr($content,0, $apicona['blog_text_limit'] );
		$content = trim(preg_replace( '/\s+/', ' ', $content));
		$content = $content.'...';
	}
	return $content;
}





/**********************  ************************/
if( !function_exists('kwayy_string_shorten') ){
function kwayy_string_shorten($text, $char) {
	$text = substr($text, 0, $char); //First chop the string to the given character length
	if(substr($text, 0, strrpos($text, ' '))!='') $text = substr($text, 0, strrpos($text, ' ')); //If there exists any space just before the end of the chopped string take upto that portion only.
	//In this way we remove any incomplete word from the paragraph
	$text = $text.'...'; //Add continuation ... sign
	return $text; //Return the value
}
}
/*****************************************************************/




if( !function_exists('kwayy_addhttp') ){
	function kwayy_addhttp($url){
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)){
			$url = "http://" . $url;
		}
		return $url;
	}
}





if( !function_exists('kwayy_buildStyle') ){
function kwayy_buildStyle($bg_image = '', $bg_color = '', $bg_image_repeat = '', $font_color = '', $padding_top = '', $padding_bottom = '', $margin_bottom = '', $margin_top = '') {
	$has_image = false;
	$style = '';
	if((int)$bg_image > 0 && ($image_url = wp_get_attachment_url( $bg_image, 'large' )) !== false) {
		$has_image = true;
		$style .= "background-image: url(".$image_url.");";
	}
	if(!empty($bg_color)) {
		$style .= 'background-color: '.$bg_color.';';
	}
	if(!empty($bg_image_repeat) && $has_image) {
		if($bg_image_repeat === 'cover') {
			$style .= "background-repeat:no-repeat;background-size: cover;";
		} elseif($bg_image_repeat === 'contain') {
			$style .= "background-repeat:no-repeat;background-size: contain;";
		} elseif($bg_image_repeat === 'no-repeat') {
			$style .= 'background-repeat: no-repeat;';
		}
	}
	if( !empty($font_color) ) {
		$style .= 'color: '.$font_color.';';
	}
	if( $padding_top != '' ) {
		$style .= 'padding-top: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_top) ? $padding_top : $padding_top.'px').';';
	}
	if( $padding_bottom != '' ) {
		$style .= 'padding-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $padding_bottom) ? $padding_bottom : $padding_bottom.'px').';';
	}
	if( $margin_bottom != '' ) {
		$style .= 'margin-bottom: '.(preg_match('/(px|em|\%|pt|cm)$/', $margin_bottom) ? $margin_bottom : $margin_bottom.'px').';';
	}
	if( $margin_top != '' ) {
		$style .= 'margin-top: '.(preg_match('/(px|em|\%|pt|cm)$/', $margin_top) ? $margin_top : $margin_top.'px').';';
	}
	return empty($style) ? $style : ' style="'.$style.'"';
}
}





/******************** CSS Parser *********************/

function kwayyCheckBGImage($css){
	$return = false;
	
	if( trim($css)!='' ){
		
		// Check if background image exists
		$newCSS = str_replace( 'http://', 'http//', $css );

		// Removing breackets
		$newCSS = explode('{', $newCSS);
		$newCSS = explode('}', $newCSS[1]);
		$newCSS = $newCSS[0];

		// Filtering background properties
		$newCSS = explode(';', $newCSS);

		foreach( $newCSS as $css ){
			$x = '';
			$x = explode(':', $css);
			if( $x[0] == 'background' ){
				if (strpos($x[1] , 'url(') !== false) {
					$return = true;
				}
			} else if( $x[0] == 'background-image' ){
				$return = true;
			}
		}
	}
	
	return $return;
}

/******************************************************/







/* Minifier */
//minifiter-library

function tm_minifier($type='js',$list_array){
	
	global $apicona;
	
	//$library = ( isset($apicona['minifiter-library']) && trim($apicona['minifiter-library'])!='' ) ? $apicona['minifiter-library'] : 'internal' ;
	
	//if( $library=='internal' ){
		
		if( $type=='js' ){
			include_once('redux-framework/redux_custom_fields/kwayy_min_generator/jsmin.php');
			// Processing JS with internal
			foreach($list_array as $js_input => $js_output ){
				
				if( file_exists($js_input) ){
					$js_input = file_get_contents($js_input);
					$js_input = JSMin::minify($js_input);
					$output   = $js_input;
					$fp       = fopen($js_output, "w");
					fwrite($fp, $output, strlen($output));
					fclose($fp);
				}
				
			}
			//var_dump('DONE JS Internal...');

		} else if( $type=='css' ){
			// Processing CSS with internal
			foreach($list_array as $css_input => $css_output ){
				
				if( file_exists($css_input) ){
					
					$buffer = file_get_contents($css_input);
					
					// Remove comments
					$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

					// Remove space after colons
					$buffer = str_replace(': ', ':', $buffer);

					// Remove whitespace
					$buffer = str_replace(array("\r\n", "\r", "\n", "\t"), '', $buffer);

					// Collapse adjacent spaces into a single space
					$buffer = ereg_replace(" {2,}", ' ',$buffer);

					// Remove spaces that might still be left where we know they aren't needed
					$buffer = str_replace(array('} '), '}', $buffer);
					$buffer = str_replace(array('{ '), '{', $buffer);
					$buffer = str_replace(array('; '), ';', $buffer);
					$buffer = str_replace(array(', '), ',', $buffer);
					$buffer = str_replace(array(' }'), '}', $buffer);
					$buffer = str_replace(array(' {'), '{', $buffer);
					$buffer = str_replace(array(' ;'), ';', $buffer);
					$buffer = str_replace(array(' ,'), ',', $buffer);

					// Saving file
					$output   = $buffer;
					$fp       = fopen($css_output, "w");
					fwrite($fp, $output, strlen($output));
					fclose($fp);
				}
			}
			
			
		}
		
	/*} else {
		
		include_once('redux-framework/redux_custom_fields/thememount_min_generator/minifier.php');
		
		if( $type=='js' ){
			
			// Processing JS with external
			ob_start();
			minifyJS($list_array);
			ob_get_clean();

			
		} else if( $type=='css' ){
			
			// Processing CSS with external
			ob_start();
			minifyCSS($list_array);
			ob_get_clean();
			
			die('CSS External PROCESSED....');
			
		}

	}*/
	
	
	
};

