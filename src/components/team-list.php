<?php
use \Ent\VisualComposer\Helpers;

class WPBakeryShortCode_team_list extends Ent\VisualComposer\ShortCode {
    protected function getContextData(array $atts) {
        $data = array_map(function ($d) {
            $d['image'] = new TimberImage($d['image']);
            $d['image_alt'] = new TimberImage($d['image_alt']);

            return $d;
        }, carbon_get_post_meta($atts['context']['page']->id, 'team', 'complex'));

        $team = array_filter($data, function ($d) { return $d['type'] != 'collaborator'; });
        shuffle($team);

        return [
            'team' => $team,
        ];
    }
}

Helpers::map([
    'base' => 'team_list',
    'is_layout' => true,
    'params' => []
]);
