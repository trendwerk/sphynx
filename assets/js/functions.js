jQuery( function( $ ) {

	/** 
	 * Fancybox
	 */
	$( 'a:has(img)' ).each( function() { 
		if( /(jpeg|jpg|png|gif|bmp)$/i.test( $( this ).prop( 'href' ) ) )
			$( this ).fancybox();
	} );

	/**
	 * Open rel="external" in new tab
	 */
	$( 'a[rel*="external"]' ).click( function() {
		window.open( $( this ).prop( 'href' ) );
		return false;
	} );

} );