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

        /**
         * Core
         */
        wp_enqueue_script('comment-reply');

        /**
         * Scripts
         */
        wp_enqueue_script('main', $assets . '/scripts/output/all.js', null, null, true);

        /**
         * Styles
         */
        wp_enqueue_style('main', $assets . '/styles/output/main.css');
    }
}
