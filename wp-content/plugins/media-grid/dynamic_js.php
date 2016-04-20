<?php
// prevent right click - global vars and mediaelement inclusion if not in the page 

// frontent JS on header or footer
if(!get_option('mg_js_head')) {
	add_action('wp_footer', 'mg_dynamic_js', 90);
} else { 
	add_action('wp_head', 'mg_dynamic_js', 850);
}

function mg_dynamic_js() {
	include_once(MG_DIR.'/functions.php');
	
	$delayed_fx 	= (get_option('mg_delayed_fx')) ? 'false' : 'true';
	$modal_class 	= (get_option('mg_modal_lb')) ? 'mg_modal_lb' : 'mg_classic_lb';
	$box_border 	= (get_option('mg_cells_border')) ? 1 : 0;
	$lb_vert_center = (get_option('mg_lb_not_vert_center')) ? 'false' : 'true';
	$lb_touchswipe 	= (get_option('mg_lb_touchswipe')) ? 'true' : 'false';
	$woocom 		= (mg_woocomm_active()) ? 'true' : 'false';
	?>
	<script type="text/javascript">
	// Media Grid global dynamic vars
	mg_boxMargin = <?php echo (int)get_option('mg_cells_margin') ?>;
	mg_boxBorder = <?php echo $box_border ?>;
	mg_imgPadding = <?php echo (int)get_option('mg_cells_img_border') ?>;
	mg_delayed_fx = <?php echo $delayed_fx ?>;
	mg_filters_behav = '<?php echo get_option('mg_filters_behav', 'standard') ?>';
	mg_lightbox_mode = "<?php echo $modal_class ?>";
	mg_lb_touchswipe = <?php echo $lb_touchswipe ?>;
	mg_mobile = <?php echo get_option('mg_mobile_treshold', 800) ?>; 

	// Galleria global vars
	mg_galleria_fx = '<?php echo get_option('mg_slider_fx', 'fadeslide') ?>';
	mg_galleria_fx_time = <?php echo get_option('mg_slider_fx_time', 400) ?>; 
	mg_galleria_interval = <?php echo get_option('mg_slider_interval', 3000) ?>;
	
    // LC micro slider vars
	mg_inl_slider_fx = '<?php echo get_option('mg_inl_slider_fx', 'fadeslide') ?>';
	mg_inl_slider_fx_time = <?php echo get_option('mg_inl_slider_fx_time', 400) ?>; 
	mg_inl_slider_intval = <?php echo get_option('mg_inl_slider_interval', 3000) ?>;
	mg_inl_slider_touch = <?php echo (get_option('mg_inl_slider_no_touch')) ? 'false' : 'true'; ?>;
	mg_inl_slider_pause_on_h = <?php echo (get_option('mg_inl_slider_pause_on_h')) ? 'true' : 'false'; ?>;
    </script>	
	<?php
    
	// if prevent right click
	if(get_option('mg_disable_rclick')) :
		?>
        <script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('body').delegate('.mg_grid_wrap *, #mg_full_overlay *, #mg_wp_video_wrap .wp-video *', "contextmenu", function(e) {
                e.preventDefault();
            });
		});
		</script>
        <?php	
	endif;
}


/* add mediaelement only if not used before */
add_action('wp_footer', 'mg_dynamic_mediael', 9999);

function mg_dynamic_mediael() {
	?>
    <script type="text/javascript">
	if(typeof(MediaElementPlayer) != 'function') {	
		jQuery(document).ready(function(e) {
            
			var s = document.createElement("script");
				
			s.type = "text/javascript";
			s.id = "mediaelement-js";
			s.src = "<?php echo MG_URL ?>/js/mediaelement/mediaelement-and-player.min.js";
			
			var head = document.getElementsByTagName('head');	
			jQuery('head').append("<link rel='stylesheet' href='<?php echo MG_URL ?>/js/mediaelement/mediaelementplayer.min.css' type='text/css' media='all' />");
	
			var body = document.getElementsByTagName('body');
			jQuery('body').append(s);
		});
	}
	</script>
    <?php	
}
