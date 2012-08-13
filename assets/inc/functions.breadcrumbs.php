<?php
/**
 * Functions for displaying the breadcrumbs of the current menu.
 *
 * @uses TPNav
 */

/**
 * Show the breadcrumbs
 *
 * @param string $separator Separator between breadcrumbs
 */
function tp_breadcrumbs($separator='>',$menu='') {
	global $post;
	
	$nav = new TPNav($menu);
	$breadcrumbs = $nav->get_breadcrumb_items();
	
	//Home
	echo '<a href="'.get_option('siteurl').'">'.__('Home','tp').'</a>';
	tp_separator($separator);
	
	$i=0;
	if($breadcrumbs) {
		foreach($breadcrumbs as $breadcrumb) {
			if(!$breadcrumb->is_current) {
				echo '<a href="'.$breadcrumb->url.'">';
					echo $breadcrumb->title;
				echo '</a>';
			} else {
				echo '<span class="current">'.$breadcrumb->title.'</span>';
			}
			
			$i++;
			if($i < count($breadcrumbs)) {
				tp_separator($separator);
			}
		}
	}
	
	//Single post or CPT and author pages or taxonomy pages have some
	if(is_single()) {
		tp_separator($separator);
		echo '<span class="current">'.$post->post_title.'</span>';
	} else if(is_category()) {
		tp_separator($separator);
		$category = get_the_category();
		echo '<span class="current">'.$category[0]->name.'</span>';
	} else if(get_query_var('author')) {
		tp_separator($separator);
		$author = get_userdata(get_query_var('author'));
		echo '<span class="current">'.$author->first_name.' '.$author->last_name.'</span>';
	} else if(get_query_var('term') && get_query_var('taxonomy')) {
		tp_separator($separator);
		$term = get_term_by('slug',get_query_var('term'),get_query_var('taxonomy'));
		echo '<span class="current">'.$term->name.'</span>';
	}
}

/**
 * Use a separator between breadcrumbs
 *
 * @param string $separator
 */
function tp_separator($separator) {
	echo ' <span class="separator">'.htmlentities($separator).'</span> ';	
}

?>