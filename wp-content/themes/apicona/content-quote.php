<?php
/**
 * The template for displaying posts in the Quote post format
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
		
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="kwayy-blog-media entry-thumbnail">
			<?php the_post_thumbnail(); ?>
	    </div>
	  <!-- .entry-header -->
		<?php endif; ?>

		<div class="postcontent">
          <div class="entry-header">
            <div class="entry-content">
              <blockquote>
                <?php the_content( '' ); ?>
                <?php
					$kwayy_quote_source_name = trim( get_post_meta( get_the_ID(), '_format_quote_source_name', true ) );
					$kwayy_quote_source_url  = trim( get_post_meta( get_the_ID(), '_format_quote_source_url', true ) );
					
					if( $kwayy_quote_source_url!='' && $kwayy_quote_source_name!='' ){
						?>
                <div class="kwayy_quote_source"><h3><a href="<?php echo $kwayy_quote_source_url; ?>"><?php echo $kwayy_quote_source_name; ?></a></h3></div>
                <?php
					} else if( $kwayy_quote_source_name!='' ){
						?>
                <div class="kwayy_quote_source"><h3><?php echo $kwayy_quote_source_name; ?></h3></div>
                <?php
					} else if( $kwayy_quote_source_url!='' ){
						?>
                <div class="kwayy_quote_source"><h3><a href="<?php echo $kwayy_quote_source_url; ?>"><?php echo $kwayy_quote_source_url; ?></a></h3></div>
                <?php
					}
				?>
                <span></span>
                </blockquote>
              
              <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'apicona' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
              </div>
          </div>
      </div>
		<!-- .entry-content -->

		<footer class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'apicona' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
		
	</div><!-- .kwayy-post-right -->
	
	<div class="clearfix"></div>
	
</article><!-- #post -->
