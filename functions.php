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
		'id' => 'homeid',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Page',
		'id' => 'pageid',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Blog',
		'id' => 'blogid',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Footer',
		'id' => 'footerid',
		'before_widget' => '<div class="%2$s widget fourcol">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',	
	));
}

/**
 * @menus Register Custom Menu's
 */
if (function_exists('register_nav_menu')) {
	register_nav_menu('hoofdnavigatie','Hoofdnavigatie');
	register_nav_menu('topnavigatie','Topnavigatie');
	register_nav_menu('footernavigatie','Footernavigatie');
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

/* Widget: Sociale media gegevens uit TrendPress thema opties */

add_action('widgets_init', create_function('', 'return register_widget("social_media");'));

class social_media extends WP_Widget {
	function social_media() {
		$widget_ops = array('classname' => 'social_media', 'description' => __('Social media widget that shows a list of social media network sites that the user specified.'));
		$control_ops = array('width' => 250, 'height' => 350);
		$this->WP_Widget('social_media', __('Social media links'), $widget_ops, $control_ops);
	}
	
	function form($instance) {
		printf(__('Change the contents of this widget on the <a href="%1$s">theme options</a> page.', 'tp'), admin_url('themes.php?page=tp-theme-option'));
	
		return 'noform';
	}

	function widget() {
		?>
		<div class="widget social-media-widget">
			<h3 class="widgettitle"><?php _e('Keep in touch','tp'); ?></h3>
			<ul>
				<?php if($twitter = get_option('tp-twitter')) { ?><li class="twitter"><a href="<?php echo $twitter; ?>">Twitter</a></li><?php } ?>
				<?php if($facebook = get_option('tp-facebook')) { ?><li class="facebook"><a href="<?php echo $facebook; ?>">Facebook</a></li><?php } ?>
				<?php if($linkedin = get_option('tp-linkedin')) { ?><li class="linkedin"><a href="<?php echo $linkedin; ?>">Linkedin</a></li><?php } ?>
				<?php if($googleplus = get_option('tp-googleplus')) { ?><li class="googleplus"><a href="<?php echo $googleplus; ?>">Google plus</a></li><?php } ?>
				<?php if($youtube = get_option('tp-youtube')) { ?><li class="youtube"><a href="<?php echo $youtube; ?>">YouTube</a></li><?php } ?>
			</ul>
		</div>
	    <?
	}
}

/* Widget: Contactgegevens uit TrendPress thema opties */

add_action('widgets_init', create_function('', 'return register_widget("contact");'));

class contact extends WP_Widget {
	function contact() {
		$widget_ops = array('classname' => 'contact', 'description' => __('Widget that shows the user specified contact data.'));
		$control_ops = array('width' => 250, 'height' => 350);
		$this->WP_Widget('contact', __('Contact data'), $widget_ops, $control_ops);
	}
	
	function form($instance) {
		printf(__('Change the contents of this widget on the <a href="%1$s">theme options</a> page.', 'tp'), admin_url('themes.php?page=tp-theme-option'));
	
		return 'noform';
	}
	
	function widget() {
		?>
		<div class="widget contact-widget">
			<h3 class="widgettitle"><?php _e('Contact','tp'); ?></h3>
			<ul class="name-adress">
				<?php if($naam = get_option('tp-naam')) { ?><li><strong><?php echo $naam; ?></strong></li><?php } ?>
				<?php if($adres = get_option('tp-adres')) { ?><li><?php echo $adres; ?></li><?php } ?>
				<?php if($postcode = get_option('tp-postcode')) { ?><li><?php echo $postcode; ?>  <?php if($plaats = get_option('tp-plaats')) { ?><?php echo $plaats; ?><?php } ?></li><?php } ?>
			</ul>
			<ul class="other">
				<?php if($email = get_option('tp-email')) { ?><li><span><?php _e('E-mail','tp'); ?>:</span><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></li><?php } ?>
				<?php if($telefoon = get_option('tp-telefoon')) { ?><li><span><?php _e('Telephone','tp'); ?>:</span><?php echo $telefoon; ?></li><?php } ?>
				<?php if($kvk = get_option('tp-kvk')) { ?><li><span><?php _e('CC No','tp'); ?>: </span><?php echo $kvk; ?></li><?php } ?>
				<?php if($btw = get_option('tp-btw')) { ?><li><span><?php _e('VAT No','tp'); ?>: </span><?php echo $btw; ?></li><?php } ?>
				<?php if($bank = get_option('tp-bank')) { ?><li><span><?php echo $bank; ?>:</span><?php if($banknr = get_option('tp-bank-nr')) { ?><?php echo $banknr; ?><?php } ?></li><?php } ?>
				
			</ul>
		</div>
	    <?
	}
}

/**
 * @other
 */

?>