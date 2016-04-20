<?php
/**
 * The template for displaying posts in the Gallery post format
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */
global $apicona;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<div class="kwayy-post-left">
		<?php kwayy_entry_date(); ?>
	</div><!-- .kwayy-post-left -->
	
	<div class="kwayy-post-right">

		<?php echo kwayy_featured_gallery_slider( 'post' ); ?>

		<div class="postcontent">
		  <header class="entry-header">
		    
		    <?php if ( is_single() ) : ?>

				<?php
				if( isset($apicona['tbar_title_content_hide']) && trim($apicona['tbar_title_content_hide'])=='1' ){
					// Titlebar hide
				} else {
					echo $the_title;
				}
				?>
			
		    <?php else : ?>
		    <h2 class="entry-title">
		      <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		    </h2>
		    <?php endif; // is_single() ?>
		    <div class="entry-meta">
		      <?php kwayy_entry_meta(); ?>
		      <?php edit_post_link( __( 'Edit', 'apicona' ), '<span class="edit-link">', '</span>' ); ?>
		      </div><!-- .entry-meta -->
		    </header><!-- .entry-header -->
		  
		  <div class="entry-content">
		    <?php if ( is_single() || ! get_post_gallery() ) : ?>
		    <?php the_content( '' ); ?>
		    <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'apicona' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		    <?php else : ?>
		    <?php the_content( '' ); ?>
		    <?php endif; // is_single() ?>
		    </div><!-- .entry-content -->
		  
		  <?php if ( is_single() ) : ?>
		  <footer class="entry-meta">
		    <?php edit_post_link( __( 'Edit', 'apicona' ), '<span class="edit-link">', '</span>' ); ?>
		    <?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
		    <?php get_template_part( 'author-bio' ); ?>
		    <?php endif; ?>
		    </footer><!-- .entry-meta -->
		  <?php endif; // is_single() ?>
	  </div>
		
	</div><!-- .kwayy-post-right -->
	
	<div class="clearfix"></div>
	
</article><!-- #post -->
