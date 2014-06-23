<?php
/**
 * Make changes to the TinyMCE editor
 *
 * @package TrendPress
 */

class TP_Editor {
	function __construct() {
		add_filter( 'tiny_mce_before_init', array( $this, 'edit' ), 1 );

		add_editor_style( 'assets/sass/output/editor-style.css' );
	}

	/**
	 * Edit TinyMCE buttons
	 */
	function edit( $settings ) {
		$settings['toolbar1'] = 'formatselect,bold,italic,bullist,numlist,link,unlink,wp_more,wpfullscreen,wp_adv';
		$settings['toolbar2'] = 'styleselect,undo,redo,pastetext,removeformat';

		return $settings;
	}

} new TP_Editor;
