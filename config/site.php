<?php
#
# Page Configuration
#

# Language for date and time calculation
return [
    "locale" => "de_DE",
    "template_folder"=> ['templates', 'views'],
    "theme_support" => [
        "menus" => [],
        "post-thumbnails"=> [],
        "title-tag"=> [],
        "automatic-feed-links"=> [],
        "html5"=> ['comment-form', 'comment-list', 'gallery', 'caption'],
        "post-formats"=> ['aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio']
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