<?php
/**
 * Mail adjustments
 *
 * @package TrendPress
 */

class TP_Mail {
	function __construct() {
		if( ! defined( 'TP_ENV' ) || 'develop' == TP_ENV || 'release' == TP_ENV )
			add_filter( 'wp_mail', array( $this, 'send_to' ) );

		if( defined( 'TP_SMTP' ) && true === TP_SMTP )
			add_action( 'phpmailer_init', array( $this, 'smtp' ) );
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

	/**
	 * Send e-mail via SMTP
	 */
	function smtp( $mailer ) {
		if( ! is_email( TP_SMTP_FROM ) || ! defined( 'TP_SMTP_HOST' ) )
			return;

		$mailer->Mailer = 'smtp';
		$mailer->From = TP_SMTP_FROM;
		$mailer->FromName = TP_SMTP_FROM_NAME;

		$mailer->Sender = $mailer->From;
		$mailer->AddReplyTo( $mailer->From, $mailer->FromName );

		$mailer->Host = TP_SMTP_HOST;
		$mailer->SMTPSecure = TP_SMTP_SECURE;
		$mailer->Port = TP_SMTP_PORT;

		$mailer->SMTPAuth = TP_SMTP_AUTH;
		if( $mailer->SMTPAuth ) {
			$mailer->Username = TP_SMTP_USERNAME;
			$mailer->Password = TP_SMTP_PASSWORD;
		}
	}
} new TP_Mail;
