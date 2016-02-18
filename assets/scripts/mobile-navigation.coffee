$ ->
  $( '.mobile-navigation' ).click ->
    $( '.navigation-icon', this ).toggleClass( 'active' )

    $( $( this ).data 'toggle' ).slideToggle 'fast', ->
      if ! $( this ).is ':visible'
        $( this ).css 'display': ''
