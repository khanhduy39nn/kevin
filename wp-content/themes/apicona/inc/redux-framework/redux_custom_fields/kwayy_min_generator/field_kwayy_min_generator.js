jQuery( document ).ready(function($) {
	/*jQuery( 'a.import-demo-thumb' ).click(function() {
		
		jQuery('.import-demo-data-layout a').removeClass('import-demo-thumb-active');
		jQuery(this).addClass('import-demo-thumb-active');
		
		var layout = jQuery(this).data('layout');
		jQuery( 'input#import-layout-color' ).val(layout);
		return false;
	});*/
	
	
	jQuery('#kwayy_min_generator_btn').click(function() {
		
		if( jQuery(this).attr('disabled') == 'disabled' ) {
			return false;
		}
		jQuery('#min-generator-wrapper').slideDown();
		
		var button = jQuery(this);
		var resultDiv = jQuery('#min-generator-results');
		
		resultDiv.addClass('kwayy-min-generator-progress'); // Adding loader class
		resultDiv.removeClass('kwayy-min-generator-success');
		
		
		
		
		// Layout Color
		//var color = jQuery('#import-layout-color').val();
		
		$.ajax({
			url: ajaxurl,
			type: "POST",
			dataType: "json",
			data: {
				'action'    : 'kwayy_min_generator',
				//'color'     : color,
				'subaction' : 'start'
			},
			beforeSend: function() {
				//resultDiv.html('<p id="install-demo-data-started">' + apiconaVars.strInstallingDemoData + '</p>').show().removeClass('error');
				resultDiv.html('<p id="install-demo-data-started">Starting MIN generator...</p>').show().removeClass('error');
			},
			success: function( result ) {

				function demoInstallerStep( result ) {
					
					if( result != null && typeof( result ) == 'object' ) {
					
						if( result.answer == 'ok' ) {
						
							resultDiv.append(' ' + result.message + ' ');
							
							/*** Extra data for next processing ***/
							var missing_menu_items = '';
							if( typeof result.missing_menu_items != "undefined" ){
								missing_menu_items = result.missing_menu_items;
							}
							
							var processed_terms = '';
							if( typeof result.processed_terms != "undefined" ){
								processed_terms = result.processed_terms;
							}
							
							var processed_posts = '';
							if( typeof result.processed_posts != "undefined" ){
								processed_posts = result.processed_posts;
							}
							
							var processed_menu_items = '';
							if( typeof result.processed_menu_items != "undefined" ){
								processed_menu_items = result.processed_menu_items;
							}
							
							var menu_item_orphans = '';
							if( typeof result.menu_item_orphans != "undefined" ){
								menu_item_orphans = result.menu_item_orphans;
							}
							
							var url_remap = '';
							if( typeof result.url_remap != "undefined" ){
								url_remap = result.url_remap;
							}
							
							var featured_images = '';
							if( typeof result.featured_images != "undefined" ){
								featured_images = result.featured_images;
							}
							/***********************************/
							
							
							
							
							$.ajax({
								url: ajaxurl,
								type: "POST",
								dataType: "json",
								data: {
									'action'    : 'kwayy_min_generator',
									//'color'     : color,
									'subaction' : result.next_subaction,
									'data'      : result.data,
									'missing_menu_items'   : result.missing_menu_items,
									'processed_terms'      : result.processed_terms,
									'processed_posts'      : result.processed_posts,
									'processed_menu_items' : result.processed_menu_items,
									'menu_item_orphans'    : result.menu_item_orphans,
									'url_remap'            : result.url_remap,
									'featured_images'      : featured_images
								},
								success: function( result ) {
									demoInstallerStep( result );
								},
								error: function(request, status, error) {
									//resultDiv.html( '<p><strong style="color: red">' + apiconaVars.strError + ": " + request.status + '</p>' );
									resultDiv.html( '<p><strong style="color: red"> Error: ' + request.status + '</p>' );
									button.removeAttr('disabled');
								}
							});
						
						}
					
						if( result.answer == 'finished' ) {
							//jQuery('#install-demo-data-started').remove();
							
							
							/*if( color == 'dark' ){
								resultDiv.append('<p><strong>All finished :) ... Please wait while we are saving the settings... </strong></p>');
								resultDiv.addClass('kwayy-import-demo-success');
								
								// Saving the Theme Options now
								jQuery('li.kwayy-pre-color-link-2 a').trigger( "click" );
								setTimeout(function() { jQuery('#redux_save').trigger( "click" ); }, 1200);
								
							} else {
								resultDiv.append('<p><strong>All finished... Enjoy :) </strong></p><div class="tm-import-done">The next step is to insert Slider and some small changes. <a href="http://apicona.kwayy.com/documentation/democontent.html" target="_blank">Click here for next steps</a>.</div>');
								resultDiv.addClass('kwayy-import-demo-success');
							}*/
							
							resultDiv.append(' All JS Files minified successfully.<br>');
							resultDiv.append('<p><strong>All finished... Enjoy :) </strong></p>');
							resultDiv.addClass('kwayy-min-generator-success');
							
							//button.removeAttr('disabled');
						}
					
					} /*else {
					
						resultDiv.append( '<p><strong style="color: red">Error:</strong> Something wrong</p>' ).addClass('error');
						button.removeAttr('disabled');
						jQuery('#install-demo-data-started').remove();
						
					}*/
					
				}

				demoInstallerStep( result );
		
			},
			error: function(request, status, error) {
				//resultDiv.html( '<p><strong style="color: red">' + apiconaVars.strError + ": " + request.status + '</p>' );
				resultDiv.html( '<p><strong style="color: red">: ERRRRROR' + request.status + '</p>' );
				//button.removeAttr('disabled');
			}
		});
		
		return false;
	
	
	
	
		/*
		var data = {
			'action'                : 'kwayy_one_click_demo',
			'startdemoinstallation' : 'true'
		};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(ajaxurl, data, function(response) {
		
			//console.log('Ajax URL: ' + ajaxurl);
			console.log('Got this from the server: ' + response);
			//alert('Got this from the server: ' + response);
		});
		*/
	});





	
	
}); // document.ready END
