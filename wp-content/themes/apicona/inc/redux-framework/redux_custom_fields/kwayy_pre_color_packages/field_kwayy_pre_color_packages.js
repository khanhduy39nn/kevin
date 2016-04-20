// Blank array
var kwayy_pre_color_list = [];

// Each color
// kwayy_pre_color_list[NUMBER] = [ 'skincolor','topbarbgcolor','headerbgcolor','footerwidget_bgcolor','footertext_bgcolor', topbar_text_color, header_text_color, footerwidget_color, footertext_color, apicona[logo_font][color]  ];
kwayy_pre_color_list[1]  = ['e85e16','192133','212c43','212c43','192133', 'white', 'white', 'white', 'white', 'ffffff' ]; // OK
kwayy_pre_color_list[2]  = ['dd4c42','232527','363b3f','363b3f','232527', 'white', 'white', 'white', 'white', 'ffffff']; // OK
kwayy_pre_color_list[3]  = ['c7a589','49423e','59524c','59524c','49423e', 'white', 'white', 'white', 'white', 'ffffff']; // OK
kwayy_pre_color_list[4]  = ['21c2f8','222222','323232','323232','222222', 'white', 'white', 'white', 'white', 'ffffff']; // OK
kwayy_pre_color_list[5]  = ['d0a825','192025','21282e','21282e','192025', 'white', 'white', 'white', 'white', 'ffffff']; // OK
kwayy_pre_color_list[6]  = ['e85e16','efefef','ffffff','ffffff','efefef', 'dark', 'dark', 'dark', 'dark', '303a3b']; // OK
kwayy_pre_color_list[7]  = ['dd4c42','efefef','ffffff','ffffff','efefef', 'dark', 'dark', 'dark', 'dark', '303a3b']; // OK
kwayy_pre_color_list[8]  = ['c7a589','efefef','ffffff','ffffff','efefef', 'dark', 'dark', 'dark', 'dark', '303a3b']; // OK
kwayy_pre_color_list[9]  = ['21c2f8','efefef','ffffff','ffffff','efefef', 'dark', 'dark', 'dark', 'dark', '303a3b']; // OK
kwayy_pre_color_list[10] = ['d0a825','efefef','ffffff','ffffff','efefef', 'dark', 'dark', 'dark', 'dark', '303a3b']; // OK




jQuery( document ).ready(function($) {

	jQuery( '.redux-container-kwayy_pre_color_packages' ).parent().parent().addClass('kwayy-special-toption');


	jQuery( '.kwayy-pre-color-packages a' ).click(function() {
		var num = jQuery(this).data( "num" );
		curr    = kwayy_pre_color_list[num];
		
		/* Setting background colours */
		if( jQuery('input[name="apicona[skincolor]"]').css('display') == 'none' ){
			jQuery('input[name="apicona[skincolor]"]').iris('color', '#'+curr[0] );
		} else {
			jQuery('input[name="apicona[skincolor]"]').val( '#'+curr[0] );
		}
		
		if( jQuery('input[name="apicona[topbarbgcolor]"]').css('display') == 'none' ){
			jQuery('input[name="apicona[topbarbgcolor]"]').iris('color', '#'+curr[1] );
		} else {
			jQuery('input[name="apicona[topbarbgcolor]"]').val( '#'+curr[1] );
		}
		
		if( jQuery('input[name="apicona[headerbgcolor]"]').css('display') == 'none' ){
			jQuery('input[name="apicona[headerbgcolor]"]').iris('color', '#'+curr[2] );
		} else {
			jQuery('input[name="apicona[headerbgcolor]"]').val( '#'+curr[2] );
		}
		
		if( jQuery('input[name="apicona[footerwidget_bgcolor]"]').css('display') == 'none' ){
			jQuery('input[name="apicona[footerwidget_bgcolor]"]').iris('color', '#'+curr[3] );
		} else {
			jQuery('input[name="apicona[footerwidget_bgcolor]"]').val( '#'+curr[3] );
		}
		
		if( jQuery('input[name="apicona[footertext_bgcolor]"]').css('display') == 'none' ){
			jQuery('input[name="apicona[footertext_bgcolor]"]').iris('color', '#'+curr[4] );
		} else {
			jQuery('input[name="apicona[footertext_bgcolor]"]').val( '#'+curr[4] );
		}
		
		
		/* Setting text colours */
		if( jQuery('select[name="apicona[topbar_text_color]"]').css('position') == 'absolute' ){
			jQuery('select[name="apicona[topbar_text_color]"]').select2( "val", curr[5] );
		} else {
			jQuery('select[name="apicona[topbar_text_color]"]').val( curr[5] );
			//jQuery('select[name="apicona[topbar_text_color]"] option:contains("'+curr[5]+'")').prop('selected', true);
		}
		
		if( jQuery('select[name="apicona[header_text_color]"]').css('position') == 'absolute' ){
			jQuery('select[name="apicona[header_text_color]"]').select2( "val", curr[6] );
		} else {
			jQuery('select[name="apicona[header_text_color]"]').val( curr[6] );
		}
		
		if( jQuery('select[name="apicona[footerwidget_color]"]').css('position') == 'absolute' ){
			jQuery('select[name="apicona[footerwidget_color]"]').select2( "val", curr[7] );
		} else {
			jQuery('select[name="apicona[footerwidget_color]"]').val( curr[7] );
		}
		
		if( jQuery('select[name="apicona[footertext_color]"]').css('position') == 'absolute' ){
			jQuery('select[name="apicona[footertext_color]"]').select2( "val", curr[8] );
		} else {
			jQuery('select[name="apicona[footertext_color]"]').val( curr[8] );
		}
		
		
		
		/* Logo Color */
		if( jQuery('input[name="apicona[logo_font][color]"]').css('display') == 'none' ){
			jQuery('input[name="apicona[logo_font][color]"]').iris('color', '#'+curr[9] );
		} else {
			jQuery('input[name="apicona[logo_font][color]"]').val( '#'+curr[9] );
		}
		
		if( jQuery('#kwayy-pre-color-infobox').css('display') == 'none' ){
			jQuery('#kwayy-pre-color-infobox').slideDown();
		} else {
			jQuery('#kwayy-pre-color-infobox').slideUp('normal',function(){
				jQuery('#kwayy-pre-color-infobox').slideDown();
			});
		}
		
		//jQuery("#e8_set").click(function () { $("#e8").select2("val", "CA"); }); // Change dropdown value of Select2 element
		return false;
	});
});
