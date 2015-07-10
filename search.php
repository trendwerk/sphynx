<?php
$context = Timber::get_context();
$context['have_posts'] = have_posts();

$context['pagination'] = Trendwerk\TrendPress\pagination();

Timber::render('search.twig', $context);
