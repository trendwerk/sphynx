<?php
/**
 * Modifications to WordPress users
 *
 * @package TrendPress
 */

class TP_Users {
	function __construct() {
		add_filter( 'user_contactmethods', array( $this, 'adjust_media' ) );
	}

	/**
	 * Adjust social media fields
	 */
	function adjust_media( $media ) {
		unset( $media['aim'] );
		unset( $media['yim'] );
		unset( $media['jabber'] );

		$media['facebook']   = __( 'Facebook profile URL', 'tp' );
		$media['linkedin']   = __( 'LinkedIn profile URL', 'tp' );
		$media['googleplus'] = __( 'Google+ profile URL', 'tp' );
	    $media['twitter']    = __( 'Twitter @username', 'tp' );
		
		return $media;
	}
} new TP_Users;