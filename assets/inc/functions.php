<?php
/**
 * Some general functions and template tags
 *
 * @package TrendPress
 */

/**
 * Debug a variable
 * 
 * @param mixed $var
 */
function dbg( $var ) {
	echo '<pre>';
	print_r( $var );
	echo '</pre>';
}

/**
 * Convert a string to an URL (Add http:// if necessary)
 *
 * @param string $url
 */
function tp_maybe_add_http( $url ) {
	if( ! $url ) 
		return;
	
	if( ! strstr( $url, 'http://' ) && ! strstr( $url, 'https://' ) )
		$url = 'http://' . $url;
	
	return $url;
}

/**
 * A function for a custom excerpt length
 *
 * @param int $length The length of the excerpt (in words)
 * @param int $more The more text in case there's more to read
 * @param int $content Custom content you may want to shorten
 */
function tp_the_excerpt( $length=55, $more='&hellip;', $content='' ) {
	$func = array();
	
	$func['more'] = create_function( '', 'return "' . $more . '";' );
	add_filter( 'excerpt_more', $func['more'] );
	
	$func['length'] = create_function( '', 'return ' . $length . ';' );
	add_filter( 'excerpt_length', $func['length'] );
	
	if( $content ) 
		$excerpt = wp_trim_words( $content, $length, $more );
	else
		$excerpt = get_the_excerpt();
	
	remove_filter( 'excerpt_more', $func['more'] );
	remove_filter( 'excerpt_length', $func['length'] );
	
	echo $excerpt;
}

/**
 * Pagination
 *
 * @param array $args Additional arguments
 */
function tp_pagination( $args = array() ) {
	global $wp_query;

	$pagination = paginate_links( wp_parse_args( $args, array(
		'base'      => str_replace( PHP_INT_MAX, '%#%', esc_url( get_pagenum_link( PHP_INT_MAX ) ) ),
		'current'   => max( 1, get_query_var( 'paged' ) ),
		'total'     => $wp_query->max_num_pages,
		'prev_text' => __( 'Previous', 'tp' ),
		'next_text' => __( 'Next', 'tp' )
	) ) );

	echo '<nav id="pager">' . $pagination . '</nav>';
}
