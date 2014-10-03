<?php
/**
 * Editor-specific settings
 *
 * @package TrendPress
 */

namespace TrendPress\Child;

class TP_Editor {
    function __construct() {
        /**
         * Set content width
         */
        if( ! isset( $content_width ) )
            $content_width = 740;

        add_action( 'init', array( $this, 'load_styles' ) );
        add_action( 'tiny_mce_before_init', array( $this, 'define_styles' ) );

        add_filter( 'embed_oembed_html', array( $this, 'video_embed' ) );
    }

    /**
     * Load editor styles
     */
    function load_styles() {
        add_editor_style( 'assets/sass/output/editor.css' );
    }

    /**
     * Define editor styles
     */
    function define_styles( $settings ) {
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

    /**
     * Responsive video container
     */
    function video_embed( $html ) {
        return '<div class="video-container">' . $html . '</div>';
    }
} new TP_Editor;
