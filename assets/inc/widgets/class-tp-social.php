<?php
/**
 * Social media links
 *
 * @package TrendPress
 */
class TP_Social extends WP_Widget {
	function TP_Social() {
		$this->WP_Widget( 'TP_Social', __( 'Social media links', 'tp' ), array( 'description' => __( 'Shows links to specified social network profiles', 'tp' ) ) );

		$this->types = array(
			'large-icons' => __( 'Large icons', 'tp' ),
			'large-icons-text' => __( 'Large icons with text', 'tp' ),
			'small-icons' => __( 'Small icons', 'tp' ),
			'small-icons-text' => __( 'Small icons with text', 'tp' ),
		);
	}
	
	function form( $instance ) {
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php _e( 'Title' ); ?></strong><br />
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>

		<p>
			<label>
				<strong><?php _e( 'Icon types', 'tp' ); ?></strong><br />
				<select class="widefat" name="<?php echo $this->get_field_name( 'type' ); ?>">
					<?php 
						foreach( $this->types as $size_type => $label )
							echo '<option value="' . $size_type . '" ' . selected( $size_type, $instance['type'] ) . '>' . $label . '</option>';
					?>
				</select>
			</label>
		</p>

		<p><?php printf( __( 'Change the contents of this widget on the <a href="%1$s">contact information</a> page.', 'tp' ), admin_url( 'options-general.php?page=tp-information' ) ); ?></p>

		<?php
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

			if( $instance['title'] ) 
				echo $before_title . $instance['title'] . $after_title; 

			?>

			<ul class="social <?php echo $instance['type']; ?>">

				<?php if( $twitter = get_option( 'tp-twitter' ) ) { ?>
					<li class="twitter">
						<a rel="external" href="<?php echo $twitter; ?>" title="<?php _e( 'Follow us on Twitter', 'tp' ); ?>">
							<i class="icon-twitter"></i>
							<span class="title"><?php _e( 'Follow us on Twitter', 'tp' ); ?></span>
						</a>
					</li>
				<?php } ?>

				<?php if( $facebook = get_option( 'tp-facebook' ) ) { ?>
					<li class="facebook">
						<a rel="external" href="<?php echo $facebook; ?>" title="<?php _e( 'Like our Facebook page', 'tp' ); ?>">
							<i class="icon-facebook"></i>
							<span class="title"><?php _e( 'Like our Facebook page', 'tp' ); ?></span>
						</a>
					</li>
				<?php } ?>

				<?php if( $linkedin = get_option( 'tp-linkedin' ) ) { ?>
					<li class="linkedin">
						<a rel="external" href="<?php echo $linkedin; ?>" title="<?php _e( 'Connect with us on LinkedIn', 'tp' ); ?>">
							<i class="icon-linkedin"></i>
							<span class="title"><?php _e('Connect with us on LinkedIn','tp'); ?></span>
						</a>
					</li>
				<?php } ?>

				<?php if( $googleplus = get_option( 'tp-googleplus' ) ) { ?>
					<li class="googleplus">
						<a rel="external" href="<?php echo $googleplus; ?>" title="<?php _e( 'Add us on Google+', 'tp' ); ?>">
							<i class="icon-google-plus"></i>
							<span class="title"><?php _e( 'Add us on Google+', 'tp' ); ?></span>
						</a>
					</li>
				<?php } ?>

				<?php if( $youtube = get_option( 'tp-youtube' ) ) { ?>
					<li class="youtube">
						<a rel="external" href="<?php echo $youtube; ?>" title="<?php _e( 'View our YouTube channel', 'tp' ); ?>">
							<i class="icon-youtube"></i>
							<span class="title"><?php _e( 'View our YouTube channel', 'tp' ); ?></span>
						</a>
					</li>
				<?php } ?>

				<?php if( $newsletter = get_option( 'tp-newsletter' ) ) { ?>
					<li class="email">
						<a href="<?php echo $newsletter; ?>" title="<?php _e( 'E-mail newsletter', 'tp' ); ?>">
							<i class="icon-envelope"></i>
							<span class="title"><?php _e( 'E-mail newsletter', 'tp' ); ?></span>
						</a>
					</li>
				<?php } ?>

				<?php if( 'true' == get_option('tp-rss') ) { ?>
					<li class="rss">
						<a href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php _e( 'Subscribe via RSS', 'tp' ); ?>">
							<i class="icon-rss"></i>
							<span class="title"><?php _e( 'Subscribe to our RSS', 'tp' ); ?></span>
						</a>
					</li>
				<?php } ?>
			</ul>

			<?php 
		echo $after_widget;
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Social" );' ) );
