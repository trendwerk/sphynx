<?php
/**
 * Everything that has to do with post types
 *
 * @package TrendPress
 */
function tp_register_post_types() {
	/**
	 * Add them support for post thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	remove_post_type_support( 'page', 'thumbnail' );

	add_image_size( 'widget', 320, 500 );
	
}
add_action( 'init', 'tp_register_post_types' );