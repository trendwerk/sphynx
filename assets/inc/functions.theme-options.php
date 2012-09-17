<?php 
/**
 * Add theme options to the back-end
 */

/**
 * Add the options page to the menu
 */
function tp_contact_info_add_page() {
	add_theme_page(__('Contact information','tp'),__('Contact information','tp'),'publish_pages','tp-contact_info','tp_contact_info_do_page');
} 
add_action('admin_menu','tp_contact_info_add_page');


/**
 * Add the back-end admin view
 */
function tp_contact_info_do_page() {
	tp_save_contact_info();
	include('admin-views/theme-options.php');	
}

/**
 * Add the admin CSS
 */
function tp_contact_info_do_css() {
	?>
	<link href="<?php echo get_template_directory_uri(); ?>/assets/css/admin.css" type="text/css" rel="stylesheet" />
	<?php
}
add_action('admin_head','tp_contact_info_do_css');

/**
 * Save the theme options
 */
function tp_save_contact_info() {
	if($_POST['tp_submit']) {
		update_option('blogname',$_POST['sitename']); 
		update_option('blogdescription',$_POST['description']);

		update_option('tp-naam',$_POST['naam']); 
		update_option('tp-adres',$_POST['adres']); 
		update_option('tp-postcode',$_POST['postcode']); 
		update_option('tp-plaats',$_POST['plaats']);
		
		update_option('tp-email',$_POST['email']); 
		update_option('tp-telefoon',$_POST['telefoon']);
		update_option('tp-fax',$_POST['fax']);
		
		update_option('tp-kvk',$_POST['kvk']); 
		update_option('tp-btw',$_POST['btw']); 
		update_option('tp-bank',$_POST['bank']); 
		update_option('tp-banknr',$_POST['banknr']); 
		
		update_option('tp-twitter',tp_maybe_add_http($_POST['twitter']));
		update_option('tp-facebook',tp_maybe_add_http($_POST['facebook']));
		update_option('tp-linkedin',tp_maybe_add_http($_POST['linkedin']));
		update_option('tp-googleplus',tp_maybe_add_http($_POST['googleplus']));
		update_option('tp-youtube',tp_maybe_add_http($_POST['youtube']));
	}
}

/**
 * Converts a string to an URL (Add http:// if necessary)
 *
 * @param string $url
 */
function tp_maybe_add_http($url) {
	if(!$url) return;
	
	if(!strstr($url,'http://') && !strstr($url,'https://')) $url = 'http://'.$url;
	
	return $url;
}
?>