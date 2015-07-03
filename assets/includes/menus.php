<?php
/**
 * Menu's
 */

namespace Trendwerk\TrendPress;

final class Menus
{
    public function __construct()
    {
        add_action('init', array($this, 'register'));
        add_filter('timber_context', array($this, 'timber'));
    }

    /**
     * Register menu's
     */
    public function register()
    {
        register_nav_menu('main', __('Main navigation', 'tp'));
        register_nav_menu('footer', __('Footer', 'tp'));
        register_nav_menu('sitemap', __('Sitemap', 'tp'));
    }

    /**
     * Make global menu's available to Timber
     */
    public function timber($context)
    {
        $context['menus'] = array(
            'main'               => wp_nav_menu(array(
                'theme_location' => 'main',
                'depth'          => 2,
                'echo'           => false,
            )),
            'footer'             => wp_nav_menu(array(
                'depth'          => 1,
                'fallback_cb'    => null,
                'theme_location' => 'footer',
                'echo'           => false,
            )),
        );

        return $context;
    }
}

new Menus;
