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
            <div class="wpb_row kwayy-row-textcolor- vc_row-fluid">
              <div class="section clearfix grid_section">
                  <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                      <?php
                      wp_nav_menu( array(
                          'menu' => 'main-menu'
                      ) );


                      $menu_name = 'custom_menu_slug';

                          $menu_items = wp_get_nav_menu_items(204);

                          $menu_list = '<ul id="menu-' . $menu_name . '">';

                          foreach ( (array) $menu_items as $key => $menu_item ) {
                              $title = $menu_item->title;
                              $url = $menu_item->url;
                              $menu_list .= '<li><a href="' . $url . '">' . $title . '</a></li>';
                          }
                          $menu_list .= '</ul>';
                        echo $menu_list;
                      ?>

                    </div>
                  </div>
              </div>
            </div>
          <div class="wpb_row kwayy-row-textcolor- vc_row-fluid orange">
              <div class="section clearfix grid_section">
                  <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                      <p class="decription text-center">PROGRAMING</p>
                      <p class="category text-center">CONTAINER EXHIBITION</p>
                      <div class="last-post">
                        <?php
                        $args = array(
                          'numberposts' => 3,
                          'offset' => 0,
                          'category' => "programing",
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

          <div class="wpb_row kwayy-row-textcolor- vc_row-fluid  whites">
              <div class="section clearfix grid_section">
                  <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                      <div class="last-post">
                        <?php
                        $args = array(
                          'numberposts' => 2,
                          'offset' => 0,
                          'category' => "programing",
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
          <div class="wpb_row kwayy-row-textcolor- vc_row-fluid  orange one-post white-color">
              <div class="section clearfix grid_section">
                  <div class="vc_col-sm-12 wpb_column vc_column_container ">
                    <div class="wpb_wrapper">
                      <div class="last-post">
                        <?php
                        $args = array(
                          'numberposts' => 1,
                          'offset' => 0,
                          'category' => "programing",
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
                              <p class="category-name justify">[<?php echo $categories[0]->name; ?>]</p>

                              <p class="expert-recent-post justify"> To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                              <a href="<?php echo get_permalink($recent["ID"]) ?>" class="see-more">More</a>
                        </div>
                        </div>
                      <?php } ?>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="wpb_row kwayy-row-textcolor- vc_row-fluid  whites">
                  <div class="section clearfix grid_section">
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <div class="wpb_wrapper">
                          <div class="last-post">
                            <?php
                            $args = array(
                              'numberposts' => 4,
                              'offset' => 0,
                              'category' => "programing",
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
              <div class="wpb_row kwayy-row-textcolor- vc_row-fluid  gray">
                  <div class="section clearfix grid_section">
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <div class="wpb_wrapper">
                          <p class="decription text-center">PROGRAMING</p>
                          <p class="category text-center"><span class="orange-color">[</span>CONTAINER EXHIBITION<span class="orange-color">]</span></p>
                          <div class="last-post">
                            <?php
                            $args = array(
                              'numberposts' => 5,
                              'offset' => 0,
                              'category' => "programing",
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

              <div class="wpb_row kwayy-row-textcolor- vc_row-fluid  whites">
                  <div class="section clearfix grid_section">
                      <div class="vc_col-sm-12 wpb_column vc_column_container ">
                        <div class="wpb_wrapper">
                          <p class="decription text-center">PROGRAMING</p>
                          <p class="category text-center"><span class="orange-color">[</span>CONTAINER EXHIBITION<span class="orange-color">]</span></p>
                          <div class="last-post">
                            <?php
                            $args = array(
                              'numberposts' => 4,
                              'offset' => 0,
                              'category' => "programing",
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
          </div>
      </div>
  </article>

</div>
<style>
.tile {
    -webkit-transform: scale(0);
    transform: scale(0);
    -webkit-transition: all 350ms ease;
    transition: all 350ms ease;

}
.tile:hover {

}

.scale-anm {
  transform: scale(1);
}


.tile img {
    max-width: 100%;
    width: 100%;
    height: auto;
    margin-bottom: 1rem;

}

.btn {
    font-family: Lato;
    font-size: 1rem;
    font-weight: normal;
    text-decoration: none;
    cursor: pointer;
    display: inline-block;
    line-height: normal;
    padding: .5rem 1rem;
    margin: 0;
    height: auto;
    border: 1px solid;
    vertical-align: middle;
    -webkit-appearance: none;
    color: #555;
    background-color: rgba(0, 0, 0, 0);
}

.btn:hover {
  text-decoration: none;
}

.btn:focus {
  outline: none;
  border-color: var(--darken-2);
  box-shadow: 0 0 0 3px var(--darken-3);
}

::-moz-focus-inner {
  border: 0;
  padding: 0;
}
</style>
<script>
jQuery(function() {
		var selectedClass = "";
		jQuery(".fil-cat").click(function(){
		selectedClass = jQuery(this).attr("data-rel");
     jQuery("#portfolio").fadeTo(100, 0.1);
		jQuery("#portfolio div").not("."+selectedClass).fadeOut().removeClass('scale-anm');
    setTimeout(function() {
      jQuery("."+selectedClass).fadeIn().addClass('scale-anm');
      jQuery("#portfolio").fadeTo(300, 1);
    }, 300);

	});
});

jQuery( "#menu-main-menu li" ).each(function( index ) {
  console.log( index + ": " + jQuery( this ).text() );
});
</script>
<?php  get_footer(); ?>
