(function($){
	var TPMobileNav = function(el) {
		var self = this;
		
		this.events = function() {
			$(el).change(function() {
				window.location = $(this).find('option:selected').data('url');
			});
		}
		
		$(document).ready(function() {
			self.events();
		});
	}
	
	$.fn.TPMobileNav = function() {
		return this.each(function() {
			if($(this).data('TPMobileNav')) return;

			var plugin = new TPMobileNav(this);
			$(this).data('TPMobileNav',plugin);
		});
	}
	
	jQuery(document).ready(function($) {
		$('.tp-mobile-nav').TPMobileNav();
	});
})(jQuery);
