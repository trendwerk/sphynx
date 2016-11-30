<?php
namespace Trendwerk\Sphynx;

final class Menus
{
    public function __construct()
    {
        add_action('init', array($this, 'register'));
    }

    public function register()
    {
        register_nav_menu('main', __('Main navigation', 'tp'));
        register_nav_menu('footer', __('Footer', 'tp'));
    }
}
