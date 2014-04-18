<?php
/**
 * SEO
 *
 * @package TrendPress
 */

class TP_SEO {
	function __construct() {
		if( ! defined( 'TP_ENV' ) || 'release' == TP_ENV )
			update_option( 'blog_public', 0 );
	}
} new TP_SEO;
