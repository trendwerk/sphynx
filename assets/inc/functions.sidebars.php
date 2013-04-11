<?php

/**
 * @sidebars Register the sidebars
 */

function tp_register_sidebars() {
	new TPSidebar('home',array(
		'name' => __('Home','tp')
	));
	new TPSidebar('page',array(
		'name' => __('Page','tp')
	));
	new TPSidebar('blog',array(
		'name' => __('Blog','tp')
	));
	new TPSidebar('footerid',array(
		'name' => __('Footer','tp')
	));
}
add_action('init','tp_register_sidebars');
?>