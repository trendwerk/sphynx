<?php
$context = Timber::get_context();
$context['have_posts'] = have_posts();

Timber::render('search.twig', $context);
