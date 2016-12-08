<?php
/*
// Redirection example
// This catches /:locale/project/:id
Routes::map('projecte/[i:id]/', function ($params) {
    $post = Timber::get_post([
        'meta_key'   => '_old_id',
        'meta_value' => $params['id'],
    ]);

    wp_redirect($post->link);
    exit;
});
*/
