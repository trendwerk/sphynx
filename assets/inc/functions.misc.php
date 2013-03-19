<?php
/**
 * @misc Add editor styles
 */
function tp_add_editor_styles($settings) {
    $style_formats = array(
    	array(
    		'title' => __('Primary button','tp'),
    		'selector' => 'a',
    		'classes' => 'cta primary'
    	),
    	array(
    		'title' => __('Secondary button','tp'),
    		'selector' => 'a',
    		'classes' => 'cta secondary'
    	),
    	array(
    		'title' => __('Read more link','tp'),
    		'selector' => 'a',
    		'classes' => 'read-more'
    	)
    );
    $settings['style_formats'] = json_encode($style_formats);
    return $settings;
}
add_filter('tiny_mce_before_init','tp_add_editor_styles');

?>