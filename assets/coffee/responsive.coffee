$ ->

  # Toggle navigation search
  $( '#mobile-navigation, #mobile-search' ).click ->
    $( this ).toggleClass( 'active' )
    $( $( this ).data 'toggle' ).slideToggle 'fast', ->
      if ! $( this ).is ':visible'
        $( this ).css 'display': ''

    $( '#mobile-search' ).click ->
      $( $( this ).data 'toggle' ).find( 'input[type="text"]' ).focus()
