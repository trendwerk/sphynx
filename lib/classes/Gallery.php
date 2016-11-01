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

    public function add($attributes)
    {
        if (empty($attributes['ids'])) {
            return;
        }

        $context['gallery'] = array_map(function ($item) {
            return new \TimberImage($item->ID);
        }, get_posts([
            'include'        => $attributes['ids'],
            'post_mime_type' => 'image',
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'order'          => 'ASC',
            'orderby'        => 'post__in',
        ]));

        return \Timber::fetch('partials/gallery.twig', $context);
    }
}
