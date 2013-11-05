<?php
/**
 * Telephone number and button
 *
 * @package TrendPress
 */
class TP_Telephone_Button extends WP_Widget {
	function TP_Telephone_Button() {
		$this->WP_Widget('TP_Telephone_Button', __('Telephone number and button','tp'), 'description='.__('Telephone number and button','tp'));
	}

	function add_js() {
		?>
		<script type="text/javascript">
			//Show / hide button fields
			jQuery(document).ready(function($) {				
				showbuttons_create_clicks($);
			});
			
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
		</script>		
		<?php
	}
	
	function form($instance) {
		$title = esc_attr($instance['title']);
		$content = esc_attr($instance['content']);
		$show_button = esc_attr($instance['show_button']);
		$button_text = esc_attr($instance['button_text']);
		$button_link = esc_attr($instance['button_link']);
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<strong><?php _e('Title'); ?></strong><br />
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('content'); ?>">
				<strong><?php _e('Content'); ?></strong><br />
				<textarea  class="widefat" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>"><?php echo $content; ?></textarea>
			</label>
		</p>

		<p><?php printf(__('Change the telephone number on the <a href="%1$s">contact information</a> page.', 'tp'), admin_url('options-general.php?page=tp-information')); ?></p>

		<p class="show_button">
			<label>
				<input onclick="showbuttons_create_clicks();" type="checkbox" name="<?php echo $this->get_field_name('show_button'); ?>" value="true" <?php if($show_button) echo 'checked'; ?>> <?php _e('Show button','tp'); ?>
			</label>
		</p>

		<div class="buttonsettings">

			<p>
				<label>
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

		</div>

		<?php
	}
	
	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['content'] = strip_tags($new_instance['content']);
		$instance['show_button'] = strip_tags($new_instance['show_button']);
		$instance['button_text'] = strip_tags($new_instance['button_text']);
		$instance['button_link'] = tp_maybe_add_http($new_instance['button_link']);
				
		return $instance;
	}
	
	function widget($args,$instance) {
		$title = $instance['title'];
		$content = nl2br($instance['content']);
		$show_button = $instance['show_button'];
		$button_text = $instance['button_text'];
		$button_link = $instance['button_link'];
		extract($args);
		
		echo $before_widget;
			echo $before_title.$instance['title'].$after_title; 
			?>

				<?php if ($instance['content']) { ?>
					<p><?php echo $instance['content']; ?></p>
				<?php } ?>

				<?php if ($telephone = get_option('tp-telephone')) { ?>
					<p class="telephone">
						<i class="icon-phone"></i> 
						<?php echo $telephone; ?>
					</p>
				<?php } ?>

				<?php if ($instance['show_button']) { ?>
					<p>
						<a class="cta primary" href="<?php echo $instance['button_link']; ?>">
							<?php echo $instance['button_text']; ?>
						</a>
					</p>
				<?php } ?>

			<?php 
		echo $after_widget;
	}
}
add_action('widgets_init',create_function('','return register_widget("TP_Telephone_Button");'));
