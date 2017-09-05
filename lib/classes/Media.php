<?php
namespace Trendwerk\Sphynx;

final class Media
{
    public function __construct()
    {
        add_action('after_switch_theme', array($this, 'defaults'));
        add_filter('embed_oembed_html', array($this, 'videoEmbed'));
    }

    public function defaults()
    {
        update_option('thumbnail_size_w', 120);
        update_option('thumbnail_size_h', 120);

        update_option('medium_size_w', 360);
        update_option('medium_size_h', '');

        update_option('medium_large_size_w', 0);
        update_option('medium_large_size_h', 0);

        update_option('large_size_w', 840);
        update_option('large_size_h', '');

        update_option('image_default_link_type', 'file');
    }

    public function videoEmbed($html)
    {
        return '<div class="video-container">' . $html . '</div>';
    }
}
