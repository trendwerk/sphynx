<?php
/**
 * Some functions that support custom post types. Adds a meta box
 * to Custom Menu's, so you can add post type archives easily.
 * Also sets the right menu item to an active state.
 */

/**
 * Adds the JS for the meta box
 */
function tp_cpt_nav_menu_js() { 
?>
	<script src="<?php echo get_template_directory_uri().'/assets/js/cpt/jquery.cpt-metabox.js'; ?>" type="text/javascript"></script>
<?php
}
add_action('admin_head','tp_cpt_nav_menu_js');

/**
 * Add a meta box to the Custom Menu page
 */
function tp_cpt_nav_menu_boxes() {
	add_meta_box('custom-post-types',__('Custom post types','tp'),'tp_cpt_nav_menu','nav-menus','side','low');
}
add_action('admin_init','tp_cpt_nav_menu_boxes');

/**
 * Inside HTML of the meta box
 */
function tp_cpt_nav_menu() {
	?>
	&nbsp;

	<div id="posttype-custom" class="posttypediv">
		<div class="tabs-panel tabs-panel-active">
			<ul class="categorychecklist form-no-clear">
				<?php 
				$cpts = get_post_types();
				if(count($cpts) > 5) {
					foreach($cpts as $cpt) { 
						$cpt_obj = get_post_type_object($cpt);
						
						$url = get_option('siteurl').'/'.$cpt_obj->rewrite['slug'].'/';
						
						if($cpt_obj->_builtin) continue;
						?>
						<li>
							<label class="menu-item-title">
								<input class="menu-item-checkbox" type="checkbox" name="custom-menu-item" value="<?php echo $cpt; ?>" />
								<?php echo $cpt_obj->labels->name; ?>
								
								<input type="hidden" name="<?php echo $cpt; ?>-label" value="<?php echo $cpt_obj->labels->name; ?>" />
								<input type="hidden" name="<?php echo $cpt; ?>-url" value="<?php echo $url; ?>" />
							</label>
						</li>
						<?php 
					}
				} else {
					echo '<li>'.__('There are no Custom Post Types at the moment.','tp').'</li>';
				}
				?>
			</ul>
		</div>
	</div>
	
	<p style="overflow:hidden;">
		<span class="add-to-menu">
			<img class="waiting" alt="" src="<?php echo get_option('siteurl'); ?>/wp-admin/images/wpspin_light.gif">
			<input id="submit-custom-post-type" class="button-secondary submit-add-to-menu" type="submit" value="<?php _e('Add to Menu'); ?>">
		</span>
	</p>
	<?php
}

/**
 * Takes care of the highlighting in a navigation menu
 *
 * @param array $items
 */
function highlight_cpt_items($items) {
	if($items) {
		$nav = new TPNav();
		
		if(is_single()) { 
			foreach($items as $key=>$item) {	
				if($nav->current_item == $item->ID) {
					$item->classes[] = 'current-menu-parent';
					$items[$key] = $item;
				}
			}
		}
	}
	
	return $items;
}
add_filter('wp_nav_menu_objects','highlight_cpt_items');
?>