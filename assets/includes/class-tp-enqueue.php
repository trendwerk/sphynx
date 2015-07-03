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
        $assets = get_template_directory_uri() . '/assets';

        /**
         * Core
         */
        wp_enqueue_script('comment-reply');

        /**
         * Scripts
         */
        wp_enqueue_script('functions', $assets . '/scripts/output/functions.js', array('jquery', 'fancybox'));
        wp_enqueue_script('responsive', $assets . '/scripts/output/responsive.js', array('jquery'));
        wp_enqueue_script('fancybox', $assets . '/scripts/lib/fancybox/jquery.fancybox.js', array('jquery'));

        /**
         * Styles
         */
        wp_enqueue_style('style', $assets . '/styles/output/style.css');
        wp_enqueue_style('fancybox', $assets . '/scripts/lib/fancybox/jquery.fancybox.css');

        /**
         * jQuery from Google's CDN
         */
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
    }
}

new Enqueue;
