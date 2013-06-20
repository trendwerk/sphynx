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
	
	$('.fancybox').fancybox({

		
	});

	/**
	 * @equal Heights and widths
	 */
	var greatestWidth = 0;

	$('#mainnav ul li li a').each(function() {
		var theWidth = $(this).width();
		if( theWidth > greatestWidth) {
		    greatestWidth = theWidth;
		}
	});
	
	$('#mainnav ul li li a').width(greatestWidth); 
	
	/** 
	 * @misc
	 */
	$('p').has('img').addClass('has-img');		
	
	$('#content article:last').addClass('last-child');
	
	/*
     * @misc Replace all SVG images with inline SVG
     */
    jQuery('img.svg').each(function(){
        var $img = jQuery(this);
        var imgID = $img.attr('id');
        var imgClass = $img.attr('class');
        var imgURL = $img.attr('src');

        jQuery.get(imgURL, function(data) {
            var $svg = jQuery(data).find('svg');
            if(typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            if(typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass+' replaced-svg');
            }
            $svg = $svg.removeAttr('xmlns:a');
            $img.replaceWith($svg);
        });
    });
});