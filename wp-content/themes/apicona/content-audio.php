<?php
/**
 * The template for displaying posts in the Audio post format
 *
 * @package WordPress
 * @subpackage Apicona
 * @since Apicona 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



	<div class="kwayy-post-left">
		<?php kwayy_entry_date(); ?>
	</div><!-- .kwayy-post-left -->
	
	<div class="kwayy-post-right">
    
    <?php
	echo '<div class="kwayy-blog-media kwayy-post-audio-embed-code">';
	$embedData  = get_post_meta( get_the_ID(), '_format_audio_embed', true );
	// Check if URL
	if(substr($embedData, 0, 4) == "http") {
		$htmlcode = apply_filters('the_content', $embedData);
		echo $htmlcode;
	} else {
		echo do_shortcode($embedData);
	}
	echo '</div>';
	?>
    
    
     <div class="postcontent">
      <header class="entry-header">
        
        
        <?php if ( is_single() ) : ?>
        
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
            <div class="audio-content">
              <?php the_content( '' ); ?>
              <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'apicona' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
              </div><!-- .audio-content -->
            </div><!-- .entry-content -->
          
          <?php if ( is_single() ) : ?>
          <footer class="entry-meta">
            <div class="footer-entry-meta">
              <?php kwayy_entry_meta(); ?>
              <?php edit_post_link( __( 'Edit', 'apicona' ), '<span class="edit-link">', '</span>' ); ?>
              </div><!-- .entry-meta -->
            <?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
            <?php get_template_part( 'author-bio' ); ?>
            <?php endif; ?>
            </footer><!-- .entry-meta -->
          <?php endif; // is_single() ?>
        </div>
		
	</div><!-- .kwayy-post-right -->
	
	<div class="clearfix"></div>
	
</article><!-- #post -->
