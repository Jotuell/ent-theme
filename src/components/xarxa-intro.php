<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_xarxa_intro extends Ent\VisualComposer\ShortCode {}

$admin_tpl = <<<TPL
    <row>
        <column>
            <h1>{{{ params.title }}}</h1>
        </column>
        <column-3>
            {{{ vc_wpautop(params.intro) }}}
        </column-3>
    </row>
TPL;

Helpers::map([
    'base' => 'xarxa_intro',
    'is_layout' => true,
    'custom_markup' => $admin_tpl,
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
    ]
]);
