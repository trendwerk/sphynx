jQuery(document).ready(function($){
	
	/**
	 * @gallery Remove unnecessary style, add rel gallery for fancybox plug-in
	 */
	 
	$('.gallery a').attr('rel', 'gallery');
	$('.gallery br').removeAttr('style');
	
	/**
	 * @pseudo-classes Add pseudo-class classes
	 */
	 
	$('#mainnav ul.sf-menu li:first-child').addClass('first-child');
	$('#mainnav ul.sf-menu li:last-child').addClass('last-child');

	$('#topnav li:first-child').addClass('first-child');
	$('#topnav li:last-child').addClass('last-child');

	$('#footernav li:first-child').addClass('first-child');
	$('#footernav li:last-child').addClass('last-child');

	$('.widget').filter(':even').addClass('even');
	$('.widget').filter(':odd').addClass('odd');

	/**
	 * @zebra-tables
	 */
	 
	if ($('body').has('table')) {
		$('table tr:odd').addClass('odd');	
		$('table tr:even').addClass('even');
		$('section table tr td:last-child').addClass('last-child');
	};

	/**
	 * @external-links Add class external to external links and open rel="external" in a new tab
	 */
	 
	$('a').filter(function() {
		return this.hostname && this.hostname !== location.hostname;
	}).addClass('external');
	$('a[rel=external]').each(function(i){
		this.target='_blank';
	});
	
	/**
	 * @browser-detection Adds the current browser, OS and render-engine to body class
	 */
	 
	$.each($.browser, function(i) {
	    $('body').addClass(i);
	    return false;  
	});
	var os = ['iphone', 'ipad', 'windows', 'mac', 'linux'];
	var match = navigator.appVersion.toLowerCase().match(new RegExp(os.join('|')));
	if (match) {
	    $('body').addClass(match[0]);
	};

});