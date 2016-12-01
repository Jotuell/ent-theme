<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_project_list extends Ent\VisualComposer\ShortCode {
    protected function getContextData(array $atts) {
        $limit = 9;
        $count = 0;
        $featured = [];
        $list = [];
        $data = Timber::get_posts([
            'post_type'      => 'co_project',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ]);

        usort($data, function ($a, $b) {
            if ($a->is_featured == $b->is_featured) {
                if ($a->start_year == $b->start_year) {
                    return strcmp($a->title, $b->title);
                } else {
                    return $a->start_year < $b->start_year;
                }
            } else {
                return $a->is_featured < $b->is_featured;
            }
        });

        foreach ($data as $project) {
            if ($project->is_featured && $count < $limit) {
                $featured[] = $project;
                $count++;
            } else {
                $list[] = $project;
            }
        }

        return [
            'featured' => $featured,
            'list'     => $list,
            'services' => Timber::get_terms('co_service', [], 'CO_Service'),
        ];
    }
}

Helpers::map([
    'base' => 'project_list',
    'is_layout' => true,
    'params' => []
]);
