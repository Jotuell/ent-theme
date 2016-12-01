<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_team_collaborators extends Ent\VisualComposer\ShortCode {
    protected function getContextData(array $atts) {
        $data = carbon_get_post_meta($atts['context']['page']->id, 'team', 'complex');
        $collaborators = array_filter($data, function ($d) { return $d['type'] == 'collaborator'; });

        return [
            'collaborators' => $collaborators,
        ];
    }
}

$admin_tpl = <<<TPL
    <row>
        <column>
            <box>Colaboradores</box>
        </column>
        <column>
            <h2>{{{ params.cta_text }}}</h2>
            {{{ ent_link(params.cta_link) }}}
        </column>
    </row>
TPL;

Helpers::map([
    'base' => 'team_collaborators',
    'is_layout' => true,
    'custom_markup' => $admin_tpl,
    'params' => [
        [
            'type'       => 'textfield',
            'heading'    => 'Texto contacto',
            'param_name' => 'cta_text',
        ],
        [
            'type'       => 'vc_link',
            'heading'    => 'Link',
            'param_name' => 'cta_link',
        ],
    ]
]);
