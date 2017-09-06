<?php
namespace Trendwerk\Sphynx\Plugins\Timber;

use Timber\Menu;

final class Context
{
    public function __construct()
    {
        add_filter('timber_context', [$this, 'add']);
    }

    public function add($context)
    {
        $context['menus'] = [
            'main'   => new Menu('main'),
            'footer' => new Menu('footer'),
        ];

        return $context;
    }
}
