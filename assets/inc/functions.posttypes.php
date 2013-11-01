<?php

/**
 * @posttype Register post types, taxonomies and setup support
 */
function tp_register_post_types() {
	/**
	 * @support Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	remove_post_type_support( 'page', 'thumbnail' );
	
	/**
	 * @register Post types and taxonomies
	 */
}
add_action( 'init', 'tp_register_post_types' );