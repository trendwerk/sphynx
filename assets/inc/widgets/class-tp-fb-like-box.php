<?php
/**
 * Facebook like box
 *
 * @package TrendPress
 * @subpackage Widgets
 */

class TP_FB_Like_Box extends WP_Widget {
	function TP_FB_Like_Box() {
		$this->WP_Widget( 'TP_FB_Like_Box', __( 'Facebook like box', 'tp' ), array( 'description' => __( 'Shows the Facebook users that like your Facebook page', 'tp' ) ) );
	}
	
	function form( $instance ) {
		$defaults = array(
			'title' => '',
			'url'   => '',
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
				<strong><?php _e( 'Facebook page URL', 'tp' ); ?></strong><br />
				<input class="widefat" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo $instance['url']; ?>" />
			</label>
		</p>

		<?php
	}
	
	function update( $new_instance, $old_instance ) {		
		$new_instance['url'] = tp_maybe_add_http( $new_instance['url'] );
		
		return $new_instance;
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		echo $before_widget; 
			if( $instance['title'] )
				echo $before_title . $instance['title'] . $after_title;

			?>

			<div id="fb-root"></div>
			<script>
				(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1";
					fjs.parentNode.insertBefore(js, fjs);
				}
				(document, 'script', 'facebook-jssdk'));
			</script>
			<div class="fb-like-box" data-href="<?php echo $instance['url']; ?>" data-show-border="false" data-height="270px" data-width="260px" data-show-faces="true" data-stream="false" data-header="false"></div>

			<?php 
		echo $after_widget;
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_FB_Like_Box" );' ) );
