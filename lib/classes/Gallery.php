<?php
namespace Trendwerk\TrendPress;

final class Gallery
{
    public function __construct()
    {
        add_action('init', [$this, 'replace']);
    }

    public function replace()
    {
        remove_shortcode('gallery');
        add_shortcode('gallery', [$this, 'add']);
    }

    public function add()
    {
    }
}
