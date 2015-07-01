<?php
$context = Timber::get_context();
$context['post'] = new TimberPost();
$context['subheader'] = true;

Timber::render('page.twig', $context);
