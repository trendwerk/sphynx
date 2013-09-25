<?php
/**
 * Parse LESS file(s) to CSS
 */

include_once('lib/lessphp/lessc.inc.php');

class TPLess {
	var $force = false;
	
	function __construct() {
		if($_SERVER['HTTP_HOST'] == 'localhost') $this->force = true;
		
		add_action('wp_enqueue_scripts',array($this,'init'),999999);
		add_action('admin_enqueue_scripts',array($this,'init'),999999);
	}
	
	/**
	 * Initialize
	 */
	function init() {
		global $wp_styles;
		
		if($wp_styles->registered) :
			foreach($wp_styles->registered as &$wp_style) :
				if($base = $this->is_less($wp_style)) :
					$file = str_replace(site_url().'/', ABSPATH, $wp_style->src);
					$new_file = str_replace('.less','.compiled.css',$file);
					
					$less = new lessc;
					
					do_action('tp-less-pre-compile',array(&$less));
					
					if($this->force) :
						$less->compileFile($file,$new_file);
					else :
						$less->checkedCompile($file,$new_file);	
					endif;
					
					$wp_style->src = str_replace(ABSPATH,site_url().'/',$new_file);
				endif;
			endforeach;
		endif;
	}
	
	/**
	 * Check if a wp_style is a LESS file
	 *
	 * @param object $wp_style
	 */
	function is_less($wp_style) {
		$info = pathinfo($wp_style->src);
		if(isset($info['extension']) && $info['extension'] == 'less') return true;
		
		return false;
	}
} new TPLess;
?>