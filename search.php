<?php
$context = Timber::get_context();
$context['posts'] = Timber::get_posts();

$context['search_query'] = get_search_query();
$context['pagination'] = Timber::get_pagination(array(
    'mid_size' => 2,
));

Timber::render('search.twig', $context);
