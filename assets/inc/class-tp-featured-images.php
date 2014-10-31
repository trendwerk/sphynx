<?php
/**
 * Everything that has to do with featured images
 *
 * @package TrendPress
 */

class TP_Featured_Images {
	function __construct() {
		add_action( 'init', array( $this, 'add_image_sizes' ) );
		add_action( 'after_switch_theme', array( $this, 'defaults' ) );
	}

	/**
	 * Define image sizes
	 */
	function add_image_sizes() {
		add_image_size( 'widget', 320, 500 );
	}

	/**
	 * Set default image sizes
	 */
	function defaults() {
		update_option( 'thumbnail_size_w', 150 );
		update_option( 'thumbnail_size_h', 150 );

		update_option( 'medium_size_w', 340 );
		update_option( 'medium_size_h', '' );

		update_option( 'large_size_w', 720 );
		update_option( 'large_size_h', '' );
		
	    update_option( 'image_default_link_type', 'file' );
	}
} new TP_Featured_Images;