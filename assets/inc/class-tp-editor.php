<?php
/**
 * Make changes to the TinyMCE editor
 */

class TP_Editor {
	function __construct() {
		add_filter( 'tiny_mce_before_init', array( $this, 'edit' ), 1 );

		add_filter( 'admin_enqueue_scripts', array( $this, 'add' ) );
		add_filter( 'admin_enqueue_scripts', array( $this, 'remove' ), 10001 );

		add_editor_style( 'assets/less/editor.compiled.css' );
	}

	/**
	 * Edit TinyMCE buttons
	 */
	function edit( $settings ) {
		$settings['toolbar1'] = 'formatselect,bold,italic,bullist,numlist,link,unlink,wp_more,wpfullscreen,wp_adv';
		$settings['toolbar2'] = 'styleselect,undo,redo,pastetext,removeformat';

		return $settings;
	}

	/**
	 * Add our editor style so it gets compiled
	 */
	function add() {
		wp_enqueue_style( 'editor', get_stylesheet_directory_uri() . '/assets/less/editor.less' );
	}

	/**
	 * Remove editor style after compilation
	 */
	function remove() {
		wp_dequeue_style( 'editor' );
	}
} new TP_Editor;
