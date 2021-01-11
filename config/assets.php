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
    ],
    "styles" => [
        
        [
            'handle' => 'theme_style',
            'url' => get_template_directory_uri() . '/assets/dist/style.css',
            'dependencies' => [],
            'version' => false,
            'media' => 'all'
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