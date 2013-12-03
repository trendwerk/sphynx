<?php 
/**
 * Register a sidebar
 *
 * @package TrendPress
 *
 * @param string $id Unique sidebar ID
 * @param array $args
 */

class TP_Sidebar {
	function __construct( $id, $args ) {
		$default = array(
			'before_widget' => '<div class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widgettitle">',
			'after_title'   => '</h3>',
		);
		
		$args['id'] = $id;
		
		register_sidebar( wp_parse_args( $args, $default ) );
	}
}