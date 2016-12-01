<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_index_destacats extends Ent\VisualComposer\ShortCode {
    protected function getContextData(array $atts) {
        $total = $atts['total'] ? $atts['total'] : 5;

        return [
            'projects' => Timber::get_posts([
                'post_type'      => 'co_project',
                'posts_per_page' => $total,
                'post_status'    => 'publish',
                'orderby'        => 'rand',
                'meta_query'     => [
                    [
                        'key'   => '_is_featured',
                        'value' => 'yes',
                    ]
                ],
            ])
        ];
    }
}

Helpers::map([
    'base' => 'index_destacats',
    'is_layout' => true,
    'params' => [
        [
            'type'       => 'textfield',
            'heading'    => 'Número de destacados',
            'value'      => 5,
            'param_name' => 'total',
        ],
    ]
]);
