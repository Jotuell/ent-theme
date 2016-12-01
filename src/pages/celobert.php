<?php
use Ent\Helpers;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Formulari Celobert')
    ->show_on_post_type('page')
    ->show_on_page(get_page_by_path('qui-som/celobert')->ID)
    ->set_priority('low')
    ->add_fields([
        Field::make('complex', 'clients', 'Clientes')->add_fields([
            Field::make('image', 'image', 'Logo')->set_width(100)->set_required(true),
            Field::make('text', 'name', 'Nom')->set_width(50)->set_required(true),
            Field::make('text', 'url', 'URL')->set_width(50)->set_required(true),
        ])->set_header_template('{{ name }}')
    ]);

Helpers::cf_collapse_complex_fields('clients');
