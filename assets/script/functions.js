/*

	FUNCTIONS.JS (CHILD)
	
	All the jQuery/JavaScript enchangements go here...
	
	------------------------------------------------------------------	
	
	FILE INFO
	
	Last update: 	06/07/2012
	Update by:		Derrik Wolthuis
	
	------------------------------------------------------------------
	
	INDEX
	
	1.	TEMPLATE URL
	2.	RESPONSIVE
	3.	FANCYBOX
	4.	CYCLE
	5.	MODERNIZR
		
	------------------------------------------------------------------
	
*/

jQuery(document).ready(function($){
						
	// 1. TEMPLATE URL
	
	/*	we need a relative path to the template files. */
	
	var tp_template_url = $('div#templateurl').html();
	
	$.getScript(tp_template_url+'/assets/script/functions.js');	    
	
	//	2. RESPONSIVE
	
	/*	see if the body class is g960... if so, then turn our
		main navigation in a select list if on small screen
		widths. also remove some base width and height image
		settings for fluid images. */
		
	if($('body').hasClass('g1140')) {
	
		// load tinynav.js, it turns the main nav into a <select> for mobile purposes
	
		$(function () {
	
			$.getScript(tp_template_url+'/assets/script/tinynav/tinynav.min.js', function() { $("ul#hoofdnavigatie").tinyNav({active: 'selected'});});	    
	
		});
	
		// remove element height and width for responsiveness
			
		$(window).load(function() {
	
			$('.wp-caption').removeAttr('style');
	
			var pic = $('img');
	
				pic.removeAttr('width'); 
				pic.removeAttr('height');
	
		});
	
	}
	
	// 3. FANCYBOX
	
	// if there's a a.fancybox, then get the fancybox script
		
	var thumbnails = jQuery("a:has(img)").filter( function() { return /(jpe?g|png|gif|bmp)$/i.test(jQuery(this).addClass('fancybox')) });
				
	if($('a.fancybox').length > 0) {
	
		$.getScript(tp_template_url+'/assets/script/fancybox/jquery.fancybox.js', function() {
		
			$('a.fancybox').fancybox();
			
		    jQuery.getCSS = function( url, media ) {
		            jQuery( document.createElement('link') ).attr({
		                    href: tp_template_url+'/assets/script/fancybox/jquery.fancybox.css',
		                    media: media || 'screen',
		                    type: 'text/css',
		                    rel: 'stylesheet'
		            }).appendTo('head');
		    };
				
		    $.getCSS();
	
		});	
		
	}
			
	// 4. CYCLE 
	
	/* 	see if there's an #cycle-slider. if true, then load
		cycle.js and add a progressie enhancement navigation
		and pagination */
		
	if($('#cycle-slider').length > 0) {
	
		$.getScript(tp_template_url+'/assets/script/cycle/cycle.all.js', function() {
	
			$('#cycle-slider').cycle({
	
				fx: 'scrollHorz', 
				speed: 'fast', 
				timeout: 7000,
				pager: '#cycle-pager-inner',
				prev: '#prev', 
				next: '#next'
	
			});
	
		});	
	
		$('div#cycle-slider').after('<div id="cyle-nav"><a id="prev" href="#">Vorige</a><a id="next" href="#">Volgende</a></div>');
		$('div#cycle-slider').after('<div id="cycle-pager"><div id="cycle-pager-inner">');
	
	}
	
	//	5. MODERNIZR
	
	/*	load a default modernizr polyfill for respond.min.js 
		we need this for responsive sites on old internet 
		explorer browsers */
	
	Modernizr.load({
	
		test: Modernizr.mq('only all and (max-width: 400px)'),
		yep : '',
		nope: tp_template_url+'/assets/script/respond/respond.min.js'
	  
	});	

});