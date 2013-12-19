<?php
/**
 * Telephone number and button
 *
 * @package TrendPress
 * @subpackage Widgets
 */

include_once( 'class-tp-title-content-button.php' );

class TP_Telephone_Button extends TP_Title_Content_Button {
	function TP_Telephone_Button() {
		$this->WP_Widget( 'TP_Telephone_Button', __( 'Telephone number and button', 'tp' ), array( 'description' => __( 'Telephone number and button', 'tp' ) ) );

		$this->setup();

		add_action( 'tp_widget_after_content_form', array( $this, 'add_telephone_field' ) );
		add_action( 'tp_widget_after_content_widget', array( $this, 'show_telephone_field' ) );
	}

	function add_telephone_field( $instance ) {
		global $tp_add_telephone;

		if( true === $tp_add_telephone ) {
			?>
			
			<p>
				<label>
					<strong><?php _e( 'Telephone number', 'tp' ); ?></strong><br />
					<input class="widefat" name="<?php echo $this->get_field_name( 'telephone' ); ?>" type="text" value="<?php echo $instance['telephone']; ?>" />
				</label>
			</p>

			<?php
		}
	}

	function form( $instance ) {
		global $tp_add_telephone;
		$tp_add_telephone = true;

		parent::form( $instance );

		$tp_add_telephone = false;
	}

	function show_telephone_field( $instance ) {
		global $tp_add_telephone;

		if( true === $tp_add_telephone ) {
			?>
			
			<p class="telephone">
				<i class="icon-phone"></i> 
				<?php echo $instance['telephone']; ?>
			</p>

			<?php
		}
	}
	
	function widget( $args, $instance ) {
		global $tp_add_telephone;
		$tp_add_telephone = true;

		parent::widget( $args, $instance );

		$tp_add_telephone = false;
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Telephone_Button" );' ) );
