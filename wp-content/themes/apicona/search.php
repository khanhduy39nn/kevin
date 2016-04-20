<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */

get_header();

global $apicona;
$sidebar         = $apicona['sidebar_search']; // Global settings

// Primary Content class
$primaryclass = setPrimaryClass($sidebar);

?>

<div class="container">
	<div class="row">

		<div id="primary" class="content-area <?php echo $primaryclass; ?>">
			<div id="content" class="site-content" role="main">
			
			<?php if( get_query_var('post_type')=='team_member' && trim(get_query_var('s'))!='' ): ?>
				<div class="kwayy-content-team-search-box">
					<?php echo kwayy_team_search_form(); ?>
				</div>
			<?php endif; ?>
			
			<?php if ( have_posts() ) : ?>

				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php if(get_post_type() == 'team_member' ): ?>
						<?php get_template_part( 'content', 'teammember' ); ?>
					<?php else: ?>
						<?php
						if( isset($apicona['blog_view']) && trim($apicona['blog_view'])!='' && trim($apicona['blog_view'])!='classic' ) {
							echo kwayy_blogbox($apicona['blog_view']);
						} else {
							get_template_part( 'content', get_post_format() );
						}
						?>
					<?php endif; ?>
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