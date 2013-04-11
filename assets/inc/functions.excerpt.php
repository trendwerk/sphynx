<?php
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