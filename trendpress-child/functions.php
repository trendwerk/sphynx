<?php
/**
 * All the child theme's specific functionalities
 * 
 * @chapter 1. Sidebars
 * @chapter 2. Custom Menu's
 * @chapter 3. Language
 * @chapter 4. Post types
 * @chapter 5. Widgets
 */

/**
 * @sidebars Register the sidebars
 */
if(function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'Footer',
		'id' => 'footerid',
		'description' => 'De sidebar die wordt weegegeven in de footer.',
		'before_widget' => '<div class="%2$s widget fourcol">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Home',
		'id' => 'homeid',
		'description' => 'De sidebar die wordt weergegeven op de homepagina.',
		'before_widget' => '<div class="widget %2$s"><div class="widget-inner">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Page',
		'id' => 'pageid',
		'description' => 'De sidebar die wordt weergegeven op de vaste pagina\'s.',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	register_sidebar(array(
		'name' => 'Blog',
		'id' => 'blogid',
		'description' => 'De sidebar die wordt weegegeven op de blog pagina\'s',		
		'before_widget' => '<div class="widget %2$s">',
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
load_theme_textdomain('tp',TEMPLATEPATH.'/assets/languages');

/**
 * @posttype Add post types and post type support
 */

/**
 * @widgets Define widgets
 */

?>