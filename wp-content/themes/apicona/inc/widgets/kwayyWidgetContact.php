<?php

add_action( 'widgets_init', 'kwayy_widget_contact' );

function kwayy_widget_contact() {
	register_widget( 'kwayy_widget_contact' );
}



/*function kwayy_addhttp($url) {
	if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
		$url = "http://" . $url;
	}
	return $url;
}*/


class kwayy_widget_contact extends WP_Widget {


	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_style = array('classname'   => 'kwayy_widget_contact',
							  'description' => __('Show Contact details with icons.', 'apicona') );
							  
		$widget_define = array('show_id'   => 'kwayy_single_contact',
							   'get_tips'  => 'true',
							   'get_title' => 'true');
							   
		$control_styles = array('width'   => 300,
								'height'  => 350,
								'id_base' => 'kwayy_widget_contact');
								
		$widget_change = array('change1' => 'delay',
							   'change2' => 'effect',
							   'change3' => 'slide',
							   'change4' => 100,
							   'change5' => 0);
							   
		parent::__construct(
			'kwayy_widget_contact', // Base ID
			__('Kwayy Contact Widget', 'apicona'), // Name
			$widget_style // Args
		);
	}


	function widget( $args, $cur_instance ) {
		extract( $args );
		//include_once('../phpflickr-library/phpFlickr.php');
		
		$title   = apply_filters( 'widget_title', $cur_instance['title'] );
		$Phone   = $cur_instance['Phone'];
		$Email   = $cur_instance['Email'];
		$Website = $cur_instance['Website'];
		$Address = $cur_instance['Address'];
		$Time    = $cur_instance['Time'];
		
		/*
		 *  WPML Translation ready
		 */
		
		// Phone
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'Kwayy Contact Widget', 'Phone Number' . $this->id, $Phone );
		}
		if ( function_exists( 'icl_t' ) ) {
			$Phone = icl_t( 'Kwayy Contact Widget', 'Phone Number' . $this->id, $Phone );
		}
		
		// Email
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'Kwayy Contact Widget', 'Email Address' . $this->id, $Email );
		}
		if ( function_exists( 'icl_t' ) ) {
			$Email = icl_t( 'Kwayy Contact Widget', 'Email Address' . $this->id, $Email );
		}
		
		// Website
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'Kwayy Contact Widget', 'Website URL' . $this->id, $Website );
		}
		if ( function_exists( 'icl_t' ) ) {
			$Website = icl_t( 'Kwayy Contact Widget', 'Website URL' . $this->id, $Website );
		}
		
		// Address
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'Kwayy Contact Widget', 'Address' . $this->id, $Address );
		}
		if ( function_exists( 'icl_t' ) ) {
			$Address = icl_t( 'Kwayy Contact Widget', 'Address' . $this->id, $Address );
		}
		
		// Time
		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'Kwayy Contact Widget', 'Time' . $this->id, $Time );
		}
		if ( function_exists( 'icl_t' ) ) {
			$Time = icl_t( 'Kwayy Contact Widget', 'Time' . $this->id, $Time );
		}
			
		echo $before_widget;
		if ( $title ) echo $before_title . $title . $after_title;	
		echo '<ul class="kwayy_widget_contact_wrapper">'; ?>
			
			<?php if( trim($Phone)!='' ): ?><li class="kwayy-contact-phonenumber kwicon-fa-phone"><?php echo nl2br($Phone); ?></li><?php endif; ?>
			<?php if( trim($Email)!='' ): ?><li class="kwayy-contact-email kwicon-fa-envelope-o"><?php echo '<a href="mailto:'.$Email.'" target="_blank">'.$Email.'</a>'; ?></li><?php endif; ?>
			<?php if( trim($Website)!='' ): ?><li class="kwayy-contact-website kwicon-fa-globe"><?php echo '<a href="'.kwayy_addhttp($Website).'" target="_blank">'.$Website.'</a>'; ?></li><?php endif; ?>
			<?php if( trim($Address)!='' ): ?><li class="kwayy-contact-address  kwicon-fa-map-marker"><?php echo nl2br($Address); ?></li><?php endif; ?>
			<?php if( trim($Time)!='' ): ?><li class="kwayy-contact-time kwicon-fa-clock-o"><?php echo nl2br($Time); ?></li><?php endif; ?>
			
			<?php 
		echo '</ul>';
		echo $after_widget;	
		
		
	}
		
	function update( $new_instance, $org_instance ) {
		$cur_instance = $org_instance;
		$cur_instance['title']   = strip_tags( $new_instance['title'] );
		$cur_instance['Phone']   = $new_instance['Phone'];
		$cur_instance['Email']   = $new_instance['Email'];
		$cur_instance['Website'] = $new_instance['Website'];
		$cur_instance['Address'] = $new_instance['Address'];
		$cur_instance['Time']    = $new_instance['Time'];
		return $cur_instance;
	}
		 
	function form( $cur_instance ) {
		$defaults = array('title'   => 'Get in touch',
					    //'class' => 'flickr',
						'Phone'   => '(+01) 123 456 7890',
						'Email'   => 'info@example.com',
						'Website' => 'www.example.com',
						'Address' => "Honey Business \n 24 Fifth st., Los Angeles, \n USA",
						'Time'    => "Mon to Sat - 9:00am to 6:00pm \n (Sunday Closed)",
		);
		
		$cur_instance = wp_parse_args( (array) $cur_instance, $defaults ); ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $cur_instance['title']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'Phone' ); ?>"><?php _e('Phone', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Phone' ); ?>" name="<?php echo $this->get_field_name( 'Phone' ); ?>" value="<?php echo $cur_instance['Phone']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'Email' ); ?>"><?php _e('Email', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Email' ); ?>" name="<?php echo $this->get_field_name( 'Email' ); ?>" value="<?php echo $cur_instance['Email']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'Website' ); ?>"><?php _e('Website', 'apicona'); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'Website' ); ?>" name="<?php echo $this->get_field_name( 'Website' ); ?>" value="<?php echo $cur_instance['Website']; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'Address' ); ?>"><?php _e('Address', 'apicona'); ?>:</label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'Address' ); ?>" name="<?php echo $this->get_field_name( 'Address' ); ?>"><?php echo $cur_instance['Address']; ?></textarea>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'Time' ); ?>"><?php _e('Time', 'apicona'); ?>:</label>
			<textarea class="widefat" id="<?php echo $this->get_field_id( 'Time' ); ?>" name="<?php echo $this->get_field_name( 'Time' ); ?>"><?php echo $cur_instance['Time']; ?></textarea>
		</p>
		
		
		<?php
	}
}
