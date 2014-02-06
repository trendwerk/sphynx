<?php
/**
 * A class for interpreting the WordPress Custom Menu in a way that 
 * it can be used in submenu's, breadcrumbs and highlighting the
 * right current menu item.
 *
 * @package TrendPress
 */
 
class TP_Nav {
	/**
	 * The entire custom menu.
	 *
	 * @var string
	 */
	private $menu;
	
	/**
	 * All the menu items from the custom menu
	 *
	 * @var array
	 */
	private $menu_items;
	
	/**
	 * The current item ID in the menu
	 *
	 * @var int
	 */
	public $current_item;
	
	/**
	 * Defines if the current item / page is a single page
	 *
	 * @var bool
	 */
	public $is_single;

	/**
	 * Defines if the current item is a post type
	 * @var bool
	 */
	public $is_post_type;
	
	/**
	 * Constructor
	 *
	 * @param string $menu Name of the custom menu that has to be used.
	 */
	function __construct( $menu='mainnav' ) {
		if( $menu ) {
			$nav_menu_locations = get_theme_mod( 'nav_menu_locations' );
			if( is_array( $nav_menu_locations ) ) {
				if( $nav_menu_locations[ $menu ] ) {
					$navmenu_term = get_term( $nav_menu_locations[ $menu ], 'nav_menu' );

					if( $navmenu_term )
						$menu = $navmenu_term->slug;
				}
			}
		}
		
		$this->menu = $menu;
		$this->menu_items = wp_get_nav_menu_items( $this->menu );

		//Defaults
		$this->is_post_type = false;
		$this->is_single = false;

		if( is_array( $this->menu_items ) )
			$this->set_current_item();
	}
	
	/**
	 * Retrieves the current menu items (with the right classes) as 
	 * submenu items for a widget (hierarchical)
	 *
	 * @return array Submenu items
	 */
	function get_submenu_items() {
		$top_item = $this->get_top_parent( $this->current_item );
		
		if( isset( $top_item ) ) {
			//Base the submenu on the top parent
			$submenu = new stdClass;
			$submenu->ID = $top_item->ID;
			$submenu->title = $top_item->title;
			$submenu->url = $top_item->url;
		
			$submenu->children = $this->get_children( $top_item->ID );
			
			return $submenu;
		}
		
		return '';
	}
	
	/**
	 * Retrieves the current menu items (with the right classes) as 
	 * breadcrumb items. This means only showing the current and parent items.
	 *
	 * @return array Breadcrumb items
	 */
	function get_breadcrumb_items() {
		//Grab the breadcrumb items based on the current menu item
		$breadcrumbs = $this->get_breadcrumb_parents( $this->current_item );
		
		//Reverse the breadcrumbs
		if( $breadcrumbs ) {
			array_reverse( $breadcrumbs );
		} else if( get_query_var( 's' ) ) {
			//Search page exception
			$breadcrumb = new stdClass;
			$breadcrumb->title = __( 'Search for', 'tp' ) . ' &quot;' . get_search_query() . '&quot;';
			$breadcrumb->url = get_option( 'siteurl' ) . '/?s=' . get_query_var( 's' );
			
			$breadcrumb->is_current = true;
			
			$breadcrumbs = array( $breadcrumb );
		} else if( is_404() ) {
			//404
			$breadcrumb = new stdClass;
			$breadcrumb->title = __( '404', 'tp' );
			$breadcrumb->is_current = true;
			
			$breadcrumbs = array( $breadcrumb );
		} else if( $this->is_post_type && 1 >= count( $breadcrumbs ) ) {
			$post_type = get_post_type_object( get_query_var( 'post_type' ) );

			$breadcrumb = new stdClass;
			$breadcrumb->title = $post_type->labels->name;
			$breadcrumb->url = get_post_type_archive_link( $post_type->name );

			if( is_post_type_archive( $post_type->name ) )
				$breadcrumb->is_current = true;

			$breadcrumbs = array( $breadcrumb );

			if( $this->is_single ) {
				global $post;
				
				$breadcrumb = new stdClass;
				$breadcrumb->ID = $post->ID;
				$breadcrumb->title = $post->post_title;
				$breadcrumb->url = get_permalink( $post->ID );
				
				$breadcrumb->is_current = true;
				
				$breadcrumbs[] = $breadcrumb;
			}
		} else if( ! is_tax() ) {
			//There are no breadcrumbs, show Home > {Current item}
			global $post;
			
			$breadcrumb = new stdClass;
			$breadcrumb->ID = $post->ID;
			$breadcrumb->title = $post->post_title;
			$breadcrumb->url = get_permalink( $post->ID );
			
			$breadcrumb->is_current = true;
			
			$breadcrumbs = array( $breadcrumb );
		}
		
		if( is_tax() ) {
			$taxonomy = get_taxonomy( get_query_var( 'taxonomy' ) );
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			
			if( count( $taxonomy->object_type ) > 1 ) {
				//Multiple post types for a taxonomy, add the taxonomy name as well
				$breadcrumb = new stdClass;
				$breadcrumb->title = $taxonomy->labels->name;
				$breadcrumb->is_current = true;
				
				$breadcrumbs[] = $breadcrumb;
			}
			
			$breadcrumb = new stdClass;
			$breadcrumb->title = $term->name;
			$breadcrumb->is_current = true;
			
			$breadcrumbs[] = $breadcrumb;
		} 
					
		return $breadcrumbs;
	}
	
	/**
	 * Retrieves parents of a menu item, meant
	 * for breadcrumb purposes.
	 *
	 * @return array Breadcrumb parents
	 */
	function get_breadcrumb_parents( $id ) {
		if( $this->menu_items ) {
			foreach( $this->menu_items as $menu_item ) {
				if( $menu_item->ID == $id ) {
					$parent = new stdClass;
					$parent->ID = $menu_item->ID;
					$parent->title = $menu_item->title;
					$parent->url = $menu_item->url;
					$parent->is_current = false;
					
					if( $this->is_current( $menu_item ) && ! $this->is_single && ! is_category() && ! get_query_var( 'taxonomy' ) )
						$parent->is_current = true;
					
					$parents[] = $parent;
					
					if( $menu_item->menu_item_parent )
						$parents = array_merge( $this->get_breadcrumb_parents( $menu_item->menu_item_parent ), $parents );
					
					return $parents;
				}
			}
		}
	}
	
	/**
	 * Retrieves children of a menu item
	 *
	 * @return array Children
	 */
	function get_children( $id ) {
		$children = array();
		foreach( $this->menu_items as $menu_item ) {
			$child = ''; //Reset the child, apparently has to be done
			if( $menu_item->menu_item_parent == $id ) {
				$child = new stdClass;
				$child->ID = $menu_item->ID;
				$child->title = $menu_item->title;
				$child->url = $menu_item->url;
				$child->is_current = false;
				$child->is_parent = false;
				
				$child->children = $this->get_children( $menu_item->ID );
				
				if( $this->is_current_parent( $child ) )
					$child->is_parent = true;
				elseif( $this->is_current( $child ) )
					$child->is_current = true;
				
				array_push( $children, $child );
			}
		}
		
		return $children;
	}
	
	/**
	 * Checks if an item is the parent of the current item
	 *
	 * @return bool
	 */
	function is_current_parent( $item ) {
		foreach( $this->menu_items as $menu_item ) {
			if( $menu_item->ID == $this->current_item ) {
				//We're in the current item
				if( $menu_item->menu_item_parent == $item->ID ) {
					return true;
				} else {
					//This item is not the parent, maybe one of it's children is?
					foreach( $item->children as $child ) {
						if( $this->is_current_parent( $child ) )
							return true;
					}
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Checks if an item is the current item
	 *
	 * @return bool
	 */
	function is_current( $item ) {
		if( $item->ID == $this->current_item )
			return true;
		
		return false;
	}
	
	/**
	 * Checks if the current item is a single page
	 *
	 * @return bool
	 */
	function is_single() {
		return $is_single;
	}
	
	/**
	 * Sets the current item based on the current URL and
	 * the custom menu
	 *
	 * @return null
	 */
	function set_current_item() {
		global $post;
		if( is_page() ) {
			//Single page, base the current item on the custom menu
			$this->current_item = $this->get_nav_id_by_page_id( $post->ID );
		} else if( get_query_var( 'author' ) ) {
			//Author page, use blog page
			$this->current_item = $this->get_nav_id_by_page_title( __( 'Blog', 'tp' ) );
			$this->is_single = true;
		} else if( get_query_var( 's' ) ) {
			//Search page
			
		} else if( is_404() ) {
			//404
			
		} else {
			if( ! get_query_var( 'post_type' ) && ! is_tax() ) {
				//Blog or single blog item
				$this->current_item = $this->get_nav_id_by_page_id( get_option( 'page_for_posts' ) );
			} else {
				if( $taxonomy = get_query_var( 'taxonomy' ) ) {
					$taxonomy = get_taxonomy( $taxonomy );
					
					if( 1 < count( $taxonomy->object_type ) ) {
						//Multiple post types to a taxonomy. Show Home > [Taxonomy name] > [Term name]
					} else {
						//One post type to a taxonomy. Show Home > [Post type] > [Term name]
						//set_query_var('post_type',$taxonomy->object_type[0]);
					}
				}
				
				//Custom post type
				if( ! is_array( get_query_var( 'post_type' ) ) ) 
					$posttype = get_post_type_object( get_query_var( 'post_type' ) );

				if( $posttype ) {
					$this->is_post_type = true;

					foreach( $this->menu_items as $menu_item ) {
						if( $menu_item->url == get_post_type_archive_link( $posttype->name ) ) {
							$this->current_item = $menu_item->ID;
							break;
						}
					}
				}
			}
			
			if( is_single() )
				$this->is_single = true;
		}
	}
	
	/**
	 * Retrieve the navigation ID (the item in the custom menu), based
	 * on a page ID.
	 *
	 * @return int 
	 */
	function get_nav_id_by_page_id( $postid ) {
		if( $this->menu_items ) {
			foreach( $this->menu_items as $menu_item ) {
				if( $menu_item->object_id == $postid )
					return $menu_item->ID;
			}
		}
	}
	
	/**
	 * Retrieve the navigation ID, based on a page title
	 *
	 * @return bool
	 */
	function get_nav_id_by_page_title( $title ) {
		if( $this->menu_items ) {
			foreach( $this->menu_items as $menu_item ) {
				if( $menu_item->title == $title )
					return $menu_item->ID;
			}
		}
	}
	
	/**
	 * Get the top parent, based on a navigation ID
	 *
	 * @return object The top menu item
	 */
	function get_top_parent( $id ) {
		if( $this->menu_items ) {
			foreach( $this->menu_items as $menu_item ) {
				if( $menu_item->ID == $id ) {
					if( 0 == $menu_item->menu_item_parent )
						return $menu_item;
					else
						return $this->get_top_parent( $menu_item->menu_item_parent );
				}
			}
		}
	}
}
