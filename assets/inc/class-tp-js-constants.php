<?php
/**
 * Declare JavaScript constants
 *
 * @package TrendPress
 */
 
class TP_JS_Constants {
	function __construct() {
		add_action( 'wp_head', array( $this, 'declare_constants' ), 1 );
	}
	
	function declare_constants() {
		?>

		<script type="text/javascript">
			var siteurl = '<?php echo site_url(); ?>';
			var templateurl = '<?php echo get_template_directory_uri(); ?>';
			var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
			var stylesheeturl = '<?php echo get_stylesheet_directory_uri(); ?>';
		</script>
		
		<?php
	}
} new TP_JS_Constants;
