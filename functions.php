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
include('assets/inc/functions.cpts.php');
include('assets/inc/functions.misc.php');

/**
 * @scripts Enqueue scripts
 */
function tp_enqueue_scripts() {
	wp_enqueue_script('functions');
	wp_enqueue_script('modernizr');
	wp_enqueue_script('cycle');
	wp_enqueue_script('fancybox');
	wp_enqueue_script('less');
	wp_enqueue_style('less-to-css');
}
add_action('wp_enqueue_scripts','tp_enqueue_scripts');

/**
 * @languages Add the language domain
 */
load_theme_textdomain('tp',STYLESHEETPATH.'/assets/lang');
?>