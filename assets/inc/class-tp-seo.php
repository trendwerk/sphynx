<?php
/**
 * SEO
 *
 * @package TrendPress
 */

class TP_SEO {
	function __construct() {
		if( ( defined( 'TP_ENV' ) && 'release' == TP_ENV ) || ( defined( 'TP_NOINDEX' ) && true === TP_NOINDEX ) )
			update_option( 'blog_public', 0 );
		else if( defined( 'TP_ENV' ) && 'master' == TP_ENV )
			update_option( 'blog_public', 1 );
	}
} new TP_SEO;
