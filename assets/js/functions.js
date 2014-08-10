jQuery( function( $ ) {

	/** 
	 * Fancybox
	 */
	$( 'a:has(img)' ).each( function() { 
		if( /(jpeg|jpg|png|gif|bmp)$/i.test( $( this ).prop( 'href' ) ) )
			$( this ).fancybox();
	} );

	$( '.gallery a' ).fancybox();
	
	/**
	 * Open rel="external" in new tab
	 */
	$( document ).on( 'click', 'a[rel*="external"]', function() {
		window.open( $( this ).prop( 'href' ) );
		return false;
	} );

} );