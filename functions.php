<?php
/**
 * This is the core of TrendPress.
 * The includes to all different added functionalities are done here.
 */

/**
 * @includes Include the following PHP files
 */
 
include('assets/inc/class.TPNav.php');
include('assets/inc/class.TPPlugins.php');
include('assets/inc/class.TPUserCaps.php');
include('assets/inc/class.TPTaxonomyLink.php');

include('assets/inc/functions.breadcrumbs.php');
include('assets/inc/functions.clean-up.php');
include('assets/inc/functions.custom-excerpt-length.php');
include('assets/inc/functions.custom-post-type.php');
include('assets/inc/functions.debug.php');
include('assets/inc/functions.js-constants.php');
include('assets/inc/functions.pagination.php');
include('assets/inc/functions.search.php');
include('assets/inc/functions.theme-options.php');

include('assets/inc/widget.submenu.php');

/**
 * @language Load the textdomain 'tp'
 */
load_theme_textdomain('tp',TEMPLATEPATH.'/assets/lang');

?>