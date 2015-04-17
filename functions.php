<?php
/**
 * Includes, theme support and localization
 * 
 * @package TrendPress
 */

/**
 * Includes
 */
include_once( 'assets/inc/class-tp-includer.php' );

new TP_Includer( get_template_directory() . '/assets/inc/' );

/**
 * Add theme support for RSS links
 */
add_theme_support( 'automatic-feed-links' );

/**
 * Add HTML5 theme support
 */
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

/**
 * Add theme support for featured images for posts
 */
add_theme_support( 'post-thumbnails' );

add_action( 'init', function() {
	remove_post_type_support( 'page', 'thumbnail' );
} );

/**
 * Add localization support
 */
load_theme_textdomain( 'tp', get_template_directory() . '/assets/lang' );
