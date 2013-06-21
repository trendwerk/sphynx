<?php
/**
 * @misc Add editor styles
 */
function tp_add_editor_styles($settings) {
    $style_formats = array(
    	array(
    		'title' => __('Primary button','tp'),
    		'selector' => 'a',
    		'classes' => 'cta primary'
    	),
    	array(
    		'title' => __('Secondary button','tp'),
    		'selector' => 'a',
    		'classes' => 'cta secondary'
    	),
    	array(
    		'title' => __('More link','tp'),
    		'selector' => 'a',
    		'classes' => 'more-link'
    	)
    );
    $settings['style_formats'] = json_encode($style_formats);
    return $settings;
}
add_filter('tiny_mce_before_init','tp_add_editor_styles');

/**
 * @author Remove AIM, YIM, JABBER and add Facebook and LinkedIn
 */
function tp_modify_profile($media) {
	unset($media['aim']);
	unset($media['yim']);
	unset($media['jabber']);
	unset($media['googleplus']);

	$media['facebook'] = __('Facebook profile URL','tp');
	$media['linkedin'] = __('LinkedIn profile URL','tp');
	$media['googleplus'] = __('Google+ profile URL','tp');
	
	return $media;
}
add_filter('user_contactmethods','tp_modify_profile');

/**
 * @author Add checkbox to hide profile on the website
 */

function tp_hide_profile_edit($user) {
  $checked = (isset($user->hide_profile) && $user->hide_profile) ? ' checked="checked"' : '';
?>
	<label for="hide_profile">
		<input name="hide_profile" type="checkbox" id="hide_profile" value="1"<?php echo $checked; ?>>
		<?php _e('Hide my profile on the website','tp'); ?>
	</label>
<?php 
}
add_action('show_user_profile', 'tp_hide_profile_edit');
add_action('edit_user_profile', 'tp_hide_profile_edit');

function tp_hide_profile_update($user_id) {
	update_user_meta($user_id, 'hide_profile', isset($_POST['hide_profile']));
}
add_action('personal_options_update', 'tp_hide_profile_update');
add_action('edit_user_profile_update', 'tp_hide_profile_update');

?>