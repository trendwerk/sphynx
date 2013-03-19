<?php

/**
 * @sidebars Register the sidebars
 */

function tp_register_sidebars() {
	tp_register_sidebar('home',array(
		'name' => __('Home','tp')
	));
	tp_register_sidebar('page',array(
		'name' => __('Page','tp')
	));
	tp_register_sidebar('blog',array(
		'name' => __('Blog','tp')
	));
	tp_register_sidebar('footerid',array(
		'name' => __('Footer','tp')
	));
}
add_action('init','tp_register_sidebars');

?>