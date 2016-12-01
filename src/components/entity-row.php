<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_entity_row extends Ent\VisualComposer\ShortCode {}

$admin_tpl = <<<TPL
    <# var bg_color = params.bg !== "neutral" ? "#fff" : "#f0f0f0"; #>
    <div style="background-color: {{{ bg_color }}};">
        <row>
            <column>
                {{{ ent_image(params.image, "medium", "100x100") }}}
            </column>
            <column-3>
                <h1>{{{ params.title }}}</h1>
                {{{ vc_wpautop(params.content) }}}
                <# if (params.link) { #>{{{ ent_link(params.link) }}}<# } #>
            </column-3>
        </row>
    </div>
TPL;

Helpers::map([
    'base' => 'entity_row',
    'is_layout' => true,
    'custom_markup' => $admin_tpl,
    'params' => [
        [
            'type'       => 'dropdown',
            'heading'    => 'Fondo',
            'param_name' => 'bg',
            'value'      => ['Blanco' => 'white', 'Neutro' => 'neutral'],
        ],
        [
            'type'       => 'textfield',
            'heading'    => 'Nombre',
            'param_name' => 'title',
        ],
        [
            'type'       => 'attach_image',
            'heading'    => 'Logo',
            'param_name' => 'image',
        ],
        [
            'type'       => 'vc_link',
            'heading'    => 'Link',
            'param_name' => 'link',
        ],
        [
            'type'       => 'textarea_html',
            'heading'    => 'Texto',
            'param_name' => 'content',
        ],
    ]
]);
