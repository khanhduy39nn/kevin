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
            <div class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid menubar">
              <div class="section clearfix grid_section" style="overflow: visible;">
                  <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                      <?php get_header_image(); ?>
                      <?php
                      wp_nav_menu( array(
                          'menu' => 'main-menu'
                      ) );

                      ?>
                      <div class="clearfix"></div>
                    </div>
                  </div>
              </div>
            </div>
          <div id="portfolio">
          <?php
            $args = array('child_of' => 205);
            $categories = get_categories( $args );
            $i=1;
            foreach($categories as $category):
                if($i==1):
          ?>

          <div class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid orange <?php echo $category->slug; ?> scale-anm all">
              <div class="section clearfix grid_section" >
                  <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                      <p class="decription text-center"><?php echo mb_strtoupper($category->name); ?></p>
                      <p class="category text-center">CONTAINER EXHIBITION</p>
                      <div class="last-post">
                        <?php
                        $args = array(
                          'numberposts' => 3,
                          'offset' => 0,
                          'category' =>  $category->name,
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
        <?php elseif($i==2): ?>
          <div class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid  whites <?php echo $category->slug; ?> scale-anm all">
              <div class="section clearfix grid_section">
                  <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                      <p class="decription text-center">PROGRAMING</p>
                      <p class="category text-center"><span class="orange-color">[</span><?php echo mb_strtoupper($category->name); ?><span class="orange-color">]</span></p>
                      <div class="last-post">
                        <?php
                        $args = array(
                          'numberposts' => 2,
                          'offset' => 0,
                          'category' =>$category->name,
                          'orderby' => 'post_date',
                          'order' => 'DESC',
                          'post_type' => 'post',
                          'post_status' => 'publish',
                          'suppress_filters' => true );
                           $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
                           $catid="";
                          foreach( $recent_posts as $recent ){
                              $categories = get_the_category($recent["ID"]);
                              $catid=$categories[0]->cat_ID;

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
                      <?php } ?>
                        <div class="clearfix"></div>
                        <div class="row">
                          <div class=" col-md-12 col-lg-12 col-sm-12 col-xs-12">
                              <p class="text-center view-more-container"><a href="<?php   echo get_category_link($catid); ?>">VIEW MORE CONTAINER EXHIBITION</a></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
        <?php elseif($i==3): ?>
          <div class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid  orange one-post white-color <?php echo $category->slug; ?> scale-anm all">
              <div class="section clearfix grid_section">
                  <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                      <div class="last-post">
                        <?php
                        $args = array(
                          'numberposts' => 1,
                          'offset' => 0,
                          'category' =>$category->name,
                          'orderby' => 'post_date',
                          'order' => 'DESC',
                          'post_type' => 'post',
                          'post_status' => 'publish',
                          'suppress_filters' => true );
                           $recent_posts = wp_get_recent_posts( $args, ARRAY_A );
                          foreach( $recent_posts as $recent ){
                            $categories = get_the_category($recent["ID"]);
                        ?>
                        <div class=" col-md-4 col-lg-4 col-sm-12 col-xs-12 ">
                            <div class="thumnail-recent">
                                <?php echo wp_get_attachment_image( get_post_thumbnail_id($recent["ID"]), 'medium', false, '' ); ?>
                            </div>
                        </div>
                        <div class=" col-md-8 col-lg-8 col-sm-12 col-xs-12 ">
                              <p class="know-more justify">KNOW MORE</p>
                              <p class="category-name justify">[<?php echo mb_strtoupper($category->name); ?>]</p>

                              <p class="expert-recent-post justify"> To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                              <a href="<?php echo get_permalink($recent["ID"]) ?>" class="see-more">More</a>
                        </div>
                        </div>
                      <?php } ?>
                      </div>
                    </div>
                  </div>
              </div>
            <?php elseif($i==4): ?>
              <div class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid  whites <?php echo $category->slug; ?> scale-anm all">
                  <div class="section clearfix grid_section">
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <div class="wpb_wrapper">
                          <p class="decription text-center">PROGRAMING</p>
                          <p class="category text-center"><span class="orange-color">[</span><?php echo mb_strtoupper($category->name); ?><span class="orange-color">]</span></p>
                          <div class="last-post">
                            <?php
                            $args = array(
                              'numberposts' => 4,
                              'offset' => 0,
                              'category' =>$category->name,
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
                                  <p class="text-center view-more-container"><a href="<?php   echo get_category_link($catid); ?>">VIEW MORE CONTAINER EXHIBITION</a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
            <?php elseif($i==5): ?>
              <div class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid  gray <?php echo $category->slug; ?> scale-anm all">
                  <div class="section clearfix grid_section">
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <div class="wpb_wrapper">
                          <p class="decription text-center">PROGRAMING</p>
                          <p class="category text-center"><span class="orange-color">[</span><?php echo mb_strtoupper($category->name); ?><span class="orange-color">]</span></p>
                          <div class="last-post">
                            <?php
                            $args = array(
                              'numberposts' => 5,
                              'offset' => 0,
                              'category' =>$category->name,
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
                                  <p class="text-center view-more-container"><a href="<?php   echo get_category_link($catid); ?>">VIEW MORE CONTAINER EXHIBITION</a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid orange scale-anm all">
                  <div class="section clearfix grid_section" >
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <?php echo do_shortcode('[the-logo-slider]');?>
                      </div>
                  </div>
              </div>
            <?php elseif($i==7): ?>
              <div class="for-filter wpb_row kwayy-row-textcolor- vc_row-fluid  whites <?php echo $category->slug; ?> scale-anm all">
                  <div class="section clearfix grid_section">
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <div class="wpb_wrapper">
                          <p class="decription text-center">PROGRAMING</p>
                          <p class="category text-center"><span class="orange-color">[</span><?php echo mb_strtoupper($category->name); ?><span class="orange-color">]</span></p>
                          <div class="last-post">
                            <?php
                            $args = array(
                              'numberposts' => 4,
                              'offset' => 0,
                              'category' =>$category->name,
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
                                  <p class="text-center view-more-container"><a href="<?php   echo get_category_link($catid); ?>">VIEW MORE CONTAINER EXHIBITION</a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <?php
            endif;
            $i++;
          endforeach;
               ?>
          </div>
        </div>
      </div>
  </article>

</div>
<script>
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
jQuery( "#menu-main-menu li" ).each(function( index ) {
   jQuery( this ).attr('data-rel', jQuery( this ).attr('class').split(' ').pop());
});

jQuery( "#menu-main-menu ul:not('.sub-menu') li a" ).attr("href","#");
</script>
<?php  get_footer(); ?>
