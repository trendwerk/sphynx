<?php
/**
 * All the child theme's specific functionalities
 */

/**
 * @sidebars Register the sidebars
 */
function tp_register_sidebars() {
	tp_register_sidebar('home',array(
		'name' => __('Home','tp')
	));
	tp_register_sidebar('page',array(
		'name' => __('Page','tp')
	));
	tp_register_sidebar('blog',array(
		'name' => __('Blog','tp')
	));
	tp_register_sidebar('footerid',array(
		'name' => __('Footer','tp')
	));
}
add_action('init','tp_register_sidebars');

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

	/**
	 * @scripts jQuery through Google's CDN
	 */
	wp_deregister_script('jquery');
	wp_register_script('jquery','http://code.jquery.com/jquery-latest.min.js',array(),null,false);

	/**
	 * @scripts register scripts
	 */
	wp_register_script('functions',get_stylesheet_directory_uri().'/assets/js/functions.js',array('jquery'));
	wp_register_script('modernizr',get_template_directory_uri().'/assets/js/modernizr/modernizr.lite.js');
	wp_register_script('cycle',get_template_directory_uri().'/assets/js/cycle/cycle.all.js',array('jquery'));
	wp_register_script('fancybox',get_template_directory_uri().'/assets/js/fancybox/jquery.fancybox.js',array('jquery'));
	
	/**
	 * @scripts enqueue the scripts
	 */
	wp_enqueue_script('functions');
	wp_enqueue_script('modernizr');
	wp_enqueue_script('cycle');
	wp_enqueue_script('fancybox');

	/*
	Remove the active comment if you want to use less for development

	DEVELOPMENT WITH LESS
	---------------------
	1. Make sure you enqueue the less.js file below
	2. Uncomment the style.less file in header.php

	wp_register_script('less',get_stylesheet_directory_uri().'/assets/js/less-1.3.0.min.js');	
	wp_enqueue_script('less');
	*/
	
	/*
	PRODUCTION WITH LESS
	--------------------
	1. Make sure you activate/install the WP-LESS (found here: http://wordpress.org/extend/plugins/wp-less)
	2. Uncomment the code below and WP-LESS will parse the .less file you define below
	
	wp_enqueue_style('less-to-css', get_stylesheet_directory_uri().'/style.less');
	*/
}

add_action('wp_enqueue_scripts','tp_load_scripts');

/**
 * @languages Add the language domain
 */
load_theme_textdomain('tp',STYLESHEETPATH.'/assets/lang');

/**
 * @posttype Register post types, taxonomies and setup support
 */
function tp_register_post_types() {
	/**
	 * @support Thumbnails
	 */
	add_theme_support('post-thumbnails');
	remove_post_type_support('page','thumbnail');
	remove_post_type_support('post','thumbnail');
	
	/**
	 * @register Post types and taxonomies
	 */
}
add_action('init','tp_register_post_types');

/**
 * @widgets Define widgets
 *
 * @widget Contact information from TrendPress settings
 */
class widget_tp_contact extends WP_Widget {
	function widget_tp_contact() {
		$this->WP_Widget('widget_tp_contact', __('Contact information','tp'), 'description='.__('Shows the specified contact information','tp'));
	}
	
	function form($instance) {
		printf(__('Change the contents of this widget on the <a href="%1$s">contact info</a> page.', 'tp'), admin_url('themes.php?page=tp-contact'));
	
		return 'noform';
	}
	
	function widget() {
		?>
		<div class="widget tp-contact">
			<h3 class="widgettitle"><?php _e('Contact','tp'); ?></h3>
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
	    <?php
	}
}
add_action('widgets_init',create_function('','return register_widget("widget_tp_contact");'));

/**
 * @widget Sociale media links from TrendPress settings
 */
class widget_tp_social extends WP_Widget {
	function widget_tp_social() {
		$this->WP_Widget('widget_tp_social', __('Social media links','tp'), 'description='.__('Shows links to specified social network profiles','tp'));
	}
	
	function form($instance) {
		$type = esc_attr($instance['type']);
		
		$options = array('Big icons with text', 'Small icons with text', 'Big icons without text', 'Small icons without text');
		?>
		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>"><?php _e('Icon types','tp'); ?>:
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
		<div class="widget widget-tp-social 
			<?php if($instance['type'] == 'Small icons with text') { 
				echo 'small-icons'; 
				} elseif ($instance['type'] == 'Big icons with text') {
				echo 'great-icons';
				} elseif ($instance['type'] == 'Big icons without text') {
				echo 'great-icons-no-text';
				} elseif ($instance['type'] == 'Small icons without text') {
				echo 'small-icons-no-text';
				}
			 ?>
			">
			<h3 class="widgettitle"><?php _e('Keep in touch','tp'); ?></h3>
			<ul>
				<?php if($twitter = get_option('tp-twitter')) { ?><li class="twitter"><a href="<?php echo $twitter; ?>"><?php _e('Follow us on Twitter','tp') ?></a></li><?php } ?>
				<?php if($facebook = get_option('tp-facebook')) { ?><li class="facebook"><a href="<?php echo $facebook; ?>"><?php _e('Like us on Facebook','tp') ?></a></li><?php } ?>
				<?php if($linkedin = get_option('tp-linkedin')) { ?><li class="linkedin"><a href="<?php echo $linkedin; ?>"><?php _e('Connect with us on LinkedIn','tp') ?></a></li><?php } ?>
				<?php if($googleplus = get_option('tp-googleplus')) { ?><li class="googleplus"><a href="<?php echo $googleplus; ?>"><?php _e('Add us on Google+','tp') ?></a></li><?php } ?>
				<?php if($youtube = get_option('tp-youtube')) { ?><li class="youtube"><a href="<?php echo $youtube; ?>"><?php _e('View our YouTube channel','tp') ?></a></li><?php } ?>
				<?php if($newsletter = get_option('tp-newsletter')) { ?><li class="email"><a href="<?php echo $newsletter; ?>"><?php _e('E-mail newsletter','tp'); ?></a></li><?php } ?>
				<?php if(get_option('tp-rss') == 'true') { ?><li class="rss"><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Subscribe to our RSS','tp') ?></a></li><?php } ?>
			</ul>
		</div>
	    <?php
	}
}
add_action('widgets_init',create_function('','return register_widget("widget_tp_social");'));

/**
 * @misc
 *
 * @misc Add editor styles
 */
function tp_add_editor_styles($settings) {
    $style_formats = array(
    	array(
    		'title' => __('Call to action','tp'),
    		'selector' => 'a',
    		'classes' => 'cta'
    	)
    );

    $settings['style_formats'] = json_encode($style_formats);
    return $settings;
}
add_filter('tiny_mce_before_init','tp_add_editor_styles');
?>