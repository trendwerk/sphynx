<?php
/**
 * Contact information
 *
 * @package TrendPress
 * @subpackage Widgets
 */
class TP_Contact extends WP_Widget {
	function TP_Contact() {
		$this->WP_Widget( 'TP_Contact', __( 'Contact information', 'tp' ), array( 'description' => __( 'Shows the specified contact information', 'tp' ) ) );
	}

	function form( $instance ) {
		?>

 		<p>
 			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
 				<strong><?php _e( 'Title' ); ?></strong><br />
 				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
 			</label>
 		</p>

 		<p><?php printf( __( 'Change the contents of this widget on the <a href="%1$s">contact information</a> page.', 'tp' ), admin_url( 'options-general.php?page=tp-information' ) ); ?></p>

		<?php
	}
	
	function widget( $args, $instance ) {
		extract( $args );

 		echo $before_widget;

 			if( $instance['title'] ) 
 				echo $before_title . $instance['title'] . $after_title; 

 			?>

			<div itemscope itemtype="http://schema.org/Organization">

				<p>
					<?php 
						if( $name = get_option( 'tp-company-name' ) )
							echo '<span itemprop="name"><strong>' . $name . '</strong></span><br />';
					?>

					<span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">	
						<?php
							if( $address = get_option( 'tp-address' )) 
								echo '<span itemprop="streetAddress">'.$address.'</span><br />'; 

							if( $postal_code = get_option( 'tp-postal-code' ))
								echo '<span itemprop="postalCode">' . $postal_code . '</span>';

							if( $city = get_option( 'tp-city' ))
								echo ' <span itemprop="addressLocality">' . $city . '</span><br />';

							if( $country = get_option( 'tp-country' ))
								echo '<span itemprop="addressCountry">' . $country . '</span>';
						?>
					</span>
				</p>

				<p>
					<?php
						if( $email = get_option( 'tp-email' ) )
							echo '<span class="label">' . __( 'E-mail', 'tp' ) . ': </span><a itemprop="email" href="mailto:' . $email . '">' . $email . '</a><br />';

						if( $telephone = get_option( 'tp-telephone' ) )
							echo '<span class="label">' . __( 'Telephone', 'tp' ) . ': </span><span itemprop="telephone">' . $telephone . '</span><br />';

						if( $fax = get_option( 'tp-fax' ) ) 
							echo '<span class="label">' . __( 'Fax', 'tp' ) . ': </span><span itemprop="faxNumber">' . $fax . '</span>';
					?>
				</p>

				<p>
					<?php
						if( $cc = get_option( 'tp-cc' ) )
							echo '<span class="label">' . __( 'CC No', 'tp' ) . ': </span>' . $cc . '<br />';

						if( $vat = get_option( 'tp-vat' ) )
							echo '<span class="label" itemprop="vatID">' . __( 'VAT No', 'tp' ) . ': </span>' . $vat . '<br />';
						
						if( $bankno = get_option( 'tp-bank-no' ) ) {
							$bank = ( 0 < strlen( get_option( 'tp-bank' ) ) ) ? get_option( 'tp-bank' ) : __( 'Bank', 'tp' );

							echo '<span class="label">' . $bank . ': </span>' . $bankno;
						} 
					?>
				</p>

			</div>

			<?php 

		echo $after_widget;
	}
}
add_action( 'widgets_init', create_function( '', 'return register_widget( "TP_Contact" );' ) );
