<?php
/**
 * Text with button
 *
 * @package TrendPress
 */
class TP_Title_Content_Button extends WP_Widget {
	function TP_Title_Content_Button() {
		$this->WP_Widget('TP_Title_Content_Button', __('Text with button','tp'), 'description='.__('Editable title, tekst and button','tp'));
	}
	
	function add_js() {
		?>
		<script type="text/javascript">
			//Show or hide extra settings
			function showbuttons_create_clicks($) {
				if(!$) $ = jQuery.noConflict();
				
				$('p.show_button input').each(function() {					
					//Extra fields
					show_or_hide_extras(this);
					
					$(this).change(function() {
						show_or_hide_extras(this);
					});
					
					function show_or_hide_extras(obj) {
						if($(obj).attr('checked')) {
							$(obj).closest('div').find('.buttonsettings').show();
						} else {
							$(obj).closest('div').find('.buttonsettings').hide();
						}
					}
				});
			}
			
			jQuery(document).ready(function($) {
				showbuttons_create_clicks($);
			});
		</script>		
		<?php
	}
	
	function form($instance) {
		$title = esc_attr($instance['title']);	
		$content = esc_attr($instance['content']);
		$show_button = $instance['show_button'];
		if(!$show_button) $show_button = 0;
		$button_text = esc_attr($instance['button_text']);
		$button_link = esc_attr($instance['button_link']);
		$link_type = esc_attr($instance['link_type']);
		$external = $instance['external'];

		$this->add_js();
	?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<strong><?php _e('Title'); ?></strong><br />
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>

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
				<labe>
					<strong><?php _e('Button text','tp'); ?></strong><br />
					<input class="widefat" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo $button_text; ?>" />
				</label>
			</p>

			<p>
				<label>
					<strong><?php _e('Button link','tp'); ?></strong><br />
					<input class="widefat" name="<?php echo $this->get_field_name('button_link'); ?>" type="text" value="<?php echo $button_link; ?>" />
				</label>
			</p>

			<p>
				<label>
					<strong><?php _e('Link type','tp'); ?></strong><br />
					<select class="widefat" name="<?php echo $this->get_field_name('link_type'); ?>" >
						<option value="more-link" <?php if($link_type == 'more-link') { echo "selected"; }; ?>><?php _e('Read more link','tp'); ?></option>
						<option value="cta primary" <?php if($link_type == 'cta primary') { echo "selected"; }; ?>><?php _e('Primary button','tp'); ?></option>
						<option value="cta secondary" <?php if($link_type == 'cta secondary') { echo "selected"; }; ?>><?php _e('Secondary button','tp'); ?></option>
					</select>
				</label>
			</p>

			<p>
				<label>
					<input type="checkbox" name="<?php echo $this->get_field_name('external'); ?>" value="true" <?php if($external) echo 'checked'; ?>> <?php _e('This link is external','tp'); ?>
				</label>
			</p>

		</div>

		<?php
	}
	
	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['content'] = $new_instance['content'];
		$instance['show_button'] = ($new_instance['show_button'] == 'true') ? true : false;
		$instance['button_text'] = $new_instance['button_text'];
		$instance['button_link'] = tp_maybe_add_http($new_instance['button_link']);
		$instance['link_type'] = $new_instance['link_type'];
		$instance['external'] = ($new_instance['external'] == 'true') ? true : false;
		
		return $instance;
	}
	
	function widget($args,$instance) {		
		$title = $instance['title'];
		$image = $instance['image'];
		$content = nl2br($instance['content']);
		$show_button = $instance['show_button'];
		$button_text = $instance['button_text'];
		$button_link = $instance['button_link'];
		$link_type = $instance['link_type'];
		$external = $instance['external'];
		extract($args);
	?>
		<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; } ?>
			<?php if($content) : ?>
				<p>
					<?php echo $content; ?>
				</p>
			<?php endif; ?>		
		    <?php if($show_button) { ?>

		    	<p>
		    		<a class="<?php echo $link_type; ?>" href="<?php echo $button_link; ?>"
		    			<?php if($external) : echo 'rel="external"'; endif; ?>>
		    			<?php echo $button_text; ?>
		    		</a>
		    	</p>

	    	<?php } ?>
		<?php echo $after_widget; ?>
	<?php
	}
}
add_action('widgets_init',create_function('','return register_widget("TP_Title_Content_Button");'));
