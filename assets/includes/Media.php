<?php
/**
 * Everything that has to do with media
 */

namespace Trendwerk\TrendPress;

final class Media
{
    public function __construct()
    {
        add_action('after_switch_theme', array($this, 'defaults'));
        add_filter('embed_oembed_html', array($this, 'videoEmbed'));
    }

    /**
     * Set default image sizes
     */
    public function defaults()
    {
        update_option('thumbnail_size_w', 150);
        update_option('thumbnail_size_h', 150);

        update_option('medium_size_w', 340);
        update_option('medium_size_h', '');

        update_option('large_size_w', 720);
        update_option('large_size_h', '');
        
        update_option('image_default_link_type', 'file');
    }

    /**
     * Responsive video container
     */
    public function videoEmbed($html)
    {
        return '<div class="video-container">' . $html . '</div>';
    }
}
