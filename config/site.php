<?php
#
# Page Configuration
#

# Language for date and time calculation
return [
    "locale" => "de_AT", 
    "template_folder"=> ['templates', 'views'],
    "theme_support" => [
        "menus" => [],
        "post-thumbnails"=> [],
        "title-tag"=> [],
        "automatic-feed-links"=> [],
        "html5"=> ['comment-form', 'comment-list', 'gallery', 'caption'],
        "post-formats"=> ['aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio'],
        "editor-color-palette" => [
            [
                "color" => "#34c4eb",
                "name" => "Blau",
                "slug" => "primary"
            ],
            [
                "color" => "#f59c00",
                "name" => "Orange",
                "slug" => "warning"
            ],
            [
                "color" => "#85bc22",
                "name" => "Orange",
                "slug" => "success"
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
    ],
    "widgets" => [
        'Footer-Bereich' => [
            "id" => 'footer_area',
            "description" => 'Widget-Bereich ganz unten auf der Seite',
            "before_widget"=> '<div class="col col-12 col-lg-4">',
            "after_widget"=> '</div>',
            "before_title"=> '<h4>',
            "after_title"=> '</h4>'
        ]
    ],
    "mime" => [
        'svg' => 'image/svg+xml',
        'pdf' => 'application/pdf',
        'zip' => 'application/zip'
    ]
];