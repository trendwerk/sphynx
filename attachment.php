<?php 
	if ( have_posts() ) : the_post();
		header('Location: '.wp_get_attachment_url());
	endif;
?>