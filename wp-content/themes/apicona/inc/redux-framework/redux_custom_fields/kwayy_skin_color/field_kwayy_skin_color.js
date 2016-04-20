jQuery( document ).ready(function($) {
	jQuery( '.kwayy-skin-color-list a' ).click(function() {
		color = jQuery(this).css('background-color');
		jQuery('.redux-container-kwayy_skin_color .redux-color-init').iris('color', color);
		return false;
	});
});
