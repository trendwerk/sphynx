<?php
/**
 * Menu's
 */

namespace Trendwerk\TrendPress\TimberHelpers;

use Timber\Menu;

final class Menus
{
    public function __construct()
    {
        add_filter('timber_context', array($this, 'addToContext'));
    }

    /**
     * Make menu's available to Timber
     */
    public function addToContext($context)
    {
        $context['menus'] = array(
            'main'   => new Menu('main'),
            'footer' => new Menu('footer'),
        );

        return $context;
    }
}
