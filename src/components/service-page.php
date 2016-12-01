<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_service_page extends Ent\VisualComposer\ShortCode {
    protected function getContextData(array $atts) {
        $service_list = [];
        $services = explode(',', $atts['service_list']);
        $columns = 3;
        $services_per_column = count($services) / $columns;

        foreach ($services as $i => $service) {
            $i = floor($i / $services_per_column) % $columns;

            if (!array_key_exists($i, $service_list)) {
                $service_list[$i] = [];
            }

            $service_list[$i][] = $service;
        }

        return [
            'related_projects' => Timber::get_posts([
                'post_type'      => 'co_project',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'orderby'        => 'meta_value_num',
                'meta_key'       => '_is_featured',
                'tax_query'      => [
                    [
                        'taxonomy' => 'co_service',
                        'field'    => 'term_id',
                        'terms'    => $atts['service'],
                    ]
                ],
            ]),
            'related_news' => Timber::get_posts([
                'post_type'      => 'post',
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'tax_query'      => [
                    [
                        'taxonomy' => 'co_service',
                        'field'    => 'term_id',
                        'terms'    => $atts['service'],
                    ]
                ],
            ]),
            'service_list' => $service_list,
        ];
    }
}

$services = [];

foreach (get_terms(['taxonomy' => 'co_service', 'hide_empty' => false]) as $term) {
    $services[$term->name] = (string) $term->term_id;
}

$admin_tpl = <<<TPL
    <row>
        <column>
            {{{ ent_image(params.image, "medium", "100%x260") }}}
        </column>
        <column>
            <h1>{{{ post_title }}}</h1>
            {{{ vc_wpautop(params.content) }}}
        </column>
    </row>
    <row>
        <column>
            <h3>{{{ params.service_list_title }}}</h3>
            <div style="column-count: 3;">
                {{{ params.service_list.split(",").join("<br>") }}}
            </div>
            <br>
            <div style="text-align: center;">
                <h3>{{{ params.contact }}}</h3>
                {{{ ent_link(params.contact_link) }}}
            </div>
            <br>
            <box>Proyectos relacionados</box>
            <br>
            <box>Noticias relacionadas</box>
        </column>
    </row>
TPL;

Helpers::map([
    'base' => 'service_page',
    'is_layout' => true,
    'custom_markup' => $admin_tpl,
    'params' => [
        [
            'type'       => 'dropdown',
            'heading'    => 'Servicio',
            'param_name' => 'service',
            'value'      => $services,
        ],
        [
            'type'       => 'attach_image',
            'heading'    => 'Imagen',
            'param_name' => 'image',
        ],
        [
            'type'       => 'attach_image',
            'heading'    => 'Imagen de fondo',
            'param_name' => 'image_overlay',
        ],
        [
            'type'       => 'textfield',
            'heading'    => 'URL del video',
            'param_name' => 'video_url',
            'description' => 'YouTube o Vimeo',
        ],
        [
            'type'       => 'textarea_html',
            'heading'    => 'Intro',
            'param_name' => 'content',
        ],
        [
            'type'       => 'textfield',
            'heading'    => 'Frase contacto',
            'param_name' => 'contact',
        ],
        [
            'type'       => 'vc_link',
            'heading'    => 'Enlace contacto',
            'param_name' => 'contact_link',
        ],
        [
            'type'       => 'textfield',
            'heading'    => 'Título servicios',
            'param_name' => 'service_list_title',
        ],
        [
            'type'       => 'exploded_textarea',
            'heading'    => 'Listado de servicios (una por linea)',
            'param_name' => 'service_list',
        ],
    ]
]);
