<?php
/**
 * Declare JavaScript constants
 */
 
/**
 * Declares some JavaScript constants
 */
function tp_declare_js_constants() {
	?>
	<script type="text/javascript">
		var siteurl = '<?php echo site_url(); ?>';
		var templateurl = '<?php echo get_template_directory_uri(); ?>';
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		var stylesheeturl = '<?php echo get_stylesheet_directory_uri(); ?>';
	</script>
	<?php
}

add_action('wp_head','tp_declare_js_constants',1);
?>