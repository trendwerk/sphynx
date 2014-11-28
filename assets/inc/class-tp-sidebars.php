<?php
/**
 * Sidebars
 *
 * @package TrendPress
 */

class TP_Sidebars {
	static $defaults = array(
		'before_widget' => '<div class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widgettitle">',
		'after_title'   => '</h5>',
	);

	function __construct() {
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register sidebars
	 */
	function register() {
		self::add( 'home', array(
			'name' => __( 'Home', 'tp' ),
		) );

		self::add( 'page', array(
			'name' => __( 'Page', 'tp' ),
		) );

		self::add( 'blog', array(
			'name' => __( 'Blog', 'tp' ),
		) );

		self::add( 'footer', array(
			'name' => __( 'Footer', 'tp' ),
		) );
	}

	/**
	 * Add a sidebar
	 *
	 * @param string $id Unique sidebar ID
	 * @param array $args
	 *
	 * @abstract
	 */
	static function add( $id, $args = array() ) {
		$args['id'] = $id;

		register_sidebar( wp_parse_args( $args, self::$defaults ) );
	}
} new TP_Sidebars;
