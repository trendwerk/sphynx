<?php
/**
 * Contains helpers and template tags.
 */

namespace Trendwerk\TrendPress;

/**
 * Pagination
 *
 * @param array $args Additional arguments
 */
function pagination($args = array())
{
    global $wp_query;

    $pagination = paginate_links(wp_parse_args($args, array(
        'base'      => str_replace(PHP_INT_MAX, '%#%', esc_url(get_pagenum_link(PHP_INT_MAX))),
        'current'   => max(1, get_query_var('paged')),
        'total'     => $wp_query->max_num_pages,
        'prev_text' => __('Previous', 'tp'),
        'next_text' => __('Next', 'tp')
    )));

    if (0 < strlen($pagination)) {
        return '<nav class="pager">' . $pagination . '</nav>';
    }
}
