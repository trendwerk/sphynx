<?php
/**
 * Modifications to WordPress users
 *
 * @package TrendPress
 */

class TP_Users {
	function __construct() {
		add_filter( 'user_contactmethods', array( $this, 'adjust_media' ) );

		add_action( 'show_user_profile', array( $this, 'add_fields' ) );
		add_action( 'edit_user_profile', array( $this, 'add_fields' ) );
		add_action( 'personal_options_update', array( $this, 'save_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_fields' ) );
	}

	/**
	 * Adjust social media fields
	 */
	function adjust_media( $media ) {
		unset( $media['aim'] );
		unset( $media['yim'] );
		unset( $media['jabber'] );

		$media['facebook']   = __( 'Facebook profile URL', 'tp' );
		$media['linkedin']   = __( 'LinkedIn profile URL', 'tp' );
		$media['googleplus'] = __( 'Google+ profile URL', 'tp' );
	    $media['twitter']    = __( 'Twitter @username', 'tp' );
		
		return $media;
	}

	/**
	 * Add extra profile fields
	 */
	function add_fields( $user ) {
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
	function save_fields( $user_id ) {
		update_user_meta( $user_id, 'show_profile', isset( $_POST['show_profile'] ) );
	}

} new TP_Users;
