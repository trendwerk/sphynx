<?php
/**
 * This is the core of TrendPress.
 * The includes to all different added functionalities are done here.
 */

/**
 * @includes Include the following PHP files
 */
 
include('assets/inc/class.TPCapabilities.php');
include('assets/inc/class.TPCleanUp.php');
include('assets/inc/class.TPCPTExtras.php');
include('assets/inc/class.TPInformation.php');
include('assets/inc/class.TPJSConstants.php');
include('assets/inc/class.TPMobileNav.php');
include('assets/inc/class.TPNav.php');
include('assets/inc/class.TPRecommendedPlugins.php');
include('assets/inc/class.TPScripts.php');
include('assets/inc/class.TPSearch.php');
include('assets/inc/class.TPSidebar.php');
include('assets/inc/class.TPTaxonomyLink.php');

include('assets/inc/functions.breadcrumbs.php');
include('assets/inc/functions.pagination.php');
include('assets/inc/functions.php');

/**
 * @language Load the textdomain 'tp'
 */
load_theme_textdomain('tp',TEMPLATEPATH.'/assets/lang');

?>