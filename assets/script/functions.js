/*

	FUNCTIONS.JS (CORE)
	
	All the jQuery/JavaScript enchangements go here...
	
	------------------------------------------------------------------	
	
	FILE INFO
	
	Last update: 	06/07/2012
	Update by:		Derrik Wolthuis
	
	------------------------------------------------------------------
	
	INDEX
	
	1.	TEMPLATE URL
	2.	WP GALLERY
	3.	SUPERFISH
	4.	PSEUDO CLASSES
	5.	TABLES
	6.	SEARCH
	7. 	HYPERLINKS
	8.	REL EXTERNAL
	
	------------------------------------------------------------------
	
*/

jQuery(document).ready(function($){

// 1. TEMPLATE URL IS DEFINED THROUGH A JQUERY CONSTANT (not really a constant but it's quite constant)
	
// 2. WP GALLERY

	/* 	the WordPress gallery needs a rel gallery class for fancybox 
		to open the images as a collection. the WordPress gallery
		also has some inline styles that need to be removed. */

	// add some class to the WordPress gallery for fancybox

	$('.gallery a').attr('rel', 'gallery');

	// remove attr style .gallery br

	$('.gallery br').removeAttr('style');

// 3. SUPERFISH

	/*	all of our websites use 'superfish' to display a dynamic 
		navigation. this is why it's in the core of our framework. */

	// see if there's a #mainnav ul.sf-menu, if true, then load superfish.js

	if($('#mainnav ul.sf-menu').length > 0) {

		$.getScript(templateurl+'/assets/script/superfish/supersubs.js', function() { });
		
	}

	if($('#mainnav ul.sf-menu').length > 0) {

		$.getScript(templateurl+'/assets/script/superfish/supersubs.js', function() {

			$.getScript(templateurl+'/assets/script/superfish/superfish.js', function() {

				$("#mainnav ul.sf-menu").supersubs({ 
		
					minWidth:    12,
					maxWidth:    27, 
					extraWidth:  1 
			
					}).superfish();
			
				});
				
		});
	
	}
// 4. PSEUDO CLASSES

	/*	add the right pseudo-classes to elements for styling purposes */

	$('#mainnav ul.sf-menu li:first-child').addClass('first-child');
	$('#mainnav ul.sf-menu li:last-child').addClass('last-child');

	$('#topnav li:first-child').addClass('first-child');
	$('#topnav li:last-child').addClass('last-child');

	$('#footernav li:first-child').addClass('first-child');
	$('#footernav li:last-child').addClass('last-child');

//	5. TABLES

	/*	add even and odd classes to the table for older browsers.
		also add a last-child class to the last row. */

	// if body has table

	if ($('body').has('table')) {

		// add even odd

		$('table tr:odd').addClass('odd');	
		$('table tr:even').addClass('even');
		
		$('section table tr td:last-child').addClass('last-child');

	}

// 6. SEARCH
	
	/*	clear the input[type="text"] on focus */
	
	$.fn.clearOnFocus = function(){

		return this.focus(function() {

			var v = $(this).val();
			
			$(this).val( v === this.defaultValue ? '' : v );

			}).blur(function(){

				var v = $(this).val();
				$(this).val( v.match(/^\s+$|^$/) ? this.defaultValue : v );

				});

			};
			
	$('div.search .search input').clearOnFocus();
	$('.hide_label').clearOnFocus();


//	7. HYPERLINKS

	/*	open all the rel="external" links in a new tab. */

	$('a[rel=external]').each(function(i){

		this.target='_blank';
		
	});
	
//	8. REL EXTERNAL

	/*	add a class to all the external links */

	$("a").filter(function() {

		return this.hostname && this.hostname !== location.hostname;

	}).addClass('external');

});