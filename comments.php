<?php
use Timber\Post;

if (post_password_required()) {
    return;
}

$context = Timber::get_context();
$context['post'] = new Post();

Timber::render('partials/comments.twig', $context);
