<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_index_actualitat extends Ent\VisualComposer\ShortCode {
    protected function getContextData(array $atts) {
        return [
            'news_link' => get_category_link(get_cat_ID('noticia')),
            'posts_link' => get_permalink(get_option('page_for_posts')),
            'news' => Timber::get_posts([
                'posts_per_page' => 3,
                'post_status'    => 'publish',
                'category_name'  => 'noticia',
            ]),
            'post' => Timber::get_post([
                'posts_per_page' => 1,
                'post_status'    => 'publish',
                'category_name'  => 'post',
            ]),
        ];
    }
}

Helpers::map([
    'base' => 'index_actualitat',
    'is_layout' => true,
    'params' => []
]);
