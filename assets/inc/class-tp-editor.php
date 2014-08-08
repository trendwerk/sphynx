<?php
/**
 * Make changes to the TinyMCE editor
 *
 * @package TrendPress
 */

class TP_Editor {
	function __construct() {
		add_filter( 'tiny_mce_before_init', array( $this, 'edit' ), 1 );
	}

	/**
	 * Edit TinyMCE buttons
	 */
	function edit( $settings ) {
		$settings['toolbar1'] = 'formatselect, bold, italic, bullist, numlist, link, unlink, wp_more, fullscreen';
		$settings['toolbar2'] = 'styleselect, undo, redo, charmap, blockquote, pastetext, removeformat';

		return $settings;
	}

} new TP_Editor;
