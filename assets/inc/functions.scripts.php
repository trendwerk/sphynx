<?php
/**
 * @scripts Register scripts
 */
function tp_register_scripts() {
	wp_register_script('modernizr',get_template_directory_uri().'/assets/js/modernizr/modernizr.lite.js');
	wp_register_script('cycle',get_template_directory_uri().'/assets/js/cycle/cycle.all.js',array('jquery'));
	wp_register_script('fancybox',get_template_directory_uri().'/assets/js/fancybox/jquery.fancybox.js',array('jquery'));
	wp_register_script('less',get_template_directory_uri().'/assets/js/less/less-1.3.0.min.js');
	wp_register_script('cookie',get_template_directory_uri().'/assets/js/cookie/jquery.cookie.js',array('jquery'));
	wp_register_script('trendpress',get_template_directory_uri().'/assets/js/functions.js',array('jquery'));
}

add_action('wp_enqueue_scripts','tp_register_scripts',9);
?>