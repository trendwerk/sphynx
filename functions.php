<?php
/**
 * All the child theme's specific functionalities
 */

/**
 * @sidebars Register the sidebars
 */
if(function_exists('register_sidebar')) {	
	register_sidebar(array(
		'name' => 'Home',
		'id' => 'home',
		'before_widget' => '<div class="widget %2$s"><div class="inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'Page',
		'id' => 'page',
		'before_widget' => '<div class="widget %2$s"><div class="inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'Blog',
		'id' => 'blog',
		'before_widget' => '<div class="widget %2$s"><div class="inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'Footer',
		'id' => 'footerid',
		'before_widget' => '<div class="%2$s widget"><div class="inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}

/**
 * @menus Register Custom Menu's
 */
if (function_exists('register_nav_menu')) {
	register_nav_menu('mainnav',__('Main navigation','tp'));
	register_nav_menu('topnav',__('Top navigation','tp'));
	register_nav_menu('footernav',__('Footer navigation','tp'));
}

/**
 * @scripts Register and enqueue scripts
 */
function tp_load_scripts() {
	//jQuery through Google's CDN
	wp_deregister_script('jquery');
	wp_register_script('jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js',array(),null,false);

	//Register scripts
	wp_register_script('functions',get_stylesheet_directory_uri().'/assets/script/functions.js',array('jquery'));
	wp_register_script('modernizr',get_template_directory_uri().'/assets/script/modernizr/modernizr.lite.js');

	//Enqueue the scripts
	wp_enqueue_script('functions');
	wp_enqueue_script('modernizr');
}
add_action('wp_enqueue_scripts','tp_load_scripts');

/**
 * @languages Add the language domain
 */
load_theme_textdomain('tp',STYLESHEETPATH.'/assets/languages');

/**
 * @posttype Register post types, taxonomies and setup support
 */
add_theme_support('post-thumbnails');

function tp_disallow_postpage_thumbnails() {
	remove_post_type_support('page','thumbnail');
	remove_post_type_support('post','thumbnail');
}
add_action('init','tp_disallow_postpage_thumbnails');

/**
 * @widgets Define widgets
 */

/* Widget: Sociale media links from TrendPress theme options */

add_action('widgets_init', create_function('', 'return register_widget("social_media");'));

class social_media extends WP_Widget {
	function social_media() {
		$widget_ops = array('classname' => 'social_media', 'description' => __('Social media widget that shows a list of social media network sites that the user specified.','tp'));
		$control_ops = array('width' => 250, 'height' => 350);
		$this->WP_Widget('social_media', __('Social media links','tp'), $widget_ops, $control_ops);
	}
	
	function form($instance) {
		$type = esc_attr($instance['type']);
		
		$options = array('Big icons with text', 'Small icons with text', 'Big icons without text', 'Small icons without text');
		?>
		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Type iconen','tp'); ?>:
				<select class="widefat" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
					<?php foreach($options as $option) : ?>
						<option <?php if($option == $type) echo 'selected="selected"'; ?>><?php echo $option; ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		</p>
		<?php
	}
	
	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		
		$instance['type'] = $new_instance['type'];
				
		return $instance;
	}

	function widget($args,$instance) {
		?>
		<div class="widget social-media-widget 
			<?php if($instance['type'] == 'Small icons with text') { 
				echo 'small-icons'; } elseif ($instance['type'] == 'Big icons with text') {
				echo 'great-icons';
				} elseif ($instance['type'] == 'Big icons without text') {
				echo 'great-icons-no-text';
				} elseif ($instance['type'] == 'Small icons without text') {
				echo 'small-icons-no-text';
				}			
			 ?>
			">
			<div class="inner">
				<h3><?php _e('Keep in touch','tp'); ?></h3>
				<ul>
					<?php if($twitter = get_option('tp-twitter')) { ?><li class="twitter"><a href="<?php echo $twitter; ?>"><?php _e('Follow us on Twitter','tp') ?></a></li><?php } ?>
					<?php if($facebook = get_option('tp-facebook')) { ?><li class="facebook"><a href="<?php echo $facebook; ?>"><?php _e('Like us on Facebook','tp') ?></a></li><?php } ?>
					<?php if($linkedin = get_option('tp-linkedin')) { ?><li class="linkedin"><a href="<?php echo $linkedin; ?>"><?php _e('Connect with us on LinkedIn','tp') ?></a></li><?php } ?>
					<?php if($googleplus = get_option('tp-googleplus')) { ?><li class="googleplus"><a href="<?php echo $googleplus; ?>"><?php _e('Add us on Google+','tp') ?></a></li><?php } ?>
					<?php if($youtube = get_option('tp-youtube')) { ?><li class="youtube"><a href="<?php echo $youtube; ?>"><?php _e('Follow us on YouTube','tp') ?></a></li><?php } ?>
					<?php if($newsletter = get_option('tp-newsletter')) { ?><li class="email"><a href="<?php echo $newsletter; ?>"><?php _e('E-mail newsletter','tp'); ?></a></li><?php } ?>
					<?php if(get_option('tp-rss') == 'true') { ?><li class="rss"><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Subscribe to our RSS','tp') ?></a></li><?php } ?>
				</ul>
			</div>
		</div>
	    <?
	}
}

/* Widget: Contact information from TrendPress theme options */

add_action('widgets_init', create_function('', 'return register_widget("contact");'));

class contact extends WP_Widget {
	function contact() {
		$widget_ops = array('classname' => 'contact', 'description' => __('Widget that shows the user specified contact data.'));
		$control_ops = array('width' => 250, 'height' => 350);
		$this->WP_Widget('contact', __('Contact information','tp'), $widget_ops, $control_ops);
	}
	
	function form($instance) {
		printf(__('Change the contents of this widget on the <a href="%1$s">contact info</a> page.', 'tp'), admin_url('themes.php?page=tp-contact_info'));
	
		return 'noform';
	}
	
	function widget() {
		?>
		<div class="widget contact-widget">
			<div class="inner">
				<h3><?php _e('Contact','tp'); ?></h3>
				<p>
					<?php 
						if ($naam = get_option('tp-naam')) {
							echo '<strong>'.$naam.'</strong><br />';
						} if ($adres = get_option('tp-adres')) { 
							echo $adres.'<br />'; 
						} if ($postcode = get_option('tp-postcode')) {
							echo $postcode.' ';
						} if ($plaats = get_option('tp-plaats')) {
							echo $plaats; 
						}
					?>
				</p>
				<p>
					<?php
						if ($email = get_option('tp-email')) { 
							echo'<span>'.__('E-mail','tp').': </span><a href="mailto:'.$email.'">'.$email.'</a><br />';
						} if ($telefoon = get_option('tp-telefoon')) { 
							echo '<span>'.__('Telephone','tp').': </span>'.$telefoon.'<br />';
						} if ($fax = get_option('tp-fax')) { 
							echo '<span>'.__('Fax','tp').': </span>'.$fax;
						} 
					?>
				</p>
				<p>
					<?php
						if ($kvk = get_option('tp-kvk')) {
							echo '<span>'.__('CC No','tp').': </span>'.$kvk.'<br />';
						} if ($btw = get_option('tp-btw')) {
							echo '<span>'.__('VAT No','tp').': </span>'.$btw.'<br />';
						} if ($banknr = get_option('tp-banknr')) {
							if ($bank = !get_option('tp-bank')) {
								$bank = "Bank";
							} else {
								$bank = get_option('tp-bank');
							}
							echo '<span>'.$bank.': </span>'.$banknr;
						} 
					?>
				</p>
			</div>
		</div>
	    <?php
	}
}

/**
 * @other
 */
function tp_mce_before_init($settings) {
    $style_formats = array(
    	array(
    		'title' => 'Call to action',
    		'selector' => 'a',
    		'classes' => 'cta'
    	)
    );

    $settings['style_formats'] = json_encode($style_formats);
    return $settings;
}
add_filter('tiny_mce_before_init', 'tp_mce_before_init');
?>