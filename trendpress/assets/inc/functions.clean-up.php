<?php
/**
 * These functions remove unnecessary inline styling and meta links. 
 * This satisfies Derrik's autism.
 */

/**
 * Remove some meta links
 */
remove_action('wp_head','rsd_link');
remove_action('wp_head','wlwmanifest_link');
remove_action('wp_head','wp_generator');
remove_action('wp_head','start_post_rel_link');
remove_action('wp_head','index_rel_link');
remove_action('wp_head','adjacent_posts_rel_link');

/**
 * Remove comments inline style
 */
function tp_remove_recent_comments_style() {
    global $wp_widget_factory;  
    remove_action('wp_head',array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],'recent_comments_style'));
}  
add_action('widgets_init','tp_remove_recent_comments_style');

/**
 * Remove gallery inline style
 */
function tp_remove_gallery_css($css) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s",'',$css);
}
add_filter('gallery_style','tp_remove_gallery_css');

/**
 * Remove category rel
 */
function tp_remove_cat_rel($text) { 
	$text = str_replace('rel="category tag"', "", $text); return $text;
}
add_filter('the_category','tp_remove_cat_rel');

?>