<?php
/**
 * Enqueue styles and scripts
 */

namespace Trendwerk\TrendPress;

final class Enqueue
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'frontend'));
    }

    /**
     * Enqueue styles and scripts for front-end
     */
    public function frontend()
    {
        $template_root = get_template_directory_uri();
        $assets = $template_root . '/assets';
        $bower = $template_root . '/bower_components';

        /**
         * Core
         */
        wp_enqueue_script('comment-reply');

        /**
         * Scripts
         */
        wp_enqueue_script('defer', $assets . '/scripts/output/defer.js', array('jquery'), false, true);

        wp_localize_script('defer', 'Assets', array(
            'scripts' => $assets . '/scripts/output',
        ));

        /**
         * Styles
         */
        wp_enqueue_style('main', $assets . '/styles/output/main.min.css');

        /**
         * jQuery from Google's CDN
         */
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
    }
}
