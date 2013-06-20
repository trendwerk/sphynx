<?php
/**
 * @widgets Define widgets
 */

/**
 * @widget Submenu
 */
class submenu extends WP_Widget {
	function submenu() {
		$tp_ops = array('classname' => 'submenu', 'description' => __('Shows submenu items of current menu item or parent','tp'));
		$control_ops = array('width' => 250, 'height' => 350);
		$this->WP_Widget('submenu', __('Submenu','tp'), $tp_ops, $control_ops);
	}
	
	/**
	 * Show children from a submenu item
	 *
	 * @param object $item
	 */
	function show_children($item) {
		if($item->children) :
			?>
			<ul>
				<?php foreach($item->children as $child) :
					$class = '';
					if($child->is_current) {
						$class = 'class="current"';
					} else if($child->is_parent) {
						$class = 'class="parent"';
					}
				?>
					<li <?php echo $class; ?>>
						<a href="<?php echo $child->url; ?>">
							<?php echo $child->title; ?>	
						</a>
						<?php $this->show_children($child); ?>
					</li>
				<?php endforeach;?>
			</ul>
		<?php endif; ?>
	<?php
	}
	
	function widget($args,$instance) {		
		extract($args);
		global $post,$wpdb;
		
		$nav = new TPNav();
		$submenu = $nav->get_submenu_items();
		
		if(isset($submenu->children)) :
			if($submenu->children) :
			?>
				<?php echo $before_widget; ?>
					<?php echo $before_title; ?>
						<a href="<?php echo $submenu->url; ?>"><?php echo $submenu->title; ?></a>
					<?php echo $after_title; ?>
					
					<?php $this->show_children($submenu); ?>
				<?php echo $after_widget; ?>
		    <?php
		    endif;
	    endif;
	}
}
add_action('widgets_init', create_function('','return register_widget("submenu");'));

/**
 * @widget Contact info from TrendPress contact info
 */
class tp_contact extends WP_Widget {
	function tp_contact() {
		$this->WP_Widget('tp_contact', __('Contact information','tp'), 'description='.__('Shows the specified contact information','tp'));
	}

	function form($instance) {
		$title = esc_attr($instance['title']);
	?>
 		<p>
 			<label for="<?php echo $this->get_field_id('title'); ?>">
 				<strong><?php _e('Title'); ?></strong><br />
 				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
 			</label>
 		</p>
 		<p><?php printf(__('Change the contents of this widget on the <a href="%1$s">contact information</a> page.', 'tp'), admin_url('options-general.php?page=tp-information')); ?></p>
	<?php
	}
	
	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
				
		return $instance;
	}
	
	function widget($args,$instance) {		
		$title = apply_filters('widget_title', $instance['title']);
		extract($args);
	?>
 		<?php echo $before_widget; ?>
 			<?php if ($title) { echo $before_title . $title . $after_title; } ?>	
			<span itemscope itemtype="http://schema.org/Organization">
				<p>
					<?php 
						if ($name = get_option('tp-company-name')) {
						echo '<span itemprop="name"><strong>'.$name.'</strong></span><br />';
					?>
					<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">	
						<?php
							} if ($address = get_option('tp-address')) { 
								echo '<span itemprop="streetAddress">'.$address.'</span><br />'; 
							} if ($postal_code = get_option('tp-postal-code')) {
								echo '<span itemprop="postalCode">'.$postal_code.'</span>';
							} if ($city = get_option('tp-city')) {
							 echo ' <span itemprop="addressLocality">'.$city.'</span><br />'; 
							} if ($country = get_option('tp-country')) {
							 echo '<span itemprop="addressCountry">'.$country.'</span><br /><br />'; 
							}
						?>
					</span>
				</p>
				<p>
					<?php
						if ($email = get_option('tp-email')) { 
							echo'<span class="label">'.__('E-mail','tp').': </span><a itemprop="email" href="mailto:'.$email.'">'.$email.'</a><br />';
						} if ($telephone = get_option('tp-telephone')) { 
							echo '<span class="label">'.__('Telephone','tp').': </span><span itemprop="telephone">'.$telephone.'</span><br />';
						} if ($fax = get_option('tp-fax')) { 
							echo '<span class="label">'.__('Fax','tp').': </span><span itemprop="faxNumber">'.$fax.'</span>';
						} 
					?>
				</p>
				<p>
					<?php
						if ($cc = get_option('tp-cc')) {
							echo '<span class="label">'.__('CC No','tp').': </span>'.$cc.'<br />';
						} if ($vat = get_option('tp-vat')) {
							echo '<span itemprop="vatID">'.__('VAT No','tp').': </span>'.$vat.'<br />';
						} if ($bankno = get_option('tp-bank-no')) {
							if ($bank = !get_option('tp-bank')) {
								$bank = "Bank";
							} else {
								$bank = get_option('tp-bank');
							}
							echo '<span class="label">'.$bank.': </span>'.$bankno;
						} 
					?>
				</p>
			</span>
		<?php echo $after_widget; ?>
	<?php
	}
}
add_action('widgets_init',create_function('','return register_widget("tp_contact");'));

/**
 * @widget Sociale media links from TrendPress contact info
 */
class tp_social extends WP_Widget {
	function tp_social() {
		$this->WP_Widget('tp_social', __('Social media links','tp'), 'description='.__('Shows links to specified social network profiles','tp'));
	}
	
	function form($instance) {
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
						<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/twitter.svg" /><span><?php _e('Follow us on Twitter','tp') ?></span>
					</a>
				</li>
			<?php } ?>
			<?php if($facebook = get_option('tp-facebook')) { ?>
				<li class="facebook">
					<a rel="external" href="<?php echo $facebook; ?>" title="<?php _e('Like us on Facebook','tp') ?>">
						<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/facebook.svg" /><span><?php _e('Like us on Facebook','tp') ?></span>
					</a>
				</li>
			<?php } if($linkedin = get_option('tp-linkedin')) { ?>
				<li class="linkedin">
					<a rel="external" href="<?php echo $linkedin; ?>" title="<?php _e('Connect with us on LinkedIn','tp') ?>">
						<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/linkedin.svg" /><span><?php _e('Connect with us on LinkedIn','tp') ?></span>
					</a>
				</li>
				<?php } if($googleplus = get_option('tp-googleplus')) { ?>
				<li class="googleplus">
					<a rel="external" href="<?php echo $googleplus; ?>" title="<?php _e('Add us on Google+','tp') ?>">
						<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/google.svg" /><span><?php _e('Add us on Google+','tp') ?></span>
					</a>
				</li>
			<?php } if($youtube = get_option('tp-youtube')) { ?>
				<li class="youtube">
					<a rel="external" href="<?php echo $youtube; ?>" title="<?php _e('View our YouTube channel','tp') ?>">
						<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/youtube.svg" /><span><?php _e('View our YouTube channel','tp') ?></span>
					</a>
				</li>
			<?php } if($newsletter = get_option('tp-newsletter')) { ?>
				<li class="email">
					<a href="<?php echo $newsletter; ?>" title="<?php _e('E-mail newsletter','tp'); ?>">
						<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/email.svg" /><span><?php _e('E-mail newsletter','tp'); ?></span>
					</a>
				</li>
			<?php } ?>
			<?php if(get_option('tp-rss') == 'true') { ?>
				<li class="rss">
					<a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Subscribe to our RSS','tp') ?>">
						<img class="svg" src="<?php echo get_stylesheet_directory_uri() ?>/assets/img/social/rss.svg" /><span><?php _e('Subscribe to our RSS','tp') ?></span>
					</a>
				</li>
			<?php } ?>
		</ul>
	<?php echo $after_widget; ?>
	<?php
	}
}
add_action('widgets_init',create_function('','return register_widget("tp_social");'));

/**
 * @widget Facebook like box
 */
class tp_fb_like_box extends WP_Widget {
	function tp_fb_like_box() {
		$this->WP_Widget('tp_fb_like_box', __('Facebook like box','tp'), 'description='.__('Shows the Facebook users that like your Facebook page','tp'));
	}
	
	function form($instance) {
		$title = esc_attr($instance['title']);
		$url = $instance['url'];
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<strong><?php _e('Title'); ?></strong><br />
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>
		
		<p>
			<label>
				<strong><?php _e('Facebook page URL'); ?></strong><br />
				<input class="widefat" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo $url; ?>" />
			</label>
		</p>
		<?php
	}
	
	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['url'] = tp_maybe_add_http($new_instance['url']);
				
		return $instance;
	}
	
	function widget($args,$instance) {		
		$title = apply_filters('widget_title', $instance['title']);
		$url = $instance['url'];
		extract($args);
	?>
		<?php echo $before_widget; ?>
			<?php if ($title) { echo $before_title . $title . $after_title; } ?>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/nl_NL/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
			
			<div class="fb-like-box" data-href="<?php echo $url; ?>" data-show-border="false" data-height="270px" data-width="260px" data-show-faces="true" data-stream="false" data-header="false"></div>
		<?php echo $after_widget; ?>
	<?php
	}
}
add_action('widgets_init',create_function('','return register_widget("tp_fb_like_box");'));

/**
 * @widget Text with button
 */
class widget_title_content_button extends WP_Widget {
	function widget_title_content_button() {
		$this->WP_Widget('widget_title_content_button', __('Text with button','tp'), 'description='.__('Editable title, tekst and button','tp'));
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
		$image = $instance['image'];
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
		$instance['image'] = $new_instance['image'];
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
		    <?php if($image) : ?>
		    	<div class="featured-widget-image">
		    		<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" />
		    	</div>
		    <?php endif; ?>
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
		    	</a>
	    	<?php } ?>
		<?php echo $after_widget; ?>
	<?php
	}
}
add_action('widgets_init',create_function('','return register_widget("widget_title_content_button");'));

/**
 * @widget Text with image and button
 */
class widget_title_image_content_button extends WP_Widget {
	function widget_title_image_content_button() {
		$this->WP_Widget('widget_title_image_content_button', __('Text with image and button','tp'), 'description='.__('Editable title, image, text and button','tp'));
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
			jQuery(document).ready(function($) {
				var currently_uploading;
				
				showbuttons_create_clicks($);
			
				//Upload an image				
				$('.upload-image').click(function() {
					currently_uploading = $(this);
				});
				
				window.send_to_editor = function(html) {
					imgurl = jQuery('img',html).attr('src');
					
					$(currently_uploading).closest('div.upload-image-container').find('div.image').html(jQuery('img',html));
					$(currently_uploading).closest('div.upload-image-container').find('input.image_url').val(imgurl);
					
					tb_remove();
					save_widget($(currently_uploading));
					currently_uploading = null;
				}
				
				//Remove the image
				$('.remove-image').click(function() {
					$(this).closest('div.upload-image-container').find('div.image').html('');
					$(this).closest('div.upload-image-container').find('input.image_url').val('');
					
					save_widget($(this));
				});
				
				function save_widget(obj) {
					$(obj).closest('form').find('.widget-control-save').trigger('click');
				}
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
		$image = $instance['image'];
		$content = esc_attr($instance['content']);
		$show_button = $instance['show_button'];
		if(!$show_button) $show_button = 0;
		$button_text = esc_attr($instance['button_text']);
		$button_link = esc_attr($instance['button_link']);
		$link_type = esc_attr($instance['link_type']);
		$external = $instance['external'];
		
		$this->add_js();
		$this->add_css();
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				<strong><?php _e('Title'); ?></strong><br />
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</label>
		</p>
		<div class="upload-image-container">
			<p class="label-upload-image-p">
				<label class="label-upload-image"><strong><?php _e('Image'); ?></strong><br /></label>
			</p>
			<div class="image"><?php if($image) : ?><img src="<?php echo $image; ?>" alt="Image" /><?php endif; ?></div>
			<p class="upload-buttons">
				<a onclick="return false;" title="Upload image" class="thickbox button-secondary upload-image" id="add_image" href="media-upload.php?type=image&amp;TB_iframe=true&amp;width=640&amp;height=450"><?php if($image) : _e('Change image','tp'); else: _e('Upload image','tp'); endif; ?></a>
				
				<?php if($image) : ?>
					<a class="remove-image button-secondary"><?php _e('Remove image','tp'); ?></a>
				<?php endif; ?>
				
				<input type="hidden" name="<?php echo $this->get_field_name('image'); ?>" class="image_url" value="<?php echo $image; ?>" />
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
		$instance['image'] = $new_instance['image'];
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
			<?php if($image) : ?>
		    	<div class="featured-widget-image">
		    		<img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" />
		    	</div>
		    <?php endif; ?>
		    <?php if($content) : ?>
				<p>
					<?php echo $content; ?>
				</p>
			<?php endif; ?>
			<?php if($show_button) : ?>
		    	<p>
		    		<a class="<?php echo $link_type; ?>" href="<?php echo $button_link; ?>"
		    			<?php if($external) : echo 'rel="external"'; endif; ?>>
		    			<?php echo $button_text; ?>
		    		</a>
		    	</a>
	    	<?php endif; ?>
    	<?php echo $after_widget; ?>
    <?php
	}
}
add_action('widgets_init',create_function('','return register_widget("widget_title_image_content_button");'));

?>