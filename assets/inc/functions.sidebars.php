<?php 
/**
 * Register a sidebar
 *
 * @param string $id Unique sidebar ID
 * @param array $args
 */
 
function tp_register_sidebar($id,$args) {
	if(function_exists('register_sidebar')) {
		$default = array(
			'before_widget' => '<div class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widgettitle">',
			'after_title' => '</h3>'
		);
		
		$args['id'] = $id;
		
		register_sidebar(wp_parse_args($args,$default));
	}
}
?>