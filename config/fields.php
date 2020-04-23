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
            "title" => "Optionen",
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
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'maxlength' => '',
                    'readonly' => 0,
                    'disabled' => 0,
                ]
                ],
            "location" => [
                [
                    [
                        "param" => "post_type",
                        "operator" => "==",
                        "value" => "post"
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
                    'placeholder' => 'http://facebook.com/yoursite'
                ],
                [
                    "key" => "youtube",
                    "label" => "Youtube",
                    "name" => "youtube",
                    "type" => "text",
                    'instructions' => '',
                    'placeholder' => 'http://youtube.com/yourchannel'
                ],
                [
                    "key" => "twitter",
                    "label" => "Twitter",
                    "name" => "twitter",
                    "type" => "text",
                    'instructions' => '',
                    'placeholder' => 'http://twitter.com/@yourtweet'
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
            ]
        ]
];