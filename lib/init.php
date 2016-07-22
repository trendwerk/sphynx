<?php
namespace Trendwerk\TrendPress;

use Timber\Timber;

$timber = new Timber();
Timber::$dirname = array('templates/base', 'templates');

/**
 * Theme support
 */
add_theme_support('title-tag');
add_theme_support('html5', array('comment-list', 'comment-form', 'gallery', 'caption'));

/**
 * Localization
 */
load_theme_textdomain('tp', get_template_directory() . '/assets/languages');

/**
 * Instantiate hooks
 */
new Admin\Editor();
new Enqueue();
new Media();
new Menus();
new Plugins\Timber\Context();
