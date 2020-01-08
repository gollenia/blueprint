<?php

/**
 * Hier werden Optionen für das Backend gespeichert. Ein Generator in \Contexis\Core\Options 
 * erstellt daraus dann die entsprechenden Wordpress-Funktionen.
 * 
 * @since 1.0.0
 */

return [
    'pages' => '',
    'sections' => [
        [
            'id' => 'default',
            'title' => 'Allgemein',
            'description' => 'Allgemeine Einstellungen'
        ],
        [
            'id' => 'social',
            'title' => "Social Media",
            'description' => "Integrate Facebook, Twitter etc. into your Site"
        ]
    ],
    'settings' => [
        [
            'id' => 'facebook',
            'title' => "Facebook-URL",
            'type' => "text",
            'section' => "default"
        ],
        [
            'id' => "twitter",
            'title' => "Twitter Name",
            'type' => "text",
            'section' => "default"
        ],
        [
            'id' => 'logo',
            'title' => "Twitter Name",
            'type' => "image",
            'section' => "default"
        ]
    ]
];