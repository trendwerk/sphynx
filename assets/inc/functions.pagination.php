<?php
/**
 * Better pagination for archive pages
 */

/**
 * Call this function to show the pagination
 *
 * @param array $args Additional arguments
 */
function tp_pagination($args = null) {
	$defaults = array(
		'page' => null, 'pages' => null, 
		'range' => 3, 'gap' => 3, 'anchor' => 1,
		'before' => '', 'after' => '',
		'title' => __('Pagination','tp'),
		'nextpage' => __('Next','tp'), 
		'previouspage' => __('Previous','tp'),
		'echo' => 1
	);

	$r = wp_parse_args($args, $defaults);
	extract($r, EXTR_SKIP);

	if (!$page && !$pages) {
		global $wp_query;

		$page = get_query_var('paged');
		$page = !empty($page) ? intval($page) : 1;

		$posts_per_page = intval(get_query_var('posts_per_page'));
		$pages = intval(ceil($wp_query->found_posts / $posts_per_page));
	}
	
	if ($pages > 1) {
		$output = '<nav id="pagination" itemscope itemtype="http://schema.org/SiteNavigationElement/"><ul>';
		
		$ellipsis = "<li class='gap'>&hellip;</li>";

		if ($page > 1 && !empty($previouspage)) {
			$output .= "<li><a href='" . get_pagenum_link($page - 1) . "' class='prev'>$previouspage</a></li>";
		}
		
		$min_links = $range * 2 + 1;
		$block_min = min($page - $range, $pages - $min_links);
		$block_high = max($page + $range, $min_links);
		$left_gap = (($block_min - $anchor - $gap) > 0) ? true : false;
		$right_gap = (($block_high + $anchor + $gap) < $pages) ? true : false;

		if ($left_gap && !$right_gap) {
			$output .= sprintf('%s%s%s', 
				tp_pagination_loop(1, $anchor), 
				$ellipsis, 
				tp_pagination_loop($block_min, $pages, $page)
			);
		}
		else if ($left_gap && $right_gap) {
			$output .= sprintf('%s%s%s%s%s', 
				tp_pagination_loop(1, $anchor), 
				$ellipsis, 
				tp_pagination_loop($block_min, $block_high, $page), 
				$ellipsis, 
				tp_pagination_loop(($pages - $anchor + 1), $pages)
			);
		}
		else if ($right_gap && !$left_gap) {
			$output .= sprintf('%s%s%s', 
				tp_pagination_loop(1, $block_high, $page),
				$ellipsis,
				tp_pagination_loop(($pages - $anchor + 1), $pages)
			);
		}
		else {
			$output .= tp_pagination_loop(1, $pages, $page);
		}

		if ($page < $pages && !empty($nextpage)) {
			$output .= "<li><a href='" . get_pagenum_link($page + 1) . "' class='next'>$nextpage</a></li>";
		}

		$output .= '</ul></nav>';
	}

	if ($echo) {
		echo isset($output) ? $output : '';
	}

	return isset($output) ? $output : '';
}

/**
 * Returns all page numbers
 *
 * @param int $start Page number start
 * @param int $max Page number amount
 * @param int $page Current page
 */
function tp_pagination_loop($start, $max, $page = 0) {
	$output = "";
	for ($i = $start; $i <= $max; $i++) {
		$output .= ($page === intval($i)) 
			? "<li><span class='page current'>$i</span></li>" 
			: "<li><a href='" . get_pagenum_link($i) . "' class='page'>$i</a></li>";
	}
	return $output;
}
?>