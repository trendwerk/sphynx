<?php
/**
 * Submenu widget based on WP Nav menu's
 *
 * @package TrendPress
 * @subpackage Widgets
 */
class TP_Submenu extends WP_Widget {
	function TP_Submenu() {
		$this->WP_Widget( 'TP_Submenu', __( 'Submenu', 'tp' ), array( 'description' => __( 'Shows submenu items of current menu item or parent', 'tp' ) ) );
	}
	
	/**
	 * Show children from a submenu item
	 *
	 * @param object $item
	 */
	function show_children( $item ) {
		if( $item->children ) {
			?>

			<ul>

				<?php 
					foreach( $item->children as $child)  {
						$class = '';
						if( $child->is_current ) {
							$class = 'class="current"';
						} elseif( $child->is_parent ) {
							$class = 'class="parent"';
						}
						?>

						<li <?php echo $class; ?>>

							<a href="<?php echo $child->url; ?>">
								<?php echo $child->title; ?>	
							</a>

							<?php $this->show_children( $child ); ?>

						</li>

						<?php
					}
				?>

			</ul>

			<?php
		}
	}
	
	function widget( $args, $instance ) {		
		global $post, $wpdb;
		extract( $args );
		
		$nav = new TP_Nav();
		$submenu = $nav->get_submenu_items();
		
		if( isset( $submenu->children ) ) {
			if( $submenu->children ) {
				echo $before_widget;
					echo $before_title; 
					?>

					<a href="<?php echo $submenu->url; ?>">
						<?php echo $submenu->title; ?>
					</a>

					<?php 
					echo $after_title;
					
					$this->show_children( $submenu ); 
				echo $after_widget;
		    }
	    }
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Submenu" );' ) );