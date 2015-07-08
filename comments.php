<?php
if (post_password_required()) {
    return;
}

$context = Timber::get_context();
$context['post'] = new TimberPost();

$context['have_comments'] = have_comments();

$context['comment_list'] = wp_list_comments(array(
    'avatar_size' => 60,
    'echo'        => false,
));

$context['comment_pages'] = paginate_comments_links(array(
    'next_text' => __('Next', 'tp'),
    'prev_text' => __('Previous', 'tp'),
    'echo'      => false,
));

Timber::render('partials/comments.twig', $context);
