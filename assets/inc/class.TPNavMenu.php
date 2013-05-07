<?php
/**
 * Additions to WP Nav Menu's
 */
class TPNavMenu {
	function __construct() {
		add_filter('wp_nav_menu_objects',array($this,'indicate_submenus'));
	}
	
	/**
	 * Indicated submenu's with classes 
	 *
	 * @param array $items
	 */
	function indicate_submenus($items) {
		if($items) {			
			foreach($items as &$item) {
				if($this->has_children($item->ID)) {
					$item->classes[] = 'has-children';
				}
			}
		}
		
		return $items;
	}
	
	/**
	 * Check if a menu item has children
	 *
	 * @param int $post_id
	 */
	function has_children($post_id) {
		$children = get_posts('post_type=nav_menu_item&meta_key=_menu_item_menu_item_parent&meta_value='.$post_id);
		if(count($children) > 0) return true;
		
		return false;
	}
	
} new TPNavMenu;
?>