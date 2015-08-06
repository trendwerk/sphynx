$(function() {
  $('#mobile-navigation, #mobile-search').click(function() {
    return $($(this).data('toggle')).slideToggle('fast', function() {
      if (!$(this).is(':visible')) {
        return $(this).css({
          'display': ''
        });
      }
    });
  });
  $('#mobile-navigation').click(function() {
    return $('.burger', this).toggleClass('active');
  });
  return $('#mobile-search').click(function() {
    $($(this).data('toggle')).find('input[type="text"]').focus();
    return $('.glass', this).toggleClass('active');
  });
});

//# sourceMappingURL=responsive.js.map