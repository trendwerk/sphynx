<?php
/**
 * Text with image and button
 *
 * @package TrendPress
 */
class TP_Title_Image_Content_Button extends WP_Widget {
	function TP_Title_Image_Content_Button() {
		$this->WP_Widget( 'TP_Title_Image_Content_Button', __( 'Text with image and button', 'tp' ), array( 'description' => __( 'Editable title, image, text and button', 'tp' ) ) );

		$this->types = array(
			'more-link' => __( 'Read more link', 'tp' ),
			'cta primary' => __( 'Primary button', 'tp' ),
			'cta secondary' => __( 'Secondary button', 'tp' ),
		);
	}
	
	function add_css() {
		?>
		<style type="text/css">
			div.image img {
				width: 100%;
				height: auto;
				margin: 0px 0px 5px 0px;
			}
			
			.label-upload-image-p {
				margin: 0px 0px 5px 0px !important;
			}
		</style>
		<?php
	}
	
	function add_js() {
		?>
		<script type="text/javascript">
			//Show / hide button fields
			jQuery( document ).ready( function( $ ) {
				var currently_uploading;
				
				showbuttons_create_clicks( $ );
			
				//Upload an image				
				$( '.upload-image' ).on( 'click', function() {
					currently_uploading = $( this );
				} );
				
				window.send_to_editor = function( html ) {
					html = '<div>' + html + '</div>';
					imgurl = jQuery.parseHTML( html );
					imgurl = $( imgurl ).find( 'img' ).prop( 'src' );
					
					$( currently_uploading ).closest( 'div.upload-image-container' ).find( 'div.image' ).html( jQuery( 'img', html ) );
					$( currently_uploading ).closest( 'div.upload-image-container' ).find( 'input.image_url' ).val( imgurl );
					
					tb_remove();
					save_widget( $( currently_uploading ) );
					currently_uploading = null;
				}
				
				//Remove the image
				$( '.remove-image' ).click( function() {
					$( this ).closest( 'div.upload-image-container' ).find( 'div.image' ).html( '' );
					$( this ).closest( 'div.upload-image-container' ).find( 'input.image_url' ).val( '' );
					
					save_widget( $( this ) );
				} );
				
				function save_widget( obj ) {
					$( obj ).closest( 'form' ).find( '.widget-control-save' ).trigger( 'click' );
				}
			});
			
			//Show or hide extra settings
			function showbuttons_create_clicks( $ ) {
				if(!$) $ = jQuery.noConflict();
				
				$( 'p.show_button input' ).each(function() {					
					//Extra fields
					show_or_hide_extras( this );
					
					$( this ).change( function() {
						show_or_hide_extras( this );
					} );
					
					function show_or_hide_extras( obj ) {
						if( $( obj ).attr('checked') ) {
							$( obj ).closest( 'div' ).find( '.buttonsettings' ).show();
						} else {
							$( obj ).closest( 'div' ).find( '.buttonsettings' ).hide();
						}
					}
				});
			}
		</script>		
		<?php
	}
	
	function form( $instance ) {
		$title = esc_attr( $instance['title'] );
		$image = $instance['image'];
		$content = esc_attr( $instance['content'] );
		$show_button = $instance['show_button'];
		$button_text = esc_attr( $instance['button_text'] );
		$button_link = esc_attr( $instance['button_link'] );
		$link_type = esc_attr( $instance['link_type'] );
		$external = $instance['external'];
		
		$this->add_js();
		$this->add_css();
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<strong><?php _e( 'Title' ); ?></strong><br />
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>

		<div class="upload-image-container">

			<p class="label-upload-image-p">
				<label class="label-upload-image"><strong><?php _e( 'Image' ); ?></strong><br /></label>
			</p>

			<div class="image">
				<?php 
					if($image) 
						echo '<img src="' . $image . '" alt="Image" />';
				 ?>
			</div>

			<p class="upload-buttons">
				<a onclick="return false;" title="Upload image" class="thickbox button-secondary upload-image" id="add_image" href="media-upload.php?type=image&amp;TB_iframe=true&amp;width=640&amp;height=450"><?php if($image) : _e('Change image','tp'); else: _e('Upload image','tp'); endif; ?></a>
				
				<?php if($image) { ?>
					<a class="remove-image button-secondary"><?php _e( 'Remove image', 'tp' ); ?></a>
				<?php } ?>
				
				<input type="hidden" name="<?php echo $this->get_field_name( 'image' ); ?>" class="image_url" value="<?php echo $image; ?>" />
			</p>

		</div>

		<p>
			<label>
				<strong><?php _e('Content','tp'); ?></strong><br />
				<textarea class="widefat" name="<?php echo $this->get_field_name('content'); ?>" ><?php echo $content; ?></textarea>
			</label>
		</p>

		<p class="show_button">
			<label>
				<input onclick="showbuttons_create_clicks();" type="checkbox" name="<?php echo $this->get_field_name('show_button'); ?>" value="true" <?php if($show_button) echo 'checked'; ?>> <?php _e('Show button / read more link','tp'); ?>
			</label>
		</p>

		<div class="buttonsettings">

			<p>
				<label>
					<strong><?php _e( 'Button text', 'tp' ); ?></strong><br />
					<input class="widefat" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo $button_text; ?>" />
				</label>
			</p>

			<p>
				<label>
					<strong><?php _e( 'Button link', 'tp' ); ?></strong><br />
					<input class="widefat" name="<?php echo $this->get_field_name( 'button_link' ); ?>" type="text" value="<?php echo $button_link; ?>" />
				</label>
			</p>


			<p>
				<label>
					<strong><?php _e( 'Link type', 'tp' ); ?></strong><br />
					<select class="widefat" name="<?php echo $this->get_field_name( 'link_type' ); ?>" >
						<?php 
							foreach( $this->types as $type => $label )
								echo '<option value="' . $type . '" ' . selected( $type, $link_type ) . '>' . $label . '</option>';
						?>
					</select>
				</label>
			</p>

			<p>
				<label>
					<input type="checkbox" name="<?php echo $this->get_field_name( 'external' ); ?>" value="true" <?php checked( $external, true ); ?>> <?php _e( 'This link is external', 'tp' ); ?>
				</label>
			</p>

		</div>

		<?php
	}
	
	function update($new_instance,$old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['image'] = $new_instance['image'];
		$instance['content'] = $new_instance['content'];
		$instance['show_button'] = isset( $new_instance['show_button'] );
		$instance['button_text'] = $new_instance['button_text'];
		$instance['button_link'] = tp_maybe_add_http( $new_instance['button_link'] );
		$instance['link_type'] = $new_instance['link_type'];
		$instance['external'] = isset( $new_instance['external'] );

		return $instance;
	}
	
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$image = $instance['image'];
		$content = nl2br( $instance['content'] );
		$show_button = $instance['show_button'];
		$button_text = $instance['button_text'];
		$button_link = $instance['button_link'];
		$link_type = $instance['link_type'];
		$external = $instance['external'];
		
		extract($args);

		echo $before_widget;

			if( $title ) 
				echo $before_title . $title . $after_title;

			if($image) {
				?>

		    	<div class="featured-widget-image">
		    		<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" />
		    	</div>

		    	<?php
		    }

		    if( $content )
		    	echo '<p>' . $content . '</p>';

			if( $show_button ) {
				?>

		    	<p>
		    		<a class="<?php echo $link_type; ?>" href="<?php echo $button_link; ?>"
		    			<?php if($external) : echo 'rel="external"'; endif; ?>>
		    			<?php echo $button_text; ?>
		    		</a>
		    	</p>
	    		<?php 
	    	}

    	echo $after_widget;
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget("TP_Title_Image_Content_Button");' ) );

