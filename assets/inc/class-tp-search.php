<?php
/**
 * Adjustments to the search functionalities
 *
 * @package TrendPress
 */

class TP_Search {
	function __construct() {
		if( ! is_admin() )
			add_filter( 'get_the_excerpt', array( $this, 'highlight_excerpt' ) );
	}
	
	/**
	 * Highlight search results in excerpts
	 *
	 * @param string $excerpt
	 */
	function highlight_excerpt( $excerpt ) {
		if( $query = get_search_query() ) {
		    $keys = implode( '|', array_filter( explode( ' ', $query ) ) );
		    $excerpt = preg_replace( '/(' . $keys . ')/iu', '<span class="search-highlight">\0</span>', $excerpt );
		}
		
	    return $excerpt;
	}
} new TP_Search;
