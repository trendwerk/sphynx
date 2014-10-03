<?php
/**
 * Enqueue styles and scripts
 *
 * @package TrendPress
 */

class TP_Enqueue {
	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin' ) );
	}

	/**
	 * Enqueue styles and scripts for front-end
	 */
	function frontend() {
		/**
		 * Register and enqueue child styles and scripts
		 */
		wp_enqueue_script( 'functions', get_stylesheet_directory_uri() . '/assets/js/functions.js', array( 'jquery' ) );
		wp_enqueue_script( 'responsive', get_stylesheet_directory_uri() . '/assets/js/responsive.js', array( 'jquery' ) );
		wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/assets/sass/output/style.css' );

		/**
		 * jQuery from Google's CDN
		 */
		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js' );

		/**
		 * Enqueue used parent libraries
		 */
		wp_enqueue_script( 'modernizr' );
	 	wp_enqueue_script( 'cycle' );
		wp_enqueue_script( 'fancybox' );
		wp_enqueue_script( 'trendpress' );
		wp_enqueue_script( 'comment-reply' );

		wp_enqueue_style( 'fancybox' );
	}

	/**
	 * Admin styles and scripts
	 */
	function admin() {
		global $current_screen;
		
		if( 'widgets' == $current_screen->base )
			wp_enqueue_media();

		wp_enqueue_script( 'admin', get_stylesheet_directory_uri() . '/assets/js/admin.js', array( 'jquery' ) );
		wp_enqueue_style( 'admin', get_stylesheet_directory_uri() . '/assets/sass/output/admin.css' );
	}
} new TP_Enqueue;
