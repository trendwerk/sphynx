$ ->

  # Fancybox for images
  $( 'a:has(img)' ).each ->
    $( this ).fancybox() if /(jpeg|jpg|png|gif|bmp)$/i.test( $( this ).prop( 'href' ) )

  # Fancybox for galleries
  $( '.gallery' ).each ( i ) ->
    $( this ).find( 'a' ).prop 'rel', 'fancybox-gallery-' + i
    $( this ).find( 'figure.gallery-item a' ).fancybox type: 'image'
