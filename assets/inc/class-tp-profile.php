<?php
/**
 * Adjustments to profiles
 *
 * @package TrendPress
 */

class TP_Profile {
	function __construct() {
		//Edit
		add_action( 'show_user_profile', array( $this, 'edit' ) );
		add_action( 'edit_user_profile', array( $this, 'edit' ) );
		
		//Save
		add_action( 'personal_options_update', array( $this, 'save' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save' ) );
	}
	
	/**
	 * Add extra profile fields
	 */
	function edit( $user ) {
		?>
		
		<h3><?php _e( 'Publish profile', 'tp' ); ?></h3>
		
		<table class="form-table">

			<tbody>

				<tr>

					<th><?php _e( 'Show profile on website', 'tp' ); ?></th>

					<td>
						<label for="show_profile">
							<input name="show_profile" type="checkbox" id="show_profile" value="1" <?php checked( ! empty( $user->show_profile ), true ); ?>>
							<?php _e( 'Show my profile on the website at blogposts and author archives', 'tp' ); ?>
						</label>
					</td>

				</tr>

				<tr>

					<th><?php _e( 'Profile picture', 'tp' ); ?></th>

					<td>
						<a href="http://gravatar.com/" target="_blank" style="float: left; margin-right: 10px;" >
							<?php echo get_avatar( $user->data->user_email, 50 ); ?>
						</a>
						
						<span class="description">
							<?php _e( 'You can change your profile picture via', 'tp' ); ?> <a href="http://gravatar.com/" target="_blank">Gravatar.com</a> <?php _e( 'by logging in or signing up for free with the email address associated with your profile', 'tp' ); ?> (<?php echo $user->data->user_email; ?>).
						</span>
					</td>

				</tr>

			</tbody>

		</table>

		<?php 
	} 
	
	/**
	 * Save profile fields
	 */
	function save( $user_id ) {
		update_user_meta( $user_id, 'show_profile', isset( $_POST['show_profile'] ) );
	}
} new TP_Profile;
