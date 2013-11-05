<?php
/**
 * Social media links
 *
 * @package TrendPress
 */
class TP_Social extends WP_Widget {
	function TP_Social() {
		$this->WP_Widget('TP_Social', __('Social media links','tp'), 'description='.__('Shows links to specified social network profiles','tp'));
	}
	
	function form($instance) {
		$title = esc_attr($instance['title']);
		$type = esc_attr($instance['type']);
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<strong><?php _e('Title'); ?></strong><br />
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>

		<p>
			<label>
				<strong><?php _e('Icon types','tp'); ?></strong><br />
				<select class="widefat" name="<?php echo $this->get_field_name('type'); ?>">
					<option <?php if($type == 'large-icons') echo 'selected="selected"'; ?> value="large-icons"><?php _e('Large icons','tp'); ?></option>
					<option <?php if($type == 'small-icons') echo 'selected="selected"'; ?> value="small-icons"><?php _e('Small icons','tp'); ?></option>
					<option <?php if($type == 'small-icons-text') echo 'selected="selected"'; ?> value="small-icons-text"><?php _e('Small icons with text','tp'); ?></option>
				</select>
			</label>
		</p>

		<p><?php printf(__('Change the contents of this widget on the <a href="%1$s">contact information</a> page.', 'tp'), admin_url('options-general.php?page=tp-information')); ?></p>

		<?php
	}
	
	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['type'] = $new_instance['type'];
				
		return $instance;
	}
	
	function widget($args,$instance) {		
		$title = apply_filters('widget_title', $instance['title']);
		$type = $instance['type'];
		extract($args);
	?>
		<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; } ?>
			<ul class="social <?php echo $type; ?>">
				<?php if($twitter = get_option('tp-twitter')) { ?>
					<li class="twitter">
						<a rel="external" href="<?php echo $twitter; ?>" title="<?php _e('Follow us on Twitter','tp') ?>">
							<i class="icon-twitter-sign"></i>
							<span class="title"><?php _e('Follow us on Twitter','tp') ?></span>
						</a>
					</li>
				<?php } ?>
				<?php if($facebook = get_option('tp-facebook')) { ?>
					<li class="facebook">
						<a rel="external" href="<?php echo $facebook; ?>" title="<?php _e('Like our Facebook page','tp') ?>">
							<i class="icon-facebook-sign"></i>
							<span class="title"><?php _e('Like our Facebook page','tp') ?></span>
						</a>
					</li>
				<?php } if($linkedin = get_option('tp-linkedin')) { ?>
					<li class="linkedin">
						<a rel="external" href="<?php echo $linkedin; ?>" title="<?php _e('Connect with us on LinkedIn','tp') ?>">
							<i class="icon-linkedin-sign"></i>
							<span class="title"><?php _e('Connect with us on LinkedIn','tp') ?></span>
						</a>
					</li>
					<?php } if($googleplus = get_option('tp-googleplus')) { ?>
					<li class="googleplus">
						<a rel="external" href="<?php echo $googleplus; ?>" title="<?php _e('Add us on Google+','tp') ?>">
							<i class="icon-google-plus-sign"></i>
							<span class="title"><?php _e('Add us on Google+','tp') ?></span>
						</a>
					</li>
				<?php } if($youtube = get_option('tp-youtube')) { ?>
					<li class="youtube">
						<a rel="external" href="<?php echo $youtube; ?>" title="<?php _e('View our YouTube channel','tp') ?>">
							<i class="icon-youtube-sign"></i>
							<span class="title"><?php _e('View our YouTube channel','tp') ?></span>
						</a>
					</li>
				<?php } if($newsletter = get_option('tp-newsletter')) { ?>
					<li class="email">
						<a href="<?php echo $newsletter; ?>" title="<?php _e('E-mail newsletter','tp'); ?>">
							<i class="icon-envelope"></i>
							<span class="title"><?php _e('E-mail newsletter','tp'); ?></span>
						</a>
					</li>
				<?php } ?>
				<?php if(get_option('tp-rss') == 'true') { ?>
					<li class="rss">
						<a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Subscribe via RSS','tp') ?>">
							<i class="icon-rss-sign"></i>
							<span class="title"><?php _e('Subscribe to our RSS','tp') ?></span>
						</a>
					</li>
				<?php } ?>
			</ul>
		<?php echo $after_widget; ?>
	<?php
	}
}
add_action('widgets_init',create_function('','return register_widget("TP_Social");'));
