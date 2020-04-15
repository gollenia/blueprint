<?php
/**
 * Main Page Configuration
 * 
 * @since 1.0.0
 */
return [
    "scripts" => [
        [
            'handle' => 'theme_script',
            'url' => get_template_directory_uri() . '/assets/dist/main.js',
            'dependencies' => [],
            'version' => false,
            'in_footer' => true
        ],
    ],
    "styles" => [
            [
                'handle' => 'theme_style',
                'url' => get_template_directory_uri() . '/assets/dist/main.css',
                'dependencies' => [],
                'version' => false,
                'media' => 'all'
            ]
    ],
    "remove_scripts" => [

    ],
    "remove_styles" => [
        ['events-manager-css']
    ]
];