<?php
/**
 * Template Name: Blog (2 columns)
 *
 * This is the template that displays Blog in one column
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */

get_header();
global $apicona;

$sidebar         = $apicona['sidebar_page']; // Global settings
$sidebarposition = get_post_meta( get_the_ID(), '_kwayy_page_options_sidebarposition', true);
$showPosts       = get_post_meta( get_the_ID(), '_kwayy_page_template_show_posts', true);
if( is_array($sidebarposition) ){ $sidebarposition = $sidebarposition[0]; } // Converting to String if Array

// Page settings
if( trim($sidebarposition) != '' ){
	$sidebar = $sidebarposition;
}

// Primary Content class
$primaryclass = setPrimaryClass($sidebar);

// Show posts per page
if( $showPosts!='' ){
	$perPage = $showPosts;
} else {
	$perPage = get_option('posts_per_page');
}

// Box Columns
$boxwidth = 'two';

?>

<div class="container">
	<div class="row">		

		<div id="primary" class="content-area <?php echo $primaryclass; ?>">
			<div id="content" class="site-content row kwayy-blog-col-page kwayy-blog-col-<?php echo $boxwidth; ?>" role="main">
				<?php
				//Protect against arbitrary paged values
				$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
				
				$args = array( 'post_type' => 'post', 'posts_per_page' => $perPage, 'paged' => $paged, );
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<?php echo kwayy_blogbox( $boxwidth ); ?>
				<?php endwhile; ?>
			</div><!-- #content -->
			
			<?php apicona_paging_nav(false, $loop); ?>
			
			<?php
			/* Restore original Post Data */
			wp_reset_postdata();
			?>
			
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