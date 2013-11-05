<?php
/**
 * 
 * Also allows static widgets
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
 */
