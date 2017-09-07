<?php
namespace Trendwerk\Sphynx;

final class Theme
{
    public function init()
    {
        $this->setSupport();
        $this->localize();
        $this->setupHooks();
    }

    private function setSupport()
    {
        add_theme_support('title-tag');
        add_theme_support('html5', ['gallery', 'caption']);
    }

    private function localize()
    {
        load_theme_textdomain('tp', get_template_directory() . '/assets/languages');
    }

    private function setupHooks()
    {
        new Admin\Editor();
        new Assets();
        new Gallery();
        new Media();
        new Menus();
        new Plugins\Timber\Context();
    }
}
