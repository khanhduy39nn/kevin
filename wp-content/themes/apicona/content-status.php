<?php
/**
 * The template for displaying posts in the Status post format
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="kwayy-post-left">
    <?php kwayy_entry_date(); ?>
  </div>
  <!-- .kwayy-post-left -->
  
  <div class="kwayy-post-right">
    <div class="postcontent">
      <div class="entry-content">
        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'apicona' ) ); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'apicona' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
      </div><!-- .entry-content -->
    </div><!-- .postcontent -->
	  
      <footer class="entry-meta">
        <?php edit_post_link( __( 'Edit', 'apicona' ), '<span class="edit-link">', '</span>' ); ?>
        <?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
        <?php get_template_part( 'author-bio' ); ?>
        <?php endif; ?>
      </footer><!-- .entry-meta -->
  </div>
  <!-- .kwayy-post-right -->
  
  <div class="clearfix"></div>
</article>
<!-- #post --> 
