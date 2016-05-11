<?php
// SHORTCODE DISPLAYING THE GRID

// [mediagrid] 
function mg_shortcode( $atts, $content = null ) {
	include_once(MG_DIR . '/functions.php');
	include_once(MG_DIR . '/classes/overlay_manager.php');
	
	extract( shortcode_atts( array(
		'cat' 			=> '',
		'filter' 		=> 0,
		'r_width' 		=> 'auto',
		'title_under' 	=> 0,
		'filters_align' => 'top',
		'hide_all' 		=> 0,
		'def_filter' 	=> 0,
		'search'		=> 0,
		'overlay'		=> 'default'
	), $atts ) );

	if($cat == '') {return '';}
	
	$grid_data = mg_get_grid_data($cat); 
	if(!is_array($grid_data['items']) || !count($grid_data['items'])) {return '';}
	
	
	// search code template
	if($search) {
		$search_code ='
		<form id="mgs_'.$cat.'" class="mgf_search_form">
			<input type="text" value="" placeholder="'. __('search', 'mg_ml') .' .." autocomplete="off" />
			<i class="fa fa-search"></i>
		</form>';
	} 
	else {$search_code = '';}
	
	
	// filters management
	if($filter) {
		$filters_code = mg_grid_terms_data($grid_data['cats'], 'html', $filters_align, $def_filter, $hide_all);
		
		if($filters_code) {
			$filter_type = (get_option('mg_use_old_filters')) ? 'mg_old_filters' : 'mg_new_filters';
			$desktop_filters = '<div id="mgf_'.$cat.'" class="mg_filter '.$filter_type.'">'. $filters_code .'</div>';
		
			// mobile dropdown 
			if(get_option('mg_dd_mobile_filter')) {
				$filters_code = mg_grid_terms_data($grid_data['cats'], 'dropdown', $filters_align, $def_filter, $hide_all);
				$mobile_filters = '<div id="mgmf_'.$cat.'" class="mg_mobile_filter">'. $filters_code .'<i></i></div>';
			}
			
			// filters align class and code composition
			switch($filters_align) {
				case 'left' : 
					$filter_align_class = 'mg_left_col_filters'; 
					$pre_grid_filters = $desktop_filters  . $mobile_filters . $search_code;
					$after_grid_filters = '';
					break;
					
				case 'right' : 
					$filter_align_class = 'mg_right_col_filters'; 
					$pre_grid_filters = $mobile_filters . $search_code;
					$after_grid_filters = $desktop_filters;
					break;
					
				default : 
					$filter_align_class = 'mg_top_filters';
					$pre_grid_filters =  $desktop_filters . $mobile_filters . $search_code .'<div style="clear: both;"></div>';
					$after_grid_filters = ''; 
					break;	
			}
		}
	}
	else {
		$pre_grid_filters = $search_code;
		$after_grid_filters = ''; 
		$filter_align_class = 'mg_no_filters';
	}


	// deeplinking class
	$dl_class = (get_option('mg_disable_dl')) ? '' : 'mg_deeplink'; 
	
	// search box class
	$search_box_class = ($search) ? 'mg_has_search' : '';
	
	// has pages class
	$has_pag_class = mg_grid_has_pag($grid_data['items']) ? 'mg_has_pag' : '';
	
	### init
	$grid = '<div id="mg_wrap_'.$cat.'" class="mg_grid_wrap '.$dl_class.' '.$search_box_class.' '.$filter_align_class.' '.$has_pag_class.'">' . $pre_grid_filters;

	// title under - wrap class
	$tit_under_class = ($title_under == 1) ? 'mg_grid_title_under' : '';
	
	// image overlay code 
	$ol_man = new mg_overlay_manager($overlay, $title_under);
	
	// pagination 
	$curr_pag = 1;
	
	// grid container
	$grid .= '<div id="mg_grid_'.$cat.'" class="mg_container '.$tit_under_class.' '.$search_box_class.' '.$ol_man->txt_vis_class.'" rel="'.$r_width.'" mg-pag="'.$curr_pag.'" '.$ol_man->img_fx_attr.'>' . mg_preloader();
	
	/////////////////////////
	// grid contents
		
	$max_width = get_option('mg_maxwidth', 1200);
	$mobile_treshold = get_option('mg_mobile_treshold', 800);
	$thumb_q = get_option('mg_thumb_q', 85);

	foreach($grid_data['items'] as $item) {
		$post_id = $item['id'];
		
		// pagination management
		if($post_id == 'paginator') {
			$curr_pag++;
			continue;	
		}
		
		// WPML - check translation
		if(function_exists('icl_object_id') ) {
			$post_id = icl_object_id($post_id, 'mg_items', true);	
		}
		
		// get main type
		$main_type = get_post_meta($post_id, 'mg_main_type', true);
		
		// check post status
		if(get_post_status($post_id) != 'publish') {continue;}
		
		// term classes, for filters - set before "post contents" post_id change
		$term_classes = mg_item_terms_classes($post_id);
		
		// post contents - get related post data
		if($main_type == 'post_contents') {
			$post = mg_post_contents_get_post($post_id);
			if(!$post) {continue;}
			
			$pc_direct_link = get_post_meta($post_id, 'mg_link_to_post', true);
			$lb_post_id = $post_id;
			$post_id = $post->ID;
		}
		else {
			$pc_direct_link = false;
			$lb_post_id = $post_id;
		}
		
		// woocomm
		if(get_post_type($post_id) == 'product') {$main_type = 'woocom';} 


		// image-based operations
		if($main_type != 'spacer') {
			// thumbs image size
			$thb_w = ceil($max_width * mg_size_to_perc($item['w']));
			$thb_h = ceil($max_width * mg_size_to_perc($item['h']));
			
			if(!isset($item['m_w'])) {
				$item['m_w'] = $item['w'];
				$item['m_h'] = $item['h'];
			}
			$m_thb_w = ceil($mobile_treshold * mg_size_to_perc($item['m_w']));
			$m_thb_h = ceil($mobile_treshold * mg_size_to_perc($item['m_h']));
			
			
			if(!in_array($main_type, array('inl_slider', 'inl_text'))) {
				// thumb url and center
				$img_id = get_post_thumbnail_id($post_id);
				$thumb_center = (get_post_meta($post_id, 'mg_thumb_center', true)) ? get_post_meta($post_id, 'mg_thumb_center', true) : 'c'; 
				
				if($img_id) {
					// main thumb
					if($item['h'] != 'auto') {
						$thumb_url = mg_thumb_src($img_id, $thb_w, $thb_h, $thumb_q, $thumb_center);
					} else {
						$thumb_url = mg_thumb_src($img_id, $thb_w, false, $thumb_q, $thumb_center);
					}
					
					// mobile thumb
					if($item['m_h'] != 'auto') {
						$mobile_url = mg_thumb_src($img_id, $m_thb_w, $m_thb_h, $thumb_q, $thumb_center);
					} else {
						$mobile_url = mg_thumb_src($img_id, $m_thb_w, false, $thumb_q, $thumb_center);
					}
				}
				else {
					$thumb_url = '';
					$mobile_url = '';	
				}
			}
			
			
			// item title
			$item_title = get_the_title($post_id);
			
			// image ALT attribute
			$img_alt = strip_tags( mg_sanitize_input($item_title) );
			
			// title under switch
			if($title_under == 1) {
				$img_ol = '<div class="overlays">' . $ol_man->get_img_ol($post_id) . '</div>';
				$txt_under = $ol_man->get_txt_under($post_id);
			} 
			else {
				$img_ol = '<div class="overlays">' . $ol_man->get_img_ol($post_id) . '</div>';
				$txt_under = '';
			}
			
			// image proportions for the "auto" height
			if(($item['h'] == 'auto' || $item['m_h'] == 'auto') && $main_type != 'inl_text') {
				$img_info = wp_get_attachment_image_src($img_id, 'full');
				$ratio_val = (float)$img_info[2] / (float)$img_info[1];
				$ratio = 'ratio="'.$ratio_val.'"';
			} else {
				$ratio = '';	
			}
		}
		
		
		////////////////////////////
		/*** item types ***/
		
		// type class
		switch($main_type) {
			case 'single_img'	: $type_class = 'mg_image'; break;	
			case 'img_gallery'	: $type_class = 'mg_gallery'; break;	
			case 'simple_img'	: $type_class = 'mg_static_img'; break;
			default 			: $type_class = 'mg_' . $main_type; break;	 
		}
		
		// transitions class
		$trans_class = (!in_array($main_type, array('inl_slider','inl_video','inl_audio','inl_text','spacer'))) ? 'mg_transitions' : '';
		
		// lightbox trigger class
		$lb_class = (!in_array($main_type, array('single_img','img_gallery','video','audio','lb_text', 'post_contents','woocom')) || ($main_type == 'woocom' && get_post_meta($post_id, 'mg_link_only', true)) || ($main_type == 'post_contents' && $pc_direct_link)) ? '' : 'mg_closed';
		
		// no overlay class fot static/inline audio items
		$item_has_no_ol = (in_array($main_type, array('simple_img', 'inl_audio')) && !get_post_meta($post_id, 'mg_static_show_overlay', true)) ? 'mg_item_no_ol' : '';
		
		// spacer - visibility class
		if($main_type == 'spacer') {
			$vis = get_post_meta($post_id, 'mg_spacer_vis', true);
			$spacer_vis = ($vis) ? 'mg_spacer_'.$vis : '';	
		}
		else {$spacer_vis = '';}
		
		// classes wrap-up
		$add_classes = implode(' ', array('mgi_'.$post_id, 'mg_pag_'.$curr_pag, $type_class, $trans_class, $lb_class, $item_has_no_ol, $spacer_vis)).' '.$term_classes;
		
		
		////////////////////////////
		/*** items custom css ***/
		
		// inline texts custom colors
		if($main_type == 'inl_text') {
			$img_wrap_css = 'style="';
			
			if(get_post_meta($post_id, 'mg_inl_txt_color', true)) {$img_wrap_css .= 'color: '.get_post_meta($post_id, 'mg_inl_txt_color', true).';';}
			if(get_post_meta($post_id, 'mg_inl_txt_box_bg', true)) {$img_wrap_css .= 'background-color: '.get_post_meta($post_id, 'mg_inl_txt_box_bg', true).';';}
			if((int)get_post_meta($post_id, 'mg_inl_txt_bg_alpha', true)) {
				$alpha = (int)get_post_meta($post_id, 'mg_inl_txt_bg_alpha', true) / 100; 
				$img_wrap_css .= 'background-color: '.mg_hex2rgba( get_post_meta($post_id, 'mg_inl_txt_box_bg', true), $alpha).';';
			}
			
			$img_wrap_css .= '"';
		}
		else {$img_wrap_css = '';}
		
		
		/////////////////////////////
		/*** search attribute ***/
		if($search && $main_type != 'spacer') {
			$search_helper = get_post_meta($post_id, 'mg_search_helper', true);
			$search_attr = 'mg-search="'. str_replace('"', '', strtolower($img_alt)) .' '.$search_helper.'"';	
		}
		else {$search_attr = '';}
		
		
		/*** item block ***/
		// first part
		$grid .= '
		<div id="'.uniqid().'" class="mg_box mg_pre_show col'.$item['w'].' row'.$item['h'].' m_col'.$item['m_w'].' m_row'.$item['m_h'].' '.$add_classes.'" rel="pid_'.$lb_post_id.'" '.$ratio.' 
			mgi_w="'.mg_size_to_perc($item['w'], 1).'" mgi_h="'.mg_size_to_perc($item['h'], 1).'" mgi_mw="'.mg_size_to_perc($item['m_w'], 1).'" mgi_mh="'.mg_size_to_perc($item['m_h'], 1).'" '.$search_attr.'>';
			
			// text under control
			$have_txt_under = (!in_array($main_type, array('inl_slider', 'simple_img', 'inl_text')) || empty($item_has_no_ol)) ? true : false;
			$txt_under_class = ($have_txt_under) ? 'mg_has_txt_under' : '';
			
			if($main_type != 'spacer') {
				$grid .= '
				<div class="mg_shadow_div">
					<div class="img_wrap '.$txt_under_class.'" '.$img_wrap_css.'>
						<div>';
						
						// link type - start tag
						if($main_type == 'link') {
							$nofollow = (get_post_meta($post_id, 'mg_link_nofollow', true) == '1') ? 'rel="nofollow"' : '';
							$grid .= '<a href="'.get_post_meta($post_id, 'mg_link_url', true).'" target="_'.get_post_meta($post_id, 'mg_link_target', true).'" '.$nofollow.' class="mg_link_elem">';
						}
						
						// woocomm link-only item
						elseif($main_type == 'woocom' && !$lb_class) {
							$grid .= '<a href="'.get_permalink($post_id).'" class="mg_link_elem">';
						}
						elseif($main_type == 'post_contents' && $pc_direct_link) {
							$grid .= '<a href="'.get_permalink($post_id).'" class="mg_link_elem">';
						}

							/*** inner contents for lightbox and inline types ***/
							// inline slider
							if($main_type == 'inl_slider') {
								$slider_img = get_post_meta($post_id, 'mg_slider_img', true);
								$autoplay = (get_post_meta($post_id, 'mg_inl_slider_autoplay', true)) ? 'mg_autoplay_slider' : '';
								$captions = get_post_meta($post_id, 'mg_inl_slider_captions', true);

								$grid .= '
								<div id="'.uniqid().'" class="mg_inl_slider_wrap '.$autoplay.'">
									<ul style="display: none;">';
								  
								if(is_array($slider_img)) {
									if(get_post_meta($post_id, 'mg_inl_slider_random', true)) {
										shuffle($slider_img);	
									}

									foreach($slider_img as $img_id) {
										
										// WPML integration - get translated ID
										if(function_exists('icl_object_id')) {
											$img_id = icl_object_id($img_id, 'attachment', true);	
										}
										
										$src = wp_get_attachment_image_src($img_id, 'full');
										
										// resize if is not an animated gif
										if(substr(strtolower($src[0]), -4) != '.gif' && substr(strtolower($src[0]), -4) != '.png') {
											$sizes = mg_inl_slider_img_sizes($src, $max_width, $item);
											$slider_thumb = mg_thumb_src($img_id, $sizes['w'], $sizes['h'], $thumb_q);
										}
										else {$slider_thumb = $src[0];}
										
										if($captions == 1) {
										   $img_data = get_post($img_id);
										   $caption = (empty($img_data->post_content)) ? '' : trim($img_data->post_content);
										}
										else {$caption = '';}
										
										$grid .= '
										<li lcms_img="'.$slider_thumb.'">
											'.$caption.'<noscript><img src="'.$slider_thumb.'" alt="'.mg_sanitize_input($caption).'" /></noscript>
										</li>';
									}
								}
						
								// slider wrap closing
								$grid .= '</ul></div>'; 
							}
							
							// inline video
							if($main_type == 'inl_video') {
								$video_url = get_post_meta($post_id, 'mg_video_url', true);
								$poster = (get_post_meta($post_id, 'mg_video_use_poster', true) && $thumb_url) ? true : false;
								$autoplay = (get_post_meta($post_id, 'mg_autoplay_inl_video', true) && !$poster) ? true : false;
								$z_index = ($poster) ? 'style="z-index: -1;"' : '';
								
								// self-hosted
								if(lcwp_video_embed_url($video_url) == 'wrong_url') {
									$sources = mg_sh_video_sources($video_url);

									if(!$sources) {
										$grid .= '<p><em>Video extension not supported ..</em></p>';	
									}
									else {
										$preload = ($poster) ? 'meta' : 'auto';
										$autoplay = ($autoplay) ? 'mg_video_autoplay' : '';
										
										$grid .= 
										'<div id="'.uniqid().'" class="mg_sh_inl_video mg_me_player_wrap mg_self-hosted-video '.$autoplay.'" '.$z_index.'>
											<video width="100%" height="100%" controls="controls" preload="'.$preload.'">
											  '.$sources.'
											</video>
										</div>';
									}
								
								}
								else {
									$url_to_use = ($poster) ? '' : lcwp_video_embed_url($video_url, $autoplay);
									$autoplay_url = ($poster) ? 'autoplay-url="'. lcwp_video_embed_url($video_url, true). '"' : '';
									
									$grid .= '<iframe class="mg_video_iframe" src="'.$url_to_use.'" frameborder="0" allowfullscreen '.$autoplay_url.' '.$z_index.'></iframe>';	
								}
							}
							
							// inline audio
							if($main_type == 'inl_audio') {
								$soundcloud = get_post_meta($post_id, 'mg_soundcloud_url', true);
								
								if(!empty($soundcloud)) {
									$sc_lazyload = ($item_has_no_ol) ? false : true;
									$grid .= mg_get_soundcloud_embed($soundcloud, true, $sc_lazyload);	
								}
								else {
									$preload = (!$item_has_no_ol) ? 'auto' : 'metadata'; 
									$tracklist = get_post_meta($post_id, 'mg_audio_tracks', true);
									
									// player
									$args = array(
										'posts_per_page'	=> -1,
										'orderby'			=> 'post__in',
										'post_type'       	=> 'attachment',
										'post__in'			=> $tracklist
									);
									$tracks = get_posts($args);
									$player_id = uniqid();
						
									$grid .= '
									<div id="'.$player_id.'" class="mg_me_player_wrap mg_inl_audio_player">
										<audio controls="controls" preload="'.$preload.'" width="100%">';
											foreach($tracks as $track) {$grid .= '<source src="'. $track->guid .'" type="'. $track->post_mime_type .'">';}
									$grid .= '
										</audio>';
										
										// tracklist
										$tot = (is_array($tracklist)) ? count($tracklist) : 0;
										if($tot > 1) {
											$grid .= '<ol id="'.$player_id.'-tl" class="mg_audio_tracklist mg_inl_audio_tracklist" style="display: none;">';
											
											$a = 1;
											foreach($tracks as $track) {
												$current = ($a == 1) ? 'mg_current_track' : '';
												$grid .= '<li mg_track="'. $track->guid .'" rel="'.$a.'" class="'.$current.'">'. $track->post_title .'</li>';
												$a++;
											}
											
											$grid .= '</ol>';
										}
										
									$grid .= '</div>';
								}
							}
							
							// inline text
							if($main_type == 'inl_text') {
								$grid .= '<table class="mg_inl_txt_table"><tbody><tr>
									<td class="mg_inl_txt_td" style="vertical-align: '.get_post_meta($post_id, 'mg_inl_txt_vert_align', true).';">
										'. do_shortcode(wpautop(get_post_field('post_content', $post_id))) .'
									</td>
								</tr></tbody></table>';	
							}
							
							
							// standard lightbox types and inline video with poster
							if(!in_array($main_type, array('inl_slider', 'inl_video', 'inl_text')) || ($main_type == 'inl_video' && $poster)) {
								
								// no image for soundcloud inline audio + no overlay
								if($main_type == 'inl_audio' && $soundcloud && $item_has_no_ol) {}
								else {
									$grid .= '
									<img src="" class="thumb" alt="'.$img_alt.'" fullurl="'.$thumb_url.'" mobileurl="'.$mobile_url.'" />
									<noscript>
										<img src="'.$thumb_url.'" alt="'.$img_alt.'" />
									</noscript>';
								}
								
								// overlays
								if(empty($item_has_no_ol)) {
									$grid .= $img_ol;
								}
							} 
							
							// SEO deeplink trick
							if(!empty($dl_class) && !in_array($main_type, array('simple_img','inl_slider','inl_video','inl_audio','inl_text','link')) ) {
								$grid .= '<a href="'.lcwp_curr_url().'#!mg_ld_'.$post_id.'" class="mg_seo_dl_link">\'</a>';
							}

						
						// link type - end tag	
						if($main_type == 'link' || ($main_type == 'woocom' && !$lb_class) || ($main_type == 'post_contents' && $pc_direct_link)) {	
							$grid .= '</a>'; 
						}

					$grid .= '
						</div>
					</div>';
					
					// overlays under
					if($have_txt_under) {
						$grid .= $txt_under;
					}
			
				$grid .= '</div>';		
			}
			
		// close main div
		$grid .= '</div>';	
		
	} // end foreach and close grid
	$grid .= '</div>'.$after_grid_filters;
			
	
	/////////////////////////		
	// pagination buttons
	if($has_pag_class) {
	
		// layout classes
		$pag_layout = get_option('mg_pag_layout', 'standard'); 
		$pl_class = '';
		
		if($pag_layout == 'standard') 		{$pl_class .= 'mg_pag_standard';}
		if($pag_layout == 'only_num') 		{$pl_class .= 'mg_pag_onlynum';}
		if($pag_layout == 'only_arr') 		{$pl_class .= 'mg_only_arr';}
		if($pag_layout == 'only_arr_dt') 	{$pl_class .= 'mg_only_arr_dt';}
	
		$grid .= '<div id="mgp_'.$cat.'" class="mg_pag_wrap '.$pl_class.' mg_pag_'.get_option('mg_pag_style', 'light').'" tot-pag="'.$curr_pag.'">';
		
			// mid nav - layout code
			if($pag_layout == 'standard') {
				$mid_code = '<div class="mg_nav_mid"><div>'. __('page', 'mg_ml') .' <span>1</span> '. __('of', 'mg_ml') .' '.$curr_pag.'</div></div>';	
			}
			elseif($pag_layout == 'only_num') {
				$mid_code = '<div class="mg_nav_mid"><div><span>1</span> <font>-</font> '.$curr_pag.'</div></div>';	
			}
			else {
				$mid_code = '';
			}
			
			$grid .= '
			<div class="mg_prev_page mg_pag_disabled"><i></i></div>
			'.$mid_code.'
			<div class="mg_next_page"><i></i></div>';		

		$grid .= '</div>';
	} // pagination end
	
	
	// grid end
	$grid .= '</div>';
	
	
	//////////////////////////////////////////////////
	// OVERLAY MANAGER ADD-ON
	if(defined('MGOM_URL')) {
		$grid .= '
		<script type="text/javascript">
		jQuery(document).ready(function($) { 
			if(typeof(mgom_hub) == "function" ) {
				mgom_hub('.$cat.');
			}
		});
		</script>
		';	
	}
	//////////////////////////////////////////////////
	
	
	// Ajax init
	if(get_option('mg_enable_ajax')) {
		$grid .= '
		<script type="text/javascript">
		jQuery(document).ready(function($) { 
			if(typeof(mg_async_init) == "function" ) {
				mg_async_init('.$cat.');
			}
		});
		</script>
		';
	}
	
	return str_replace(array("\r", "\n", "\t", "\v"), '', $grid);
}
add_shortcode('mediagrid', 'mg_shortcode');
