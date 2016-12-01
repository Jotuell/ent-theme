<?php
// To resize images to max width of 2400, copy the original folder, then run on the copied folder:
// mogrify -resize '2400>' -verbose * && rm *~
// mogrify -resize '2000x2000>' -verbose -quality 85 * && rm *~

$file_ids     = [];
$file_paths   = [];
$media_id     = 0;
$assets_path  = realpath(WP_CONTENT_DIR .'/../../celobert-old');
$uploads_path = WP_CONTENT_DIR .'/uploads/'. date('Y') .'/'. date('m');
$__ = [
    'attachment' => [
        'ca' => 'Descarregar PDF',
        'es' => 'Descargar PDF',
        'en' => 'Download PDF',
        'fr' => 'Télécharger PDF',
    ],
    'link' => [
        'ca' => 'Més informació',
        'es' => 'Más información',
        'en' => 'More info',
        'fr' => "Plus d'info",
    ],
];

// 1 Arquitectura sostenible
// 2 Enginyeria de proximitat
// 3 Urbanisme transofrmador
$serviceMap = [
    'ca' => [
        1  => [4],
        2  => [4],
        3  => [4],
        4  => [4],
        6  => [3, 4],
        7  => [5],
        8  => [3, 5],
        9  => [3],
        10 => [5],
        11 => [3, 5],
        12 => [4],
        14 => [5],
        15 => [3],
        16 => [5],
    ],
    'es' => [
        1  => [18],
        2  => [18],
        3  => [18],
        4  => [18],
        6  => [12, 18],
        7  => [15],
        8  => [12, 15],
        9  => [12],
        10 => [15],
        11 => [12, 15],
        12 => [18],
        14 => [15],
        15 => [12],
        16 => [15],
    ],
    'en' => [
        1  => [16],
        2  => [16],
        3  => [16],
        4  => [16],
        6  => [10, 16],
        7  => [13],
        8  => [10, 13],
        9  => [10],
        10 => [13],
        11 => [10, 13],
        12 => [16],
        14 => [13],
        15 => [10],
        16 => [13],
    ],
    'fr' => [
        1  => [17],
        2  => [17],
        3  => [17],
        4  => [17],
        6  => [11, 17],
        7  => [14],
        8  => [11, 14],
        9  => [11],
        10 => [14],
        11 => [11, 14],
        12 => [17],
        14 => [14],
        15 => [11],
        16 => [14],
    ],
];

$newsMap = ['ca' => [1], 'es' => [9], 'en' => [7], 'fr' => [8]];

function echo_flush($str) {
    echo $str;
    flush();
    ob_flush();
}

function reset_media_counter() {
    global $media_id;
    $media_id = 0;
}

function add_media(&$meta, $group, $values) {
    global $media_id;

    foreach ($values as $field => $value) {
        $meta['_media_'. $group .'-_'. $field .'_'. $media_id] = $value;
    }

    $media_id++;
}

function add_section_media(&$meta, $group, $values) {
    global $media_id;

    foreach ($values as $field => $value) {
        $meta['_section_-_media_0_'. $group .'-_'. $field .'_'. $media_id] = $value;
    }

    $media_id++;
}

function get_file($basename) {
    require_once ABSPATH .'wp-admin/includes/image.php';

    global $file_ids, $file_paths, $uploads_path, $assets_path;

    $basename = strtolower($basename);

    if (array_key_exists($basename, $file_ids)) {
        return $file_ids[$basename];
    } else {
        // FILE UPLOAD!
        // See: http://wordpress.stackexchange.com/questions/141509/how-to-upload-a-media-file-via-ftp-and-then-create-an-attachment-post-with-it
        if (!array_key_exists($basename, $file_paths)) {
            throw new \Exception('Unknown file: "'. $basename .'".');
        } else {
            $filename = $file_paths[$basename];
        }

        $basename = strtolower(basename($filename));

        copy($filename, $uploads_path .'/'. $basename);

        $filename = $uploads_path .'/'. $basename;
        $filetype = wp_check_filetype($basename, null);
        $wp_upload_dir = wp_upload_dir();
        $file_id = wp_insert_attachment([
            'guid'           => $wp_upload_dir['url'] .'/'. $basename,
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace('/\.[^.]+$/', '', $basename),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ], $filename);

        // For images, generate the metadata for the attachment, and update the database record.
        // Resized images, thumbnails, etc.
        if (strpos($filetype['type'], 'image') !== false) {
            wp_update_attachment_metadata($file_id, wp_generate_attachment_metadata($file_id, $filename));
        }

        $file_ids[$basename] = $file_id;

        return $file_id;
    }
}

function insert_new($locale, $d) {
    // [X] imagen - FILE/GALLERY
    // [X] imagen2 - FILE/GALLERY
    // [X] imagen3 - FILE/GALLERY
    // [X] imagen4 - FILE/GALLERY
    // [X] imagen5 - FILE/GALLERY
    // [X] imagen6 - FILE/GALLERY
    // [X] any
    // [X] pdf - FILE/GALLERY
    // [X] link
    // [X] titol_ca
    // [X] titol_es
    // [X] titol_fr
    // [X] titol_en
    // [X] texto_ca
    // [X] texto_es
    // [X] texto_fr
    // [X] texto_en
    // [X] video - FILE/GALLERY
    // [-] destacado
    // [X] estado

    global $__, $newsMap;

    $meta = [];
    reset_media_counter();

    if ($d['link'] !== '') {
        $meta['_links_-_title_0'] = $__['link'][$locale];
        $meta['_links_-_url_0']   = $d['link'];
    }

    if ($d['pdf'] !== '') {
        $meta['_attachments_-_title_0'] = $__['attachment'][$locale];
        $meta['_attachments_-_file_0']  = get_file($d['pdf']);
    }

    if ($d['video'] != '') {
        add_media($meta, 'youtube', [
            'video_url' => 'https://www.youtube.com/watch?v='. $d['video'],
        ]);
    }

    foreach (['imagen', 'imagen2', 'imagen3', 'imagen4', 'imagen5', 'imagen6'] as $f) {
        if ($d[$f] !== '') {
            add_media($meta, 'image', [
                'image' => get_file($d[$f]),
            ]);
        }
    }

    // Old ID
    $meta['_old_id'] = $d['id'];

    $id = wp_insert_post([
        'post_date'    => $d['any'],
        'post_title'   => $d['titol_'. $locale],
        'post_content' => $d['texto_'. $locale],
        'post_status'  => +$d['estado'] == 0 ? 'draft' : 'publish',
        'meta_input'   => $meta,
    ]);

    // Define services taxonomy
    wp_set_object_terms($id, $newsMap[$locale], 'category');

    return $id;
}

function insert_project($locale, $d) {
    // [-] portada
    // [X] imagen - FILE/GALLERY
    // [X] imagen2 - FILE/GALLERY
    // [X] imagen3 - FILE/GALLERY
    // [X] imagen4 - FILE/GALLERY
    // [X] imagen5 - FILE/GALLERY
    // [X] imagen6 - FILE/GALLERY
    // [X] video - FILE/GALLERY
    // [X] any
    // [X] anyf
    // [X] client
    // [X] ubicacio
    // [X] ubicacio_es
    // [X] ubicacio_fr
    // [X] ubicacio_en
    // [X] equip
    // [X] pdf - FILE/GALLERY
    // [X] link
    // [X] titol_ca
    // [X] titol_es
    // [X] titol_fr
    // [X] titol_en
    // [X] serveis
    // [X] texto_ca
    // [X] texto_es
    // [X] texto_fr
    // [X] texto_en
    // [-] destacado
    // [X] activitat
    // [X] clas
    // [X] estado

    global $__, $serviceMap;

    reset_media_counter();

    $energy_class = 'ABCDEFG';
    $meta = [
        '_is_finished'  => $d['anyf'] == 'en curs' ? '' : 'yes',
        '_start_year'   => $d['any'] == 'en curs' ? '' : $d['any'],
        '_end_year'     => $d['anyf'] == 'en curs' ? '' : $d['anyf'],
        '_team'         => html_entity_decode($d['equip']),
        '_place'        => html_entity_decode($d['ubicacio'. ($locale == 'ca' ? '' : '_'. $locale)]),
        '_client'       => html_entity_decode($d['client']),
        '_energy_class' => $d['clas'] == 0 ? '' : $energy_class[$d['clas'] - 1],
    ];

    if ($d['link'] !== '') {
        $meta['_links_-_title_0'] = $__['link'][$locale];
        $meta['_links_-_url_0']   = $d['link'];
    }

    if ($d['pdf'] !== '') {
        $meta['_attachments_-_title_0'] = $__['attachment'][$locale];
        $meta['_attachments_-_file_0']  = get_file($d['pdf']);
    }

    if ($d['video'] != '') {
        add_section_media($meta, 'youtube', [
            'video_url' => 'https://www.youtube.com/watch?v='. $d['video'],
        ]);
    }

    foreach (['imagen', 'imagen2', 'imagen3', 'imagen4', 'imagen5', 'imagen6'] as $f) {
        if ($d[$f] !== '') {
            add_section_media($meta, 'image', [
                'image' => get_file($d[$f]),
            ]);
        }
    }

    // Old ID
    $meta['_old_id'] = $d['id'];

    // Services array
    $services = [];

    if (trim($d['serveis']) !== '') {
        foreach (explode(',', $d['serveis']) as $service_id) {
            // Don't insert "Sostre Civic" projects
            if (+$service_id == 12) {
                return false;
            }

            $services = array_merge($services, $serviceMap[$locale][+$service_id]);
        }
    }

    $services = array_unique($services);

    // Insert project
    $id = wp_insert_post([
        'post_type'    => 'co_project',
        'post_title'   => html_entity_decode($d['titol_'. $locale]),
        'post_content' => html_entity_decode($d['texto_'. $locale]),
        'post_status'  => +$d['estado'] == 0 ? 'draft' : 'publish',
        'meta_input'   => $meta,
    ]);

    // Define services taxonomy
    wp_set_object_terms($id, $services, 'co_service');

    return $id;
}

Routes::map('migrate', function () use ($sitepress) {
    set_time_limit(0);
    ini_set('max_execution_time', 0);

    // CREATE FILES INDEX
    global $file_paths, $assets_path, $uploads_path;

    echo_flush('Assests path: '. $assets_path .'<br>');
    echo_flush('Assests path: '. $uploads_path .'<br>');

    $asset_sets = [
        ['path' => 'org-resized'],
        ['path' => 'pdf-resized'],
    ];

    foreach ($asset_sets as $set) {
        echo_flush('<div style="width: 65%; word-wrap: break-word;">Indexing files from path "'. $set['path'] .'" ');

        foreach (glob($assets_path .'/'. $set['path'] .'/*') as $filename) {
            echo_flush('|');

            $basename = strtolower(basename($filename));

            if (array_key_exists($basename, $file_paths)) {
                continue;
            }

            $file_paths[$basename] = $filename;
        }

        echo_flush(' <strong>Done.</strong></div><br>');
    }

    // MIGRATE NEWS & PROJECTS
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=celobert_old', 'root', null);

    $datasets = [
        [
            'action'    => 'Populating news',
            'query'     => 'SELECT * FROM tb_noticies',
            'insert_fn' => 'insert_new',
            'wpml_type' => 'post_post',
        ],
        [
            'action'    => 'Populating projects',
            'query'     => 'SELECT * FROM tb_projectes',
            'insert_fn' => 'insert_project',
            'wpml_type' => 'post_co_project',
        ]
    ];

    foreach ($datasets as $set) {
        echo_flush($set['action'] .' ');

        foreach ($pdo->query($set['query']) as $i => $d) {
            echo_flush('|');

            $caid = $set['insert_fn']('ca', $d);
            $trid = $sitepress->get_element_trid($caid);

            foreach (['es', 'fr', 'en'] as $locale) {
                if (empty($d['titol_'. $locale]) && empty($d['texto_'. $locale])) {
                    continue;
                }

                $id = $set['insert_fn']($locale, $d);

                if ($id !== false) {
                    $sitepress->set_element_language_details($id, $set['wpml_type'], $trid, $locale);
                }
            }
        }

        echo_flush(' <strong>Done.</strong><br>');
    }

    die;
});
