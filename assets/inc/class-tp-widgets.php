<?php
/**
 * Extra widget functionality
 *
 * @package TrendPress
 */

/**
 * Automatically include files in 'trendpress-child/assets/inc/widgets/'
 */
class TP_Widgets {
	function __construct() {
		$this->activate();
	}

	/**
	 * Activate widgets
	 */
	function activate() {
		new TP_Includer( get_stylesheet_directory() . '/assets/inc/widgets/' );
	}
} new TP_Widgets;

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
