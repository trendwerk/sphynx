<?php 
/**
 * @menus Register Custom Menu's
 */
if (function_exists('register_nav_menu')) {
	register_nav_menu('mainnav',__('Main navigation','tp'));
	register_nav_menu('topnav',__('Top navigation','tp'));
	register_nav_menu('footernav',__('Footer navigation','tp'));
}