<?php
/**
 * Sidebars
 *
 * @package TrendPress
 */

class TP_Sidebars {
	function __construct() {
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register sidebars
	 */
	function register() {
		new TP_Sidebar( 'home', array(
			'name' => __( 'Home', 'tp' ),
		) );

		new TP_Sidebar( 'page', array(
			'name' => __( 'Page', 'tp' ),
		) );

		new TP_Sidebar( 'blog', array(
			'name' => __( 'Blog', 'tp' ),
		) );

		new TP_Sidebar( 'footerid', array(
			'name' => __( 'Footer', 'tp' ),
		) );
	}
} new TP_Sidebars;
