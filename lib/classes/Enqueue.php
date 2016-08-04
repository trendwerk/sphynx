<?php
namespace Trendwerk\TrendPress;

final class Enqueue
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'frontend'));
    }

    public function frontend()
    {
        $template_root = get_template_directory_uri();
        $assets = $template_root . '/assets';

        wp_enqueue_script('main', $assets . '/scripts/output/all.js', null, null, true);
        wp_enqueue_style('main', $assets . '/styles/output/main.css');
    }
}
