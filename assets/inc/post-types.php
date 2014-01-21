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

	/**
	 * Testimonials
	 *
	 * @subpackage Post types
	 */
	$args = array(
		'labels'            => array(
			'name'          => __( 'Testimonials', 'tp' ),
			'singular_name' => __( 'Testimonial', 'tp' ),
			'add_new'       => __( 'Add testimonial', 'tp' ),
			'add_new_item'  => __( 'Add new testimonial', 'tp' ),
			'edit_item'     => __( 'Edit testimonial', 'tp' ),
		),
		'public'            => true,
		'has_archive'       => true,
		'menu_position'     => 5,
		'rewrite'           => array(
			'slug'          => __( 'testimonials', 'tp' ),
		),
		'supports'          => array( 'title', 'editor', 'thumbnail', 'revisions' ),
	); 
	register_post_type( 'testimonials', $args );
	
}
add_action( 'init', 'tp_register_post_types' );