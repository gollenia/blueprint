<?php

/** 
 * Maybe you don't want every block being allowed on every page. Here, you can whitelist, which blocks on
 * which page are allowed
 * 
 * @link https://developer.wordpress.org/reference/hooks/allowed_block_types/
 * 
 * @return array Allowed Blocks
 * 
 * @since 1.0.0
*/ 

return [
    "post" => [
        "core/paragraph",
        "core/heading",
        "ctx-blocks/button",
        "ctx-blocks/image",
        "ctx-blocks/button",
        "ctx-blocks/alert",
        "ctx-blocks/progress",
        "ctx-blocks/description-list",
        "ctx-blocks/description-item",
        "ctx-blocks/accordion-collection",
        "ctx-blocks/accordion-item",
        "ctx-blocks/",
        "core/file",
        "core/more",
        "core/list",
        "core/table",
        "core/shortcode",
        "core/spacer",
        "core/pullquote",
        "core/code"
    ],
    "page" => [
        "core/paragraph",
        "core/heading",
        "core/audio",
        "core/latest-posts",
        "core/archives",
        "core/embed",
        "core-embed/twitter",
        "core-embed/facebook",
        "core-embed/instagram",
        "core-embed/youtube",
        "core/freeform",
        "ctx-blocks/image",
        "ctx-blocks/alert",
        "ctx-blocks/grid-row",
        "ctx-blocks/grid-column",
        "ctx-blocks/card",
        "ctx-blocks/button",
        "ctx-blocks/modal",
        "ctx-blocks/progress",
        "ctx-blocks/section",
        "ctx-blocks/columns",
        "ctx-blocks/description-list",
        "ctx-blocks/description-item",
        "ctx-blocks/accordion-collection",
        "ctx-blocks/accordion-item",
        "core/file",
        "core/list",
        "core/table",
        "core/subhead",
        "core/shortcode",
        "core/spacer",
        "core/pullquote",
        "core/code"
    ]
];