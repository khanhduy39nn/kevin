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
    <div id="content" class="site-content" role="main">
        <article id="post-40" class="post-40 page type-page status-publish hentry">
            <div class="entry-content">
                <div class="wpb_row kwayy-row-textcolor- vc_row-fluid">
                    <div class="section clearfix grid_section">
                        <div class="vc_col-sm-12 gachdoc wpb_column vc_column_container ">
                            <div class="wpb_wrapper">
                              <div id="navbar" class="k_searchbutton">
                                  <nav id="site-navigation" class="navigation main-navigation" role="navigation">
                                    <h3 class="menu-toggle">
                                      <span>Toggle menu</span><i class="kwicon-fa-navicon"></i>              </h3>
                                    <a class="screen-reader-text skip-link" href="#content" title="Skip to content">
                                    Skip to content              </a>
                                    <div class="nav-menu">
                                      <?php wp_nav_menu( array('menu' => 'main-menu') ); ?>
                                    </div><!-- .k_flying_searchform -->

                                  </nav>
                                  <!-- #site-navigation -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>
<?php  get_footer(); ?>
