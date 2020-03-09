<?php

/**
 * Hier könen Sammlungen und Felder für Advanced Custom Fields gespeichert werden. 
 * 
 * @since 1.0.0
 * 
 */

return [
    'blocks' => [
        [
            'name'              => 'testimonial',
            'id'                => 'hihi',
            'title'             => __('Testimonial'),
            'description'       => __('A custom testimonial block.'),
            'render_callback'   => "\Contexis\Utilities::render",
            'category'          => 'formatting',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'testimonial', 'quote' )
        ]
    ],
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