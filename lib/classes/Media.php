<?php
namespace Trendwerk\Sphynx;

final class Media
{
    public function __construct()
    {
        add_action('after_switch_theme', [$this, 'defaults']);
        add_filter('intermediate_image_sizes_advanced', [$this, 'removeMediumLarge']);
        add_filter('embed_oembed_html', [$this, 'videoEmbed']);
    }

    public function defaults()
    {
        update_option('thumbnail_size_w', 120);
        update_option('thumbnail_size_h', 120);

        update_option('medium_size_w', 360);
        update_option('medium_size_h', '');

        update_option('large_size_w', 840);
        update_option('large_size_h', '');

        update_option('image_default_link_type', 'file');
    }

    public function removeMediumLarge($sizes)
    {
        if (isset($sizes['medium_large'])) {
            unset($sizes['medium_large']);
        }

        return $sizes;
    }

    public function videoEmbed($html)
    {
        return '<div class="video-container">' . $html . '</div>';
    }
}
