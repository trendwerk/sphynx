( function( $ ){
	var TP_Redirects = function( el ) {
		var self = this;
		var waiting = false;
		var nothingFound = false;

		this.events = function() {
			$( el ).on( 'keyup', 'input#tp-redirects-search', function( event ) {
				var term = self.correct( $( this ).val() );
				if( term != $( this ).val() )
					$( this ).val( term );


				if( 13 == event.which && 0 < term.length )
					self.create( term );

				if( 2 < term.length )
					self.search( term );
				else if( 0 == term.length )
					self.search( '' );
			} );

			$( el ).on( 'click', '.tp-redirects-edit', function() {
				self.edit( $( this ).closest( 'tr' ).data( 'source' ) );
			} );

			$( el ).on( 'click', '.tp-redirects-edit-dismiss', function() {
				self.dismiss( $( this ).closest( 'tr' ).data( 'source' ) );
			} );
		}

		/**
		 * Search redirects for a term
		 */
		this.search = function( term ) {
			self.get( {
				type:   'search',
				term:   term
			} );
		}

		/**
		 * Correct search string
		 */
		this.correct = function( string ) {
			var corrected = string.replace( TP_Redirects_Labels['site_url'], '' );

			return corrected;
		}

		/**
		 * Get redirects HTML and show them
		 */
		this.get = function( data ) {
			if( self.waiting )
				return;

			self.waiting = true;
			data.action = 'tp_redirects_get';

			$.post( ajaxurl, data, function( response ) {
				self.parse( response );
			} );
		}

		/**
		 * Create a new redirect
		 */
		this.create = function( source ) {
			if( self.waiting )
				return;

			self.waiting = true;
			data =  {
				action: 'tp_redirects_create',
				source: source
			}

			$.post( ajaxurl, data, function( response ) {
				self.parse( response );
				self.edit( source, 'destination' );
			} );
		}

		/**
		 * Parse AJAX response
		 */
		this.parse = function( response ) {
			self.nothingFound = false;

			if( response.html ) {
				if( response.replace )
					$( el ).find( 'table.tp-redirects-table tbody' ).html( response.html );
				else
					$( el ).find( 'table.tp-redirects-table tbody' ).append( response.html );
			} else {
				$( el ).find( 'table.tp-redirects-table tbody' ).html( '<tr><td colspan="3">' + TP_Redirects_Labels['not_found'] + '</td></tr>' );
				self.nothingFound = true;
			}

			self.waiting = false;
		}

		/**
		 * Edit redirect
		 */
		this.edit = function( source, focus ) {
			var row = $( el ).find( 'tr[data-source="' + source + '"]');
			row.data( 'html-before', row.html() );

			row.addClass( 'editing' );

			row.find( 'td.source' ).html( '<input type="text" value="' + row.data( 'source' ) + '" class="widefat" />' );
			row.find( 'td.destination' ).html( '<input type="text" value="' + row.data( 'destination' ) + '" class="widefat" />' );

			row.find( 'td.actions' ).html( '<a class="dashicons dashicons-yes tp-redirects-edit-finish" title="' + TP_Redirects_Labels['edit_finish'] + '"></a>');
			row.find( 'td.actions' ).append( '<a class="dashicons dashicons-dismiss tp-redirects-edit-dismiss" title="' + TP_Redirects_Labels['edit_dismiss'] + '"></a>' );

			if( 'destination' == focus )
				row.find( 'td.destination input' ).focus();
			else if( 'source' == focus )
				row.find( 'td.source input' ).focus();
		}

		/**
		 * Dismiss edit
		 */
		this.dismiss = function( source ) {
			var row = $( el ).find( 'tr[data-source="' + source + '"]');

			row.removeClass( 'editing' );
			row.html( row.data( 'html-before' ) );
		}
		
		/**
		 * Setup
		 */
		$( document ).ready( function() {
			self.events();
		} );
	}
	
	$.fn.tp_redirects = function() {
		return this.each( function() {
			if( $( this ).data( 'tp_redirects' ) )
				return;

			var tp_redirects = new TP_Redirects( this );
			$( this ).data( 'tp_redirects', tp_redirects );
		} );
	}
	
	jQuery( document ).ready( function( $ ) {
		$( '.tp-redirects' ).tp_redirects();
	} );
} )( jQuery );
