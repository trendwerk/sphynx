<?php
/**
 * Contains helpers and template tags. No hooks!
 *
 * @package TrendPress
 */

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

	if( 0 < strlen( $pagination ) )
		echo '<nav id="pager">' . $pagination . '</nav>';
}

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
