jQuery( function( $ ) {
	/**
	 * Show button in widget
	 *
	 * @subpackage Widgets
	 */
	$( document ).on( 'click', '.tp-show-button', function() {
		$( this ).closest( 'div.widget-content' ).find( '.tp-show-button-content' ).toggle();
	} );

	/**
	 * Upload image in widget
	 *
	 * @subpackage Widgets
	 */
	var TP_Upload_Image_Widget;
	var TP_Upload_Button;

	$( document ).on( 'click', '.tp-upload-image, .tp-edit-image', function( event ) {
		event.preventDefault();

		TP_Upload_Button = this;

		if( typeof( TP_Upload_Image_Widget ) !== "undefined" )
			TP_Upload_Image_Widget.close();

		TP_Upload_Image_Widget = wp.media.frames.customHeader = wp.media( {
			title: TP_Title_Content_Image_Button['media_frame_labels']['title'],
			library: {
				type: 'image'
			},
			button: {
				text: TP_Title_Content_Image_Button['media_frame_labels']['button']
			},
			multiple: false
		} );

		TP_Upload_Image_Widget.on( 'select', function() {
			var attachment = TP_Upload_Image_Widget.state().get( 'selection' ).first().toJSON();
			$( TP_Upload_Button ).closest( '.widget-content').find( '.tp-upload-image-content' ).val( attachment.id );
			$( TP_Upload_Button ).closest( '.widget-inside').find( '.widget-control-save' ).trigger( 'click' );
		} );

		TP_Upload_Image_Widget.open();
	} );

	$( document ).on( 'click', '.tp-remove-image', function( event ) {
		$( this ).closest( '.widget-content').find( '.tp-upload-image-content' ).val( '' );
		$( this ).closest( '.widget-inside').find( '.widget-control-save' ).trigger( 'click' );
	} );
} );