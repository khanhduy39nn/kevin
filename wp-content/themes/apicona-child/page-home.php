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
                                  <a href="<?php echo get_permalink($recent["ID"]) ?>">
                                    <div class="thumnail-recent">
                                        <?php echo wp_get_attachment_image( get_post_thumbnail_id($recent["ID"]), 'medium', false, '' ); ?>
                                        <div class="thumnail-recent-hover"><div></div></div>
                                    </div>
                                    <p class="title-recent-post bold justify"><?php echo $recent["post_title"]; ?></p>
                                    <p class="expert-recent-post justify"> <div class="overline-expert"></div> To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                                    <a href="<?php echo get_permalink($recent["ID"]) ?>" class="see-more">More</a>
                                  </a>
                              </div>
                            <?php } ?>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>

                <div class="wpb_row kwayy-row-textcolor- vc_row-fluid  white">
                    <div class="section clearfix grid_section">
                        <div class="vc_col-sm-12 wpb_column vc_column_container ">
                          <div class="wpb_wrapper">
                            <p class="decription text-center">PROGRAMING</p>
                            <p class="category text-center">CONTAINER EXHIBITION</p>
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
                                foreach( $recent_posts as $recent ){
                              ?>

                              <div class=" col-md-6 col-lg-6 col-sm-12 col-xs-12 baiviet">
                                  <a href="<?php echo get_permalink($recent["ID"]) ?>">
                                    <div class="thumnail-recent">
                                        <?php echo wp_get_attachment_image( get_post_thumbnail_id($recent["ID"]), 'medium', false, '' ); ?>
                                        <div class="thumnail-recent-hover"><div></div></div>
                                    </div>
                                    <p class="title-recent-post bold justify"><?php echo $recent["post_title"]; ?></p>
                                    <p class="expert-recent-post justify"> <div class="overline-expert"></div> To exclude posts with a certain post format, you can use like this next example, which excludes all posts with the 'aside' and 'image' formats</p>
                                    <a href="<?php echo get_permalink($recent["ID"]) ?>" class="see-more">More</a>
                                  </a>
                              </div>
                            <?php } ?>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
</div>
<?php  get_footer(); ?>
