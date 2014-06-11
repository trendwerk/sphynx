# TrendPress
**Documentation version 2.0**

TrendPress is a WordPress framework. There’s a parent theme (TrendPress) that contains a lot of useful scripts and settings, ensuring a solid workflow and quick development of your WordPress theme. Then there’s a child theme (TrendPress Child) with minimal styling. Use this theme to develop your bespoke WordPress theme.

##Downloads

+ [TrendPress](https://github.com/trendwerk/trendpress)
+ [TrendPress](https://github.com/trendwerk/trendpress-child)

***

##Function reference

##tp_breadcrumbs

`tp_breadcrumbs( separator, menu )` 

Shows the breadcrumbs. 

+ Separator (string) - Sets the character between the page titles. Default `’>’`.
+ Menu (string) - Sets the menu which will be used. Default `mainnav`.

###tp_the_excerpt

`tp_the_excerpt( length, more, content )` 

This function builds a custom excerpt and is located within the parent theme.

+ Length (number) - Sets the number of words used within the excerpt. Default is ’55’ words.
+ More (string) - Sets the custom character(s) after the excerpt. Default is an `&hellip;`.
+ Content (string) - Sets the custom content which you might want to use. Default is empty and uses the regular content.

###tp_pagination

This function builds an pagination for archive pages. 

`tp_pagination(page, pages, range, gap, anchor, before, after, title, nextpage, previouspage, echo)`

+ Page - 
+ Pages - 
+ Range - 
+ Gap - 
+ Anchor - 
+ Before - 
+ After - 
+ Title (string) - Sets the title for the navigation. Default `__( ‘Pagination’, ‘tp’ )`
+ Nextpage (string) - Sets the title for the next page link. Default `__( ‘Next’, ‘tp’ )`
+ Previouspage (string) - Sets the title for the previous page link. Default `__( ‘Previous’, ‘tp’ )`
+ Echo - 

***

##Actions and filters

###tp_enqueue_scripts

This function enqueues scripts that get registered within the parent theme and is located in  `functions.php `.

It also enqueues custom JavaScript files `functions.js`, `responsive.js` and the main Less file `style.less`. We also de-register the default jQuery and add a CDN version, which is likely to already exist within the cache of the user.

###tp_admin_enqueue_scripts

Is also located in  `functions.php ` and enqueues TrendPress scripts used back-end.

###tp_register_sidebars

`tp_register_sidebar()` can be located in `assets/inc/sidebars.php` and registers four sidebars used within the child theme. Widgets in the footer sidebar get a `threecol` class for styling purposes. See [Function Reference/register sidebar](http://codex.wordpress.org/Function_Reference/register_sidebar) for more information.

###tp_register_post_types 

`tp_register_post_types()` can be found in `assets/inc/post-types.php` and adds theme support for post thumbnails and removes support for thumbnails on the pages. 

This is also the place where you want to add your custom image sizes.

###tp_add_editor_styles

`tp_add_editor_styles` lets you build custom styles for your WYSWYG editor, which are automatically included. Use an array to define the title, selector type and class. See [Function Reference/add editor style](http://codex.wordpress.org/Function_Reference/add_editor_style) for more information.

###tp_set_image_sizes
Updates the sizes of basic WordPress image sizes (thumbnail, medium and large).

###tp_modify_profile
Removes AIM, YIM and Jabber and adds Facebook, LinkedIn, Google Plus and Twitter on author profile pages.

***

##Mixins

Note: all these mixing are located in `assets/less/mixins.less `

###Animate this

Lets you animate elements with CSS animations. `animate-this(@what: all, @time: 0.5s, @ease: ease-in-out)` 

+ What - Choose which properties you want to animate. Default: ‘All’
+ Time - Sets the speed of the animation in seconds. Default ‘0.5s’
+ Ease - Sets the easing of the animation. Default ‘ease-in-out’

###Border-radius

Sets the allround border-radius of an element with vendor pre-fixes. `.border-radius (@radius)`

+ Radius - Specifies the border-radius size. Default: empty.

###Border-radiuses

Sets the  border-radius of an element with vendor pre-fixes on all the corners from top right to top left. `.border-radiuses (@topright, @bottomright, @bottomleft, @topleft)`.

##Changelog

