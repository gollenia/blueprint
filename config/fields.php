<?php
/** 
 * In this file, you may configure your custom fields. You need to install Advanced Custom Fields in order to work,
 * otherwise this file will be ignored.
 * 
 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
 * @link https://www.advancedcustomfields.com/resources/acf_add_options_page/
 * 
 * @return array Fields and Pages
 * 
 * @since 1.0.0
*/ 


return [
    "fields" => [
        [
            "key" => "page_options",
            "title" => "Seiten-Optionen",
            "fields" => [
                [
                    "key" => "subtitle",
                    "label" => "Untertitel",
                    "name" => "subtitle",
                    "type" => "text",
                    'prefix' => '',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '',
                ],
                [
                    "key" => "pagecolor",
                    "label" => "Farbe",
                    "name" => "pagecolor",
                    "type" => "select",
                    'choices' => array(
                        '' => 'Standard',
                        'page-orange'	=> 'Orange',
                        'page-green'	=> 'Grün',
                        'page-blue'	=> 'Blau',
                        'page-violett'	=> 'Violett',
                        'page-grey'	=> 'Grau',
                    ),
                    'prefix' => '',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '',
                ],
                [
                    "key" => "headerheight",
                    "label" => "Größe des Headers",
                    "name" => "headerheight",
                    "type" => "number",
                    "min" => 1,
                    "max" => 100,
                    'instructions' => 'Angabe in Prozent der Bildschirmhöhe',
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '10',
                ],
                [
                    "key" => 'headerurl',
                    "label" => "Link-URL",
                    "name" => "headerurl",
                    "type" => "link",
                    "instructions" => "Wenn ausgefüllt, wird ein entsprechender Button im Header angezeigt",
                    "required" => 0,
                    "return_format" => "array",
                    "conditional_logic" => 0
                ],
                [
                    "key" => "headerimageorientation",
                    "label" => "Ausrichtung des Seitenbildes",
                    "name" => "headerimageorientation",
                    "type" => "select",
                    'choices' => array(
                        '' => 'Standard',
                        'top'	=> 'Oben',
                        'center'	=> 'Mitte',
                        'bottom'	=> 'Unten',
                    ),
                    'prefix' => '',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '',
                ],
            ],
            "location" => [
                [
                    [
                        "param" => "post_type",
                        "operator" => "==",
                        "value" => "page"
                    ]
                    ],
                    [
                        [
                            "param" => "post_type",
                            "operator" => "==",
                            "value" => "page"
                        ]
                    ]
            ],
            'menu_order' => 0,
            'position' => 'side',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ],
        [
            "key" => "social_options",
            "title" => "Links zu sozialen Medien",
            "fields" => [
                [
                    "key" => "facebook",
                    "label" => "Facebook",
                    "name" => "facebook",
                    "type" => "text",
                    'prefix' => '',
                    'instructions' => '',
                    'default_value' => '',
                    'placeholder' => 'https://facebook.com/yoursite'
                ],
                [
                    "key" => "youtube",
                    "label" => "Youtube",
                    "name" => "youtube",
                    "type" => "text",
                    'instructions' => '',
                    'placeholder' => 'https://youtube.com/yourchannel'
                ],
                [
                    "key" => "twitter",
                    "label" => "Twitter",
                    "name" => "twitter",
                    "type" => "text",
                    'instructions' => '',
                    'placeholder' => 'https://twitter.com/@yourtweet'
                ]
            ],
            "location" => [
                [
                    [
                        'param' => 'options_page',
                        "operator" => "==",
                        "value" => "social-media-options"
                    ]
                ]
            ],
            'menu_order' => 0,
            //'position' => 'page',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
        ],
        [
            "key" => "branding_options",
            "title" => "Branding-Optionen",
            "fields" => [
                [
                    "key" => "Claim",
                    "label" => "claim",
                    "name" => "claim",
                    "type" => "text",
                    'prefix' => '',
                    'instructions' => '',
                    'default_value' => '',
                    'placeholder' => '... Damit Kinder ihr Vertrauen auf Gott setzen'
                ],
                [
                    "key" => "logo",
                    "label" => "logo",
                    "name" => "logo",
                    "type" => "text",
                    'instructions' => '',
                    'placeholder' => 'logo.svg'
                ]
            ],
            "location" => [
                [
                    [
                        'param' => 'options_page',
                        "operator" => "==",
                        "value" => "theme-settings"
                    ]
                ]
            ],
            'menu_order' => 0,
            //'position' => 'page',
            'style' => 'seamless',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
        ]
    ],
    "pages" => [
        "social_media" => [
           'page_title'    => __('Social Media Optionen'),
           'menu_title'    => __('Social Media'),
           'menu_slug'     => 'social-media-options',
           'capability'    => 'edit_posts',
           'redirect'      => false,
           'parent_slug' => 'options-general.php',
        ],
        "theme_settings" => [
            'page_title'    => __('Theme-Einstellungen'),
            'menu_title'    => __('Theme-Einstellungen'),
            'menu_slug'     => 'theme-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'parent_slug' => 'options-general.php',
         ]
    ]
];