<?php
/**
 * Extra widget functionality
 *
 * @package TrendPress
 */

/**
 * Allows users to create widgets in seperate files in 'trendpress-child/assets/inc/widgets/filename.php'
 */
class TP_Widgets {
	function __construct() {
		$this->activate();
	}

	/**
	 * Activate widgets
	 */
	function activate() {
		$folder = STYLESHEETPATH . '/assets/inc/widgets/';

		if( is_dir( $folder ) ) {
			foreach( scandir( $folder ) as $widget ) {
				if( '.' == substr( $widget, 0, 1 ) ) continue;
				if( substr( $widget, -4 ) != '.php' ) continue;

				$widget = $folder . $widget;

				if( is_readable( $widget ) )
					include_once( $widget );
			}
		}
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

	$default = array(
		'before_widget' => '<div class="widget ' . $widget->widget_options['classname'] . '">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>',
	);
	$args = wp_parse_args( $args, $default );

	$widget->widget( $args, $instance );
}
