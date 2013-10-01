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
	
	//De-register jQuery. Register en enqueue CDN version
	if( !is_admin() ) {
	    wp_deregister_script('jquery');
	    wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), false, 'latest', false);
	    wp_register_script('jquery-migrate', ("http://code.jquery.com/jquery-migrate-1.2.1.js"));
	    wp_enqueue_script('jquery');
	    wp_enqueue_script('jquery-migrate');
	}

}
add_action('wp_enqueue_scripts','tp_enqueue_scripts');

/**
 * @languages Add the language domain
 */
load_theme_textdomain('tp',STYLESHEETPATH.'/assets/lang');