jQuery(document).ready(function($) {
	/**
	 * @adjust Plugins table when visiting 'TrendPress' plugins
	 */
	if($('body.tp-plugins-current').length > 0) {
		$('.tablenav .alignleft.actions').first().html('<p>'+TPPluginsL10n['tp-plugins-explanation']+'</p>').css('margin-left','10px');
		$('table.plugins #the-list').find('.inactive').removeClass('inactive').addClass('active');
		$('table.plugins #the-list .check-column').html('');
	}
});