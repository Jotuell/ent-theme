<?php
Routes::map('projecte/[i:id]/', function ($params) {
    $post = Timber::get_post([
        'post_type'  => 'co_project',
        'meta_key'   => '_old_id',
        'meta_value' => $params['id'],
    ]);

    wp_redirect($post->link);
    exit;
});

Routes::map('actualitat/[i:id]/', function ($params) {
    $post = Timber::get_post([
        'meta_key'   => '_old_id',
        'meta_value' => $params['id'],
    ]);

    wp_redirect($post->link);
    exit;
});
