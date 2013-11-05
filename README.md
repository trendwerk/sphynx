# TrendPress / Trendpress Child
__Documentation version 1.__

Welcome, you are currently viewing the TrendPress documentation. TrendPress is a WordPress framework of sorts. There's a parent theme (TrendPress) that contains a lot of useful scripts and settings ensuring a solid workflow and quick development. Then there's a child theme (TrendPress Child) with minimal styling. You should use the child theme to develop the actual website.

* TrendPress can be found here: [https://github.com/trendwerk/trendpress](https://github.com/trendwerk/trendpress).
* TrendPress Child can be found here: [https://github.com/trendwerk/trendpress-child](https://github.com/trendwerk/trendpress-child).

# 1. Installation:

Installation is easy enough. Download both theme's, and upload them to your wp-content/themes folder. Then give the child theme an appropriate name, change the style.css and activate in the WordPress back-end and you are ready to go. 

# 2. TrendPress features

TrendPress has a lot of interesting features. First of all there's a lot of CSS presets to help you on your way. Most of the stylesheets are reset stylesheets that define a basic style for the most common website elements. 

##2.1 - CSS##

###Admin.css###
Just some basic styles for the TrendPress back-end features. Nothing more, nothing less.

###Forms.css###

Developing cross browser compatible forms can be a pain in the you know what. That's why we use [Formalize](http://formalize.me/). for all of our forms. We've also included some CSS for our favourite WordPress form plug-in [Gravity Forms](http://www.gravityforms.com/). Feel free to change this file to suit your personal needs.

###Grid.css###

This stylesheet contains two different grid systems. One is based upon the classic 960 pixel grid. The others is a more progressive 1140 pixel responsive grid. Both grid systems use twelve lay-out collumns. It's easy to switch, just change the body class in child theme's `header.php` file.

**Example:**

The body class **g1140** `<?php body_class('g1140'); ?>` gives you the ability to use the fluid grid. If you want to use the static grid, just change it to **g960** `<?php body_class('g960'); ?>`.

We tried to use common naming conventions for the class names. From `onecol` all the way to `twelvecol`. There's no need for `last` classes to clear floats. All the elements get the same margins left and right. 

**Example:**

The following code gives a basic blog like lay-out with a sidebar:

~~~
<section id="blog" class="container">

    <article class="eightcol">
    </article>
    
    <aside class="fourcol">
    </aside>

</div>
~~~

###Misc.css###

This stylesheet contains miscellaneous CSS rules:

* Basic classes for development, like: `mute`, `remove`, `clear`, `hide` and `border`.
* Styles for the [Suckerfish](http://www.htmldog.com/articles/suckerfish/dropdowns/) / [Superfish](http://users.tpg.com.au/j_birch/plugins/superfish/) navigation.
* Style for the TrendPress pagination script.
* Styles for WordPress stuff, like the gallery, blockquotes and widgets.
* Styles for the TrendPress contact and social media widget.

###Print.css###

A stylesheet based upon the excellent [Boilerplate](http://html5boilerplate.com/) print stylesheet.

###Reset.css###

The [HTML5 doctor](http://html5doctor.com/html-5-reset-stylesheet/) reset stylesheet. This stylesheet eliminates browser differences. Head on over to the official website to find out more.

###Table.css###

Styles for the tables. Makes them look just a little bit nicer. That's all!

###Typography###

Basic styles for the typography.

##2.2 - Images##

Lets keep this short. This folder contains:

* Fancybox images (like a previous, next and close button).
* Favicon images (basic desktop version and an Apple Touch Icon).
* Formalize images (a button and select arrow).
* Some dummy images for the UI slider plug-in.
* Social media images the most common services. This folder contains both 32x32 and 16x16 versions.
* Images for the Suckerfish/Superfish navigation enhancement. 
 
##2.3 - Includes

This is where things get interesting. The includes folder contains all sorts of little WordPress improvements and new functions that help speed up the developing process. All these files are included in the TrendPress parent theme's `function.php`. 


###Class.TPNav.php, widget.submenu.php and functions.breadcrumbs.php

The file class.TPNav.php contains a class for interpreting the 
WordPress Custom Menu in a way that it can be used in submenu's, breadcrumbs and highlighting the right current menu item. 

The widget.submenu.php is a widget that shows the sub-menu items of a current page as widget. 

Functions.breadcrumbs.php is a functions for displaying the breadcrumbs of the current menu item. It uses class.TPNav.php for this.

You can show the breadcrumbs by including the following script:

`<?php tp_breadcrumbs(); ?>`

This gives you something like  _You are here: Home > Example page_.

Don't like the '>' separator? You can easily change it by adding your own. 

Like this: `<?php tp_breadcrumbs('-'); ?>`.
	
###Class.TPPlugins.php

This class inserts a settings screen to the "Plugins" admin menu. It shows some recommended and optional plugins you can immediately download, activate and apply settings to it. 

###Deprecated.php

A file where we'll stack all the deprecated functions in the future.

###Functions.clean-up.php

This file removes:

* Some unnecessary thing in `<?php wp_head(); ?>`. Namely: wp_generator and some rel links.
* A lot of inline style (for example the gallery styles and recent comments style). You should never use inline style!

###Functions.custom-excerpt-length.php

This function gives us the possibility to define our custom excerpt width. It's easy to use. 

Just add: `<?php tp_the_excerpt(40); ?>`. Note 40 is the number of words used in this excerpt. If you leave this empty it uses the default number of 55 words. 

If you want to use something other than the ellipsis then use the following code: `<?php tp_the_excerpt(40, 'Whatever'); ?>`.

###Functions.custom-post-type.php

This file contains some functions that support custom post types. Adds a meta box to Custom Menu's, so you can add post type archives easily. Also sets the right menu item to an active state.

###Functions.debug.php

A debug functions for developers.

Just use `<?php dbg(); ?>` to show possible errors and messages for debugging purposes.

###Functions.js-constants.php

Declares some constants that you can use in your JavaScript files. These variables come in handy because you can use them instead of static URLS. Static URL'S are bad.

* `var siteurl` - Gives you the `<?php echo site_url(); ?>`.
* `var templateurl` - Gives you the `<?php echo get_template_directory_uri(); ?>`.
* `var ajaxurl` - Gives you the `<?php echo admin_url('admin-ajax.php'); ?>`.
* `var stylesheeturl` - Gives you the `<?php echo get_stylesheet_directory_uri(); ?>`

###Functions.pagination.php

Adds pagination to WordPress archive templates. It basically builds the same functionality as the [WP-Pagenavi](http://wordpress.org/extend/plugins/wp-pagenavi/).

###Functions.search.php

This function highlight search results in titles, excerpts and content. They get wrapped in a `<span class="search-highlight">...</span>`.

###Functions.theme-options.php

Builds a page in the back-end where users can fill in their address information and social media links so they can be used in a widget that is located in the child theme.

##2.4 - Languages

Contains language files. There's a Dutch .MO and .PO file. And two empty ones. Feel free to make you own translations!

##2.5 - Script

The scripts folder contains a lot jQuery scripts. Most of them are used within the framework. 

__[Cookie](https://github.com/carhartl/jquery-cookie#jquerycookie):__
A simple, lightweight jQuery plugin for reading, writing and deleting cookies 

__[Cycle](http://jquery.malsup.com/cycle/)__: The excellent Cycle slideshow jQuery script. Makes implementing slideshows very easy. 

__[Fancybox](http://fancyapps.com/fancybox/):__ FancyBox is a tool that offers a nice and elegant way to add zooming functionality for images, html content and multi-media on your webpages. It is built at the top of the popular JavaScript framework jQuery and is both easy to implement and a snap to customize. 

__[Modernizr](http://modernizr.com/):__ 
Modernizr is a JavaScript library that detects HTML5 and CSS3 features in the user’s browser. This folder contains two Modernizr scripts. One for development (with all the feature detections) called `modernizr.dev.js` and one with only the necessary Shiv and Modernizr Load. called `modernizr.lite.js`

__[PIE](http://css3pie.com/):__
PIE makes Internet Explorer 6-9 capable of rendering several of the most useful CSS3 decoration features". This folder contains the usual PIE includes. 

__[Respond](https://github.com/scottjehl/Respond#respondjs):__ A fast & lightweight polyfill for min/max-width CSS3 Media Queries (for IE 6-8, and more).

__[Superfish](http://users.tpg.com.au/j_birch/plugins/superfish/):__ Superfish is an enhanced Suckerfish-style menu jQuery plugin that takes an existing pure CSS drop-down menu (so it degrades gracefully without JavaScript) and adds the following much-sought-after enhancements

__[Tinynav](http://tinynav.viljamis.com/)__: TinyNav.js is a tiny jQuery plugin that converts `<ul>` and `<ol>` navigations to a select dropdowns for small screen. It also automatically selects the current page and adds `selected="selected` for that item. 

##Functions.js

This script does a couple of things:

* Removes inline style in the WordPress gallery function.
* Gives the main navigation Superfish powers.
* Set some pseudo-classes on the navigation elements for styling purposes. The first list item gets a `.first-child` class and the last list items gets a `.last-child` class. It's a fallback for Internet Explorer 7.
* Adds `.even` and `.odd` classes to the table row for styling purposes.
* Lets you use the class `.hide_label` on input fields to hide values on focus.
* Makes links with `rel="external"` open up in a new browser tab and adds the class `external`.

#3. Child theme

Basically, the child theme contains a lot of common WordPress files. So instead explaining all these common files (and wasting your time) we're going to talk about the not-so-normal files.

##3.1 Page.sitemap.php
This page template filters through all the post types (that's custom post-types as well) and puts them in a `<ul>` with multiple levels. 

##3.2 Functions.php

A summary of what happens in this file.

* The registering of sidebars (home, page, blog and footer).
* We register a few menu's (main navigation, top navigation and footer navigation).
* We dynamically include some JavaScript: A CDN version of jQuery and Modernizr.
* We set the language path.
* We tell WordPress to use thumbnails for posts.
* There's a social media widget and a contact information widget.
* We add some editor styles (like a 'call to action" button).

##3.3 Functions.js

In this file we...

* See if the body class is g960... if so, then turn our main navigation in a select list if on small screen widths. also remove some base width and height image settings for fluid images.
* We load tinynav. A plugin that turns the main navigation in a select at small viewports.
* We remove the height and width of images if the body class is g1140.
* We load the fancybox script. There's a check function that checks if links contain an image, and if the link links to and image. Then we let fancybox open these links.
* Next we see if there's an #cycle-slider. if true, then load cycle.js and add a progressive enhancement navigation and pagination */

