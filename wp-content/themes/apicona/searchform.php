<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<label>
		<span class="screen-reader-text"><?php _e( 'Search for:', 'apicona' ) ?></span>
		<input type="search" class="search-field" placeholder="<?php _e( 'Search ...', 'apicona' ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php _e( 'Search for:', 'apicona' ) ?>" />
	</label>
	<input type="submit" class="search-submit" value="<?php _e( 'Search', 'apicona' ) ?>" />
</form>
