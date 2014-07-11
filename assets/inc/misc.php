<?php
/**
 * Miscellaneous functions
 *
 * @package TrendPress
 */

/**
 * Load editor styles
 */
function tp_add_editor_style() {
    add_editor_style( 'assets/sass/output/editor.css' );
}
add_action( 'init', 'tp_add_editor_style' );

/**
 * Define editor styles
 */
function tp_add_editor_styles( $settings ) {
    $style_formats = array(
    	array(
    		'title'    => __( 'Button', 'tp' ),
    		'selector' => 'a',
    		'classes'  => 'button',
    	),
    	array(
    		'title'    => __( 'Secondary button', 'tp' ),
    		'selector' => 'a',
    		'classes'  => 'button secondary',
    	),
    	array(
    		'title'    => __( 'More link', 'tp' ),
    		'selector' => 'a',
    		'classes'  => 'more-link',
    	),   
    );
    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;
}
add_filter( 'tiny_mce_before_init', 'tp_add_editor_styles' );

/**
 * Set content width
 */
if( ! isset( $content_width ) )
    $content_width = 740;

/**
 * Set image sizes
 */
function tp_set_image_sizes() {
	update_option( 'thumbnail_size_w', 140 );
	update_option( 'thumbnail_size_h', 140 );
	
	update_option( 'medium_size_w', 300 );
	update_option( 'medium_size_h', '' );
	
	update_option( 'large_size_w', 600 );
	update_option( 'large_size_h', '' );
}
add_action( 'after_switch_theme', 'tp_set_image_sizes' );

/**
 * Add HTML5 theme support
 */
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

/**
 * Responsive video container
 */
function tp_video_embed( $html ) {
    return '<div class="video-container">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'tp_video_embed' );

/**
 * Remove AIM, YIM, JABBER and add Facebook and LinkedIn
 */
function tp_modify_profile( $media ) {
	unset( $media['aim'] );
	unset( $media['yim'] );
	unset( $media['jabber'] );

	$media['facebook']   = __( 'Facebook profile URL', 'tp' );
	$media['linkedin']   = __( 'LinkedIn profile URL', 'tp' );
	$media['googleplus'] = __( 'Google+ profile URL', 'tp' );
    $media['twitter']    = __( 'Twitter @username', 'tp' );
	
	return $media;
}
add_filter( 'user_contactmethods', 'tp_modify_profile' );
