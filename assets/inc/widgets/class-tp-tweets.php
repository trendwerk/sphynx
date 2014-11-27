<?php
/**
 * Latest tweets
 *
 * @package TrendPress
 * @subpackage Widgets
 */
class TP_Tweets extends WP_Widget {
	function TP_Tweets() {
		$this->WP_Widget( 'TP_Tweets', __( 'Tweets', 'tp' ), array( 'description' => __( 'Shows latest tweets from a Twitter account', 'tp' ) ) );
	}
	
	function form( $instance ) {
		$defaults = array(
			'title'    => $this->name,
			'username' => '',
		);

		$instance = wp_parse_args( $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php _e( 'Title' ); ?></strong><br />
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		
		<p>
			<label>
				<strong><?php _e( 'Twitter username', 'tp' ); ?></strong><br />
				<input class="widefat" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo $instance['username']; ?>" />
			</label>
		</p>

		<?php
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		echo $before_widget;
			if( $instance['title'] )
				echo $before_title . $instance['title'] . $after_title;
			?>

			<a class="twitter-timeline" data-chrome="noheader nofooter noscrollbar transparent" data-tweet-limit="3" data-dnt="true" href="https://twitter.com/<?php echo $instance['username']; ?>" data-screen-name="<?php echo $instance['username']; ?>" data-widget-id="387581823514972160">
				<?php printf( __( 'Tweets from @%1$s', 'tp' ), $instance['username'] ); ?>
			</a>
			
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

			<?php
			
		echo $after_widget;
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Tweets" );' ) );
