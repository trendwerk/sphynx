<?php
use Timber\Timber;

$timber = new Timber();
Timber::$dirname = array('templates/base', 'templates');

/**
 * Theme support
 */
add_theme_support('automatic-feed-links');
add_theme_support('title-tag');
add_theme_support('html5', array('comment-list', 'comment-form', 'gallery', 'caption'));
add_theme_support('post-thumbnails');

add_action('init', function () {
    remove_post_type_support('page', 'thumbnail');
});

/**
 * Localization
 */
load_theme_textdomain('tp', get_template_directory() . '/assets/languages');

/**
 * Instantiate hooks
 */
new Trendwerk\TrendPress\Editor();
new Trendwerk\TrendPress\Enqueue();
new Trendwerk\TrendPress\Media();
new Trendwerk\TrendPress\Menus();

new Trendwerk\TrendPress\TimberHelpers\Menus();
