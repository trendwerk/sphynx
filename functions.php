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

new TP_Includer( get_stylesheet_directory() . '/assets/inc/' );

/**
 * Add theme support for RSS links
 */
add_theme_support( 'automatic-feed-links' );

/**
 * Add HTML5 theme support
 */
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

/**
 * Add theme support for featured images
 */
add_theme_support( 'post-thumbnails' );

/**
 * Add localization support
 */
load_theme_textdomain( 'tp', get_stylesheet_directory() . '/assets/lang' );
