<?php
/**
 * Timber
 */
if (class_exists('Timber')) {
    Timber::$dirname = array('templates/base', 'templates');
}

/**
 * Add theme support for RSS links
 */
add_theme_support('automatic-feed-links');

/**
 * Add support for <title>
 */
add_theme_support('title-tag');

/**
 * Add HTML5 theme support
 */
add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

/**
 * Add theme support for featured images for posts
 */
add_theme_support('post-thumbnails');

add_action('init', function () {
    remove_post_type_support('page', 'thumbnail');
});

/**
 * Add localization support
 */
load_theme_textdomain('tp', get_template_directory() . '/assets/languages');

/**
 * WordPress defaults
 */
new Trendwerk\TrendPress\Editor;
new Trendwerk\TrendPress\Enqueue;
new Trendwerk\TrendPress\Media;
new Trendwerk\TrendPress\Menus;

/**
 * Timber helpers
 */
new Trendwerk\TrendPress\TimberHelpers\Menus;
