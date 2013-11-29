jQuery( function( $ ) {

	/**
	 * Tablet
	 */

	/**
	 * Sidebar should fall below the content
	 */
	if( window.innerWidth < 1080 )
		$( '#main .sidebar' ).insertAfter( '#main #content' );

	/**
	 * Mobile
	 */
	
	/**
	 * Toggle Navigation
	 */
	$( '.toggle-main-navigation, .toggle-search' ).click( function() {
		$( this ).toggleClass( 'active' );
		$( $( this ).data( 'toggle' ) ).slideToggle( 'fast' );
	} );

	$( '.toggle-search' ).click( function() {
		$( $( this ).data( 'toggle' ) ).find( 'input[type="text"]' ).focus();
	} );
	
} );