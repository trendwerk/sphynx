<?php
$context = Timber::get_context();
$context['have_posts'] = have_posts();

$context['search_query'] = get_search_query();
$context['pagination'] = Trendwerk\TrendPress\pagination();

Timber::render('search.twig', $context);
