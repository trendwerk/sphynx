<?php
$context = Timber::get_context();
$context['posts'] = Timber::get_posts();

if (is_archive()) {
    $context['title'] = get_the_archive_title();
} else {
    $context['title'] = get_the_title(get_option('page_for_posts'));
}

$context['description'] = get_the_archive_description('<div class="archive-description">', '</div>');
$context['pagination'] = Timber::get_pagination(array(
    'mid_size' => 2,
));

Timber::render('index.twig', $context);
