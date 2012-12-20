<?php 
/**
 * Submenu widget
 */
 
add_action('widgets_init', create_function('','return register_widget("submenu");'));

class submenu extends WP_Widget {
	function submenu() {
		$widget_ops = array('classname' => 'submenu', 'description' => __('Shows the submenu according to the custom menu','tp'));
		$control_ops = array('width' => 250, 'height' => 350);
		$this->WP_Widget('submenu', __('Submenu','tp'), $widget_ops, $control_ops);
	}
	
	function widget($args,$instance) {		
		global $post,$wpdb;
		
		$nav = new TPNav();
		$submenu = $nav->get_submenu_items();
		
		if(isset($submenu->children)) {
			if($submenu->children) {
			?>
				<div class="widget submenu">
					<h3 class="widgettitle"><a href="<?php echo $submenu->url; ?>"><?php echo $submenu->title; ?></a></h3>
					<div class="widget-inner">
					   	<?php $this->show_children($submenu); ?>
					</div>
				</div>
		    <?php
		    }
	    }
	}
	
	/**
	 * Show children from a submenu item
	 *
	 * @param object $item
	 */
	function show_children($item) {
		if($item->children) {
			?>
			<ul>
				<?php foreach($item->children as $child) { ?>
					<?php
						$class = '';
						
						if($child->is_current) {
							$class = 'class="current"';
						} else if($child->is_parent) {
							$class = 'class="parent"';
						}
					?>
					<li <?php echo $class; ?>>
						<a href="<?php echo $child->url; ?>"><?php echo $child->title; ?></a>
						<?php $this->show_children($child); ?>
					</li>
				<?php } ?>
			</ul>
			<?php
		}
	}
}
?>