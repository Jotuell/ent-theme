<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_index_intro extends Ent\VisualComposer\ShortCode {}

$admin_tpl = <<<TPL
    <row>
        <column>
            <h1>{{{ params.intro }}}</h1>
        </column>
        <column>
            {{{ ent_image(params.image, "medium", "100%x200") }}}
        </column>
    </row>
    <row>
        <column>
            <h2>{{{ params.title_a }}}</h2>
            <p>{{{ params.text_a }}}</p>
        </column>
        <column></column>
    </row>
    <row>
        <column></column>
        <column>
            <h2>{{{ params.title_b }}}</h2>
            <p>{{{ params.text_b }}}</p>
        </column>
    </row>
TPL;

Helpers::map([
    'base' => 'index_intro',
    'is_layout' => true,
    'custom_markup' => $admin_tpl,
    'params' => [
        [
            'type'       => 'attach_image',
            'heading'    => 'Imagen',
            'param_name' => 'image',
        ],
        [
            'type'       => 'textfield',
            'heading'    => 'Texto introducción',
            'param_name' => 'intro',
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
