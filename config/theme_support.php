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
            "slug" => "default",
            "dark" => false
            
        ],
        [
            "color" => "#009cd9",
            "name" => "Blau",
            "slug" => "blue",
            "dark" => true
        ],
        [
            "color" => "#ccf1ff",
            "name" => "Hellblau",
            "slug" => "lightblue",
            "dark" => false
        ],
        [
            "color" => "#f59b00",
            "name" => "Orange",
            "slug" => "orange",
            "dark" => false
        ],
        [
            "color" => "#ffeccc",
            "name" => "Hell Orange",
            "slug" => "lightorange",
            "dark" => false
        ],
        [
            "color" => "#A5BD58",
            "name" => "Grün",
            "slug" => "green",
            "dark" => true
        ],
        [
            "color" => "#ebf0db",
            "name" => "Grün",
            "slug" => "lightgreen",
            "dark" => false
        ],
        [
            "color" => "#9F70B0",
            "name" => "Lila",
            "slug" => "purple",
            "dark" => true
        ],
        [
            "color" => "#e9deed",
            "name" => "Lila",
            "slug" => "lightpurple",
            "dark" => false
        ],
        [
            "color" => "#e3000b",
            "name" => "Rot",
            "slug" => "red",
            "dark" => true
        ],
        [
            "color" => "#ffcccf",
            "name" => "Hell-Rot",
            "slug" => "lightred",
            "dark" => false
        ],
        [
            "color" => "#222222",
            "name" => "Schwarz",
            "slug" => "black",
            "dark" => true
        ]       	    
    ]
];