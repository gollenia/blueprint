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
        "ctx-blocks/image",
        "ctx-blocks/alert",
        "ctx-blocks/grid-row",
        "ctx-blocks/grid-column",
        "ctx-blocks/card",
        "ctx-blocks/nav",
        "ctx-blocks/button",
        "ctx-blocks/modal",
        "ctx-blocks/posts",
        "ctx-blocks/progress",
        "ctx-blocks/section",
        "ctx-blocks/description-list",
        "ctx-blocks/description-item",
        "ctx-blocks/accordion-collection",
        "ctx-blocks/accordion-item",
        "core/file",
        "core/more",
        "core/list",
        "core/table",
        "core/shortcode",
        "core/spacer",
        "core/pullquote",
        "core/quote",
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
        "ctx-blocks/nav",
        "ctx-blocks/button",
        "ctx-blocks/modal",
        "ctx-blocks/posts",
        "ctx-blocks/progress",
        "ctx-blocks/section",
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
        "core/quote",
        "core/cover",
        "core/code",
    ]
];
