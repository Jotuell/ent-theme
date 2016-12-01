<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_celobert_page extends Ent\VisualComposer\ShortCode {
    protected function getContextData(array $atts) {
        return [
            'clients' => array_map(function ($d) {
                $d['image'] = new TimberImage($d['image']);

                return $d;
            }, carbon_get_post_meta($atts['context']['page']->id, 'clients', 'complex')),
        ];
    }
}

Helpers::map([
    'base' => 'celobert_page',
    'is_layout' => true,
    'params' => [
        [
            'type'       => 'textfield',
            'heading'    => 'Título',
            'param_name' => 'title',
        ],
        [
            'type'       => 'textarea',
            'heading'    => 'Intro',
            'param_name' => 'intro',
        ],
        [
            'type'       => 'attach_image',
            'heading'    => 'Imagen',
            'param_name' => 'image',
        ],
        [
            'type'       => 'textfield',
            'heading'    => 'Título (A)',
            'param_name' => 'title_a',
        ],
        [
            'type'        => 'textarea',
            'heading'     => 'Parrafo (A)',
            'param_name'  => 'text_a',
        ],
        [
            'type'       => 'textfield',
            'heading'    => 'Título (B)',
            'param_name' => 'title_b',
        ],
        [
            'type'        => 'textarea',
            'heading'     => 'Parrafo (B)',
            'param_name'  => 'text_b',
        ],
    ]
]);
