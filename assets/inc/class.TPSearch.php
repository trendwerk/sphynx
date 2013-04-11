<?php
/**
 * Adjustments to the search functionalities
 */

class TPSearch {
	function __construct() {
		if(!is_admin()) :
			add_filter('the_excerpt',array($this,'highlight_excerpt'));
			add_filter('the_content',array($this,'highlight_content'));
		endif;
	}
	
	/**
	 * Highlight search results in excerpts
	 *
	 * @param string $excerpt
	 */
	function highlight_excerpt($excerpt) {
		if($query = get_search_query()) {
		    $keys = implode('|', array_filter(explode(' ', $query)));
		    $excerpt = preg_replace('/(' . $keys .')/iu', '<span class="search-highlight">\0</span>',$excerpt);
		}
		
	    return $excerpt;
	}
	
	/**
	 * Highlight search results in the content
	 *
	 * @param string $content
	 */
	function highlight_content($content) {
		if($query = get_search_query()) {
		    $keys = implode('|', array_filter(explode(' ', $query)));
		    $content = preg_replace('/(' . $keys .')/iu', '<span class="search-highlight">\0</span>',$content);
		}
		
	    return $content;
	}
} new TPSearch;
?>