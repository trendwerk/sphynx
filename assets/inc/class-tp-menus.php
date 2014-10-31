<?php 
/**
 * Menu's
 *
 * @package TrendPress
 */

class TP_Menus {
	function __construct() {
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register menu's
	 */
	function register() {
		register_nav_menu( 'mainnav', __( 'Main navigation', 'tp' ) );
		register_nav_menu( 'topnav', __( 'Top navigation', 'tp' ) );
		register_nav_menu( 'footernav', __( 'Footer navigation', 'tp' ) );
		register_nav_menu( 'sitemap', __( 'Sitemap', 'tp' ) );
	}
} new TP_Menus;
