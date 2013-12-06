<?php
/**
 * Adds meta to taxonomy terms
 *
 * @package TrendPress
 * @subpackage Term_Taxonomy_Meta
 */

class TP_Term_Taxonomy_Meta {
	var $table = 'term_taxonomymeta';

	function __construct() {
		add_action( 'init', array( $this, 'init' ), 11 );
	}

	/**
	 * Register taxonomy_termmeta table
	 */
	function init() {
		if( current_theme_supports( 'term-taxonomy-meta' ) ) {
			$this->maybe_create_table();

			global $wpdb;
			$wpdb->term_taxonomymeta = $wpdb->prefix . $this->table;
		}
	}

	/**
	 * Maybe create the table if it doesn't yet exists
	 */
	function maybe_create_table() {
		global $wpdb;

		$table_name = $wpdb->prefix . $this->table;

		if( ! empty( $wpdb->charset ) )
			$charset_collate = "DEFAULT CHARACTER SET " . $wpdb->charset;

	    if( ! empty( $wpdb->collate ) )
	        $charset_collate .= " COLLATE " . $wpdb->collate;
		             
		$sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
	        meta_id bigint(20) NOT NULL AUTO_INCREMENT,
	        term_taxonomy_id bigint(20) NOT NULL default 0,
	     
	        meta_key varchar(255) DEFAULT NULL,
	        meta_value longtext DEFAULT NULL,
	                 
	        UNIQUE KEY meta_id (meta_id)
	    ) " . $charset_collate . ";";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
} new TP_Term_Taxonomy_Meta;

/**
 * Extendable class for term meta. Do not call this class directly
 *
 * @package TrendPress
 * @subpackage Term_Taxonomy_Meta
 */

class TP_Term_Meta {
	function __construct( $taxonomy ) {
		$this->taxonomy = $taxonomy;

		//Make sure taxonomy term meta is allowed
		if( ! current_theme_supports( 'term-taxonomy-meta' ) )
			add_theme_support( 'term-taxonomy-meta' );

		//Abstract
		add_action( $this->taxonomy . '_edit_form_fields', array( $this, 'display' ), 11 );
		add_action( 'edit_'. $this->taxonomy, array( $this, 'save' ), 10, 2 );

		//
		add_action( 'edited_'. $this->taxonomy, array( $this, 'redirect' ) );
	}

	/**
	 * Display meta box
	 * 
	 * @param object $term
	 */
	function display( $term ) {}

	/**
	 * Save taxonomy term meta
	 * 
	 * @param int $term_id
	 * @param int $tt_id
	 */
	function save( $term_id, $tt_id ) {}

	/**
	 * Redirect to the right URL
	 *
	 * @param  int $term_id  
	 */
	function redirect( $term_id ) {
		wp_redirect( get_edit_term_link( $term_id, $this->taxonomy ) );
		die();
	}
}

/**
 * API: Some functions for taxonomy term meta
 *
 * @package TrendPress
 * @subpackage Term_Taxonomy_Meta
 */

/**
 * Add term taxonomy meta
 *
 * @see add_metadata
 */
function add_term_meta( $object_id, $meta_key, $meta_value, $unique = false ) {
	return add_metadata( 'term_taxonomy', $object_id, $meta_key, $meta_value, $unique );
}

/**
 * Update term taxonomy meta
 *
 * @see update_metadata
 */
function update_term_meta( $object_id, $meta_key, $meta_value, $prev_value = '' ) {
	return update_metadata( 'term_taxonomy', $object_id, $meta_key, $meta_value, $prev_value );
}

/**
 * Get term taxonomy meta
 *
 * @see get_metadata
 */
function get_term_meta( $object_id, $meta_key, $single = false ) {
	return get_metadata( 'term_taxonomy', $object_id, $meta_key, $single );
}

/**
 * Delete term taxonomy meta
 *
 * @see delete_metadata
 */
function delete_term_meta( $object_id, $meta_key, $meta_value, $delete_all = false ) {
	return delete_metadata( 'term_taxonomy', $object_id, $meta_key, $meta_value, $delete_all );
}