<?php
/**
 * Additions to Custom Post Types
 *
 * Adds a meta box to Custom Menu's, so you can add post type archives easily.
 * Sets up the right menu item to an active state.
 *
 * @package TrendPress
 */

class TP_CPT_Extras {
	function __construct() {		
		add_filter( 'wp_nav_menu_objects', array( $this, 'highlight' ) );
	}

	/**
	 * Takes care of the highlighting in a navigation menu
	 *
	 * @param array $items
	 */
	function highlight( $items ) {
		if( $items ) {
			foreach( $items as $item ) {
				if( in_array( 'current-menu-item', $item->classes ) )
					return $items;
			}
			
			$nav = new TP_Nav();
			
			if( is_single() || is_tax() || is_paged() || is_author() ) {
				foreach( $items as &$item ) {
					if( $nav->current_item == $item->ID )
						$item->classes[] = 'current-menu-parent';
				}
			}
		}
		
		return $items;
	}
} new TP_CPT_Extras;
