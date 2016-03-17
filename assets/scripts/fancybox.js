jQuery(($) => {
  // Fancybox for images
  $('a:has(img)').each(function() {
    let _this = $(this);

    if(/(jpeg|jpg|png|gif|bmp)$/i.test(_this.prop('href'))) {
      _this.fancybox();
    }
  });

  // Fancybox for galleries
  $('.gallery').each(function(i) {
    let _this = $(this);

    _this.find('a').prop('rel', 'fancybox-gallery-' + i);
    _this.find('figure.gallery-item a').fancybox({
      type: 'image'
    });
  });
});
