<?php
/**
 * Some general functions and template tags
 */

/**
 * Debug a variable
 * 
 * @param mixed $var
 */
 
function dbg($var) {
	echo '<pre>';
		print_r($var);
	echo '</pre>';
}

/**
 * Convert a string to an URL (Add http:// if necessary)
 *
 * @param string $url
 */
function tp_maybe_add_http($url) {
	if(!$url) return;
	
	if(!strstr($url,'http://') && !strstr($url,'https://')) $url = 'http://'.$url;
	
	return $url;
}

/**
 * A function for a custom excerpt length
 *
 * @param int $length The length of the excerpt (in words)
 * @param int $more The more text in case there's more to read
 * @param int $content Custom content you may want to shorten
 */
function tp_the_excerpt($length=55,$more='&hellip;',$content='') {
	if(!$content) $content = apply_filters('the_content',get_the_excerpt());
	if(!$content) $content = apply_filters('the_content',get_the_content());
	
	$excerpt = wp_trim_words($content,$length,$more);
	
	echo apply_filters('the_excerpt',$excerpt);
}
?>