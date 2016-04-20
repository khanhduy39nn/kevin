<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */

get_header();



// Checking if Blog page
$primaryclass = 'col-md-12 col-lg-12 col-xs-12';
if( is_home() ){
	global $apicona;
	
	$template    = get_page_template_slug( get_option('page_for_posts') );
	$pageSidebar = get_post_meta( get_option('page_for_posts'), '_kwayy_page_options_sidebarposition', true );
	if( is_array($pageSidebar) ){ $pageSidebar = $pageSidebar[0]; } // Converting to String if Array
	$blogSidebar = $apicona['sidebar_blog']; // Global settings
	
	
	if( $template!='template-full-width.php' ){
		if( $pageSidebar!='' ){
			$sidebar = $pageSidebar;
		} else {
			$sidebar = $blogSidebar;
		}
	} else {
		$sidebar = '';
	}
	
	

	// Page settings
	if( isset($sidebarposition) && trim($sidebarposition) != '' ){
		$sidebar = $sidebarposition;
	}

	// Primary Content class
	$primaryclass = setPrimaryClass($sidebar);
}

?>
<div class="container">
<div class="row">		

	<div id="primary" class="content-area <?php echo $primaryclass; ?>">
		<div id="content" class="site-content" role="main">
		<?php if ( have_posts() ) : ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
				if( isset($apicona['blog_view']) && trim($apicona['blog_view'])!='' && trim($apicona['blog_view'])!='classic' ) {
					echo kwayy_blogbox($apicona['blog_view']);
				} else {
					get_template_part( 'content', get_post_format() );
				}
				?>
			<?php endwhile; ?>

			<?php apicona_paging_nav(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

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