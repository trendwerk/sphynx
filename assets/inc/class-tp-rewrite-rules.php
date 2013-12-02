<?php
/**
 * TrendPress rewrite rules
 *
 * @package TrendPress
 */
class TP_Rewrite_Rules {
	function __construct() {
		add_filter( 'mod_rewrite_rules', array( $this, 'replace_404_images' ) );
	}

	/**
	 * Redirect images from uploads to placehold.it on develop and release environments if they don't exist
	 * 
	 * @param  string $rules WordPress' own rules
	 * @return string        New rules
	 */
	function replace_404_images( $rules ) {
		if( 'develop' == TP_ENV || 'release' == TP_ENV ) {

			$tp_images_rules = array(
				'#BEGIN TrendPress placeholder images',
				'RewriteCond %{REQUEST_FILENAME} !-f',
				'RewriteRule ^wp-content/uploads/(.*)-([0-9]+)x([0-9]+).(gif|jpe?g|png|bmp)$ http://placehold.it/$2x$3 [NC,L]',
				'RewriteCond %{REQUEST_FILENAME} !-f',
				'RewriteRule ^wp-content/uploads/(.*)(gif|jpe?g|png|bmp)$ http://placehold.it/600x600 [NC,L]',
				'#END TrendPress placeholder images',
				'',
			);

			$rules = explode( "\n", $rules );
			$rules = wp_parse_args( $rules, $tp_images_rules );
			$rules = implode( "\n", $rules );
		}

		return $addition . $rules;
	}
} new TP_Rewrite_Rules;
