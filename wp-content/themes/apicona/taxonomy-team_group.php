<?php
/**
 * The template for displaying Team Group
 *
 * Used to display team_member with a unique design.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */
global $apicona;
global $wp_query;
$tax   = $wp_query->get_queried_object();
//var_dump($tax);
/*
object(stdClass)#325 (10) {
  ["term_id"]=>
  int(19)
  ["name"]=>
  string(6) "Dental"
  ["slug"]=>
  string(6) "dental"
  ["term_group"]=>
  int(0)
  ["term_taxonomy_id"]=>
  int(19)
  ["taxonomy"]=>
  string(10) "team_group"
  ["description"]=>
  string(1344) "This is dental cat description. This is dental cat description. This is dental cat description."
  ["parent"]=>
  int(0)
  ["count"]=>
  int(2)
  ["filter"]=>
  string(3) "raw"
}
*/

/*
 * Featured Image for taxonomy
 */
$featured_img = get_option( "taxonomy_term_$tax->term_id" );
if( isset( $featured_img['kwayy_img_url'] ) ){
	$featured_img = $featured_img['kwayy_img_url'];
}

$docPostGrp = ( isset($apicona['team_group_title']) && trim($apicona['team_group_title'])!='' ) ? trim($apicona['team_group_title']) : 'Doctors' ;


get_header(); ?>

<div class="container">
	<div class="row">
		<div id="primary" class="content-area <?php echo $primaryclass; ?>">
			<div id="content" class="site-content" role="main">
			
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<!-- Left Sidebar -->
					<div class="kwayy-team-group-left col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<div class="kwayy-team-group-left-wrapper">
							<?php echo do_shortcode('[heading tag="h2" text="' . __($apicona['team_group_title'], 'apicona') . '"]'); ?>
							<?php
							$termList = get_terms( $tax->taxonomy, array('hide_empty'=>false) );
							if( is_array($termList) && count($termList)>0 ){
								echo '<div class="kwayy-team-term-list"><ul>';
								foreach( $termList as $term ){
									$active = ($tax->slug == $term->slug) ? ' class="kwayy-active" ' : '';
									echo '<li'.$active.'><a href="'.get_term_link( $term ).'">'.$term->name.'</a></li>';
								}
								echo '</ul></div>';
							}
							?>
						</div>
					</div>
					
					<!-- Right Content Area -->
					<div class="kwayy-team-group-right col-lg-9 col-md-9 col-sm-12 col-xs-12">
						
						<?php
						/*
						 * Category featured image
						 */
						if( trim($featured_img)!='' ){
							echo '<div class="kwayy-team-term-img"><img src="'.$featured_img.'" alt="'.$tax->name.'" /></div>';
						}
						?>
						
						
						<?php
						/*
						 * Category Title
						 */
						echo do_shortcode('[heading tag="h2" text="'.$tax->name.'"]');
						?>
						
						
						<?php
						/*
						 * Category description
						 */
						echo '<div class="kwayy-team-group-desc">';
						echo do_shortcode(nl2br($tax->description));
						echo '</div>';
						?>
						
						
						<?php /* The loop */ ?>
						<?php if ( have_posts() ) : ?>
							<?php echo do_shortcode('[heading tag="h2" text="'.__($docPostGrp, 'apicona').'"]'); ?>
						<?php endif; ?>
						
						<div class="row multi-columns-row">
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'content', 'teammember' ); ?>
								<?php comments_template(); ?>
							<?php endwhile; ?>
						</div><!-- .row -->
						
					</div>
				
				</article>

			</div><!-- #content -->
		</div><!-- #primary -->
	
	</div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>