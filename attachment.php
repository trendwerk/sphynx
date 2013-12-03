<?php 
	if ( have_posts() ) : the_post();
		wp_redirect( wp_get_attachment_url() );
		die();
	endif;
?>