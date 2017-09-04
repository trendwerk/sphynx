<?php
namespace Trendwerk\Sphynx;

final class Assets
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'frontend']);
    }

    public function frontend()
    {
        $assetsPath = get_stylesheet_directory() . '/assets';
        $assetsUri = get_stylesheet_directory_uri() . '/assets';

        /**
         * Style
         */
        $stylePath = '/styles/dist/main.css';
        $styleModTime = filemtime($assetsPath . $stylePath);
        wp_enqueue_style('fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,400italic,600');
        wp_enqueue_style('main', $assetsUri . $stylePath, null, $styleModTime);

        /**
         * Script
         */
        $scriptPath = '/scripts/dist/all.js';
        $scriptModTime = filemtime($assetsPath . $scriptPath);
        wp_enqueue_script('main', $assetsUri . $scriptPath, null, $scriptModTime, true);
    }
}
