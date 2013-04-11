<?php 
/**
 * Add contact information
 */

class TPInformation {
	function __construct() {
		add_action('admin_init',array($this,'add_settings'));
		add_action('admin_menu',array($this,'add_menu'));
	}
	
	/**
	 * Add settings fields through the Settings API
	 */
	function add_settings() {
		/**
		 * @section General
		 */
		add_settings_section('tp-general',__('General settings','tp'),'','tp-information');
		
		add_settings_field('tp-sitename',__('Sitename','tp'),array($this,'show_text_field'),'tp-information','tp-general',array('label_for' => 'tp-sitename', 'class' => 'regular-text', 'option_key' => 'blogname'));
		register_setting('tp-information','tp-sitename',array($this,'save_site_name'));
		
		add_settings_field('tp-description',__('Description','tp'),array($this,'show_text_field'),'tp-information','tp-general',array('label_for' => 'tp-description', 'class' => 'regular-text', 'option_key' => 'blogdescription'));
		register_setting('tp-information','tp-description',array($this,'save_site_description'));
		
		/**
		 * @section Contact
		 */
		add_settings_section('tp-contact',__('Contact','tp'),'','tp-information');
		
		add_settings_field('tp-company-name',__('Company name','tp'),array($this,'show_text_field'),'tp-information','tp-contact',array('label_for' => 'tp-company-name', 'class' => 'regular-text'));
		register_setting('tp-information','tp-company-name');
		
		add_settings_field('tp-address',__('Address','tp'),array($this,'show_text_field'),'tp-information','tp-contact',array('label_for' => 'tp-address', 'class' => 'regular-text'));
		register_setting('tp-information','tp-address');
		
		add_settings_field('tp-postal-code',__('Postal code','tp'),array($this,'show_text_field'),'tp-information','tp-contact',array('label_for' => 'tp-postal-code', 'class' => 'regular-text'));
		register_setting('tp-information','tp-postal-code');
		
		add_settings_field('tp-city',__('City','tp'),array($this,'show_text_field'),'tp-information','tp-contact',array('label_for' => 'tp-city', 'class' => 'regular-text'));
		register_setting('tp-information','tp-city');
		
		add_settings_field('tp-email',__('E-mail','tp'),array($this,'show_text_field'),'tp-information','tp-contact',array('label_for' => 'tp-email', 'class' => 'regular-text'));
		register_setting('tp-information','tp-email');
		
		add_settings_field('tp-telephone',__('Telephone','tp'),array($this,'show_text_field'),'tp-information','tp-contact',array('label_for' => 'tp-telephone', 'class' => 'regular-text'));
		register_setting('tp-information','tp-telephone');
		
		add_settings_field('tp-fax',__('Fax','tp'),array($this,'show_text_field'),'tp-information','tp-contact',array('label_for' => 'tp-fax', 'class' => 'regular-text'));
		register_setting('tp-information','tp-fax');
		
		/**
		 * @section Registration numbers & financial
		 */
		add_settings_section('tp-registration',__('Registration numbers & financial','tp'),'','tp-information');
		
		add_settings_field('tp-cc',__('CC No.','tp'),array($this,'show_text_field'),'tp-information','tp-registration',array('label_for' => 'tp-cc', 'class' => 'regular-text'));
		register_setting('tp-information','tp-cc');
		
		add_settings_field('tp-vat',__('VAT No.','tp'),array($this,'show_text_field'),'tp-information','tp-registration',array('label_for' => 'tp-vat', 'class' => 'regular-text'));
		register_setting('tp-information','tp-vat');
		
		add_settings_field('tp-bank',__('Bank name','tp'),array($this,'show_text_field'),'tp-information','tp-registration',array('label_for' => 'tp-bank', 'class' => 'regular-text'));
		register_setting('tp-information','tp-bank');
		
		add_settings_field('tp-bank-no',__('Bank No.','tp'),array($this,'show_text_field'),'tp-information','tp-registration',array('label_for' => 'tp-bank-no', 'class' => 'regular-text'));
		register_setting('tp-information','tp-bank-no');
		
		/**
		 * @section Social media links
		 */
		add_settings_section('tp-social',__('Social media links','tp'),'','tp-information');
		
		add_settings_field('tp-twitter',__('Twitter URL','tp'),array($this,'show_text_field'),'tp-information','tp-social',array('label_for' => 'tp-twitter', 'class' => 'regular-text'));
		register_setting('tp-information','tp-twitter','tp_maybe_add_http');
		
		add_settings_field('tp-facebook',__('Facebook URL','tp'),array($this,'show_text_field'),'tp-information','tp-social',array('label_for' => 'tp-facebook', 'class' => 'regular-text'));
		register_setting('tp-information','tp-facebook','tp_maybe_add_http');
		
		add_settings_field('tp-linkedin',__('LinkedIn URL','tp'),array($this,'show_text_field'),'tp-information','tp-social',array('label_for' => 'tp-linkedin', 'class' => 'regular-text'));
		register_setting('tp-information','tp-linkedin','tp_maybe_add_http');
		
		add_settings_field('tp-googleplus',__('Google Plus URL','tp'),array($this,'show_text_field'),'tp-information','tp-social',array('label_for' => 'tp-googleplus', 'class' => 'regular-text'));
		register_setting('tp-information','tp-googleplus','tp_maybe_add_http');
		
		add_settings_field('tp-youtube',__('YouTube URL','tp'),array($this,'show_text_field'),'tp-information','tp-social',array('label_for' => 'tp-youtube', 'class' => 'regular-text'));
		register_setting('tp-information','tp-youtube','tp_maybe_add_http');
		
		add_settings_field('tp-newsletter',__('Newsletter / mailto link','tp'),array($this,'show_text_field'),'tp-information','tp-social',array('label_for' => 'tp-newsletter', 'class' => 'regular-text'));
		register_setting('tp-information','tp-newsletter');
		
		add_settings_field('tp-rss','',array($this,'show_checkbox'),'tp-information','tp-social',array('label' => __('Show RSS feed in the social media widget','tp'), 'option_key' => 'tp-rss'));
		register_setting('tp-information','tp-rss');
	}
	
	/**
	 * Show a text field
	 *
	 * @param array $args Some additional arguments
	 */
	function show_text_field($args) {
		$args['option_key'] = isset($args['option_key']) ? $args['option_key'] : $args['label_for'];
		?>
		<input id="<?php echo $args['label_for']; ?>" name="<?php echo $args['label_for']; ?>" value="<?php echo get_option($args['option_key']); ?>" class="<?php echo $args['class']; ?>" type="text" />
		<?php
	}
	
	/**
	 * Show a checkbox
	 *
	 * @param array $args Some additional arguments
	 */
	function show_checkbox($args) {
		?>
		<label>
			<input name="<?php echo $args['option_key']; ?>" value="true" class="<?php echo $args['class']; ?>" type="checkbox" <?php if(get_option($args['option_key']) == 'true') echo 'checked="checked"'; ?> /> <?php echo $args['label']; ?>
		</label>
		<?php
	}
	
	/**
	 * @exception Save the site name
	 */
	function save_site_name($value) {
		update_option('blogname',$value);
	}
	
	/**
	 * @exception Save the site description
	 */
	function save_site_description($value) {
		update_option('blogdescription',$value);
	}
	
	/**
	 * Add contact information page to menu
	 */
	function add_menu() {
		add_options_page(__('Contact information','tp'),__('Contact information','tp'),'publish_pages','tp-information',array($this,'display'));
	}
	
	/**
	 * Display admin page
	 */
	function display($iets) {
		?>
		<div class="wrap">
			<div class="icon32" id="icon-themes"><br></div>
			<h2><?php _e('Contact information','tp'); ?></h2>
			
			<form action="options.php" method="post">
				<?php 
					settings_fields('tp-information');
					do_settings_sections('tp-information');
					submit_button(); 
				?>
			</form>
		</div>
		<?php
	}
} new TPInformation;
?>