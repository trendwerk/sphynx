$(function() {
  if (window.innerWidth < 980) {
    $('#main aside').insertAfter('#main #content');
  }
  $('#mobile-navigation, #mobile-search').click(function() {
    return $($(this).data('toggle')).slideToggle('fast', function() {
      if (!$(this).is(':visible')) {
        return $(this).css({
          'display': ''
        });
      }
    });
  });
  return $('#mobile-search').click(function() {
    return $($(this).data('toggle')).find('input[type="text"]').focus();
  });
});
