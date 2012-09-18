<?php
/**
 * All the child theme's specific functionalities
 * 
 * @chapter 1. Sidebars
 * @chapter 2. Custom Menu's
 * @chapter 3. Language
 * @chapter 4. Post types
 * @chapter 5. Widgets 
 * @chapter 6. Other
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
 * @languages Add the language domain
 */
load_theme_textdomain('tp',STYLESHEETPATH.'/assets/languages');

/**
 * @posttype Add support post thumbnails
 */
 
add_theme_support('post-thumbnails');

function no_postpage_thumbnails() {
	remove_post_type_support('page','thumbnail');
	remove_post_type_support('post','thumbnail');
}

add_action('init','no_postpage_thumbnails');

/**
 * @posttype Add post types and post type support
 */

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
		printf(__('Change the contents of this widget on the <a href="%1$s">theme options</a> page.', 'tp'), admin_url('themes.php?page=tp-theme-option'));
	
		return 'noform';
	}

	function widget() {
		?>
		<div class="widget social-media-widget">
			<div class="inner">
				<h3><?php _e('Keep in touch','tp'); ?></h3>
				<ul>
					<?php if($twitter = get_option('tp-twitter')) { ?><li class="twitter"><a href="<?php echo $twitter; ?>">Twitter</a></li><?php } ?>
					<?php if($facebook = get_option('tp-facebook')) { ?><li class="facebook"><a href="<?php echo $facebook; ?>">Facebook</a></li><?php } ?>
					<?php if($linkedin = get_option('tp-linkedin')) { ?><li class="linkedin"><a href="<?php echo $linkedin; ?>">Linkedin</a></li><?php } ?>
					<?php if($googleplus = get_option('tp-googleplus')) { ?><li class="googleplus"><a href="<?php echo $googleplus; ?>">Google plus</a></li><?php } ?>
					<?php if($youtube = get_option('tp-youtube')) { ?><li class="youtube"><a href="<?php echo $youtube; ?>">YouTube</a></li><?php } ?>
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
		printf(__('Change the contents of this widget on the <a href="%1$s">theme options</a> page.', 'tp'), admin_url('themes.php?page=tp-theme-option'));
	
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
	    <?
	}
}

/**
 * @other
 */
function my_mce_before_init($settings) {
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
add_filter('tiny_mce_before_init', 'my_mce_before_init');
?>