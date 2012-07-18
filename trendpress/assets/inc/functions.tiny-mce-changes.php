<?php
/**
 * Edit the WYSIWYG editor so we don't have to use TinyMCE Advanced
 */

add_editor_style();

/**
 * Add tables to the used TinyMCE plugins
 *
 * @param array $plugin_array
 */
function tp_plugins_tiny_MCE($plugin_array) {
   $plugin_array = array('table' => get_bloginfo('template_url').'/assets/script/tinymce/plugins/table/editor_plugin.js');
   return $plugin_array;
}
add_filter('mce_external_plugins','tp_plugins_tiny_MCE');

/**
 * Modifies used items in the editor
 *
 * @param array $rows
 */
function tp_remove_basic_tiny_MCE($rows) {
	//First row
	$rows['theme_advanced_buttons1'] = 'formatselect, styleselect, separator, bold, italic, underline, strikethrough, separator, bullist, numlist, separator, blockquote, hr, charmap, separator, link, unlink, media, separator, wp_more, wp_page';
	
	//Second row
	$rows['theme_advanced_buttons2'] = 'cut, copy, paste, removeformat, separator, undo, redo, separator, tablecontrols, separator, help';
	
	//Remove h1, pre, address from the format select
	$rows['theme_advanced_blockformats'] = 'p, h2, h3, h4, h5';
	
	//Add custom styles to tinyMCE
	$rows['theme_advanced_styles'] = 'Button=cta';
	
	//Add table plugin
	$rows['plugins'] = 'table, media, wordpress';
		
	return $rows;
}
add_filter('tiny_mce_before_init','tp_remove_basic_tiny_MCE');
?>
