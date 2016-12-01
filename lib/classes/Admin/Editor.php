<?php
namespace Trendwerk\Sphynx\Admin;

final class Editor
{
    public function __construct()
    {
        add_action('init', array($this, 'loadStyles'));
        add_action('tiny_mce_before_init', array($this, 'styles'));
        add_filter('tiny_mce_before_init', array($this, 'buttons'), 1);
    }

    public function loadStyles()
    {
        add_editor_style('assets/styles/output/editor.css');
    }

    public function styles($settings)
    {
        $style_formats = array(
            array(
                'title'    => __('Button', 'tp'),
                'selector' => 'a',
                'classes'  => 'button',
            )
        );
        $settings['style_formats'] = json_encode($style_formats);

        return $settings;
    }

    public function buttons($settings)
    {
        $dfw_fs = (0 < strpos($settings['toolbar1'], 'dfw')) ? 'dfw' : 'fullscreen';

        $settings['toolbar1'] = 'formatselect, bold, italic, bullist, numlist, link, unlink, wp_more, ' . $dfw_fs;
        $settings['toolbar2'] = 'styleselect, undo, redo, charmap, blockquote, pastetext, removeformat';

        $settings['wordpress_adv_hidden'] = false;

        return $settings;
    }
}
