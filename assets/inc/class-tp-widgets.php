<?php
/**
 * Extra widget functionality
 *
 * @package TrendPress
 */

/**
 * Static widgets
 * 
 * @param string $class The class name of the widget
 */
function tp_static_widget( $class, $args = array(), $instance = array() ) {
	if( ! class_exists( $class ) )
		return;

	$widget = new $class;

	$defaults = array(
		'before_widget' => '<div class="widget ' . $widget->widget_options['classname'] . '">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
	);
	$args = wp_parse_args( $args, $defaults );

	$widget->widget( $args, $instance );
}
