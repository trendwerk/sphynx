( function( $ ){
	var TP_Redirects = function( el ) {
		var self = this;
		var waiting = false;
		var page = 1;
		var tryLater = '';
		var closedPointers = [];

		this.events = function() {
			self.prevTerm = '';

			/**
			 * Search
			 */
			$( el ).on( 'keyup', 'input#tp-redirects-search', function( event ) {
				var term = self.correct( $( this ).val() );
				if( term != $( this ).val() )
					$( this ).val( term );

				if( 13 == event.which && 0 < term.length ) {
					self.create( term );
					self.point( 'tp-redirects-search', 'close', true );
				}

				if( 8 == event.which )
					self.waiting = false; //Always listen to backspace

				if( term == self.prevTerm && 0 == term.length )
					return;

				if( 2 < term.length )
					self.search( term );
				else if( 0 == term.length )
					self.search( '' );

				self.prevTerm = term;
			} );

			/**
			 * Add
			 */
			$( el ).on( 'click', '#tp-redirects-add', function() {
				self.create( $( el ).find( '#tp-redirects-search' ).val() );
			} );

			/**
			 * Edit
			 */
			$( el ).on( 'click', '.tp-redirects-edit', function() {
				self.edit( $( this ).closest( 'tr' ).data( 'source' ) );
			} );

			$( el ).on( 'keyup', 'td.source input, td.destination input', function( event ) {
				if( 13 == event.which ) {
					self.save( $( this ).closest( 'tr' ).data( 'source' ), $( this ).closest( 'tr' ).find( 'td.source input' ).val(), $( this ).closest( 'tr' ).find( 'td.destination input' ).val(), function() {
						if( $( 'input#tp-redirects-search' ).val() != '' )
							$( 'input#tp-redirects-search' ).focus();
					} );
				} else if( 27 == event.which ) {
					self.dismiss( $( this ).closest( 'tr' ).data( 'source' ) );

					if( $( 'input#tp-redirects-search' ).val() != '' )
						$( 'input#tp-redirects-search' ).focus();
				}
			} );

			/**
			 * Save
			 */
			$( el ).on( 'click', '.tp-redirects-edit-finish', function() {
				self.save( $( this ).closest( 'tr' ).data( 'source' ), $( this ).closest( 'tr' ).find( 'td.source input' ).val(), $( this ).closest( 'tr' ).find( 'td.destination input' ).val() );
			} );

			/**
			 * Dismiss changes
			 */
			$( el ).on( 'click', '.tp-redirects-edit-dismiss', function() {
				self.dismiss( $( this ).closest( 'tr' ).data( 'source' ) );
			} );

			/**
			 * Remove
			 */
			$( el ).on( 'click', '.tp-redirects-remove', function() {
				self.remove( $( this ).closest( 'tr' ).data( 'source' ) );
			} );

			/**
			 * Lazy loading
			 */
			$( window ).scroll( function() {
			    if( '' == $( el ).find( '#tp-redirects-search').val() && $( window ).scrollTop() == $( document ).height() - $( window ).height() ) {
			    	self.next();
			    }
			} );
		}

		/**
		 * Search redirects for a term
		 */
		this.search = function( term ) {
			if( 0 < term.length )
				self.point( 'tp-redirects-search' );
			else
				self.point( 'tp-redirects-search', 'close' );

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
			if( self.waiting && 'search' == data.type ) {
				self.tryLater = data.term;
				return;
			}

			self.waiting = true;
			data.action = 'tp_redirects_get';

			$.post( ajaxurl, data, function( response ) {
				self.parse( response );
				self.catchup();
			} );
		}

		/**
		 * Get redirects that might've been requested while waiting
		 */
		this.catchup = function() {
			if( ! self.tryLater || $( el ).find( 'input#tp-redirects-search' ).val() != self.tryLater ) {
				self.tryLater = '';
				return;
			}

			self.search( self.tryLater );
			self.tryLater = '';
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
			if( response.html ) {
				if( response.replace )
					$( el ).find( 'table.tp-redirects-table tbody' ).html( response.html );
				else
					$( el ).find( 'table.tp-redirects-table tbody' ).append( response.html );
			} else if( response.replace ) {
				$( el ).find( 'table.tp-redirects-table tbody' ).html( '<tr><td colspan="3">' + TP_Redirects_Labels['not_found'] + '</td></tr>' );
			}

			if( response.page )
				self.page = response.page;

			self.waiting = false;

			$( el ).find( 'tr.tp-redirects-more' ).hide();
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
			row.find( 'td.actions' ).append( '<a class="dashicons dashicons-no-alt tp-redirects-edit-dismiss" title="' + TP_Redirects_Labels['edit_dismiss'] + '"></a>' );

			if( 'destination' == focus )
				row.find( 'td.destination input' ).focus();
			else if( 'source' == focus )
				row.find( 'td.source input' ).focus();
		}

		/**
		 * Save edited redirect
		 */
		this.save = function( refSource, source, destination, callback ) {
			if( self.waiting )
				return;

			self.waiting = true;
			data = {
				action:      'tp_redirects_save',
				refSource:   refSource,
				source:      source,
				destination: destination
			}

			$.post( ajaxurl, data, function( response ) {
				if( response.html )
					$( el ).find( 'tr[data-source="' + refSource + '"]').after( response.html ).remove();

				self.waiting = false;

				if( typeof callback == 'function' )
					callback();
			} );
		}

		/**
		 * Remove redirect
		 */
		this.remove = function( source ) {
			if( ! confirm( TP_Redirects_Labels['delete_confirm'] ) )
				return;

			if( self.waiting )
				return;

			self.waiting = true;
			data =  {
				action: 'tp_redirects_remove',
				source: source
			}

			$.post( ajaxurl, data, function( response ) {
				if( response.removed )
					$( el ).find( 'tr[data-source="' + source + '"]').remove();

				self.waiting = false;
			} );
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
		 * Load more (pagination)
		 */
		this.next = function() {
			if( ! self.page )
				self.page = 1;

			$( el ).find( 'tr.tp-redirects-more' ).show();

			self.get( {
				type:   'paged',
				page:   self.page + 1
			} );
		}

		/**
		 * Show pointer
		 */
		this.point = function( to, action, dismiss ) {
			if( ! action )
				action = 'open';

			if( TP_Redirects_Pointers[ to ] ) {
				if( closedPointers[ to ] )
					return;

				var pointer = TP_Redirects_Pointers[ to ];

				var pointer_el = $( pointer[ 'element']  ).pointer( {
					content : '<h3>' + pointer[ 'header' ] + '</h3><p>' + pointer[ 'text' ] + '</p>',
					close   : function() {
						closedPointers[ to ] = true;

						if( action == 'close' && ! dismiss )
							closedPointers[ to ] = false;

						$.post( ajaxurl, {
							pointer : to,
							action  : 'dismiss-wp-pointer'
						} );
					}
				} ).pointer( action );

				if( dismiss )
					pointer_el.close();
			}
		}
		
		/**
		 * Setup
		 */
		$( document ).ready( function() {
			self.events();

			$( 'input#tp-redirects-search' ).focus();
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
