<?php
require_once(__DIR__ . '/vendor/autoload.php');
new \Ent\Ent(__DIR__);

//-------

//require_once 'src/migrate.php';
require_once 'src/redirects.php';

add_filter('Timber\PostClassMap', function () {
    return [
        'post' => 'CO_Post',
        'co_project' => 'CO_Project',
    ];
});

add_filter('timber/context', function ($data) {
    $data['menu_primary'] = new TimberMenu('primary');
    $data['social_links'] = Timber::get_widgets('social_links');
    $data['footer_address'] = Timber::get_widgets('footer_address');

    return $data;
});

add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary' => 'Menu principal',
    ]);
});

add_action('widgets_init', function () {
    register_sidebar([
        'name'          => 'Footer dirección',
        'id'            => 'footer_address',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => ''
    ]);

    register_sidebar([
        'name'          => 'Enlaces redes sociales',
        'id'            => 'social_links',
        'before_widget' => '',
        'after_widget'  => '',
        'before_title'  => '',
        'after_title'   => ''
    ]);
});
