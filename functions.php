<?php
/**
 * Enqueue scripts and styles, register languages
 * 
 * @package TrendPress
 * @see assets/inc/ for all specific functions
 */

/**
 * Enqueue scripts and styles
 */
function tp_enqueue_scripts() {
	//Enqueue used parent libraries
	wp_enqueue_script( 'modernizr' );
 	wp_enqueue_script( 'cycle' );
	wp_enqueue_script( 'fancybox' );
	wp_enqueue_script( 'trendpress' );
	wp_enqueue_script( 'comment-reply' );

	wp_enqueue_style( 'fancyboxcss' );
	wp_enqueue_style( 'printcss' );
		
	//Register & enqueue child scripts and styles
	wp_enqueue_script( 'functions', get_stylesheet_directory_uri() . '/assets/js/functions.js', array( 'jquery' ) );
	wp_enqueue_script( 'responsive', get_stylesheet_directory_uri() . '/assets/js/responsive.js', array( 'jquery' ) );
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.less' );
	
	//Get jQuery from Google CDN
	if( ! is_admin() ) {
	    wp_deregister_script( 'jquery' );
	    wp_enqueue_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' );
	}
}
add_action( 'wp_enqueue_scripts', 'tp_enqueue_scripts' );

/**
 * Add the language domain
 */
load_theme_textdomain( 'tp', STYLESHEETPATH . '/assets/lang' );
