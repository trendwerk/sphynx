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
    }

    /**
     * Register menu's
     */
    public function register()
    {
        register_nav_menu('main', __('Main navigation', 'tp'));
        register_nav_menu('footer', __('Footer', 'tp'));
    }
}
