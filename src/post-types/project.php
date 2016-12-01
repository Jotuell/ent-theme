<?php
use Ent\Helpers;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('init', function () {
    register_post_type('co_project', [
        'labels' => [
            'name'          => 'Projectes',
            'singular_name' => 'Projecte',
        ],
        'rewrite' => ['slug' => 'projecte'],
        'public' => true,
        'has_archive' => false,
    ]);

    add_post_type_support('co_project', ['thumbnail']);
});

Helpers::setMeta('co_project', function () {
    function get_years_list() {
        $data = ['' => 'Selecciona…'];

        foreach (range(date('Y'), 2007) as $year) {
            $data[$year] = $year;
        }

        return $data;
    }
    
    $project_section_show_for_content = [
        'relation' => 'AND', 
        ['field' => 'has_content', 'value' => 'yes', 'compare' => '=']
    ];

    return Container::make('post_meta', 'Formulari projecte')
        ->show_on_post_type('co_project')
        ->set_priority('low')
        ->add_fields([
            Field::make('checkbox', 'is_featured', 'Destacat')->set_option_value('yes'),
            Field::make('textarea', 'home_intro', 'Intro para la home')
                ->set_width(100)
                ->set_rows(3)
                ->set_help_text('Aproximadamente 250 caracteres (incluidos espacios y puntuación).')
                ->set_conditional_logic([
                    'relation' => 'AND',
                    [
                        'field' => 'is_featured',
                        'value' => 'yes',
                    ]
                ]),
            Field::make('checkbox', 'is_finished', 'Projecte acabat')->set_width(50)->set_option_value('yes')->set_help_text('Si no se marca esta casilla se entiende de que esta "en curso".'),
            Field::make('select', 'start_year', "Data d'inici")
                ->set_width(25)
                ->set_options(get_years_list())
                ->set_default_value(''),
            Field::make('select', 'end_year', 'Data final')
                ->set_width(25)
                ->set_options(get_years_list())->set_default_value('')
                ->set_conditional_logic([
                    'relation' => 'AND',
                    [
                        'field' => 'is_finished',
                        'value' => 'yes',
                    ]
                ]),
            Field::make('text', 'team', 'Equip')->set_width(100),
            Field::make('text', 'place', 'Ubicació')->set_width(40),
            Field::make('text', 'client', 'Client')->set_width(30),
            Field::make('select', 'energy_class', 'Classificació Energètica')
                ->set_width(30)
                ->set_options([
                    ''  => 'Selecciona…',
                    'A' => 'A',
                    'B' => 'B',
                    'C' => 'C',
                    'D' => 'D',
                    'E' => 'E',
                    'F' => 'F',
                    'G' => 'G',
                ]),
            Helpers::cf_create_links('Enlaces'),
            Helpers::cf_create_attachments('Archivos adjuntos'),
            Field::make('complex', 'section', 'Secciónes multimedia')->add_fields([
                Field::make('checkbox', 'has_content', 'Tiene texto?')->set_width(100)->set_option_value('yes'),
                Field::make('text', 'title', 'Título')->set_width(100)->set_conditional_logic($project_section_show_for_content),
                Field::make('rich_text', 'content', 'Texto')->set_conditional_logic($project_section_show_for_content),
                Helpers::cf_create_media('Galeria multimedia'),
            ])->set_header_template('{{ title }}'),
        ]);
});

class CO_Project extends \Timber\Post {
    protected $service;
    protected $service_ids;
    protected $services;

    public function __construct($pid = null) {
        parent::__construct($pid);
        Helpers::getPostMeta('co_project', $this);

        // Some URLs don't have scheme, fix it.
        foreach ($this->links as $key => $link) {
            $url = new \webignition\Url\Url($link['url']);

            if (!$url->hasScheme()) {
                $url->setScheme('http');
            }

            $this->links[$key]['url'] = (string) $url;
        }

        $this->sections = $this->section; // Ejem...
        $this->start_year = $this->start_year == 0 ? null : $this->start_year;
        $this->end_year = $this->end_year == 0 ? null : $this->end_year;
    }

    public function service() {
        if (!$this->service) {
            $services = $this->terms('co_service', true, 'CO_Service');

            if (is_array($services) && count($services)) {
                $this->service = $services[0];
            }
        }

        return $this->service;
    }

    public function service_ids() {
        if (!$this->service_ids) {
            $this->service_ids = array_map(function ($service) {
                return $service->id;
            }, $this->services());
        }

        return $this->service_ids;
    }

    public function services() {
        if (!$this->services) {
            $this->services = $this->terms('co_service', true, 'CO_Service');
        }

        return $this->services;
    }
}
