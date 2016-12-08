<?php 
use Ent\Helpers;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

$team_hide_for_collaborator = ['relation' => 'AND', ['field' => 'type', 'value' => 'collaborator', 'compare' => '!=']];

Container::make('post_meta', 'Formulari equip')
    ->show_on_post_type('page')
    //->show_on_page(get_page_by_path('qui-som/equip')->ID)
    ->set_priority('low')
    ->add_fields([
        Field::make('complex', 'team', 'Equipo')->add_fields([
            Field::make('image', 'image', 'Foto seria')->set_width(50)->set_conditional_logic($team_hide_for_collaborator),
            Field::make('image', 'image_alt', 'Foto graciosa')->set_width(50)->set_conditional_logic($team_hide_for_collaborator),
            Field::make('text', 'name', 'Nom')->set_width(15)->set_required(true),
            Field::make('text', 'surname', 'Cognoms')->set_width(25)->set_required(true),
            Field::make('text', 'position', 'Càrrec')->set_width(40),
            Field::make('select', 'type', 'Tipus')->set_width(20)->add_options(['member' => 'Soci', 'worker' => 'Treballador', 'collaborator' => 'Col·laborador']),
            Field::make('text', 'email', 'Email')->set_width(100)->set_conditional_logic($team_hide_for_collaborator),
            Field::make('text', 'linkedin', 'LinkedIn')->set_width(50)->set_help_text('URL al perfil público.'),
            Field::make('text', 'twitter', 'Twitter')->set_width(50)->set_help_text('URL al perfil público.'),
            Field::make('text', 'pinterest', 'Pinterest')->set_width(50)->set_help_text('URL al perfil público.'),
            Field::make('text', 'instagram', 'Instagram')->set_width(50)->set_help_text('URL al perfil público.'),
            Field::make('rich_text', 'bio', 'Bio'),
        ])->set_header_template('{{ name }} {{ surname }} ({{ type }})')
    ]);

Helpers::cf_collapse_complex_fields('team');
