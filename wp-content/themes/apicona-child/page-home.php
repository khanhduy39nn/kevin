<?php
if ( is_front_page() ) :
    get_header( 'home' );
elseif ( is_page( 'About' ) ) :
    get_header( 'about' );
else:
    get_header();
endif;


echo do_shortcode( '[rev_slider slidehome]' );
?>

<div id="primary" class="content-area col-md-12 col-lg-12 col-sm-12 col-xs-12">

  <article id="post-40" class="post-40 page type-page status-publish hentry">
      <div class="entry-content">
            <div id="sticky-anchor"></div>
            <!--div class=" wpb_row kwayy-row-textcolor- vc_row-fluid menubar">
              <div class="section clearfix grid_section" style="overflow: visible;">
                  <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                      <img  class="menulogo" src="http://localhost/kevin/wp-content/uploads/2016/05/logo.png">
                      <?php
                      wp_nav_menu( array(
                          'menu' => 'main-menu'
                      ) );

                      ?>
                      <div class="clearfix"></div>
                    </div>
                  </div>
              </div>
            </div-->
          <div id="portfolio">
            <div id="<?php echo $category->slug; ?>" class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid orange <?php echo $category->slug; ?> scale-anm all">
                <div class="section clearfix grid_section" >
                    <div class="vc_col-sm-12 wpb_column vc_column_container ">
                      <div class="wpb_wrapper">
                        <p class="decription text-center">PROGRAMING</p>
                        <p class="category text-center">CONTAINER EXHIBITION</p>
                        <div class="last-post">
                          <?php
                          $args = array(
                            'numberposts' => 3,
                            'offset' => 0,
                            'category' =>"CONTAINER EXHIBITIONS",
                            'orderby' => 'post_date',
                            'order' => 'DESC',
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'suppress_filters' => true );
                             $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
                            foreach( $recent_posts as $recent ){
                          ?>

                          <div class=" col-md-4 col-lg-4 col-sm-12 col-xs-12 baiviet">
                                <div class="thumnail-recent">
                                    <?php echo wp_get_attachment_image( get_post_thumbnail_id($recent["ID"]), 'medium', false, '' ); ?>
                                    <div class="thumnail-recent-hover"><div></div></div>
                                </div>
                                <p class="title-recent-post bold justify"><?php echo $recent["post_title"]; ?></p>
                                <p class="expert-recent-post justify"> <span class="overline-expert"></span><span class="featuring">Featuring:</span>To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                                <a href="<?php echo get_permalink($recent["ID"]) ?>" class="see-more">More</a>
                          </div>
                        <?php } ?>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div id="<?php echo $category->slug; ?>" class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid  whites <?php echo $category->slug; ?> scale-anm all">
                <div class="section clearfix grid_section">
                    <div class="vc_col-sm-12 wpb_column vc_column_container ">
                      <div class="wpb_wrapper">
                        <div class="last-post">
                          <?php
                          $args = array(
                            'numberposts' => 5,
                            'offset' => 0,
                            'category' =>"CONTAINER EXHIBITIONS",
                            'orderby' => 'post_date',
                            'order' => 'DESC',
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'suppress_filters' => true );
                             $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
                             $u3=1;
                            foreach( $recent_posts as $recent ){
                              if($u3>3):
                          ?>


                          <div class=" col-md-6 col-lg-6 col-sm-12 col-xs-12 baiviet">
                                <div class="thumnail-recent">
                                    <?php echo wp_get_attachment_image( get_post_thumbnail_id($recent["ID"]), 'medium', false, '' ); ?>
                                    <div class="thumnail-recent-hover"><div></div></div>
                                </div>
                                <p class="title-recent-post bold justify"><?php echo $recent["post_title"]; ?></p>
                                <p class="expert-recent-post justify"> <span class="overline-expert"></span> <span class="featuring">Featuring:</span>To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                                <a href="<?php echo get_permalink($recent["ID"]) ?>" class="see-more">More</a>
                          </div>

                        <?php endif; $u3++;} ?>
                          <div class="clearfix"></div>
                          <div class="row">
                            <div class=" col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <p class="text-center view-more-container"><a href="<?php echo get_site_url(); ?>/container-exhibitions/">VIEW MORE CONTAINER EXHIBITION</a></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div id="<?php echo $category->slug; ?>" class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid  orange one-post white-color <?php echo $category->slug; ?> scale-anm all">
                <div class="section clearfix grid_section">
                    <div class="vc_col-sm-12 wpb_column vc_column_container ">
                      <div class="wpb_wrapper">
                        <div class="last-post">
                          <div class=" col-md-4 col-lg-4 col-sm-12 col-xs-12 ">
                              <div class="thumnail-recent">
                                <img src="http://localhost/kevin/wp-content/uploads/2016/05/hours.jpg" />
                              </div>
                          </div>
                          <div class=" col-md-8 col-lg-8 col-sm-12 col-xs-12 ">
                                <p class="know-more justify">KNOW MORE</p>
                                <p class="category-name justify">[ Hours of operations ]</p>

                                <p class="expert-recent-post justify"> To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                                <a href="<?php echo get_site_url(); ?>/hours-of-operation/" class="see-more">Detail</a>
                          </div>
                          </div>

                      </div>
                    </div>
                </div>
              </div>
              <div id="<?php echo $category->slug; ?>" class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid  whites <?php echo $category->slug; ?> scale-anm all">
                  <div class="section clearfix grid_section">
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <div class="wpb_wrapper">
                          <p class="decription text-center">PROGRAMING</p>
                          <p class="category text-center"><span class="orange-color">[</span>OUTDOOR INSTALATIONS<span class="orange-color">]</span></p>
                          <div class="last-post">
                            <?php
                            $args = array(
                              'numberposts' => 4,
                              'offset' => 0,
                              'category' =>"OUTDOOR INSTALATIONS",
                              'orderby' => 'post_date',
                              'order' => 'DESC',
                              'post_type' => 'post',
                              'post_status' => 'publish',
                              'suppress_filters' => true );
                               $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
                              foreach( $recent_posts as $recent ){
                                $categories = get_the_category($recent["ID"]);
                                $catid=$categories[0]->cat_ID;
                            ?>

                            <div class=" col-md-3 col-lg-3 col-sm-12 col-xs-12 baiviet">
                                  <div class="thumnail-recent">
                                      <?php echo wp_get_attachment_image( get_post_thumbnail_id($recent["ID"]), 'medium', false, '' ); ?>
                                      <div class="thumnail-recent-hover"><div></div></div>
                                  </div>
                                  <p class="title-recent-post bold justify"><?php echo $recent["post_title"]; ?></p>
                                  <p class="expert-recent-post justify"> <span class="overline-expert"></span> <span class="featuring">Featuring:</span>To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                                  <a href="<?php echo get_permalink($recent["ID"]) ?>" class="see-more">More</a>
                            </div>
                          <?php } ?>
                            <div class="clearfix"></div>
                            <div class="row">
                              <div class=" col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                  <p class="text-center view-more-container"><a href="<?php echo get_site_url(); ?>/outdoor-instalations/">VIEW MORE OUTDOOR INSTALATIONS</a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div id="<?php echo $category->slug; ?>" class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid  gray <?php echo $category->slug; ?> scale-anm all">
                  <div class="section clearfix grid_section">
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <div class="wpb_wrapper">
                          <p class="decription text-center">PROGRAMING</p>
                          <p class="category text-center"><span class="orange-color">[</span>2016 programming<span class="orange-color">]</span></p>
                          <div class="last-post">
                            <?php
                            $args = array(
                              'numberposts' => 5,
                              'offset' => 0,
                              'category' =>'programing-2016',
                              'orderby' => 'post_date',
                              'order' => 'DESC',
                              'post_type' => 'post',
                              'post_status' => 'publish',
                              'suppress_filters' => true );
                               $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
                               $i=1;
                              foreach( $recent_posts as $recent ){
                                $categories = get_the_category($recent["ID"]);
                                $catid=$categories[0]->cat_ID;
                            ?>
                            <?php if($i<3){ ?>
                                <div class=" col-md-6 col-lg-6 col-sm-12 col-xs-12 baiviet">
                                      <div class="thumnail-recent">
                                          <?php echo wp_get_attachment_image( get_post_thumbnail_id($recent["ID"]), 'medium', false, '' ); ?>
                                          <div class="thumnail-recent-hover"><div></div></div>
                                      </div>
                                      <p class="title-recent-post bold justify"><?php echo $recent["post_title"]; ?></p>
                                      <p class="expert-recent-post justify"> <span class="overline-expert"></span> <span class="featuring">Featuring:</span>To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                                      <a href="<?php echo get_permalink($recent["ID"]) ?>" class="see-more">More</a>
                                </div>
                              <?php } else{

                                ?>
                                <div class=" col-md-4 col-lg-4 col-sm-12 col-xs-12 baiviet">
                                      <div class="thumnail-recent">
                                          <?php echo wp_get_attachment_image( get_post_thumbnail_id($recent["ID"]), 'medium', false, '' ); ?>
                                          <div class="thumnail-recent-hover"><div></div></div>
                                      </div>
                                      <p class="title-recent-post bold justify"><?php echo $recent["post_title"]; ?></p>
                                      <p class="expert-recent-post justify"> <span class="overline-expert"></span> <span class="featuring">Featuring:</span>To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                                      <a href="<?php echo get_permalink($recent["ID"]) ?>" class="see-more">More</a>
                                </div>
                              <?php } ?>
                          <?php $i++; } ?>
                            <div class="clearfix"></div>
                            <div class="row">
                              <div class=" col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                  <p class="text-center view-more-container"><a href="<?php echo get_site_url(); ?>/programing-2016/" >VIEW MORE 2016 PROGRAMMING</a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div  class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid orange scale-anm all">
                  <div class="section clearfix grid_section" >
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <?php echo do_shortcode('[the-logo-slider]');?>
                      </div>
                  </div>
              </div>
              <div id="<?php echo $category->slug; ?>" class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid  whites <?php echo $category->slug; ?> scale-anm all">
                  <div class="section clearfix grid_section">
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <div class="wpb_wrapper">
                          <p class="decription text-center">PROGRAMING</p>
                          <p class="category text-center"><span class="orange-color">[</span>PHOTOSHELTER PROFESSIONAL DEVELOPMENT DAY<span class="orange-color">]</span></p>
                          <div class="last-post">
                            <?php
                            $args = array(
                              'numberposts' => 4,
                              'offset' => 0,
                              'category' =>'deloyment-day',
                              'orderby' => 'post_date',
                              'order' => 'DESC',
                              'post_type' => 'post',
                              'post_status' => 'publish',
                              'suppress_filters' => true );
                               $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
                              foreach( $recent_posts as $recent ){
                                $categories = get_the_category($recent["ID"]);
                                $catid=$categories[0]->cat_ID;
                            ?>

                            <div class=" col-md-3 col-lg-3 col-sm-12 col-xs-12 baiviet">
                                  <div class="thumnail-recent">
                                      <?php echo wp_get_attachment_image( get_post_thumbnail_id($recent["ID"]), 'medium', false, '' ); ?>
                                      <div class="thumnail-recent-hover"><div></div></div>
                                  </div>
                                  <p class="title-recent-post bold justify"><?php echo $recent["post_title"]; ?></p>
                                  <p class="expert-recent-post justify"> <span class="overline-expert"></span> <span class="featuring">Featuring:</span>To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                                  <a href="<?php echo get_permalink($recent["ID"]) ?>" class="see-more">More</a>
                            </div>
                          <?php } ?>
                            <div class="clearfix"></div>
                            <div class="row">
                              <div class=" col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                  <p class="text-center view-more-container"><a href="<?php echo get_site_url(); ?>/photoshelter-professional-development-day/">VIEW MORE PHOTOSELTER/a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
               <!--div class=" wpb_row kwayy-row-textcolor- vc_row-fluid search-row ">
                   <div class="section clearfix grid_section">
                     <div class="vc_col-sm-4 wpb_column vc_column_container ">
                       <div class="wpb_wrapper">
                        <p class="lookingfor text-center">LOOKING FOR SOMETHING</p>
                       </div>
                     </div>
                       <div class="vc_col-sm-8 wpb_column vc_column_container ">
                         <div class="wpb_wrapper">
                           <?php get_search_form(true); ?>
                         </div>
                       </div>
                   </div>
               </div-->

          </div>
        </div>
      </div>
  </article>
</div>
<script>
function sticky_relocate() {
  //  alert("sdfsf");
    var window_top = jQuery(window).scrollTop();
    var div_top = jQuery('#sticky-anchor').offset().top;
    console.log(div_top);
    if (window_top > div_top) {
        jQuery('.menubar').addClass('stick');
    } else {
        jQuery('.menubar').removeClass('stick');
       jQuery('#sticky-anchor').height(0);
    }
}

jQuery(function() {
    jQuery(window).scroll(sticky_relocate);
    sticky_relocate();

});
jQuery(document).ready(function (){

           jQuery(".fil-cat").click(function (){
             var id=jQuery(this).attr("data-rel");
               jQuery('html, body').animate({
                   scrollTop: jQuery("#"+id).offset().top  }, 1000);
           });
       });
jQuery( "#menu-main-menu li" ).each(function( index ) {
   jQuery( this ).attr('data-rel', jQuery( this ).attr('class').split(' ').pop());

});
jQuery("#menu-main-menu .fil-cat a:first-child").attr("href","#");

/*
jQuery(function() {
		var selectedClass = "";
		jQuery("#menu-main-menu .fil-cat:not('.menu-item-has-children') ").click(function(){
      jQuery(".fil-cat" ).removeClass("mega-current-menu-item");
       jQuery( this ).addClass("mega-current-menu-item");
  		selectedClass = jQuery(this).attr("data-rel");
       jQuery("#portfolio").fadeTo(100, 0.1);
  		jQuery("#portfolio .for-filter").not("."+selectedClass).fadeOut().removeClass('scale-anm');
      setTimeout(function() {
        jQuery("."+selectedClass).fadeIn().addClass('scale-anm');
        jQuery("#portfolio").fadeTo(300, 1);
      }, 300);
      return false;
	  });
});

*/
</script>
<?php  get_footer(); ?>
