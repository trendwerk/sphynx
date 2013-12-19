<?php
/**
 * Register parent theme scripts that can be used
 *
 * @package TrendPress
 */
 
class TP_Libraries {
	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register' ), 9 );
	}
	
	/**
	 * Add scripts
	 */
	function register() {
		//Scripts
		wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr/modernizr.lite.js' );
		wp_register_script( 'cycle', get_template_directory_uri() . '/assets/js/cycle/jquery.cycle2.min.js', array( 'jquery' ) );
		wp_register_script( 'fancybox', get_template_directory_uri() . '/assets/js/fancybox/jquery.fancybox.js', array( 'jquery' ) );
		wp_register_script( 'cookie', get_template_directory_uri() . '/assets/js/cookie/jquery.cookie.js', array( 'jquery' ) );
		wp_register_script( 'trendpress', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ) );

		//Styles
		wp_register_style( 'print', get_template_directory_uri() . '/assets/css/print.css', null, null, array( 'print' ) );
		wp_register_style( 'fancybox', get_template_directory_uri() . '/assets/js/fancybox/jquery.fancybox.css' );
	}
} new TP_Libraries;
