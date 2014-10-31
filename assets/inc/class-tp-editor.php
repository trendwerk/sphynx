<?php
/**
 * Editor-specific settings
 *
 * @package TrendPress
 */

class TP_Editor {
    function __construct() {
        /**
         * Set content width
         */
        if( ! isset( $content_width ) )
            $content_width = 740;

        add_action( 'init', array( $this, 'load_styles' ) );
        add_action( 'tiny_mce_before_init', array( $this, 'styles' ) );
        add_filter( 'tiny_mce_before_init', array( $this, 'buttons' ), 1 );

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
    function styles( $settings ) {
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
     * Define buttons
     */
    function buttons( $settings ) {
        $settings['toolbar1'] = 'formatselect, bold, italic, bullist, numlist, link, unlink, wp_more, fullscreen';
        $settings['toolbar2'] = 'styleselect, undo, redo, charmap, blockquote, pastetext, removeformat';

        $settings['wordpress_adv_hidden'] = false;

        return $settings;
    }

    /**
     * Responsive video container
     */
    function video_embed( $html ) {
        return '<div class="video-container">' . $html . '</div>';
    }
} new TP_Editor;
