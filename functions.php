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
	wp_enqueue_style( 'fancybox' );
		
	//Register & enqueue child scripts and styles
	wp_enqueue_script( 'functions', get_stylesheet_directory_uri() . '/assets/js/functions.js', array( 'jquery' ) );
	wp_enqueue_script( 'responsive', get_stylesheet_directory_uri() . '/assets/js/responsive.js', array( 'jquery' ) );
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/assets/sass/output/style.css' );
	
	//Get jQuery from Google CDN
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js' );
}
add_action( 'wp_enqueue_scripts', 'tp_enqueue_scripts' );

/**
 * Admin style and script
 */
function tp_admin_enqueue_scripts() {
	global $current_screen;
	
	if( 'widgets' == $current_screen->base )
		wp_enqueue_media();

	wp_enqueue_script( 'admin', get_stylesheet_directory_uri() . '/assets/js/admin.js', array( 'jquery' ) );
	wp_enqueue_style( 'admin', get_stylesheet_directory_uri() . '/assets/sass/output/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'tp_admin_enqueue_scripts' );

/**
 * Add the language domain
 */
load_theme_textdomain( 'tp', get_stylesheet_directory() . '/assets/lang' );
