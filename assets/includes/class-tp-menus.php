<?php 
/**
 * Menu's
 *
 * @package TrendPress
 */

class TP_Menus {
	function __construct() {
		add_action( 'init', array( $this, 'register' ) );
		add_filter( 'timber_context', array( $this, 'timber' ) );
	}

	/**
	 * Register menu's
	 */
	function register() {
		register_nav_menu( 'main', __( 'Main navigation', 'tp' ) );
		register_nav_menu( 'footer', __( 'Footer', 'tp' ) );
		register_nav_menu( 'sitemap', __( 'Sitemap', 'tp' ) );
	}

	/**
	 * Make global menu's available to Timber
	 */
	function timber( $context ) {
		$context['menus'] = array(
			'main'               => wp_nav_menu( array(
				'theme_location' => 'main',
				'depth'          => 2,
				'echo'           => false,
			) ),
			'footer'             => wp_nav_menu( array(
				'depth'          => 1,
				'fallback_cb'    => null,
				'theme_location' => 'footer',
				'echo'           => false,
			) ),
		);

		return $context;
	}
} new TP_Menus;
