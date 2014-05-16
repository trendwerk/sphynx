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

		add_action( 'tp_widget_after_content', array( $this, 'show' ) );
	}

	function show( $instance ) {
		if( true === $instance['tp-telephone'] ) {
			?>
			
			<p class="telephone">
				<i class="fa fa-phone"></i> 
				<?php echo get_option( 'tp-telephone' ); ?>
			</p>

			<?php
		}
	}
	
	function widget( $args, $instance ) {
		$instance['tp-telephone'] = true;
		parent::widget( $args, $instance );
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Telephone_Button" );' ) );
