<?php
/**
 * Mail adjustments
 */

class TP_Mail {
	function __construct() {
		if( ! defined( 'TP_ENV' ) || 'develop' == TP_ENV || 'release' == TP_ENV )
			add_filter( 'wp_mail', array( $this, 'send_to' ) );
	}

	/**
	 * Don't send e-mails in develop and release environments
	 */
	function send_to( $mail ) {
		$mail['subject'] .= ' [' . $mail['to'] . ']';

		if( 'release' == TP_ENV )
			$mail['to'] = get_option( 'admin_email' );
		else if( defined( 'TP_DEV_MAIL' ) )
			$mail['to'] = TP_DEV_MAIL;
		else
			$mail['to'] = '';

		return $mail;
	}
} new TP_Mail;
