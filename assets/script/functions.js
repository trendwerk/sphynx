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
						
	// 1. TEMPLATE URL IS DEFINED THROUGH A JQUERY CONSTANT (not really a constant but it's quite constant)
	
	$.getScript(templateurl+'/assets/script/functions.js');	    
	
	//	2. RESPONSIVE
	
	/*	see if the body class is g960... if so, then turn our
		main navigation in a select list if on small screen
		widths. also remove some base width and height image
		settings for fluid images. */
		
	if($('body').hasClass('g1140')) {
	
		// load tinynav.js, it turns the main nav into a <select> for mobile purposes
	
		$(function () {
	
			$.getScript(templateurl+'/assets/script/tinynav/tinynav.min.js', function() { $("ul.sf-menu").tinyNav({active: 'selected'});});	    
	
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
		
	var thumbnails = jQuery('a:has(img)').filter( function() { 
				
		$("a[href$='.jpg'],a[href$='.png'],a[href$='.gif'],a[href$='.bmp']").addClass('links-to-image');
		
		return /(jpeg|png|gif|bmp)$/i.test(jQuery(this).addClass('has-image'));
			
	}); 
	
	$('a:has(img)').each(function () {
	
	  var element = $(this);
	  
	  if( element.is('.has-image') && element.is('.links-to-image') ) {
	  	 
	  	 element.addClass('fancybox');
	  
	  }
	  
	});
					
	if($('a.fancybox').length > 0) {
	
		$.getScript(templateurl+'/assets/script/fancybox/jquery.fancybox.js', function() {
		
			$('a.fancybox').fancybox();
			
		    jQuery.getCSS = function( url, media ) {
		            jQuery( document.createElement('link') ).attr({
		                    href: templateurl+'/assets/script/fancybox/jquery.fancybox.css',
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
	
		$.getScript(templateurl+'/assets/script/cycle/cycle.all.js', function() {
	
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
	
	
});