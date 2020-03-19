<?php

/**
 * Hier könen Sammlungen und Felder für Advanced Custom Fields gespeichert werden. 
 * 
 * @since 1.0.0
 * 
 */

return [
    'field_groups' => [
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
    'fields' => [
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