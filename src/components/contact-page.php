<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_contact_page extends Ent\VisualComposer\ShortCode {}

Helpers::map([
    'base' => 'contact_page',
    'is_layout' => true,
    'params' => [
        [
            'type'       => 'textfield',
            'heading'    => 'Latitud',
            'param_name' => 'lat',
        ],
        [
            'type'       => 'textfield',
            'heading'    => 'Longitud',
            'param_name' => 'lng',
        ],
    ]
]);
