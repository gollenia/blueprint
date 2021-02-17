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
    
    "audience" => [
        "object_type" => EM_POST_TYPE_EVENT,
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
    ],
    "event_category" => [
        "object_type" => EM_POST_TYPE_EVENT,
        "options" => [
            'hierarchical' => true,
            'labels' => [
                'name' => "Veranstaltungsart",
                'singular_name' => "Veranstaltungsart",
                'all_items' => "Alle Veranstaltungsarten",
                'add_new_item' => "Neue Veranstaltungsart erstellen",
                'not_found' => "Keine Veranstaltungsart gefunden",
            ],
            'show_ui' => true,
            'show_in_rest' => true,
            'description' => "Art der Veranstaltung",
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite' => ['slug' => 'event_category']
        ]
    ],
    "event_tag" => [
        "object_type" => EM_POST_TYPE_EVENT,
        "options" => [
            'hierarchical' => false,
            'labels' => [
                'name' => "Schlagwort",
                'singular_name' => "Schlagworte",
                'all_items' => "Alle Schlagworte",
                'add_new_item' => "Neues Schlagwort erstellen",
                'not_found' => "Keine Schlagworte gefunden",
            ],
            'show_ui' => true,
            'show_in_rest' => true,
            'description' => "Schlagworte, um Veranstaltungen besser zu kategorisieren",
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite' => ['slug' => 'event_tag']
        ]
    ]
    
];
