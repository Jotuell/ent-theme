<?php
use \Ent\Helpers;

add_action('init', function () {
    Helpers::convertTaxonomyToRadio('category');
});
