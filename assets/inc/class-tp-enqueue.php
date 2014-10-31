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
		 * Core
		 */
		wp_enqueue_script( 'comment-reply' );

		/**
		 * Scripts
		 */
		wp_enqueue_script( 'functions', get_template_directory_uri() . '/assets/js/output/functions.js', array( 'jquery', 'fancybox' ) );
		wp_enqueue_script( 'responsive', get_template_directory_uri() . '/assets/js/output/responsive.js', array( 'jquery' ) );
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/js/lib/fancybox/jquery.fancybox.js', array( 'jquery' ) );

		/**
		 * Styles
		 */
		wp_enqueue_style( 'style', get_template_directory_uri() . '/assets/sass/output/style.css' );
		wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/assets/js/lib/fancybox/jquery.fancybox.css' );

		/**
		 * jQuery from Google's CDN
		 */
		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js' );
	}

	/**
	 * Admin styles and scripts
	 */
	function admin() {
		global $current_screen;
		
		if( 'widgets' == $current_screen->base )
			wp_enqueue_media();

		wp_enqueue_script( 'admin', get_template_directory_uri() . '/assets/js/output/admin.js', array( 'jquery' ) );
		wp_enqueue_style( 'admin', get_template_directory_uri() . '/assets/sass/output/admin.css' );
	}
} new TP_Enqueue;
