jQuery(document).ready(function($){  

	/** 
	 * Re-order sidebars responsive site
	 */
	var bodyWidth = window.innerWidth;
		
	if (window.innerWidth < 1000 ) {
				
		$('#main .sidebar').insertAfter('#main #content');
		
	}
						
	/** 
	 * Fancybox
	 */		
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
	
	$('.fancybox').fancybox();
	


	/**
	 * Toggle Navigation
	 */
	$('.toggle-main-navigation, .toggle-search').click(function() {
		$(this).toggleClass('active');
	});

	$('.toggle-main-navigation').click(function() {
		$('#main-navigation').slideToggle('fast');
	});

	$('.toggle-search').click(function() {
		$('#header #search').slideToggle('fast');
	});
    
});