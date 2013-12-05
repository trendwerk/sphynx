jQuery( function( $ ) {

	$( '#custom-post-types img.waiting' ).hide();
	
	$( 'input#submit-custom-post-type' ).click( function() {
		processMethod = wpNavMenu.addMenuItemToBottom;
		
		var post_types = $( 'input[name="custom-menu-item"]:checked' );
		
		$.each( post_types, function( index, value ) {
			var post_type = $( value ).val();
			
			var label = $( 'input[name="' + post_type + '-label"]' ).val();
			var url = $( 'input[name="' + post_type + '-url"]' ).val();

			$( '#custom-post-types img.waiting' ).show();
			wpNavMenu.addLinkToMenu( url, label, processMethod, function() {
				$( '#custom-post-types img.waiting' ).hide();
				$( value ).attr( 'checked', false );
			});
		});
				
	});

});