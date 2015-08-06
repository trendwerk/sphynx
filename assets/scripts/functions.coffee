$ ->

  # Fancybox for images
  $( 'a:has(img)' ).each ->
    if /(jpeg|jpg|png|gif|bmp)$/i.test( $( this ).prop( 'href' ) )
      $( this ).fancybox()

  # Fancybox for galleries
  $( '.gallery' ).each ( i ) ->
    $( this ).find( 'a' ).prop 'rel', 'fancybox-gallery-' + i
    $( this ).find( 'figure.gallery-item a' ).fancybox type: 'image'
