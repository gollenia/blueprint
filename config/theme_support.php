<?php

/** 
 * Add theme-support here. The can be registered with \Contexis\Wordpress\ThemeSupport:register()
 * For further Info on options and Arguments see:
 * 
 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
 * 
 * @return array Taxonomies
*/

return [
    "menus" => [],
    "post-thumbnails" => [],
    "title-tag" => [],
    'disable-custom-font-sizes' => [],
    'disable-custom-colors' => [],
    'wp-block-styles' => [],
    'responsive-embeds' => [],
    'editor-styles' => [],
    'custom-background' => [],
    'align-wide' => [],
    "automatic-feed-links" => [],
    "html5"=> ['comment-form', 'comment-list', 'gallery', 'caption'],
    "post-formats"=> ['aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio'],
    "editor-color-palette" => [
        [
            "color" => "#eeeeee",
            "name" => "Standard",
            "slug" => "default"
        ],
        [
            "color" => "#10bae7",
            "name" => "Blau",
            "slug" => "primary"
        ],
        [
            "color" => "#f59b00",
            "name" => "Orange",
            "slug" => "warning"
        ],
        [
            "color" => "#85bc22",
            "name" => "Orange",
            "slug" => "success"
        ],
        [
            "color" => "#e3000b",
            "name" => "Rot",
            "slug" => "danger"
        ],
        [
            "color" => "#fff",
            "name" => "Weiß",
            "slug" => "white"
        ],
        [
            "color" => "#333",
            "name" => "Schwarz",
            "slug" => "black"
        ]       	    
    ]
];