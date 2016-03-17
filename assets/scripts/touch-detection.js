$(document).ready(() => {
  if(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch) {
  	$('body').addClass('touch');
  }
});
