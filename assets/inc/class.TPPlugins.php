<?php
/**
 * This class inserts a settings screen to the "Plugins" admin menu.
 * It shows some recommended and optional plugins you can immediately download,
 * activate and apply settings to it.
 */

class TPPlugins {
	/**
	 * Recommended plugins
	 *
	 * @var array
	 */
	var $recommended = array();
	
	/**
	 * Optional plugins
	 *
	 * @var array
	 */
	var $optional = array();
	
	/**
	 * Constructor
	 */
	function __construct() {
		add_action('admin_menu',array($this,'add_admin_page'));
		
		//Include JS & CSS
		add_action('admin_print_scripts', array($this,'include_js'));
		add_action('admin_print_styles', array($this,'include_css'));
		
		//Setup recommended plugins
		$this->recommended = array(
			'wordpress-seo' => array(
				'name' => __('WordPress SEO by Yoast','tp'),
				'description' => __('Improve your WordPress SEO: Write better content and have a fully optimized WordPress site using the WordPress SEO plugin by Yoast.','tp'),
				'path' => 'wordpress-seo/wp-seo.php'
			),
			'google-analytics-for-wordpress' => array(
				'name' => __('Google Analytics for WordPress','tp'),
				'description' => __('This plugin makes it simple to add Google Analytics to your WordPress blog, adding lots of features, eg. custom variables and automatic clickout and download tracking.','tp'),
				'path' => 'google-analytics-for-wordpress/googleanalytics.php'
			),
			'theme-updater' => array(
				'name' => __('Theme updater','tp'),
				'description' => __('Enables the ability to update the TrendPress parent theme within WordPress.','tp'),
				'path' => 'theme-updater/updater.php'
			),
			'w3-total-cache' => array(
				'name' => __('W3 Total Cache','tp'),
				'description' => __('Improve site performance and user experience via caching: browser, page, object, database, minify and content delivery network support.','tp'),
				'path' => 'w3-total-cache/w3-total-cache.php'
			),
			'search-everything' => array(
				'name' => __('Search everything','tp'),
				'description' => __('Increases WordPress\' default search functionality in three easy steps.','tp'),
				'path' => 'search-everything/search-everything.php',
				'settings' => true
			)
		);
		
		$this->optional = array(
			'multiple-content-blocks' => array(
				'name' => __('Multiple content blocks','tp'),
				'description' => __('Lets you use more than one content "block" on a template. You only have to insert one tag inside the template, so it\'s easy to use.','tp'),
				'path' => 'multiple-content-blocks/multiple_content.php'
			),
			'redirection' => array(
				'name' => __('Redirection','tp'),
				'description' => __('Redirection is a WordPress plugin to manage 301 redirections and keep track of 404 errors without requiring knowledge of Apache .htaccess files.','tp'),
				'path' => 'redirection/redirection.php'
			)
		);
		
		//Check if 'Apply settings' has been clicked
		add_action('init',array($this,'handle_settings'));
		
		//Register activation hooks
		$this->setup_activation();
		
		//Redirect after activation
		add_action('init',array($this,'redirect_after_activation'));
		
		//Show activation message
		if(isset($_GET['activated']) && $_GET['page'] == 'tp-recommended-plugins') add_action('admin_notices',array($this,'show_plugin_activated'));
		
		//Add recommended link after install
		add_filter('update_plugin_complete_actions',array($this,'add_recommended_link'));
		add_filter('install_plugin_complete_actions',array($this,'add_recommended_link'));
	}
	
	
	/**
	 * Add the admin page to the menu
	 */
	function add_admin_page() {
		add_plugins_page(__('Recommended plugins','tp'),__('Recommended','tp'),'install_plugins','tp-recommended-plugins',array($this,'admin_page'));
	}
	
	
	/**
	 * Show the admin panel
	 */
	function admin_page() {		
		include('admin-views/recommended-plugins.php');
	}
	
	
	/**
	 * Shows a message that a recommended plugin is activated
	 */
	function show_plugin_activated() {
		?>
		<div class="updated" id="message"><p><?php _e('Recommended plugin <strong>activated</strong>.','tp'); ?></p></div>
		<?php
	}
	
	/**
	 * Shows available plugins in a table
	 *
	 * @param array $plugins The list of plugins that has to be shown
	 */
	function show_plugins($plugins) {
		include('admin-views/plugin-table.php');
	}
	
	/**
	 * Include JS
	 */
	function include_js() {
		wp_enqueue_script('thickbox');
	}
	
	/**
	 * Include CSS
	 */
	function include_css() {
		wp_enqueue_style('thickbox');
	}
	
	/**
	 * Check if a plugin is installed
	 *
	 * @param string $path The path to the plugin folder & file
	 */
	function has_plugin($path) {
		return file_exists(ABSPATH.'/wp-content/plugins/'.$path);
	}
	
	/**
	 * Handle the 'Apply settings' buttons
	 */
	function handle_settings() {
		if(isset($_GET['settings']) && $_GET['page'] == 'tp-recommended-plugins') {
			add_action('admin_notices',array($this,'show_settings_updated'));
			
			//Apply settings, different each plugin
			$plugins = array_merge($this->recommended,$this->optional);
			$plugin = $plugins[$_GET['settings']];
			
			//Search everything settings
			if($_GET['settings'] == 'search-everything') {
				$options = array(
					'se_exclude_categories'			=> '',
					'se_exclude_categories_list'	=> '',
					'se_exclude_posts'				=> '',
					'se_exclude_posts_list'			=> '',
					'se_use_page_search'			=> 'Yes',
					'se_use_comment_search'			=> 'Yes',
					'se_use_tag_search'				=> 'Yes',
					'se_use_tax_search'				=> 'Yes',
					'se_use_category_search'		=> 'Yes',
					'se_approved_comments_only'		=> 'Yes',
					'se_approved_pages_only'		=> 'Yes',
					'se_use_excerpt_search'			=> 'Yes',
					'se_use_draft_search'			=> 'No',
					'se_use_attachment_search'		=> 'Yes',
					'se_use_authors'				=> 'Yes',
					'se_use_cmt_authors'			=> 'Yes',
					'se_use_metadata_search'		=> 'Yes',
					'se_use_highlight'				=> 'No',
					'se_highlight_color'			=> '',
					'se_highlight_style'			=> ''
				);
					
				update_option('se_options',$options);
			}
		}
	}
	
	/**
	 * Show the apply settings message
	 */
	function show_settings_updated() {
		$plugins = array_merge($this->recommended,$this->optional);
		$plugin = $plugins[$_GET['settings']];
		?>
		<div class="updated" id="message"><p><?php echo sprintf(__('The plugin <strong>%1$s</strong> has been reset to the recommended TrendPress settings.','tp'),$plugin['name']); ?></p></div>
		<?php
	}
	
	/**
	 * Adds an activation hook to all plugins to redirect on activation
	 */
	function setup_activation() {
		add_action('activate_plugin',array($this,'setup_exceptions'));
		
		foreach(array_merge($this->recommended,$this->optional) as $name=>$plugin) {
			register_activation_hook($plugin['path'],array($this,'plugin_activated'));
		}
	}
	
	/**
	 * Some exceptional code. This is probably based on single plugins
	 */
	function setup_exceptions() {
		//Ofcourse WordPress SEO needs some tweaking..
		remove_action('activate_wordpress-seo/wp-seo.php','wpseo_activate');
	}
	
	/**
	 * Sets redirection to true
	 */
	function plugin_activated() {
		update_option('recommended_plugins_do_activation_redirect','true');
	}
	
	/**
	 * Redirects to 'recommended plugins' when one of the recommended plugins is activated
	 */
	function redirect_after_activation() {
		if(get_option('recommended_plugins_do_activation_redirect',false)) {
			delete_option('recommended_plugins_do_activation_redirect');
			wp_redirect(admin_url('plugins.php?page=tp-recommended-plugins&activated'));
		}
	}
	
	/**
	 * Adds recommended link after installing a recommended plugin
	 */
	function add_recommended_link($links) {
		if(!isset($_GET['plugin'])) return $links;
		
		if(isset($this->recommended[$_GET['plugin']]) || isset($this->optional[$_GET['plugin']])) {
			$links[] = sprintf(__('<a href="%1$s">Return to recommended plugins</a>','tp'),admin_url('plugins.php?page=tp-recommended-plugins'));
		}
		
		return $links;
	}
}

new TPPlugins();
?>