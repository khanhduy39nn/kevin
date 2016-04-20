<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */

get_header();

// Checking if Blog page
$primaryclass = 'col-md-12 col-lg-12 col-sm-12 col-xs-12';
global $apicona;
$sidebar = $apicona['sidebar_blog']; // Global settings

$sidebarposition = get_post_meta( get_the_ID(), '_kwayy_post_options_sidebarposition', true);

// Page settings
if( isset($sidebarposition) && trim($sidebarposition) != '' ){
    $sidebar = $sidebarposition;
}

// Primary Content class
$primaryclass = setPrimaryClass($sidebar);


?>
    <div class="container">
        <div class="row">

            <div id="primary" class="content-area <?php echo $primaryclass; ?>">
                <div id="content" class="site-content" role="main">

                    <?php /* The loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php get_template_part( 'content', get_post_format() ); ?>
                        <?php apicona_post_nav(); ?>
                        <?php comments_template(); ?>

                    <?php endwhile; ?>

                </div><!-- #content -->
            </div><!-- #primary -->

            <?php
            // Sidebar 1 (Left Sidebar)
            if($sidebar=='left' || $sidebar=='both' || $sidebar=='bothleft' || $sidebar=='bothright' ){
                get_sidebar('left');
            }

            // Sidebar 2 (Right Sidebar)
            if($sidebar=='right' || $sidebar=='both' || $sidebar=='bothleft' || $sidebar=='bothright' ){
                get_sidebar('right');
            }
            ?>

        </div><!-- .row -->
    </div><!-- .container -->
<?php get_footer(); ?>

<script>
    jQuery(document).ready(function($){
        var data=$('.kwayy-row-bgprecolor-skin.kwayy-row-parallax').clone();
        $('.kwayy-row-bgprecolor-skin.kwayy-row-parallax').remove();
        $('#main').append(data);

        $('.vc_col-sm-12.wpb_column.vc_column_container .wpb_wrapper').css("padding","0px 50px");

    });


</script>