<?php
/**
 * Parse LESS file(s) to CSS
 *
 * @package TrendPress
 */

include_once( 'lib/lessphp/lessc.inc.php' );

class TP_Less {
	var $force = false;
	
	function __construct() {
		if( 'develop' == TP_ENV || get_option( 'tp-less-rebuild' ) == true )
			$this->force = true;
		
		add_action( 'wp_enqueue_scripts', array( $this, 'init' ), 100000 );
		add_action( 'admin_enqueue_scripts', array( $this, 'init'), 100000 );
	}
	
	/**
	 * Initialize
	 */
	function init() {
		global $wp_styles;
		
		if( $wp_styles->registered ) {
			foreach( $wp_styles->registered as &$wp_style ) {
				if( $base = $this->is_less( $wp_style ) ) {
					$file = str_replace( site_url() . '/', ABSPATH, $wp_style->src );
					$new_file = apply_filters( 'tp-less-filename', str_replace( '.less', '.compiled.css', $file ) );
					
					$less = new lessc;
					
					do_action( 'tp-less-pre-compile', array( &$less ) );
					
					if( $this->force ) {
						$less->compileFile( $file, $new_file );
						update_option( 'tp-less-rebuild', false );
					} else {
						$less->checkedCompile( $file, $new_file );
					}
					
					$wp_style->src = str_replace( ABSPATH, site_url() . '/', $new_file );
				}
			}
		}
	}
	
	/**
	 * Check if a wp_style is a LESS file
	 *
	 * @param object $wp_style
	 */
	function is_less( $wp_style ) {
		$info = pathinfo( $wp_style->src );

		if( isset( $info['extension'] ) && 'less' == $info['extension'] )
			return true;
		
		return false;
	}
} new TP_Less;
