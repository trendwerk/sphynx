jQuery(document).ready(function($){  
		
	/** 
	 * @responsive Remove the width and height added to images by WordPress for responsive design
	 */			
	$(window).load(function() {

		$('.wp-caption').removeAttr('style');

		var pic = $('img');

			pic.removeAttr('width'); 
			pic.removeAttr('height');

	});
	
	/** 
	 * @responsive place sidebars after content for responsive design purposes
	 */
	var bodyWidth = window.innerWidth;
		
	if (window.innerWidth < 1000 ) {
				
		$('#main .sidebar').insertAfter('#main #content');
		
	}
						
	/** 
	 * @fancybox
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
	 * @sfhover
	 */
	 
	$("#main-navigation li").mouseover(function() {
		$(this).addClass("hover");
	});
	$("#main-navigation li").mouseout(function() {
		$(this).removeClass("hover");
	});	
    
});