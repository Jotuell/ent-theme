<?php
use Ent\Helpers;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('init', function () {
    register_taxonomy('co_service', ['post', 'co_project'], [
        'labels' => [
            'name' => 'Servicios',
        ],
        'rewrite' => ['slug' => 'servei'],
        'show_ui' => true,
        'show_tagcloud' => true,
        'show_in_menus' => true,
        'show_admin_column' => true,
        'hierarchical' => true,
        'has_archive' => true,
    ]);
});

Helpers::setMeta('co_service', function () {
    return Container::make('term_meta', 'Formulari servei')
        ->show_on_taxonomy('co_service')
        ->add_fields(array(
            Field::make('text', 'class'),
        ));
});
    
class CO_Service extends \Timber\Term {
    public function __construct($tid = null) {
        parent::__construct($tid);
        Helpers::getTermMeta('co_service', $this);
    }
}
