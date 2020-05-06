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
            "contrast" => "#222222"
        ],
        [
            "color" => "#009cd9",
            "name" => "Blau",
            "slug" => "blue",
            "contrast" => "#eeeeee"
        ],
        [
            "color" => "#ccf1ff",
            "name" => "Hellblau",
            "slug" => "lightblue",
            "contrast" => "#222222"
        ],
        [
            "color" => "#f59b00",
            "name" => "Orange",
            "slug" => "orange",
            "contrast" => "#eeeeee"
        ],
        [
            "color" => "#ffeccc",
            "name" => "Hell Orange",
            "slug" => "lightorange",
            "contrast" => "#222222"
        ],
        [
            "color" => "#A5BD58",
            "name" => "Grün",
            "slug" => "green",
            "contrast" => "#eeeeee"
        ],
        [
            "color" => "#ebf0db",
            "name" => "Grün",
            "slug" => "lightgreen",
            "contrast" => "#222222"
        ],
        [
            "color" => "#9F70B0",
            "name" => "Lila",
            "slug" => "purple",
            "contrast" => "#eeeeee"
        ],
        [
            "color" => "#e9deed",
            "name" => "Lila",
            "slug" => "lightpurple",
            "contrast" => "#222222"
        ],
        [
            "color" => "#e3000b",
            "name" => "Rot",
            "slug" => "red",
            "contrast" => "#eeeeee"
        ],
        [
            "color" => "#ffcccf",
            "name" => "Hell-Rot",
            "slug" => "lightred",
            "contrast" => "#222222"
        ],
        [
            "color" => "#222222",
            "name" => "Schwarz",
            "slug" => "black",
            "contrast" => "#eeeeee"
        ]       	    
    ]
];