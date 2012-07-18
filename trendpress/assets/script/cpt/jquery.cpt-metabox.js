jQuery(document).ready(function($) {
	$('input#submit-custom-post-type').click(function() {
	
		//Bepaal de parameters
		processMethod = wpNavMenu.addMenuItemToBottom;
		
		var cpt = $('input[name="custom-menu-item"]:checked');
		
		$.each(cpt,function(index,value) {
			var posttype = $(value).val();
			
			var label = $('input[name="'+posttype+'-label"]').val();
			var url = $('input[name="'+posttype+'-url"]').val();

			$('#custom-post-types img.waiting').show();
			wpNavMenu.addLinkToMenu( url, label, processMethod, function() {
				// Remove the ajax spinner
				$('#custom-post-types img.waiting').hide();
				
				$(value).attr('checked',false);
			});
		});
				
	});
});