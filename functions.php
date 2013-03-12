<?php
/**
 * This is the core of TrendPress.
 * The includes to all different added functionalities are done here.
 */

/**
 * @includes Include the following PHP files
 */
 
include('assets/inc/class.TPNav.php');
include('assets/inc/class.TPPlugins.php');
include('assets/inc/class.TPUserCaps.php');
include('assets/inc/class.TPTaxonomyLink.php');

include('assets/inc/functions.breadcrumbs.php');
include('assets/inc/functions.clean-up.php');
include('assets/inc/functions.custom-excerpt-length.php');
include('assets/inc/functions.custom-post-type.php');
include('assets/inc/functions.debug.php');
include('assets/inc/functions.js-constants.php');
include('assets/inc/functions.pagination.php');
include('assets/inc/functions.search.php');
include('assets/inc/functions.sidebars.php');
include('assets/inc/functions.theme-options.php');

/**
 * @scripts Register scripts
 */
function tp_register_scripts() {
	wp_deregister_script('jquery');
	wp_register_script('jquery','http://code.jquery.com/jquery-latest.min.js',array(),null,false);
	wp_register_script('functions',get_stylesheet_directory_uri().'/assets/js/functions.js',array('jquery'));
	wp_register_script('modernizr',get_template_directory_uri().'/assets/js/modernizr/modernizr.lite.js');
	wp_register_script('cycle',get_template_directory_uri().'/assets/js/cycle/cycle.all.js',array('jquery'));
	wp_register_script('fancybox',get_template_directory_uri().'/assets/js/fancybox/jquery.fancybox.js',array('jquery'));
	wp_register_script('less',get_stylesheet_directory_uri().'/assets/js/less-1.3.0.min.js');
	wp_register_style('less-to-css', get_stylesheet_directory_uri().'/style.less');
}

add_action('wp_enqueue_scripts','tp_register_scripts');

/**
 * @language Load the textdomain 'tp'
 */
load_theme_textdomain('tp',TEMPLATEPATH.'/assets/lang');

?>