<?php
/**
 * Enables to use TP Plugins (see https://bitbucket.org/trendwerk/tp-plugins)
 *
 * Put your plugin (<name>/<name>.php) in <child-theme>/assets/plugins. 
 * Name it and let's go!
 */

class TPPlugins {
	var $plugins;
	
	function __construct() {
		$this->activate();
		
		add_action('admin_enqueue_scripts',array($this,'add_scripts'));
		add_action('views_plugins',array($this,'add_tab'));
		
		if(isset($_GET['plugin_status'])) :
			if($_GET['plugin_status'] == 'tp') :
				add_action('admin_head',array($this,'set_status'));
				add_filter('all_plugins',array($this,'show'));
				add_filter('plugin_action_links',array($this,'remove_actions'));
				add_filter('manage_plugins_columns',array($this,'remove_checkbox'));
				add_filter('bulk_actions-plugins',array($this,'remove_bulk'));
				add_filter('admin_body_class',array($this,'set_class'));
			endif;
		endif;
	}
	
	/**
	 * Add scripts
	 */
	function add_scripts() {
		wp_enqueue_script('tp-plugins',get_template_directory_uri().'/assets/js/TPPlugins/TPPlugins.js');
		
		$theme = wp_get_theme();		
		wp_localize_script('tp-plugins','TPPluginsL10n',array(
			'tp-plugins-explanation' => sprintf(__('Plugins in the %1$s folder are executed automatically.','tp'),'<code>'.$theme->get_stylesheet().'/assets/plugins/</code>')
		));
	}
	
	/**
	 * Set body class for futher jQuery adjustments
	 */
	function set_class($classes) {
		return $classes.' tp-plugins-current';
	}
	
	/**
	 * Set status to our status
	 */
	function set_status() {
		global $status,$totals;
		$status = 'tp';
		$totals = wp_parse_args($this->_totals,$totals);
	}
	
	/**
	 * Show our plugins instead of WP's
	 */
	function show($plugins) {
		//Save old totals
		$this->_totals = array('all' => 0,'active' => 0,'inactive' => 0);
		foreach($plugins as $file=>$plugin) :
			$this->_totals['all']++;
			if(is_plugin_active($file) || is_plugin_active_for_network($file)) :
				$this->_totals['active']++;
			else :
				$this->_totals['inactive']++;
			endif;
		endforeach;
	
		//Setup our plugins
		$plugins = array();
		if($this->plugins) :
			foreach($this->plugins as $plugin) :
				$plugins[$plugin] = get_plugin_data($plugin);
			endforeach;
		endif;
		
		return $plugins;
	}
	
	/**
	 * Remove actions
	 */
	function remove_actions($actions) {
		return;
	}
	
	/**
	 * Remove bulk
	 */
	function remove_bulk() {
		return array();
	}
	
	/**
	 * Remove checkboxes
	 */
	function remove_checkbox($columns) {
		$columns['cb'] = '';
				
		return $columns;
	}
	
	/**
	 * Add another tab to WordPress "Installed Plugins"
	 */
	function add_tab($views) {
		global $status;
		
		$class = ($status == 'tp') ? 'current' : '';
		
		$views['tp'] = '<a class="'.$class.'" href="'.admin_url('plugins.php?plugin_status=tp').'">'.__('TrendPress','tp').' <span class="count">('.count($this->plugins).')</span></a>';
		
		return $views;
	}
	
	/**
	 * Activate them plugins
	 */
	function activate() {
		if($this->plugins = $this->get_plugins()) :
			foreach($this->plugins as $plugin) :
				include_once($plugin);
			endforeach;
		endif;
	}
	
	/**
	 * Get plugins
	 */
	function get_plugins() {
		$folder = STYLESHEETPATH.'/assets/plugins/';
		if(is_dir($folder)) :
			foreach(scandir($folder) as $plugin) :
				if(substr($plugin,0,1) == '.') continue;
				
				$plugin = $folder.$plugin.'/'.$plugin.'.php';
				if(!is_readable($plugin)) continue;
				
				$plugins[] = $plugin;
			endforeach;
		endif;
		
		return $plugins;
	}
} new TPPlugins;
?>