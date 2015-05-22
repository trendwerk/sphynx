<?php
$context = Timber::get_context();

$context['post'] = new TimberPost();
$context['post']->pagination = wp_link_pages( array(
	'before'         => '<nav class="pages">',
	'after'          => '</nav>',
	'next_or_number' => 'next',
	'echo'           => false,
) );

Timber::render( 'page.twig', $context );
