<?php
/** 
 * Add assets here. The can be registered with \Contexis\Wordpress\Assets:register()
 * 
 * Use following sections: scripts, styles, remove_scripts, remove_styles
 * For further Info on options and Arguments see:
 * 
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 * 
 * @return array assets
 * 
 * @since 1.0.0
*/

return [
    "styles" => [
        [
            'handle' => 'material_icons',
            'url' => 'https://fonts.googleapis.com/icon?family=Material+Icons',
            'version' => false,
        ],
        [
            'handle' => 'style',
            'url' => get_template_directory_uri() . '/assets/dist/style.css',
            'version' => filesize ( get_template_directory() . "/assets/dist/style.css" ),
            'media' => 'all',
        ]
    ],
    "scripts" => [
        [
             'handle' => 'theme_script',
             'url' => get_template_directory_uri() . '/assets/dist/app.js',
             'dependencies' => [
                 'wp-api-fetch'
             ],
            'version' => false,
            'in_footer' => true
        ],
        [
            'handle' => 'alpine',
            'url' => 'https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js',
            'dependencies' => [],
           'version' => false,
           'in_footer' => false
       ]
    ],
    "admin_styles" => [
        [
            'handle' => 'admin_style',
            'url' => get_template_directory_uri() . '/assets/dist/admin.css',
            'dependencies' => [],
            'version' => false,
            'media' => 'all'
        ]
    ],
    "admin_scripts" => [

    ],
    "remove_scripts" => [

    ],
    "remove_styles" => [
        'events-manager', "events-manager-pro"
    ]
];