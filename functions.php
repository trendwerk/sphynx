<?php
/**
 * All the child theme's specific functionalities
 */

/**
 * @includes Include the following PHP files
 */
include('assets/inc/functions.menus.php');
include('assets/inc/functions.sidebars.php');
include('assets/inc/functions.widgets.php');
include('assets/inc/functions.posttypes.php');
include('assets/inc/functions.misc.php');

/**
 * @scripts Enqueue scripts
 */
function tp_enqueue_scripts() {
	//Enqueue used parent libraries
	wp_enqueue_script('modernizr');
	wp_enqueue_script('cycle');
	wp_enqueue_style('printcss');
	wp_enqueue_script('fancybox');
	wp_enqueue_script('trendpress');
	wp_enqueue_script('comment-reply');
	wp_enqueue_style('fancyboxcss');
	
	
	//Register & enqueue child scripts and styles
	wp_enqueue_script('functions',get_stylesheet_directory_uri().'/assets/js/functions.js',array('jquery'));
	wp_enqueue_style('style',get_stylesheet_directory_uri().'/style.less');
}
add_action('wp_enqueue_scripts','tp_enqueue_scripts');

/**
 * @languages Add the language domain
 */
load_theme_textdomain('tp',STYLESHEETPATH.'/assets/lang');
?>