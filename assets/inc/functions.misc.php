<?php
/**
 * @editor add editor styles
 */
function tp_add_editor_styles( $settings ) {
    $style_formats = array(
    	array(
    		'title'    => __( 'Primary button', 'tp' ),
    		'selector' => 'a',
    		'classes'  => 'cta primary'
    	),
    	array(
    		'title'    => __( 'Secondary button', 'tp' ),
    		'selector' => 'a',
    		'classes'  => 'cta secondary'
    	),
    	array(
    		'title'    => __( 'More link', 'tp' ),
    		'selector' => 'a',
    		'classes'  => 'more-link'
    	)
    );
    $settings['style_formats'] = json_encode( $style_formats );
    return $settings;
}
add_filter( 'tiny_mce_before_init', 'tp_add_editor_styles' );

/**
 * @thumbnail set image sizes
 */
function tp_set_image_sizes() {

	/* set thumbnail size */
	update_option( 'thumbnail_size_w', 140 );
	update_option( 'thumbnail_size_h', 140 );
	
	/* set medium image size */
	update_option( 'medium_size_w', 300 );
	update_option( 'medium_size_h', '' );
	
	/* set large image size */
	update_option( 'large_size_w', 600 );
	update_option( 'large_size_h', '' );
}
add_action('after_switch_theme', 'tp_set_image_sizes'); 

/**
 * @author Remove AIM, YIM, JABBER and add Facebook and LinkedIn
 */
function tp_modify_profile( $media ) {
	unset( $media['aim'] );
	unset( $media['yim'] );
	unset( $media['jabber'] );
	unset( $media['googleplus'] );

	$media['facebook']   = __( 'Facebook profile URL', 'tp' );
	$media['linkedin']   = __( 'LinkedIn profile URL', 'tp' );
	$media['googleplus'] = __( 'Google+ profile URL', 'tp' );
	
	return $media;
}
add_filter( 'user_contactmethods','tp_modify_profile' );
