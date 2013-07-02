<?php
/**
 * Adjustments to profiles
 */

class TPProfile {
	function __construct() {
		//Edit
		add_action('show_user_profile',array($this,'edit'));
		add_action('edit_user_profile',array($this,'edit'));
		
		//Save
		add_action('personal_options_update',array($this,'save'));
		add_action('edit_user_profile_update',array($this,'save'));
	}
	
	/**
	 * Add extra profile fields
	 */
	function edit($user) {
		?>
		<label for="hide_profile">
			<input name="hide_profile" type="checkbox" id="hide_profile" value="1" <?php checked(!empty($user->hide_profile),true); ?>>
			<?php _e('Hide my profile on the website','tp'); ?>
		</label>
		<?php 
	} 
	
	/**
	 * Save profile fields
	 */
	function save($user_id) {
		update_user_meta($user_id,'hide_profile',isset($_POST['hide_profile']));
	}
} new TPProfile;
?>