<?php
/**
 * Highlight search results in titles, excerpts and content
 */

/**
 * Highlight search results in titles
 *
 * @param string $title
 */
function tp_search_title_highlight($title) {
	if($query = get_search_query()) {
	    $keys = implode('|', array_filter(explode(' ', $query)));
	    $title = preg_replace('/(' . $keys .')/iu', '<span class="search-highlight">\0</span>',$title);
    }

    return $title;
}
if(!is_admin()) add_filter('the_title','tp_search_title_highlight');

/**
 * Highlight search results in excerpts
 *
 * @param string $excerpt
 */
function tp_search_excerpt_highlight($excerpt) {
	if($query = get_search_query()) {
	    $keys = implode('|', array_filter(explode(' ', $query)));
	    $excerpt = preg_replace('/(' . $keys .')/iu', '<span class="search-highlight">\0</span>',$excerpt);
	}
	
    return $excerpt;
}
if(!is_admin()) add_filter('the_excerpt','tp_search_excerpt_highlight');

/**
 * Highlight search results in the content
 *
 * @param string $content
 */
function tp_search_content_highlight($content) {
	if($query = get_search_query()) {
	    $keys = implode('|', array_filter(explode(' ', $query)));
	    $content = preg_replace('/(' . $keys .')/iu', '<span class="search-highlight">\0</span>',$content);
	}
	
    return $content;
}
if(!is_admin()) add_filter('the_content','tp_search_content_highlight');
?>