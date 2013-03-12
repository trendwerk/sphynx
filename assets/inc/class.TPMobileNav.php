<?php
/**
 * Adds a dropdown box with the navigation for mobile browsers
 * Should be hidden and/or shown with CSS media queries
 */
 
class TPMobileNav {
	var $nav;
	var $depth;
	
	function __construct() {
		add_filter('wp_nav_menu',array($this,'add'),10,2);
	}
	
	/**
	 * Add select box
	 */
	function add($nav_menu,$args) {
		if($args->mobile) :
			$this->nav = new TPNav($args->theme_location);
			
			$nav_menu .= '<select class="tp-mobile-nav">';
				$this->depth = 0;
				$nav_menu .= $this->add_children(0);
			$nav_menu .= '</select>';
		endif;
		
		return $nav_menu;
	}
	
	/**
	 * Add children
	 * 
	 * @param int $id
	 */
	function add_children($id) {
		$menu = '';
		
		if($items = $this->nav->get_children($id)) :
			$this->depth++;
			foreach($items as $item) :
				$menu .= $this->add_option($item);
				$menu .= $this->add_children($item->ID);
			endforeach;
			$this->depth--;
		endif;
		
		return $menu;
	}
	
	/**
	 * Add option field
	 *
	 * @param object $item Menu item
	 */ 
	function add_option($item) {
		$option = '<option class="depth-'.$this->depth.'" '.selected($item->is_current,true,false).'>';
			$option .= $item->title;
		$option .= '</option>';
		
		return $option;
	}
}
new TPMobileNav;
?>