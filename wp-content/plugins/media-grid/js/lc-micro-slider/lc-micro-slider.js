/**
 * lc_micro_slider.js - lightweight responsive slider with jquery.touchSwipe.js integration
 * Version: 1.0
 * Author: LCweb - Luca Montanari
 * Website: http://www.lcweb.it
 * Licensed under the MIT license
 */

(function ($) {
	var lc_micro_slider = function(element, lcms_settings) {
		
		var settings = $.extend({
			slide_fx		: 'fadeslide',	// (string) sliding effect / slide - fade - fadeslide 
			nav_arrows		: true,		// (bool) shows the navigation arrows 
			carousel		: true,		// (bool) non-stop carousel
			touchswipe		: true,		// (bool) enable touch navigation (requires hammer.js)
			autoplay		: false,	// (bool) starts the slideshow
			animation_time	: 700, 		// (int) animation timing in millisecods / 1000 = 1sec
			slideshow_time	: 5000, 	// (int) interval time of the slideshow in milliseconds / 1000 = 1sec	
			pause_on_hover	: true,		// (bool) pause and restart the autoplay on box hover
			loader_code		: '<span class="lcms_loader"></span>'	// loading animation code
		}, lcms_settings);

	
		// Global variables accessible only by the plugin
		var vars = { 
			slides : [], 		// slides array -> object {content - img}
			shown_slide : 0,	// shown slide index
			cached_img: [],		// array containing cached images
			is_sliding : false,
			is_playing : false,
			paused_on_hover : false 
		};	
		
		
		// .data() system to avoid issues on multi instances
		var $lcms_wrap_obj = $(element);
		$lcms_wrap_obj.data('lcms_vars', vars);
		$lcms_wrap_obj.data('lcms_settings', settings);		
			
		/////////////////////////////////////////////////////////////////	


		/*** setup slider and slides array ***/
		var slider_setup = function($lcms_wrap_obj) {
			var vars = $lcms_wrap_obj.data('lcms_vars');
			var settings = $lcms_wrap_obj.data('lcms_settings');
			
			$lcms_wrap_obj.find('li').each(function(i, v) {
            	$(this).find('noscript').remove();
				var obj = {
					'content' 	: $(this).html(),
					'img'		: $(this).attr('lcms_img')
				}; 
				vars.slides.push(obj);
            });
			
			// populate with first to show
			$lcms_wrap_obj.html('<div class="lcms_wrap"></div>');
			
			vars.shown_slide = 0;
			populate_slide($lcms_wrap_obj, 'init', 0);
			
			// populate with arrows
			if(settings.nav_arrows && vars.slides.length > 1) {
				$lcms_wrap_obj.find('.lcms_wrap').append('<div class="lcms_nav"><span class="lcms_prev"></span><span class="lcms_next"></span></div>');	
			}
			
			// autoplay
			if(settings.autoplay) {
				$lcms_wrap_obj.lcms_start_slideshow();
			}
			
			// touchswipe
			$(document).ready(function(e) {
				if(typeof($.fn.swipe) == 'function') {
					touchswipe();
				}
			});
		};



		/* populate slide and append it in the slider
		 * type -> init - fade - prev - next
		 */
		var populate_slide = function($lcms_wrap_obj, type, slide_index) {
			var vars = $lcms_wrap_obj.data('lcms_vars');
			var settings = $lcms_wrap_obj.data('lcms_settings');
			
			var slide = vars.slides[ slide_index ];
			var bg_img_code = (slide.img) ? 'style="background: url('+ slide.img +') center center repeat transparent; background-size: cover;"' : '';
			var preload_class = (bg_img_code) ? 'lcms_preload' : '';
			var loader_code = (bg_img_code) ? settings.loader_code : '';
			
			// showing fx class
			switch(type) {
				case 'init' : var fx_class = 'lcms_active_slide'; break;
				case 'fade' : var fx_class = 'lcms_fadein'; break;	
				case 'prev' : var fx_class = 'lcms_before'; break;	
				case 'next' : var fx_class = 'lcms_after'; break;	
			}
			
			// contents block
			var contents = ($.trim(slide.content) != '') ? '<div class="lcms_content">'+ slide.content +'</div>' : '';
			
			var slide_code = '<div class="lcms_slide '+ fx_class +' '+ preload_class +'" rel="'+ slide_index +'"><div class="lcms_inner" '+ bg_img_code +'>'+ contents +'</div>'+ loader_code +'</div>';
			
			// populate
			$lcms_wrap_obj.find('.lcms_wrap').append(slide_code);	
			
			// preload current element	
			if(bg_img_code) {
				if( $.inArray(slide.img, vars.cached_img) === -1 ) {
					$('<img/>').bind("load",function(){ 
						vars.cached_img.push( this.src );
						
						$('.lcms_slide[rel='+ slide_index +']').removeClass('lcms_preload');
						$('.lcms_slide[rel='+ slide_index +']').find('> *').not('.lcms_inner').fadeOut(300, function() {
							$(this).remove();	
						});
					}).attr('src', slide.img);
				}
				else {
					$('.lcms_slide[rel='+ slide_index +']').removeClass('lcms_preload').addClass('lcms_cached');
					$('.lcms_slide[rel='+ slide_index +']').find('> *').not('.lcms_inner').remove();	
				}
			}
			
			// smart preload - previous and next
			if(vars.slides.length > 1) {
				var next_load = (slide_index < (vars.slides.length - 1)) ? (slide_index + 1) : 0;
				
				if( $.inArray(vars.slides[ next_load ].img, vars.cached_img) === -1 ) {
					$('<img/>').bind("load",function(){ 
						vars.cached_img.push( this.src );
					}).attr('src', vars.slides[ next_load ].img);
				}
			}
			if(vars.slides.length > 2) {
				var prev_load = (slide_index == 0) ? (vars.slides.length - 1) : (slide_index - 1); 
				
				if( $.inArray(vars.slides[ prev_load ].img, vars.cached_img) === -1 ) {
					$('<img/>').bind("load",function(){ 
						vars.cached_img.push( this.src );
					}).attr('src', vars.slides[ prev_load ].img);
				}
			}	
		}
		
		
		
		/*** slide/fade element ***/
		lcms_slide = function($lcms_wrap_obj, direction) {
			var vars = $lcms_wrap_obj.data('lcms_vars');
			var settings = $lcms_wrap_obj.data('lcms_settings');

			if(!settings.carousel && ((direction == 'prev' &&  vars.shown_slide == 0) || (direction == 'next' &&  vars.shown_slide == vars.slides.length - 1))) {return false;}
			if(vars.lcms_is_sliding) {return false;}
			vars.lcms_is_sliding = true;
			
			// find the new index and populate
			if(direction == 'prev') {
				var new_index = (vars.shown_slide === 0) ? (vars.slides.length - 1) : (vars.shown_slide - 1); 
			} else {
				var new_index = (vars.shown_slide == (vars.slides.length - 1)) ? 0 : (vars.shown_slide + 1); 	
			}
			
			// populate
			var type = (settings.slide_fx == 'fade') ? 'fade' : direction;
			populate_slide($lcms_wrap_obj, type, new_index);
			vars.shown_slide = new_index;
			
			if(settings.slide_fx == 'fade') {
				$lcms_wrap_obj.find('.lcms_active_slide').fadeOut(settings.animation_time);	
			}
			else if(settings.slide_fx == 'slide') {
				if(direction == 'prev') {
					$lcms_wrap_obj.find('.lcms_before').css('left', '-100%').animate({left : '0%'}, settings.animation_time);
					$lcms_wrap_obj.find('.lcms_active_slide').animate({left : '100%'}, settings.animation_time);	
				} else {
					$lcms_wrap_obj.find('.lcms_after').css('left', '100%').animate({left : '0%'}, settings.animation_time);
					$lcms_wrap_obj.find('.lcms_active_slide').animate({left : '-100%'}, settings.animation_time);	
				}
			}
			else if(settings.slide_fx == 'fadeslide') {
				if(direction == 'prev') {
					$lcms_wrap_obj.find('.lcms_before').fadeTo(0, 0).animate({left : '0%', opacity: 1}, settings.animation_time);
					$lcms_wrap_obj.find('.lcms_active_slide').animate({left : '100%', opacity: 0}, settings.animation_time);	
				} else {
					$lcms_wrap_obj.find('.lcms_after').fadeTo(0, 0).animate({left : '0%', opacity: 1}, settings.animation_time);
					$lcms_wrap_obj.find('.lcms_active_slide').animate({left : '-100%', opacity: 0}, settings.animation_time);	
				}
			}

			setTimeout(function() {
				$lcms_wrap_obj.find('.lcms_active_slide').remove();
				$lcms_wrap_obj.find('.lcms_slide').removeClass('lcms_fadein lcms_before lcms_after').addClass('lcms_active_slide');
				
				vars.lcms_is_sliding = false;
			}, settings.animation_time); 
		}


		////////////////////////////////////////////
		
		// prev news - click event
		$('.lcms_prev').unbind('click');
		$lcms_wrap_obj.delegate('.lcms_prev:not(.lcms_disabled)', 'click', function() {
			var $subj = $(this).parents('.lcms_wrap').parent();
			if(typeof(lcms_one_click) != 'undefined') {clearTimeout(lcms_one_click);}
			
			lcms_one_click = setTimeout(function() {
				$subj.lcms_stop_slideshow();
				lcms_slide($subj, 'prev');	
			}, 5);
		});
		
		// next news - click event
		$('.lcms_next').unbind('click');
		$lcms_wrap_obj.delegate('.lcms_next:not(.lcms_disabled)', 'click', function() {
			var $subj = $(this).parents('.lcms_wrap').parent();
			if(typeof(lcms_one_click) != 'undefined') {clearTimeout(lcms_one_click);}
			
			lcms_one_click = setTimeout(function() {
				$subj.lcms_stop_slideshow();
				lcms_slide($subj, 'next');	
			}, 5);
		});

		
		// touchswipe	
		var touchswipe = function() {
			$('.lcms_wrap').swipe({
				swipeRight: function() {
					var $subj = jQuery(this).parent();
					console.log($subj);
					
					$subj.lcms_stop_slideshow();
					lcms_slide($subj, 'prev');		
				},
				swipeLeft: function() {
					var $subj = jQuery(this).parent();
				
					$subj.lcms_stop_slideshow();
					lcms_slide($subj, 'next');		
				},
				threshold: 40,
				allowPageScroll: 'vertical'
			});	
		}
		
		
		// pause on hover
		if(settings.pause_on_hover) {
			$lcms_wrap_obj.delegate('.lcms_wrap', 'mouseenter', function() {
				var $subj = $(this).parent();
				
				var vars = $subj.data('lcms_vars');
				var settings = $subj.data('lcms_settings');
				
				if(vars.is_playing) {
					$subj.lcms_stop_slideshow();
					vars.paused_on_hover = true; 
				}
			})
			.delegate('.lcms_wrap', 'mouseleave', function() {
				var $subj = $(this).parent();
				
				var vars = $subj.data('lcms_vars');
				var settings = $subj.data('lcms_settings');
				
				if(vars.paused_on_hover) {
					$subj.lcms_start_slideshow();
					vars.paused_on_hover = false;
				}
			});
		}
		
		////////////////////////////////////////////
		
		// execution
		slider_setup($lcms_wrap_obj);
		return this;
	};	
		
	////////////////////////////////////////////
	
	// init
	$.fn.lc_micro_slider = function(lcms_settings) {

		// destruct
		$.fn.lcms_destroy = function() {
			var $elem = $(this);
			$elem.find('.lcms_wrap').remove();
			
			// clear interval
			var vars = $elem.data('lcms_vars');
			if(vars.is_playing) {clearInterval(vars.is_playing); }
			
			// undelegate events
			$elem.find('.lcms_next, .lcms_prev').undelegate('click');
			
			// remove stored data
			$elem.removeData('lcms_vars');
			$elem.removeData('lcms_settings');
			$elem.removeData('lc_micro_slider');
			
			return true;
		};	
		
		
		// pagination (next/prev)
		$.fn.lcms_paginate = function(direction) {
			var $elem = $(this);
			
			var vars = $elem.data('lcms_vars');	
			var settings = $elem.data('lcms_settings');
			
			$elem.lcms_stop_slideshow(); 
			
			lcms_slide($elem, direction);
			return true;
		};
		
		
		// start slideshow
		$.fn.lcms_start_slideshow = function() {
			var $elem = $(this);
			
			var vars = $elem.data('lcms_vars');	
			var settings = $elem.data('lcms_settings');	

			vars.is_playing = setInterval(function() {
				lcms_slide($elem, 'next');
			}, (settings.slideshow_time + settings.animation_time));	
			
			return true;
		};
		
		
		// stop the slideshow
		$.fn.lcms_stop_slideshow = function() {
			var $elem = $(this);

			var vars = $elem.data('lcms_vars');	
			var settings = $elem.data('lcms_settings');
			
			clearInterval(vars.is_playing);
			vars.is_playing = null;


			return true;
		};


		// construct
		return this.each(function(){
            // Return early if this element already has a plugin instance
            if ( $(this).data('lc_micro_slider') ) { return $(this).data('lc_micro_slider'); }
			
            // Pass options to plugin constructor
            var ms = new lc_micro_slider(this, lcms_settings);
			
            // Store plugin object in this element's data
            $(this).data('lc_micro_slider', ms);
        });
	};			
	
})(jQuery);
