<?php
/**
 * Submenu widget based on WP Nav menu's
 *
 * @package TrendPress
 * @subpackage Widgets
 */

class TP_Submenu extends WP_Widget {
	var $title;
	
	function __construct() {
		$this->WP_Widget( 'TP_Submenu', __( 'Submenu', 'tp' ), array(
			'description' => __( 'Shows submenu items of current menu item or parent.', 'tp'
		) ) );

		add_filter( 'wp_nav_menu_objects', array( $this, 'submenu' ), 10, 2 );
	}

	function form( $instance ) {
		$defaults = array(
			'menu' => 0,
		);

		$instance = wp_parse_args( $instance, $defaults );

		$menus = wp_get_nav_menus();

		if( 0 === count( $menus ) )
			return;
		?>
		
		<p>
			<label>

				<strong>
					<?php _e( 'Menu' ); ?>
				</strong>

				<select class="widefat" id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>" type="text" value="<?php echo $instance['menu']; ?>">

					<?php foreach( $menus as $menu ) { ?>

						<option value="<?php echo $menu->term_taxonomy_id; ?>" <?php selected( $menu->term_taxonomy_id, $instance['menu'] ); ?>>
							<?php echo $menu->name; ?>
						</option>

					<?php } ?>

				</select>

			</label>
		</p>
		
		<?php
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		if( ! isset( $instance['menu'] ) || 0 === strlen( $instance['menu'] ) )
			return;
		
		$menu = wp_nav_menu( array(
			'menu'    => $instance['menu'],
			'submenu' => true,
			'echo'    => false,
		) );

		if( 0 === strlen( $menu ) )
			return;

		echo $before_widget;

			echo $before_title . $this->title . $after_title;

			echo $menu;

		echo $after_widget;
	}

	/**
	 * Submenu support for wp_nav_menu
	 */
	function submenu( $items, $args ) {
		if( ! isset( $args->submenu ) || ! $args->submenu )
			return $items;

		$current = array_pop( ( wp_filter_object_list( $items, array( 'current' => true ) ) ) );

		if( ! isset( $current ) )
			return array();

		$parent = $this->get_top( $current, $items );
		$this->title = $parent->title;

		return $this->get_children( $parent, $items );
	}

	/**
	 * Get top parent
	 */
	function get_top( $item, $items ) {
		if( ! isset( $item->menu_item_parent ) )
			return $item;

		while( 0 < $item->menu_item_parent )
			$item = array_pop( ( wp_filter_object_list( $items, array( 'ID' => $item->menu_item_parent ) ) ) );

		return $item;
	}

	/**
	 * Get all children
	 */
	function get_children( $parent, $items ) {
		$children = wp_filter_object_list( $items, array( 'menu_item_parent' => $parent->ID ) );

		if( 0 === count( $children ) )
			return array();

		foreach( $children as $child )
			$children = array_merge( $children, $this->get_children( $child, $items ) );

		return $children;
	}
}

add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Submenu" );' ) );
