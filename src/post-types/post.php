<?php
use \Ent\Helpers;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('init', function () {
    Helpers::adminRemoveComments();
    Helpers::adminChangePostLabels([
        'name'     => 'Actualitat',
        'singular' => 'Noticia',
        'add'      => 'Afegeix',
        'tags'     => 'Tags actualitat',
    ]);
});

Helpers::setMeta('post', function () {
    return Container::make('post_meta', 'Formulari noticia')
        ->show_on_post_type('post')
        ->set_priority('low')
        ->add_fields([
            Helpers::cf_create_links('Enlaces'),
            Helpers::cf_create_attachments('Archivos adjuntos'),
            Helpers::cf_create_media('Galeria multimedia'),
        ]);
});

class CO_Post extends \Timber\Post {
    public function __construct($pid = null) {
        parent::__construct($pid);
        Helpers::getPostMeta('post', $this);
    }

    // Get an image, any image, try with featured image first
    public function one_image() {
        if ($this->thumbnail) {
            return $this->thumbnail;
        } else {
            foreach ($this->media as $media) {
                if ($media['_type'] == '_image') {
                    return new \TimberImage(+$media['image']);
                }
            }

            return null;
        }
    }
}
