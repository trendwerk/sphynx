$(function() {
  $('a:has(img)').each(function() {
    if (/(jpeg|jpg|png|gif|bmp)$/i.test($(this).prop('href'))) {
      return $(this).fancybox();
    }
  });
  $('.gallery').each(function(i) {
    $(this).find('a').prop('rel', 'fancybox-gallery-' + i);
    return $(this).find('figure.gallery-item a').fancybox({
      type: 'image'
    });
  });
  return $(document).on('click', 'a[rel*=\"external\"]', function() {
    window.open($(this).prop('href'));
    return false;
  });
});
