<?php
$context = Timber::get_context();
$context['posts'] = Timber::get_posts();

$context['search_query'] = get_search_query();
$context['pagination'] = Trendwerk\TrendPress\pagination();

Timber::render('search.twig', $context);
