<?php
/**
 * This is the core of TrendPress
 *
 * @package TrendPress
 */

/**
 * Include PHP files in /assets/inc/
 */
new TP_Includer( dirname( __FILE__ ) . '/assets/inc/' );

/**
 * Load the textdomain 'tp'
 */
load_theme_textdomain( 'tp', get_template_directory() . '/assets/lang' );
