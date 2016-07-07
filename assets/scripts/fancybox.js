import jQuery from '../../bower_components/jquery/dist/jquery';
import '../../bower_components/fancybox/source/jquery.fancybox';

jQuery(($) => {
  // Fancybox for images
  $('a:has(img)').each(function fancyboxImage() {
    const $this = $(this);

    if (/(jpeg|jpg|png|gif|bmp)$/i.test($this.prop('href'))) {
      $this.fancybox();
    }
  });

  // Fancybox for galleries
  $('.gallery').each(function fancyboxGallery(i) {
    const $this = $(this);

    $this.find('a').prop('rel', 'fancybox-gallery-' + i);
    $this.find('figure.gallery-item a').fancybox({
      type: 'image',
    });
  });
});
