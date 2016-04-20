<?php

add_action( 'widgets_init', 'kwayy_widget_flickr' );

function kwayy_widget_flickr() {
	register_widget( 'kwayy_widget_flickr' );
}

class kwayy_widget_flickr extends WP_Widget {


	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_style = array('classname'   => 'kwayy_widget_flickr',
							  'description' => __('Show photos from Flickr.','apicona') );
							  
		$widget_define = array('show_id'   => 'single_flickr',
							   'get_tips'  => 'true',
							   'get_title' => 'true');
							   
		$control_styles = array('width'   => 300,
								'height'  => 350,
								'id_base' => 'kwayy_widget_flickr');
								
		$widget_change = array('change1' => 'delay',
							   'change2' => 'effect',
							   'change3' => 'slide',
							   'change4' => 100,
							   'change5' => 0);
							   
		parent::__construct(
			'kwayy_widget_flickr', // Base ID
			__('Kwayy Flickr Widget', 'apicona'), // Name
			$widget_style // Args
		);
	}


	function widget( $args, $cur_instance ) {
		extract( $args );
		//include_once('../phpflickr-library/phpFlickr.php');
		
		$title = apply_filters( 'widget_title', $cur_instance['title'] );
		//$class = $cur_instance['class'];
		$flickrID = $cur_instance['flickrID'];
		$postcount = $cur_instance['postcount'];
		$type = $cur_instance['type'];
		$display = $cur_instance['display'];

		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;
		
		$url = 'http://www.flickr.com/badge_code_v2.gne?count='.trim($postcount).'&amp;display='.$display.'&amp;size=m&amp;layout=v&amp;source='.$type.'&amp;'.$type.'='.urlencode($flickrID);
		//$url = urlencode($url);
		
		echo '<div class="kwayy_widget_flickr_wrapper">'; ?>
			<!--<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $postcount ?>&amp;display=<?php echo $display ?>&amp;size=m&amp;layout=v&amp;source=<?php echo $type ?>&amp;<?php echo $type ?>=<?php echo $flickrID ?>"></script>-->
			<script type="text/javascript" src="<?php echo $url; ?>"></script>
			<?php 
		echo '</div>';
		echo $after_widget;	
		
		
	}
		
	function update( $new_instance, $org_instance ) {
		$cur_instance = $org_instance;
		$cur_instance['title'] = strip_tags( $new_instance['title'] );
		//$cur_instance['class'] = strip_tags( $new_instance['class'] );
		$cur_instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		$cur_instance['show'] = $new_instance['slide'];
		$cur_instance['postcount'] = $new_instance['postcount'];
		$cur_instance['type'] = $new_instance['type'];
		$cur_instance['inline'] = $new_instance['true'];
		$cur_instance['display'] = $new_instance['display'];
		return $cur_instance;
	}
		 
	function form( $cur_instance ) {
		$defaults = array('title'     => 'Flickr',
					      //'class'   => 'flickr',
						  'flickrID'  => '65961696@N02',
						  'postcount' => '9',
						  'type'      => 'user',
						  'display'   => 'latest');
		
		$cur_instance = wp_parse_args( (array) $cur_instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo __('Title', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $cur_instance['title']; ?>" />
		</p>		
		
		

		<p>
			<label for="<?php echo $this->get_field_id( 'flickrID' ); ?>">Flickr ID: (see <a href="http://idgettr.com/">idGettr</a>)</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'flickrID' ); ?>" name="<?php echo $this->get_field_name( 'flickrID' ); ?>" value="<?php echo $cur_instance['flickrID']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'postcount' ); ?>">Number of photos:</label>
			<select id="<?php echo $this->get_field_id( 'postcount' ); ?>" name="<?php echo $this->get_field_name( 'postcount' ); ?>" class="widefat">
				<?php
				$maxList = 12;
				for( $x=1; $x<=$maxList; $x++ ){
					?>
					<option <?php if ( $x == $cur_instance['postcount'] ) echo 'selected="selected"'; ?>> <?php echo $x; ?> </option>
					<?php
				}
				?>
			</select>		
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>">Type (user or group):</label>
			<select id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" class="widefat">	
				<option <?php if ( 'user' == $cur_instance['type'] ) echo 'selected="selected"'; ?>>user</option>
				<option <?php if ( 'group' == $cur_instance['type'] ) echo 'selected="selected"'; ?>>group</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'display' ); ?>">Show (random or most recent):</label>
			<select id="<?php echo $this->get_field_id( 'display' ); ?>" name="<?php echo $this->get_field_name( 'display' ); ?>" class="widefat">
				<option <?php if ( 'random' == $cur_instance['display'] ) echo 'selected="selected"'; ?>>random</option>
				<option <?php if ( 'latest' == $cur_instance['display'] ) echo 'selected="selected"'; ?>>latest</option>
			</select>
		</p><?php
	}
}
