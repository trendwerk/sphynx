<?php
/**
 * Everything that has to do with post types
 *
 * @package TrendPress
 */

class TP_Post_Types {
	function __construct() {
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register & adjust post types
	 */
	function register() {
		/**
		 * Remove thumbnails from pages
		 */
		remove_post_type_support( 'page', 'thumbnail' );
	}
} new TP_Post_Types;
