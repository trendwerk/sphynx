$ -> 
 
    # Sidebar
    if window.innerWidth < 980
        $( '#main aside' ).insertAfter( '#main #content' )

    # Toggle navigation & search
    $( '#mobile-navigation, #mobile-search' ).click ->

        $( $( this ).data 'toggle' ).slideToggle( 'fast', () ->

            if ! $( this ).is ':visible'
                $( this ).css 'display': ''

        )

    $( '#mobile-search' ).click ->
        $( $( this ).data 'toggle' ).find( 'input[type="text"]' ).focus();