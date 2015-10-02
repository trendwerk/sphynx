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
    }

    /**
     * Make global menu's available to Timber
     */
    public function timber($context)
    {
        $context['menus'] = array(
            'main'   => new \TimberMenu('main'),
            'footer' => new \TimberMenu('footer'),
        );

        return $context;
    }
}
