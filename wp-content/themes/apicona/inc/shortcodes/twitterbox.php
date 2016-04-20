<?php

/***** Visual Composer: Apicona Twitter Box ********/
// Example: [twitterbox consumer_key="v6t8ta31234ZkoljqvBDa" consumer_secret="731111dgQqSflffj1t68e60ly1sy5gvvuBgmCXlGEQg" oauth_token="156789585-yOkqsdefmgnrkgjhnrtfjhlgUXRNwkIIWOSCnk3SMOjzKx" oauth_token_secret="dgthuyjrtfjhka3Vh2J0DGr7oR6pBMLdLtnwo5E"]
if( !function_exists('kwayy_sc_twitterbox') ){
function kwayy_sc_twitterbox( $atts, $content=NULL ){
	$return = '';
	extract( shortcode_atts( array(
		'consumer_key'		=> '',
		'consumer_secret'	=> '',
		'oauth_token'		=> '',
		'oauth_token_secret'=> '',
		'show'				=> '3',
		'username'          => '',
	), $atts ) );
	
	$keys = array();
	$keys['consumer_key']		= $consumer_key;
	$keys['consumer_secret']	= $consumer_secret;
	$keys['oauth_token']		= $oauth_token;
	$keys['oauth_token_secret']	= $oauth_token_secret;
	$keys['show']				= $show;
	$keys['username']			= $username;
	
	
	/*$carouselbtnCode = ( $carouselbtn == 'yes' ) ? '<div class="kwayy-carousel-controls-inner"><a href="#" class="kwayy-carousel-prev"><span class="wpb_button"><i class="kwicon-fa-angle-left"></i></span></a><a href="#" class="kwayy-carousel-next"><span class="wpb_button"><i class="kwicon-fa-angle-right"></i></span></a></div>' : '' ;*/
	
	
	$mainWrapperStart = '<div class="kwayy-blog-boxes">';
	$mainWrapperEnd   = '</div>';
	
	/*$heading = ( trim($title)!='' ) ? do_shortcode('[heading text="'.$title.'" tag="h2" style="linedot" align="top" '.$headerCarslBtn.' subtext="'.$subtitle.'" align="left"]') : '' ;*/
	

	
	$tweetList = kwayy_twitterbar($keys);
	
	$return .= $mainWrapperStart.$tweetList.$mainWrapperEnd;
	
	return $return;
	
}
}
add_shortcode( 'twitterbox', 'kwayy_sc_twitterbox' );










/******************** Extra Functions *********************/
function kwayy_twitterbar($keys) {
	
	$consumer_key       = trim($keys['consumer_key']);
	$consumer_secret    = trim($keys['consumer_secret']);
	$oauth_token        = trim($keys['oauth_token']);
	$oauth_token_secret	= trim($keys['oauth_token_secret']);
	$show				= trim($keys['show']);
	
	$username = '';
	if( isset($keys['username']) && trim($keys['username'])!='' ){
		$username = trim($keys['username']);
	}
	
	$twittercount = ($show=='') ? '3' : $show ;
	
	$return = '';
	
	if( $consumer_key   != '' &&
	$consumer_secret    != '' &&
	$oauth_token        != '' &&
	$oauth_token_secret != '' ){
		
		
		// new API 1.1
		if ( !class_exists('TwitterOAuth')) {
			require_once ('twitteroauth/twitteroauth.php');
		}
		$connection      = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
		$search_feed3    = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=".$twittercount; 
		$api_1_1_content = $connection->get($search_feed3);
		$html_result     = '';
		
		// if connection is ok
		if ( is_array( $api_1_1_content ) AND isset( $api_1_1_content[0]->id ) ) {
			$rss_i = $api_1_1_content;
			// avatar
			$author = $rss_i[0] -> user -> screen_name;
			$avatar = $rss_i[0] -> user -> profile_image_url;
			$html_avatar = $new_attrs = '';
			// followers	
			$user_followers = $rss_i[0] -> user -> followers_count;
			$i = 0;
			foreach ( $rss_i as $tweet ) {
				$i++;
				$i_source	= '';
				$i_title	= kwayy_format_tweettext($tweet -> text, $username);
				$i_creat	= kwayy_format_since( $tweet -> created_at );
				$i_guid		= "http://twitter.com/".$tweet -> user -> screen_name."/status/".$tweet -> id_str;
				//time ago filters
				$the_time_ago = array(
					'before'	=> __('Time ago', 'apicona'),
					'after'		=> '',
					'content'	=> __('See the status', 'apicona')
				);
				$the_time_ago = apply_filters('kwayy_time_ago', $the_time_ago); // @filters
				// for PHP4 fail with strtotime() function
				$target4a = apply_filters('kwayy_target_attr', '_self'); // @filters
				
				//$time_ago = ($i_creat!=false) ?  ' <a href="'. esc_url( $i_guid ) .'" target="'.$target4a.'" title="'.$the_time_ago['content'].'">' . $i_creat . '</a>' . $the_time_ago['after'] : '<a href="'. esc_url( $i_guid ) .'" target="'.$target4a.'">' . $the_time_ago['content'] .'</a>';
				
				$time_ago = ($i_creat!=false) ?  ' <a href="'. esc_url( $i_guid ) .'" target="'.$target4a.'" title="'.$the_time_ago['content'].'">' . $i_creat . '</a>' . $the_time_ago['after'] : '<a href="'. esc_url( $i_guid ) .'" target="'.$target4a.'">' . $the_time_ago['content'] .'</a>';
				// action links
				$kwayy_tweet_id = $tweet -> id_str;
				$html_action_links = '';
				if ( isset($show_action_links) && $show_action_links==true) {
					$target4action_links = apply_filters('kwayy_target_action_links_attr', '_blank'); // @filters
					$html_action_links ='<span class="kwayy_action_links">
						<a title="'.__('Reply', 'apicona').'" href="http://twitter.com/intent/tweet?in_reply_to='.$kwayy_tweet_id.'" class="kwayy_al_reply" rel="nofollow" target="'.$target4action_links.'">'.__('Reply', 'apicona').'</a> <span class="kwayy_sep">-</span>
						<a title="'.__('Retweet', 'apicona').'" href="http://twitter.com/intent/retweet?tweet_id='.$kwayy_tweet_id.'" class="kwayy_al_retweet" rel="nofollow" target="'.$target4action_links.'">'.__('Retweet', 'apicona').'</a> <span class="kwayy_sep">-</span>
						<a title="'.__('Favorite', 'apicona').'" href="http://twitter.com/intent/favorite?tweet_id='.$kwayy_tweet_id.'" class="kwayy_al_fav" rel="nofollow" target="'.$target4action_links.'">'.__('Favorite', 'apicona').'</a> 
					</span>';
				}
				$item_pos_class = " kwayy_tweetitem";
				if ( isset($nb_tweets) && $nb_tweets > 1) {
					switch ($i) {
						case 1;
							$item_pos_class = " kwayy_item_first";
							break;
						case $twittercount;
							$item_pos_class = " kwayy_item_last";
							break;
						default;
							$item_pos_class = " kwayy_item_".$i;
							break;
					}
				}
				$remove_metadata = apply_filters('kwayy_remove_metadata', false); // @filters
				$html_avatar = $i==1 ? $html_avatar : '';
				$metadata = $remove_metadata ? '' : '<em class="kwayy_last_tweet_inner kwayy_last_tweet_metadata">'.$time_ago .' '. $i_source .'</em>';
				$html_result_temp = '
					<div class="kwayy_tweet_item'.$item_pos_class.'">
						'. $html_avatar .'
						<span class="kwayy_lt_content">' . $i_title . '</span>
						<span class="kwayy_last_tweet_footer_item">
							'.$metadata.'
							'.$html_action_links.'
						</span>
					</div>
				';
				$html_result .= apply_filters('kwayy_each_tweet', $html_result_temp); // @filters
				if( $twittercount == $i ){
					break;
				}
			}
		}
		$return .= '
			<section class="kwayy-twitterbar-wrapper kwayy-items-wrapper kwayy-effect-carousel kwayy-carousel-col-one kwayy-with-pagination">
				<div class="kwayy-twitterbar">
					<h3><span>Twitter link</span><a class="twitter-link" href="http://twitter.com/' . $tweet->user->screen_name . '"><i class="kwicon-fa-twitter"></i></a></h3>
					<div class="kwayy-twitterbar-list kwayy-items-wrapper kwayy-carousel-items-wrapper">
						'.$html_result.'
					</div>
				</div>
			</section>';
		
	} else {
		$return .= 'Incorrect key of empty key. Please fill correct Twitter keys. You will get keys from <a href="https://dev.twitter.com" target="_blank">https://dev.twitter.com</a>.';
	}
	
	return $return;
	
} // print_footertwitterbar()






/** Functions **/
if ( !function_exists('kwayy_format_tweettext')) {
	function kwayy_format_tweettext($raw_tweet, $username) {

		$target4a = apply_filters('kwayy_target_attr', '_self'); // @filters

		$i_text = $raw_tweet;			
		//$i_text = htmlspecialchars_decode($raw_tweet);
		//$i_text = preg_replace('#(([a-zA-Z0-9_-]{1,130})\.([a-z]{2,4})(/[a-zA-Z0-9_-]+)?((\#)([a-zA-Z0-9_-]+))?)#','<a href="//$1">$1</a>',$i_text); 
		// replace tag
		$i_text = preg_replace('#\<([a-zA-Z])\>#','&lt;$1&gt;',$i_text);
		// replace ending tag
		$i_text = preg_replace('#\<\/([a-zA-Z])\>#','&lt;/$1&gt;',$i_text);
		// replace classic url
		$i_text = preg_replace('#(((https?|ftp)://(w{3}\.)?)(?<!www)(\w+-?)*\.([a-z]{2,4})(/[a-zA-Z0-9_\?\=-]+)?)#',' <a href="$1" rel="nofollow" class="kwayy_last_tweet_url" target="'.$target4a.'">$5.$6$7</a>',$i_text);
		// replace user link
		$i_text = preg_replace('#@([a-zA-z0-9_]+)#i','<a href="http://twitter.com/$1" class="kwayy_last_tweet_tweetos" rel="nofollow" target="'.$target4a.'">@$1</a>',$i_text);
		// replace hash tag search link ([a-zA-z0-9_] recently replaced by \S)
		$i_text = preg_replace('#[^&]\#(\S+)#i',' <a href="http://twitter.com/search/?src=hash&amp;q=%23$1" class="kwayy_last_tweet_hastag" rel="nofollow" target="'.$target4a.'">#$1</a>',$i_text); // old url was : /search/%23$1
		// remove start username
		$i_text = preg_replace( '#^'.$username.': #i', '', $i_text );
		$i_text = str_replace( 'target=""', '', $i_text ); // Remove empty TARGET tag
		
		return $i_text;
	
	}
}

if ( !function_exists('kwayy_format_since')) {
	function kwayy_format_since ( $date ) {
		
		$temp = strtotime($date);
		
		if($temp != -1)
			$timestamp = $temp;
		else {
			// often PHP4 fail
			return false;
			exit;
		}
		
		$the_date = '';
		$now = time();
		$diff = $now - $timestamp;
		
		if($diff < 60 ) {
			$the_date = sprintf( _nx( '%s Second ago', '%s Seconds ago', round($diff), 'Twitter message for Second Ago', 'apicona' ), round($diff) );
		}
		elseif($diff < 3600 ) {
			$the_date = sprintf( _nx( '%s Minute ago', '%s Minutes ago', round($diff/60) , 'Twitter message for Minute Ago', 'apicona' ), round($diff/60) );
		}
		elseif($diff < 86400 ) {
			$the_date = sprintf( _nx( '%s Hour ago', '%s Hours ago', round($diff/3600) , 'Twitter message for Hours Ago', 'apicona' ), round($diff/3600) );
		}
		else {
			$the_date = sprintf( _nx( '%s Day ago', '%s Days ago', round($diff/86400) , 'Twitter message for Days Ago', 'apicona' ), round($diff/86400) );
		}
		return $the_date;
	}
}
if ( !function_exists('kwayy_format_tweetsource')) {
	function kwayy_format_tweetsource($raw_source) {
	
		$target4a = apply_filters('kwayy_target_attr', '_self'); // @filters

		$i_source = htmlspecialchars_decode($raw_source);
		$i_source = preg_replace('#^web$#','<a href="http://twitter.com" rel="nofollow" target="'.$target4a.'">Twitter</a>', $i_source);
		
		return $i_source;
	
	}
}
