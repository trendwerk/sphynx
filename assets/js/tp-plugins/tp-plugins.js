jQuery( function( $ ) {

	/**
	 * Adjust plugins table when visiting 'TrendPress' plugins
	 */
	if( 0 < $( 'body.tp-plugins-current' ).length ) {

		$( '.tablenav .alignleft.actions' ).first().html( '<p>' + TPPluginsL10n['tp-plugins-explanation'] + '</p>' ).css( 'margin-left', '10px' );
		$( 'table.plugins #the-list' ).find( '.inactive' ).removeClass( 'inactive' ).addClass( 'active' );
		$( 'table.plugins #the-list .check-column' ).html( '' );

	}

} );