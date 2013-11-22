<?php
/**
 * Additions to CPT's:
 *
 * Adds a meta box to Custom Menu's, so you can add post type archives easily.
 * Sets up the right menu item to an active state.
 */

class TPCPTExtras {
	function __construct() {
		//Nav menu meta box for CPT Archives
		add_action('admin_enqueue_scripts',array($this,'add_scripts'));
		add_action('admin_init',array($this,'add_meta_boxes'));
		
		//Nav menu higlighting
		add_filter('wp_nav_menu_objects',array($this,'highlight'));
	}
	
	/**
	 * Add scripts
	 */
	function add_scripts() { 
		wp_enqueue_script('tp-cpt-meta',get_template_directory_uri().'/assets/js/TPCPTMeta/TPCPTMeta.js',array('jquery'));
	}
	
	/**
	 * Add a meta box to the Custom Menu page
	 */
	function add_meta_boxes() {
		add_meta_box('custom-post-types',__('Archive pages','tp'),array($this,'nav_menu_meta'),'nav-menus','side','high');
	}
	
	/**
	 * Inside HTML of the meta box
	 */
	function nav_menu_meta() {
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
							$url = get_post_type_archive_link($cpt);
							
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
	function highlight($items) {
		if($items) {
			foreach( $items as $item ) {
				if( in_array( 'current-menu-item', $item->classes ) )
					return $items;
			}
			
			$nav = new TPNav();
			
			if(is_single() || is_tax()) { 
				foreach($items as &$item) {
					if($nav->current_item == $item->ID) {
						$item->classes[] = 'current-menu-parent';
					}
				}
			}
		}
		
		return $items;
	}
} new TPCPTExtras;
?>