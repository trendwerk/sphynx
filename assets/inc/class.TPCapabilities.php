<?php
/**
 * A class that edits some user capabilities. Editors can
 * edit theme options and anyone but admins are refrained
 * from editing/creating/removing admins.
 */

class TPCapabilities {
	function __construct() {
		//Editors can edit theme options
		add_action('init',array($this,'set_editor_capabilities'));
		
		//Anyone lower than admin can't remove, edit or promote (to) admins
		add_filter('editable_roles',array($this,'set_notadmin_promotions'));
		add_filter('map_meta_cap',array($this,'set_notadmin_capabilities'),10,4);
	}
	
	/**
	 * Set some of the editors capabilities
	 */
	function set_editor_capabilities() {
		$role_object = get_role('editor');
		
		$role_object->add_cap('list_users');
		$role_object->add_cap('remove_users');
		$role_object->add_cap('add_users');
		$role_object->add_cap('promote_users');
		$role_object->add_cap('create_users');
		$role_object->add_cap('delete_users');
		$role_object->add_cap('edit_users');
		
		$role_object->add_cap('edit_theme_options');
		$role_object->remove_cap('switch_themes');
	}

	/**
	 * Remove 'administrator' from the promote/create users for non-admins
	 */
	function set_notadmin_promotions($roles){
		if(isset($roles['administrator']) && !current_user_can('administrator')) {
			unset( $roles['administrator']);
		}
		return $roles;
	}
	
  	/**
  	 * Refrain non-admins from editing/promoting/deleting administrators
  	 */
	function set_notadmin_capabilities($caps,$cap,$user_id,$args) {
		if($cap == 'promote_user') {
			if(isset($args[0]) && $args[0] == $user_id) return $caps;
			if(!isset($args[0])) $caps[] = 'do_not_allow';
			
			$other = new WP_User(absint($args[0]));
			if($other->has_cap('administrator')){
				if(!current_user_can('administrator')) {
					$caps[] = 'do_not_allow';
				}
			}
		} else if($cap == 'delete_users' || $cap == 'edit_user') {
			if(!isset($args[0])) return;
			if(isset($args[0]) && $args[0] == $user_id) return $caps;
			
			$other = new WP_User(absint($args[0]));
			if($other->has_cap('administrator')){
				if(!current_user_can('administrator')) {
					$caps[] = 'do_not_allow';
				}
			}
		}
		
		return $caps;
	}
}

new TPCapabilities;
?>