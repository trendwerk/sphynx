$(document).ready(function() {
  // Fancybox for images
  $('a:has(img)').each(function() {
    if(/(jpeg|jpg|png|gif|bmp)$/i.test($(this).prop('href'))) {
      $(this).fancybox();
    }
  });

  // Fancybox for galleries
  $('.gallery').each(function(i) {
    $(this).find('a').prop('rel', 'fancybox-gallery-' + i);
    $(this).find('figure.gallery-item a').fancybox({
      type: 'image'
    });
  });
});
