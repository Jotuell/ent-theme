<?php
require_once(__DIR__ . '/vendor/autoload.php');

new \Ent\Ent([
    'theme_dir' => __DIR__,
    'post_class_map' => [
        'post' => 'CO_Post',
        'co_project' => 'CO_Project',
    ],
    'menus' => [
        'main_menu' => 'Menu principal',
    ],
    'sidebars' => [
        'footer_address' => 'Footer dirección',
        'social_links'   => 'Enlaces redes sociales',
        'sidebar'        => 'Columna lateral'
    ]
]);
