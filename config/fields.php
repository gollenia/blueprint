<?php

// In this fils, you may configure your custom fields. You need to install Advanced Custom Fields in order to work,
// otherwise this file will be ignored.


return [
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
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ]
];