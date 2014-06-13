<?php
/**
 * This is the core of TrendPress
 *
 * @package TrendPress
 */

/**
 * Include PHP files in /assets/inc/
 * Include PHP files in trendpress-child/assets/inc/
 */

include_once( 'assets/inc/class-tp-includer.php' );

new TP_Includer( dirname( __FILE__ ) . '/assets/inc/' );
new TP_Includer( get_stylesheet_directory() . '/assets/inc/' );

/**
 * Load the textdomain 'tp'
 */
load_theme_textdomain( 'tp', get_template_directory() . '/assets/lang' );
