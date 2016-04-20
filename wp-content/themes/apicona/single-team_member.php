<?php
/**
 * The template for displaying Team Member
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */

get_header();

// Checking if Blog page
//$primaryclass = 'col-md-12 col-lg-12 col-sm-12 col-xs-12';
global $apicona;
//$sidebar = $apicona['sidebar_blog']; // Global settings

// Page settings
//if( isset($sidebarposition) && trim($sidebarposition) != '' ){
//	$sidebar = $sidebarposition;
//}

// Primary Content class
//$primaryclass = setPrimaryClass($sidebar);


/* Post Meta */
global $post;
$position = trim(get_post_meta( get_the_id(), '_kwayy_team_member_details_position', true ));
$email    = trim(get_post_meta( get_the_id(), '_kwayy_team_member_details_email', true ));
$excerpt  = trim($post->post_excerpt);
$title    = get_the_title();


if( trim($position)!='' ){ $position = '<h4 class="kwayy-team-position">'.$position.'</h4>'; }
if( trim($email)   !='' ){ $email = '<span class="kwayy-team-email"><a href="mailto:'.$email.'">'.$email.'</a></span>'; }



?>
<div class="container">
	<div class="row">		
		<div id="primary" class="content-area <?php echo $primaryclass; ?>">
			<article class="post single post-type-team_member">
				<div id="content" class="site-content" role="main">
					<?php /* The loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
					
					<div class="single-team-left col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ( has_post_thumbnail() ) { ?>
							<div class="kwayy-team-img">
								<?php if( has_post_thumbnail() ){  the_post_thumbnail( 'full' ); } ?>
								
								<h3><?php echo $title; ?></h3>
								
								<?php
								/* Group */
								$categories_list = get_the_term_list( get_the_ID(), 'team_group', '', ' &nbsp; &middot; &nbsp; ' ); // Team Group
								if( $categories_list!='' ){
									echo '<div class="kwayy-team-cat-links">'.$categories_list.'</div>';
								}
								?>
								
								<?php /* Social Links */ echo kwayy_team_social(); ?>
								
							</div>
						<?php } ?>
					</div>
					
					<div class="single-team-right col-xs-12 col-sm-8 col-md-8 col-lg-8"> 
						<div class="kwayy-team-title-block">
							<h2><?php
								if( isset($apicona['team_before_title_text']) ){
									if( trim($apicona['team_before_title_text'])!='' ){
										_e( trim($apicona['team_before_title_text']), 'apicona' );
										echo ' ';
									}
									echo $title;
								} else {
									_e('About', 'apicona'); echo ' '.$title;
								}
								?></h2>
							<?php echo $position . $email; ?>
						</div>
						<?php the_content(); ?>
						<?php //echo $socialcode; ?>
					</div>
					
				<?php endwhile; ?>

				</div><!-- #content -->
			</article>
		</div><!-- #primary -->
	</div><!-- .row -->
</div><!-- .containenr -->
<?php get_footer(); ?>
