jQuery( function( $ ) {

	/**
	 * Tablet
	 */

	/**
	 * Sidebar should fall below the content
	 */
	if( window.innerWidth < 980 )
		$( '#main .sidebar' ).insertAfter( '#main #content' );

	/**
	 * Mobile
	 */
	
	/**
	 * Toggle Navigation
	 */
 	$( '#mobile-navigation, #mobile-search' ).click( function() {

		$( $( this ).data( 'toggle' ) ).slideToggle( 'fast', function() {
			if( ! $( this ).is( ':visible' ) )
				$( this ).css( 'display', '' );
		} );
		
 	} );
 
 	$( '#mobile-search' ).click( function() {
		$( $( this ).data( 'toggle' ) ).find( 'input[type="text"]' ).focus();
	} );	

} );