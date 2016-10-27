import '../../bower_components/fancybox/source/jquery.fancybox';

jQuery(($) => {
  $('a:has(img)').each(function fancyboxImage() {
    const $this = $(this);

    if (/(jpeg|jpg|png|gif|bmp)$/i.test($this.prop('href'))) {
      $this.fancybox();
    }
  });

  $('.gallery').each(function fancyboxGallery(i) {
    const $this = $(this);

    $this.find('a').prop('rel', 'fancybox-gallery-' + i);
    $this.find('.gallery-item a').fancybox({
      type: 'image',
    });
  });
});
