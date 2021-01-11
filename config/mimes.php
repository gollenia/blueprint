<?php

/** 
 * Add MEME-Types here, which are allowed to be uploaded. Be carefull with these types,
 * as some file-types may be critical.
 * For a list of all possible MIME-TYpes see:
 * 
 * @link https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types
 * 
 * @return array MIME-Types
*/

return [
    "add" => [
        'webm' => 'video/webm',
        'svg' => 'image/svg+xml',
        'pdf' => 'application/pdf'
    ],
    "remove" => [
        "doc",
        "docx",
        "xlsx",
        "xlsm",
        "odt",
        "pages",
        "numbers",
        "key",
        "exe",
        "docm",
        "xla|xls|xlt|xlw",
        "pot|pps|ppt",
        "js",
        "html",
        "tiff|tif",
        "swf"
    ]
    ];