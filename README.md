TrendPress
==========

A WordPress framework to create awesome websites

SUMMARY
-------

	Introduction
	1. Structure

INTRODUCTION
------------

TrendPress is a simple and elegant WordPress theme framework. TrendPress was developed by Trendwerk, a Dutch web design company in order to speed up their work process. 

You are currently reading the 'readme.md' for the parent theme. There's a child theme available as well. It's called 'trendpress-child'. 'trendpress' (the parent theme) contains a lot of best practices, improvements and other scripts wich help us to speed up the workprocess.


1. STRUCTURE
------------

The main folder contains the usual files and settings that WordPress needs for a parent/child theme structure to work.

There's an index.php file, which is empty. A screenshot.png to spice up the theme folder in the WordPress back-end, a style.css file with a few credits and such this a functions.php with a few includes and language settings and last but not least this 'readme.md' file. 

Most of the action happens in the assets folder. So let's talk about that.

ASSETS
------

	CSS 
	---
	Contains: All the core CSS files. These files are included using @imports in the child theme's main CSS file.

		ADMIN.CSS
		---------
		Contains: A few CSS rules to improve the lay-out of our theme options in the WordPress back-end. Nothing exiting here.

		FORMS.CSS
		---------
		Contains: A customized version of the amazing formalize (http://www.formalize.me) CSS framework. Formalize gives us forms a uniform looking and crossbrowser compatible forms, which is great. There's also a modified version of the Gravity Forms plug-in stylesheet (Trendwerk endorses Gravity Forms).

		GRID.CSS
		--------
		Contains: Some basic CSS grid settings. There's a static 960 pixel grid (some clients just don't want a responsive design) and there's a fluid/responsive 1140 pixel grid. Both grids use 12 collumns. These grids correspond with a single body class and a few element classes. Use g960 in the child theme to use the static grid and g1140 to use the fluid grid. 

		Don't worry though. These are some quite basic settings... no 'two-collumn last left bottom' mumbo jumbo. You decide whether to use them or not. If you decide against it, just remove the @import from the stylesheet and remove the element classes.

		MISC.CSS
		--------
		Contains: Quite a few things... Namely:

		1. CSS classes that we use in the development stage of the website. Things like '.clear', '.remove', '.hide' and '.border'. I guess you can figure out by yourself what these classes do exactly.
		
		2. Some CSS rules for the Suckerfish / Superfish navigation *.
		
		3. Some CSS rules for the custom TrendPress page navigation system *.

		4. Styles for the WordPress WYSWYG editor and widgets. There's a basic style for the WordPress image gallery, WYSIWYG blockquote's, the calendar widget, RSS widget.

		5. Styles for the TrendPress custom widgets. The TrendPress child theme enables the use of a 'Social media' and a 'Contact informatio' widget, which gives users the possibility to fill in links to their social media accounts in the WordPress back-end and then use these widgets.

		PRINT.CSS
		---------

		A print stylesheed based upon the excellent boilerplate stylesheet. That's all. Head on over to http://html5boilerplate.com/ to find out more about this stylesheet

		RESET.CSS
		---------

		A basic HTML5 reset stylesheet based upon the work of Eric Meyer. Find out more about this stylesheet at the HTML5 Doctor website: 

		* - More on that later...