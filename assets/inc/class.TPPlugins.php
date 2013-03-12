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
				'name' => 'WordPress SEO by Yoast',
				'description' => __('Improve your SEO: Write better content and have a fully optimized WordPress site.','tp'),
				'path' => 'wordpress-seo/wp-seo.php'
			),
			'google-analytics-for-wordpress' => array(
				'name' => 'Google Analytics for WordPress',
				'description' => __('Add Google Analytics to the website to track user statistics.','tp'),
				'path' => 'google-analytics-for-wordpress/googleanalytics.php'
			),
			'w3-total-cache' => array(
				'name' => 'W3 Total Cache',
				'description' => __('Improve site performance and user experience via caching: browser, page, object, database, minify and content delivery network support.','tp'),
				'path' => 'w3-total-cache/w3-total-cache.php'
			),
			'wp-smushit' => array(
				'name' => 'WP Smush.it',
				'description' => __('Reduce image file sizes and improve performance using the Smush.it API within WordPress.','tp'),
				'path' => 'wp-smushit/wp-smushit.php'
			),
			'search-everything' => array(
				'name' => 'Search everything',
				'description' => __('Increases WordPress\' default search functionality.','tp'),
				'path' => 'search-everything/search-everything.php',
				'settings' => true
			),
			'tinymce-advanced' => array(
				'name' => 'TinyMCE Advanced',
				'description' => __('Enables the advanced features of TinyMCE, the WordPress WYSIWYG editor.','tp'),
				'path' => 'tinymce-advanced/tinymce-advanced.php',
				'settings' => true
			)
		);
		
		$this->optional = array(
			'multiple-content-blocks' => array(
				'name' => 'Multiple content blocks',
				'description' => __('Display more than one content field on WordPress pages and posts.','tp'),
				'path' => 'multiple-content-blocks/multiple-content-blocks.php'
			),
			'social' => array(
				'name' => 'Social',
				'description' => __('Broadcast posts to Twitter and/or Facebook, pull in reactions from Twitter and Facebook as comments.','tp'),
				'path' => 'social/social.php'
			),
			'capsman' => array(
				'name' => 'Capability Manager',
				'description' => __('A simple way to create and manage roles and capabilities.','tp'),
				'path' => 'capsman/capsman.php'
			),
			'redirection' => array(
				'name' => 'Redirection',
				'description' => __('Manage 301 redirections and keep track of 404 errors.','tp'),
				'path' => 'redirection/redirection.php'
			),
			'wp-migrate-db' => array(
				'name' => 'WP Migrate DB',
				'description' => __('Exports your database, does a find and replace on URLs and file paths, then allows you to save it to your computer.','tp'),
				'path' => 'wp-migrate-db/wp-migrate-db.php'
			),
			'ajax-thumbnail-rebuild' => array(
				'name' => 'AJAX Thumbnail Rebuild',
				'description' => __(' Rebuild all image thumbnails at once without script timeouts on your server.','tp'),
				'path' => 'ajax-thumbnail-rebuild/ajax-thumbnail-rebuild.php'
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
			
			//TinyMCE Advanced settings
			if($_GET['settings'] == 'tinymce-advanced') {
				$tadv_options = array( 'advlink1' => 0, 'advimage' => 1, 'editorstyle' => 1, 'hideclasses' => 0, 'contextmenu' => 0, 'no_autop' => 0 );
				$tadv_plugins = array( 'style', 'emotions', 'print', 'searchreplace', 'xhtmlxtras', 'advimage', 'table' );
				$tadv_toolbars = array( 
					'toolbar_1' => array( 'bold', 'italic', 'separator1', 'bullist', 'numlist', 'separator2', 'link', 'unlink', 'separator3', 'styleprops', 'separator4', 'wp_more', 'wp_page', 'separator5', 'spellchecker', 'search', 'separator6', 'fullscreen' ), 
					'toolbar_2' => array( 'formatselect', 'styleselect', 'pastetext', 'pasteword', 'removeformat', 'separator7', 'charmap', 'print', 'separator8', 'undo', 'redo', 'attribs', 'wp_help', 'wp_adv' ), 
					'toolbar_3' => array( 'tablecontrols' ), 
					'toolbar_4' => array() 
				);
				
				$tadv_btns1 = array( 'bold', 'italic', 'separator', 'bullist', 'numlist', 'separator', 'link', 'unlink', 'separator', 'styleprops', 'separator', 'wp_more', 'wp_page', 'separator', 'spellchecker', 'search', 'separator', 'fullscreen' );
				$tadv_btns2 = array( 'formatselect', 'styleselect', 'pastetext', 'pasteword', 'removeformat', 'separator', 'charmap', 'print', 'separator', 'undo', 'redo', 'attribs', 'wp_help', 'wp_adv' );
				$tadv_btns3 = array( 'tablecontrols' );
				$tadv_btns4 = array();
				
				$tadv_allbtns = array( 'wp_adv', 'bold', 'italic', 'strikethrough', 'underline', 'bullist', 'numlist', 'outdent', 'indent', 'justifyleft', 'justifycenter', 'justifyright', 'justifyfull', 'cut', 'copy', 'paste', 'link', 'unlink', 'image', 'wp_more', 'wp_page', 'search', 'replace', 'fontselect', 'fontsizeselect', 'wp_help', 'fullscreen', 'styleselect', 'formatselect', 'forecolor', 'backcolor', 'pastetext', 'pasteword', 'removeformat', 'cleanup', 'spellchecker', 'charmap', 'print', 'undo', 'redo', 'tablecontrols', 'cite', 'ins', 'del', 'abbr', 'acronym', 'attribs', 'layer', 'advhr', 'code', 'visualchars', 'nonbreaking', 'sub', 'sup', 'visualaid', 'insertdate', 'inserttime', 'anchor', 'styleprops', 'emotions', 'media', 'blockquote', 'separator', '|' );
				
				update_option('tadv_options',$tadv_options);
				update_option('tadv_toolbars',$tadv_toolbars);
				update_option('tadv_plugins',$tadv_plugins);
				update_option('tadv_btns1',$tadv_btns1);
				update_option('tadv_btns2',$tadv_btns2);
				update_option('tadv_btns3',$tadv_btns3);
				update_option('tadv_btns4',$tadv_btns4);
				update_option('tadv_allbtns',$tadv_allbtns);
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