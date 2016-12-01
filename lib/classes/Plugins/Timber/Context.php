<?php
namespace Trendwerk\Sphynx\Plugins\Timber;

use Timber\Menu;

final class Context
{
    public function __construct()
    {
        add_filter('timber_context', array($this, 'add'));
    }

    public function add($context)
    {
        $context['menus'] = array(
            'main'   => new Menu('main'),
            'footer' => new Menu('footer'),
        );

        return $context;
    }
}
