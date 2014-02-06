<?php
/**
 * Text with button
 *
 * @package TrendPress
 * @subpackage Widgets
 */
class TP_Title_Content_Image_Button extends WP_Widget {
	function TP_Title_Content_Image_Button() {
		$this->WP_Widget( 'TP_Title_Content_Image_Button', __( 'Text with image and button', 'tp' ), array( 'description' => __( 'Editable title, image text and button', 'tp' ) ) );

		$this->types = array(
			'more-link'     => __( 'Read more link', 'tp' ),
			'cta primary'   => __( 'Primary button', 'tp' ),
			'cta secondary' => __( 'Secondary button', 'tp' ),
		);

		add_action( 'admin_enqueue_scripts', array( $this, 'localize' ), 11 );
	}

	function localize() {
		wp_localize_script( 'admin', 'TP_Title_Content_Image_Button', array(
			'media_frame_labels' => array(
				'title'  => __( 'Choose an image', 'tp' ),
				'button' => __( 'Insert into widget', 'tp' ),
			),
		) );
	}

	function form( $instance ) {
		?>

		<p>
			<label>
				<strong><?php _e( 'Title' ); ?></strong><br />
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>

		<p>
			<label>
				<strong><?php _e( 'Image' ); ?></strong><br />

				<?php 
					if( ! $instance['image'] ) {
						echo '<a class="tp-upload-image button-secondary">';
							_e( 'Upload' );
						echo '</a>';
					} else {
						echo '<div class="tp-edit-image">';
							echo wp_get_attachment_image( $instance['image'], array( 400, 600 ) );
						echo '</div>';

						echo '<a class="tp-edit-image button-secondary">';
							_e( 'Edit' );
						echo '</a> ';

						echo '<a class="tp-remove-image button-secondary">';
							_e( 'Remove' );
						echo '</a>';
					} 
				?>
				<input class="tp-upload-image-content" type="hidden" name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo $instance['image']; ?>" />
			</label>
		</p>

		<p>
			<label>
				<strong><?php _e('Content','tp'); ?></strong><br />
				<textarea class="widefat" name="<?php echo $this->get_field_name('content'); ?>" ><?php echo $instance['content']; ?></textarea>
			</label>
		</p>

		<p>
			<label>
				<input class="tp-show-button" type="checkbox" name="<?php echo $this->get_field_name('show_button'); ?>" <?php checked( $instance['show_button'], true ); ?>>
				<?php _e('Show button / read more link','tp'); ?>
			</label>
		</p>

		<div class="tp-show-button-content <?php if( ! $instance['show_button'] ) echo 'hide'; ?>">

			<p>
				<label>
					<strong><?php _e( 'Button text', 'tp' ); ?></strong><br />
					<input class="widefat" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo $instance['button_text']; ?>" />
				</label>
			</p>

			<p>
				<label>
					<strong><?php _e( 'Button link', 'tp' ); ?></strong><br />
					<input class="widefat" name="<?php echo $this->get_field_name( 'button_link' ); ?>" type="text" value="<?php echo $instance['button_link']; ?>" />
				</label>
			</p>


			<p>
				<label>
					<strong><?php _e( 'Link type', 'tp' ); ?></strong><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'link_type' ); ?>" >
						<?php 
							foreach( $this->types as $type => $label )
								echo '<option value="' . $type . '" ' . selected( $type, $instance['link_type'] ) . '>' . $label . '</option>';
						?>
					</select>
				</label>
			</p>

			<p>
				<label>
					<input type="checkbox" name="<?php echo $this->get_field_name( 'external' ); ?>" value="true" <?php checked( $instance['external'], true ); ?>>
					<?php _e( 'This link is external', 'tp' ); ?>
				</label>
			</p>

		</div>

		<?php
	}
	
	function update( $new_instance, $old_instance ) {
		$new_instance['show_button'] = isset( $new_instance['show_button'] );
		$new_instance['button_link'] = tp_maybe_add_http( $new_instance['button_link'] );
		$new_instance['external'] = isset( $new_instance['external'] );
		
		return $new_instance;
	}
	
	function widget( $args, $instance ) {
		extract($args);

		echo $before_widget;
			if( $instance['title'] )
				echo $before_title . $instance['title'] . $after_title; 

			if( $instance['image'] )
				echo wp_get_attachment_image( $instance['image'], 'widget' );

			if( $instance['content'] )
				echo '<p>' . nl2br( $instance['content'] ) . '</p>';
		
		    if( $instance['show_button'] ) { 
		    	?>

		    	<p>
		    		<a class="<?php echo $instance['link_type']; ?>" href="<?php echo $instance['button_link']; ?>" <?php if( $instance['external'] ) echo 'rel="external"'; ?>>
		    			<?php echo $instance['button_text']; ?>
		    		</a>
		    	</p>

	    		<?php 
	    	} 
		echo $after_widget;
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Title_Content_Image_Button" );' ) );
