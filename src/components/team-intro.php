<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_team_intro extends Ent\VisualComposer\ShortCode {}

$admin_tpl = <<<TPL
    <row>
        <column>
            {{{ ent_image(params.image, "large", "100%x250") }}}
            <br>
        </column>
    </row>
    <row>
        <column>
            <h1>{{{ params.title }}}</h1>
        </column>
        <column>
            {{{ vc_wpautop(params.content) }}}
        </column>
    </row>
TPL;

Helpers::map([
    'base' => 'team_intro',
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
            'heading'    => 'Titulo',
            'param_name' => 'title',
        ],
        [
            'type'       => 'textarea_html',
            'heading'    => 'Texto',
            'param_name' => 'content',
        ],
    ]
]);
