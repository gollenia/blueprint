<?php

/** 
 * Add taxonomies here. The can be registered with \Contexis\Wordpress\Taxonomy:register()
 * For further Info on options and Arguments see:
 * 
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 * 
 * @return array Taxonomies
*/

return [
    /*
    "audience" => [
        "object_type" => ['page', 'post'],
        "options" => [
            'hierarchical' => false,
            'labels' => [
                'name' => "Zielgruppen",
                'singular_name' => "Zielgruppe",
                'all_items' => "Alle Zielgruppen",
                'add_new_item' => "Neue Zielgruppe erstellen",
                'not_found' => "Keine Zielgruppen gefunden",

            ],
            'show_ui' => true,
            'show_in_rest' => true,
            'description' => "Für wen ist der Beitrag geeignet?",
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite' => ['slug' => 'audience']
        ]
    ]
    */
];