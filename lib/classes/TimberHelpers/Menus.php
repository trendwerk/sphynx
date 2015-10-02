<?php
/**
 * Menu's
 */

namespace Trendwerk\TrendPress\TimberHelpers;

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
            'main'   => new \TimberMenu('main'),
            'footer' => new \TimberMenu('footer'),
        );

        return $context;
    }
}
