<?php
/**
 * Register parent theme scripts that can be used
 */
 
class TPScripts {
	function __construct() {
		add_action('wp_enqueue_scripts',array($this,'add'),9);
	}
	
	/**
	 * Add scripts
	 */
	function add() {
		wp_register_script('modernizr',get_template_directory_uri().'/assets/js/modernizr/modernizr.lite.js');
		wp_register_script('cycle',get_template_directory_uri().'/assets/js/cycle/jquery.cycle2.min.js',array('jquery'));
		wp_register_script('fancybox',get_template_directory_uri().'/assets/js/fancybox/jquery.fancybox.js',array('jquery'));
		wp_register_style('fancyboxcss',get_template_directory_uri().'/assets/js/fancybox/jquery.fancybox.css');
		wp_register_script('cookie',get_template_directory_uri().'/assets/js/cookie/jquery.cookie.js',array('jquery'));
		wp_register_script('trendpress',get_template_directory_uri().'/assets/js/functions.js',array('jquery'));
	}
} new TPScripts;
?>