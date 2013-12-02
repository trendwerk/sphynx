<?php
/**
 * Remove unnecessary inline styling and meta links.
 * This satisfies Derrik's autism.
 *
 * @package TrendPress
 */

class TP_Clean_Up {
	function __construct() {
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'start_post_rel_link' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'adjacent_posts_rel_link' );
		
		add_action( 'widget_init', array( $this, 'remove_recent_comments_style' ) );
		add_filter( 'gallery_style', array( $this, 'remove_gallery_css' ) );
		add_filter( 'the_category', array( $this, 'remove_cat_rel' ) );
	}
	
	/**
	 * Remove comments inline style
	 */
	function remove_recent_comments_style() {
	    global $wp_widget_factory;
	    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	} 
	
	/**
	 * Remove gallery inline style
	 */
	function remove_gallery_css( $css ) {
		return preg_replace( '#<style type="text/css">(.*?)</style>#s', '', $css );
	}
	
	/**
	 * Remove category rel
	 */
	function remove_cat_rel( $text ) {
		$text = str_replace( 'rel="category tag"', '', $text );
		return $text;
	}

} new TP_Clean_Up;
