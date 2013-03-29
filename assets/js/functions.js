jQuery(document).ready(function($){

	/**
	 * @parent-theme-functions Load the functions.js from the TrendPress parent theme
	 */
							
	$.getScript(templateurl+'/assets/js/functions.js');	    
		
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
	 * @repsonsive Place sidebars after content for responsive design purposes
	 */
	
	var bodyWidth = window.innerWidth;
		
	if (window.innerWidth < 1000 ) {
				
		$('#main .sidebar').insertAfter('#main #content');
		
		$('.widget:even').addClass('clear');

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
						
});