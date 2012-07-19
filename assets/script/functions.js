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
	9. 	REMOVE LINKS
	
	------------------------------------------------------------------
	
*/

jQuery(document).ready(function($){

// 1. TEMPLATE URL

	/*	we need a relative path to the template files. */

var tp_template_url = $('div#templateurl').html();
	
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

	// see if there's a ul#hoofdnavigatie, if true, then load superfish.js

	if($('ul#hoofdnavigatie').length > 0) {

		$.getScript(tp_template_url+'/assets/script/superfish/supersubs.js', function() { });
		
	}

	if($('ul#hoofdnavigatie').length > 0) {

		$.getScript(tp_template_url+'/assets/script/superfish/supersubs.js', function() { });
		
		$.getScript(tp_template_url+'/assets/script/superfish/superfish.js', function() {
		
		$("ul#hoofdnavigatie").supersubs({ 
		
			minWidth:    12,
			maxWidth:    27, 
			extraWidth:  1 
		
		}).superfish();
		
		});
	
	}

// 4. PSEUDO CLASSES

	/*	add the right pseudo-classes to elements for styling purposes */

	$('ul#hoofdnavigatie li:first-child').addClass('first-child');
	$('ul#hoofdnavigatie li:last-child').addClass('last-child');

	$('ul#topmenu li:first-child').addClass('first-child');
	$('ul#topmenu li:last-child').addClass('last-child');

	$('ul#footernavigatie li:first-child').addClass('first-child');
	$('ul#footernavigatie li:last-child').addClass('last-child');

	$('div.sidebar.horizontal div.widget:last-child').addClass('last');

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
			
	$('.search input').clearOnFocus();

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
	
//	9. REMOVE LINKS

	/*	either use hyperlinks as widget titles, or
		don't. we did the lather. */
	
	var c = $('h3.widgettitle a').contents().unwrap();
	var d = $('.widget_rss h3 a').contents().unwrap();

});