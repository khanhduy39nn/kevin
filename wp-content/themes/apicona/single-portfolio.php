<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage GoMetro
 * @since GoMetro 1.0
 */

get_header();

$clientName = get_post_meta( get_the_ID(),'_kwayy_portfolio_data_clientname',true);
$clientLink = get_post_meta( get_the_ID(),'_kwayy_portfolio_data_clientlink',true);
$skills     = get_post_meta( get_the_ID(),'_kwayy_portfolio_data_skills',true);
$terms      = wp_get_post_terms( get_the_ID(), 'portfolio_category' );

$portfolioLinkText = get_post_meta( get_the_ID(),'_kwayy_portfolio_data_portfoliolinktext',true);
$portfolioLinkUrl  = get_post_meta( get_the_ID(),'_kwayy_portfolio_data_portfoliolinkurl',true);

global $apicona;


/********* Generating array for Project Details box **********/
/*$detailsbox = '';
$detailsArray = array();
if($clientName != ''){ // Client Name and link
	if($clientLink != ''){
		$detailsArray[] = '<strong>'._('Client').'</strong>: <a href="'.$clientLink.'" target="_blank">'.$clientName.'</a>';
	} else {
		$detailsArray[] = '<strong>'._('Client').'</strong>: '.$clientName;
	}
}

if($skills != ''){ // Skills
	$detailsArray[] = '<strong>'._('Skills').'</strong>: '.$skills;
}

if(is_array($terms)){ // Category
	$termlist = array();
	foreach($terms as $term){
		$termlist[] = $term->name;
	}
	$detailsArray[] = '<strong>'._('Category').'</strong>: '.implode(', ',$termlist);
}*/
/*************************************************************/


/************** Generating Product Details Box ***************/
/*if( (is_array($detailsArray) && count($detailsArray)>0) || trim($portfolioLinkUrl)!='' ){
	$detailsbox = '<div class="portfolio-details"><h2>'.__('Project Details','apicona').':</h2>';
	// Project Details
	if(is_array($detailsArray) && count($detailsArray)>0){
		$detailsbox .= '<ul class="list2">';
		foreach($detailsArray as $detail){
			$detailsbox .= '<li>'.$detail.'</li>';
		}
		$detailsbox .= '</ul>';
	}
	// Project Link
	if( trim($portfolioLinkUrl)!='' ){
		$detailsbox .= '<div class="portfolio-big-link-wrapper"><a class="portfolio-big-link" href="'.$portfolioLinkUrl.'" target="_blank">'.$portfolioLinkText.'</a></div>';
	}
	
	$detailsbox .= '</div>';
	
	
}*/
/*************************************************************/

?>
	<div class="container">
		<div id="primary" class="site-content col">
			<div id="content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
				<?php $categories = get_the_category( get_the_ID() ); /* Getting category list for showing related portfolio items */ ?>
				
				<div class="row">
				
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="kwayy-portfolio-content col-md-7">
							<div class="entry-content">
								<?php kwayy_get_portfolio_featured_content(); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'apicona' ), 'after' => '</div>' ) ); ?>
							</div><!-- .entry-content -->
							<footer class="entry-meta">
								<?php edit_post_link( __( 'Edit', 'apicona' ), '<span class="edit-link">', '</span>' ); ?>
							</footer><!-- .entry-meta -->
						</div><!-- .kwayy-portfolio-content -->
						<div id="kwayy-portfolio-sidebar" class="kwayy-portfolio-aside col-md-5">
							<div class="portfolio-description">
								<?php echo do_shortcode('[heading tag="h2" text="' . __($apicona['portfolio_description'], 'apicona') . '"]'); ?>
								<div id="sidebar-inner">
									<?php the_content(); ?>
								</div>
							</div><!-- .portfolio-description -->
							<div class="portfolio-meta-details">
								<?php kwayy_portfolio_detailsbox(); ?>
							</div><!-- #portfolio-description -->
						</div><!-- .portfolio-meta-details -->
					</article><!-- #post -->
					
                </div><!-- .row -->
				
				<?php endwhile; // end of the loop. ?>
              
              
				<?php
				if( $apicona['portfolio_show_related'] == '1' ){

					$catid      = wp_get_post_terms( get_the_ID() , 'portfolio_category', array("fields" => "ids"));
					$thisPostID = array(get_the_ID());
					
					$args = array(
						'post__not_in'	=> $thisPostID,
						'post_type' => 'portfolio',
						'showposts' => 4,
						'tax_query' => array(
							array(
								'taxonomy' => 'portfolio_category',
								'field'    => 'id',
								'terms'    => $catid,
							)
						),
						'orderby' => 'rand',
					);
					
					$relatedPortfolio = new WP_Query( $args );
					
					
					if ( $relatedPortfolio->have_posts() ) {
						echo '<div class="kwayy-portfolio-related">';
						echo do_shortcode('[heading tag="h2" text="' . __($apicona['portfolio_related_title'], 'apicona') . '"]');
						echo '<div clas="container"><div class="row">';
						while ( $relatedPortfolio->have_posts() ) { $relatedPortfolio->the_post(); ?>
							<?php echo kwayy_portfoliobox( 'four' ); ?>
						<?php }; // end of the loop.
						echo '</div></div></div>';
					};
					
					// Restore original Post Data
					wp_reset_postdata();
					
				} // IF : $apicona['portfolios_show_related'] == '1'
				?>
              
				</div><!-- #content -->
			</div>
		</div>
        <!-- #primary -->	

<?php get_footer(); ?>
