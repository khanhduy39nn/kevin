<?php

add_action( 'widgets_init', 'kwayy_widget_tabs' );

function kwayy_widget_tabs() {
	register_widget( 'kwayy_widget_tabs' );
}

class kwayy_widget_tabs extends WP_Widget {


	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_style = array('classname'   => 'kwayy_widget_tabs',
							  'description' => 'Show tabs.');
							  
		/*$widget_define = array('show_id'   => 'single_flickr',
							   'get_tips'  => 'true',
							   'get_tab1' => 'true');
							   
		$control_styles = array('width'   => 300,
								'height'  => 350,
								'id_base' => 'kwayy_widget_tabs');
								
		$widget_change = array('change1' => 'delay',
							   'change2' => 'effect',
							   'change3' => 'slide',
							   'change4' => 100,
							   'change5' => 0);
		*/
		
		parent::__construct(
			'kwayy_widget_tabs', // Base ID
			__('Kwayy Tabs Widget', 'apicona'), // Name
			$widget_style // Args
		);
	}


	function widget( $args, $cur_instance ) {
		extract( $args );
		
		//var_dump( $args['widget_id'] );
		//var_dump( $cur_instance );
		
		$title = apply_filters( 'widget_title', $cur_instance['title'] );
		$tab1 = $cur_instance['tab1'];
		$tab2 = $cur_instance['tab2'];
		$tab3 = $cur_instance['tab3'];
		$tab4 = $cur_instance['tab4'];
		$tab5 = $cur_instance['tab5'];
		$tab6 = $cur_instance['tab6'];
		$tab1content = $cur_instance['tab1content'];
		$tab2content = $cur_instance['tab2content'];
		$tab3content = $cur_instance['tab3content'];
		$tab4content = $cur_instance['tab4content'];
		$tab5content = $cur_instance['tab5content'];
		$tab6content = $cur_instance['tab6content'];
		
		
		/*
		$tab1 = apply_filters( 'widget_tab1', $cur_instance['tab1'] );
		//$class = $cur_instance['class'];
		$flickrID = $cur_instance['flickrID'];
		$tab2 = $cur_instance['tab2'];
		$tab3 = $cur_instance['tab3'];
		$display = $cur_instance['display'];

		echo $before_widget;
		if ( $tab1 ) echo $before_tab1 . $tab1 . $after_tab1;	
		echo '<div class="kwayy_widget_tabs_wrapper">'; ?>
			<script tab3="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $tab2 ?>&amp;display=<?php echo $display ?>&amp;size=m&amp;layout=v&amp;source=<?php echo $tab3 ?>&amp;<?php echo $tab3 ?>=<?php echo $flickrID ?>"></script><?php 
		echo '</div>';
		echo $after_widget;	
		*/
		
		echo $before_widget;
		
		$totalTabs = 6;
		
		$return = '';
		for( $x=1; $x<=$totalTabs; $x++ ){
			if( ${'tab'.$x}!='' ){
				$return .= '[vc_tab title="'.${'tab'.$x}.'" tab_id="'.$args['widget_id'].'_'.$x.'"][vc_column_text]'.${'tab'.$x.'content'}.'[/vc_column_text][/vc_tab]';
			}
		}
		if( $return!='' ){
			echo do_shortcode('[vc_tabs] '.$return.' [/vc_tabs]');
		}
		echo $after_widget;	

	}
		
	function update( $new_instance, $org_instance ) {
		$cur_instance = $org_instance;
		$cur_instance['title'] = strip_tags( $new_instance['title'] );
		$cur_instance['tab1'] = $new_instance['tab1'];
		$cur_instance['tab2'] = $new_instance['tab2'];
		$cur_instance['tab3'] = $new_instance['tab3'];
		$cur_instance['tab4'] = $new_instance['tab4'];
		$cur_instance['tab5'] = $new_instance['tab5'];
		$cur_instance['tab6'] = $new_instance['tab6'];
		$cur_instance['tab1content'] = $new_instance['tab1content'];
		$cur_instance['tab2content'] = $new_instance['tab2content'];
		$cur_instance['tab3content'] = $new_instance['tab3content'];
		$cur_instance['tab4content'] = $new_instance['tab4content'];
		$cur_instance['tab5content'] = $new_instance['tab5content'];
		$cur_instance['tab6content'] = $new_instance['tab6content'];
		//$cur_instance['class'] = strip_tags( $new_instance['class'] );
		//$cur_instance['flickrID'] = strip_tags( $new_instance['flickrID'] );
		//$cur_instance['show'] = $new_instance['slide'];
		
		//$cur_instance['inline'] = $new_instance['true'];
		//$cur_instance['display'] = $new_instance['display'];
		return $cur_instance;
	}
		 
	function form( $cur_instance ) {
		$defaults = array('tab1' => 'Tab 1',
					      'tab2' => '',
						  'tab3' => '',
						  'tab4' => '',
						  'tab5' => '',
						  'tab6' => '',
						  'tab1content' => 'Content for tab 1',
					      'tab2content' => '',
						  'tab3content' => '',
						  'tab4content' => '',
						  'tab5content' => '',
						  'tab6content' => '',
						  
					);
		
		$cur_instance = wp_parse_args( (array) $cur_instance, $defaults ); ?>
		
		<!-- Tab 1 -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab1'); ?>"><?php echo __('Tab 1 Title', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab1' ); ?>" name="<?php echo $this->get_field_name( 'tab1' ); ?>" value="<?php echo $cur_instance['tab1']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab1' ); ?>"><?php echo __('Tab 1 content', 'apicona'); ?>:</label>
			<textarea type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab1content' ); ?>" name="<?php echo $this->get_field_name( 'tab1content' ); ?>"><?php echo $cur_instance['tab1content']; ?></textarea>
		</p>
		
		<!-- Tab 2 -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab2' ); ?>"><?php echo __('Tab 2 Title', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab2' ); ?>" name="<?php echo $this->get_field_name( 'tab2' ); ?>" value="<?php echo $cur_instance['tab2']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab2' ); ?>"><?php echo __('Tab 2 content', 'apicona'); ?>:</label>
			<textarea type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab2content' ); ?>" name="<?php echo $this->get_field_name( 'tab2content' ); ?>"><?php echo $cur_instance['tab2content']; ?></textarea>
		</p>
		
		
		<!-- Tab 3 -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab3' ); ?>"><?php echo __('Tab 3 Title', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab3' ); ?>" name="<?php echo $this->get_field_name( 'tab3' ); ?>" value="<?php echo $cur_instance['tab3']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab3' ); ?>"><?php echo __('Tab 3 content', 'apicona'); ?>:</label>
			<textarea type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab3content' ); ?>" name="<?php echo $this->get_field_name( 'tab3content' ); ?>"><?php echo $cur_instance['tab3content']; ?></textarea>
		</p>
		
		
		<!-- Tab 4 -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab4' ); ?>"><?php echo __('Tab 4 Title', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab4' ); ?>" name="<?php echo $this->get_field_name( 'tab4' ); ?>" value="<?php echo $cur_instance['tab4']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab4' ); ?>"><?php echo __('Tab 4 content', 'apicona'); ?>:</label>
			<textarea type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab4content' ); ?>" name="<?php echo $this->get_field_name( 'tab4content' ); ?>"><?php echo $cur_instance['tab4content']; ?></textarea>
		</p>
		
		
		<!-- Tab 5 -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab5' ); ?>"><?php echo __('Tab 5 Title', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab5' ); ?>" name="<?php echo $this->get_field_name( 'tab5' ); ?>" value="<?php echo $cur_instance['tab5']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab5' ); ?>"><?php echo __('Tab 5 content', 'apicona'); ?>:</label>
			<textarea type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab5content' ); ?>" name="<?php echo $this->get_field_name( 'tab5content' ); ?>"><?php echo $cur_instance['tab5content']; ?></textarea>
		</p>
		
		
		<!-- Tab 6 -->
		<p>
			<label for="<?php echo $this->get_field_id( 'tab6' ); ?>"><?php echo __('Tab 6 Title', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab6' ); ?>" name="<?php echo $this->get_field_name( 'tab6' ); ?>" value="<?php echo $cur_instance['tab6']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab6' ); ?>"><?php echo __('Tab 6 content', 'apicona'); ?>:</label>
			<textarea type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab6content' ); ?>" name="<?php echo $this->get_field_name( 'tab6content' ); ?>"><?php echo $cur_instance['tab6content']; ?></textarea>
		</p>
		
		
		<?php
	}
}
