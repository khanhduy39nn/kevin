<?php

// [team show="0"]
if( !function_exists('kwayy_sc_team') ){
function kwayy_sc_team($atts, $content=NULL ) {
	extract( shortcode_atts( array(
		'title'     => '',
		'subtitle'  => '',
		'align'     => 'left',
		'groupslug' => '',
		'show'      => '4',
		'column'    => 'four',
		'view'      => '',
		'carousel_autoplay' => '1',
		//'style'   => 'default'
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
	
	$return = '';
	$width  = kwayy_translateColumnWidthToSpan($column);
	
	$args = array(
		'post_type'      => 'team_member',
		'posts_per_page' => $show,
	);
	
	// Creating array for multiple groupslug
	if(strpos($groupslug, ',') !== false) {
		$groupslug = explode(',',$groupslug);
	}
	
	
	// Group
	if( $groupslug!='' || is_array($groupslug) ){
		$args['tax_query'] = array(
								array(
									'taxonomy' => 'team_group',
									'field' => 'slug',
									'terms' => $groupslug
								),
							);
	}
	
	
	$results = new WP_Query( $args );
	
	// The Loop
	if ( $results->have_posts() ) {
		$return .= "\n\t".'<div class="kwayy-team-wrapper kwayy-effect-'.$view.' kwayy-items-col-'.$column.' '.$itemCol.'" '.$datatags.'>';
		if( trim($title)!='' ){
			$return .= "\n\t" . do_shortcode('[heading text="'.$title.'" subtext="'.do_shortcode($subtitle).'" tag="h2" '.$headerCarslBtn.' style="linedot" align="'.$align.'"]');
		}
		$return .= '<div class="'.$rowClass.' kwayy-items-wrapper '.$itemWrapper.'">';
		
		while ( $results->have_posts() ) {
			$results->the_post();
			
			$return .= kwayy_teammemberbox( $boxwidth );
			
		}
		$return .= "\n\t".'</div></div>';
	} else {
		// no posts found
	}
	
	
	
	/*
	$results = new WP_Query( $args );
	
	// The Loop
	
	$return .= '<div class="'.$rowClass.' kwayy-items-wrapper '.$itemWrapper.'">';
	
	if ( $results->have_posts() ) {
		$return .= "\n\t".'<div class="kwayy-team-wrapper container">';
		//$return .= ($style=='default') ? '<ul class="row">' : '<ul class="tm-grid">' ;
		$return .= '<ul class="row">';
		
		while ( $results->have_posts() ) {
			$results->the_post();
			global $post;
			
			$position = trim(get_post_meta( get_the_id(), '_kwayy_team_member_details_position', true ));
			$email    = trim(get_post_meta( get_the_id(), '_kwayy_team_member_details_email', true ));
			$content  = trim($post->post_content);
			$excerpt  = trim($post->post_excerpt);
			
			if( $content!='' && $excerpt!='' ){
				$title = '<a href="'.get_permalink( get_the_ID() ).'">'.get_the_title().'</a>';
			} else {
				$title = get_the_title();
			}
			
			if( trim($position)!='' ){ $position = '<h4 class="kwayy-team-position">'.$position.'</h4>'; }
			//if( trim($email)   !='' ){ $email = '<span class="kwayy-team-email"><a href="mailto:'.$email.'">'.$email.'</a></span>'; }
			//if( trim($email)   !='' ){ $email = '<div class="overthumb"></div><div class="kwayy-team-icons"><a href="mailto:'.$email.'" class="kwayy-team-email"><i class="kwicon-fa-envelope-o"></i></a></div>'; }
			
			
			$facebook   = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_facebook', true ));
			$twitter    = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_twitter', true ));
			$linkedin   = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_linkedin', true ));
			$googleplus = trim(get_post_meta( get_the_id(), '_kwayy_team_member_social_links_googleplus', true ));
						
			$socialcode = '';
			if($facebook!=''){   $socialcode .= '<li class="kwayy-social-facebook"><a href="'.$facebook.'"><i class="kwicon-fa-facebook"></i></a></li>'; }
			if($twitter!=''){    $socialcode .= '<li class="kwayy-social-twitter"><a href="'.$twitter.'"><i class="kwicon-fa-twitter"></i></a></li>'; }
			if($linkedin!=''){   $socialcode .= '<li class="kwayy-social-linkedin"><a href="'.$linkedin.'"><i class="kwicon-fa-linkedin"></i></a></li>'; }
			if($googleplus!=''){ $socialcode .= '<li class="kwayy-social-gplus"><a href="'.$googleplus.'"><i class="kwicon-fa-google-plus"></i></a></li>'; }
			if($email!=''){      $socialcode .= '<li class="kwayy-social-email"><a href="mailto:'.$email.'"><i class="kwicon-fa-envelope-o"></i></a></li>'; }
			if($socialcode!=''){ $socialcode = '<div class="kwayy-team-social-links"><ul>'.$socialcode.'</ul></div>'; }
			
		
			$return .= "\n\t".'<li class="kwayy-team-box '.$width.'">';
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
					
				$return .= '</div>';
			$return .= "\n\t".'</li>';

			
		}
		$return .= "\n\t".'</ul></div>';
	} else {
		// no posts found
	}
	
	$return .= '</div>';
	
	*/
	
	
	
	/* Restore original Post Data */
	wp_reset_postdata();
	
	return $return;
}
}
add_shortcode( 'team', 'kwayy_sc_team' );