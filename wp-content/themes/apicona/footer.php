<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */
 global $apicona;
?>
<?php /*if( !is_page() ){
		echo '</div>';
	}*/ ?>
				
		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
        	<div class="footer footer-text-color-<?php echo $apicona['footerwidget_color']; ?>">
			<?php /* ?>
              <div class="footersocialicon">
                  <div class="container">
                        <div class="row">
                          <div class="col-xs-12"><?php echo kwayy_get_social_links(); ?></div>
                        </div>                
                  </div>                
              </div>
			  <?php */ ?>
				<div class="container">
					<div class="row">
						<?php get_sidebar( 'footer' ); ?>
					</div>
				</div>
            </div>
			<div class="site-info footer-info-text-color-<?php echo $apicona['footertext_color']; ?>">
                <div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 copyright">
							<span class="kwayy_footer_text"><?php
							global $apicona;
							if( isset($apicona['copyrights']) && trim($apicona['copyrights'])!='' ){
								$tm_footer_copyright = apply_filters('the_content', $apicona['copyrights']);
								echo $tm_footer_copyright;
							}
							?>
							</span> 
						</div><!--.copyright -->
					  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 kwayy_footer_menu">
							<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'footer-nav-menu', 'container' => false ) ); ?>
					  </div>
                    </div><!--.row -->
				</div><!-- .site-info -->
			</div><!-- .container -->
		</footer><!-- #colophon -->
	</div><!-- #page -->
	
	</div><!-- .main-holder.animsition -->

    <a id="totop" href="#top" style="display: inline;"><i class="kwicon-fa-angle-up"></i></a>
    
	<?php
	if( isset($apicona['custom_js_code']) && trim($apicona['custom_js_code'])!='' ){
		echo '<script type="text/javascript"> /* Custom JS Code */ '.$apicona['custom_js_code'].'</script>';
	}
	?>
	
	<?php wp_footer(); ?>
	
</body>
</html>
