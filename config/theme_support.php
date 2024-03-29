<?php

/** 
 * Add theme-support here. The can be registered with \Contexis\Wordpress\ThemeSupport:register()
 * For further Info on options and Arguments see:
 * 
 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
 * 
 * @return array Taxonomies
 */

return [
	"menus" => [],
	"post-thumbnails" => [],
	"title-tag" => [],
	'wp-block-styles' => [],
	'responsive-embeds' => [],
	"custom-fields",
	'editor-styles' => [],
	'custom-background' => [],
	"automatic-feed-links" => [],
	"custom-logo" => [],
	"html5" => ['comment-form', 'comment-list', 'gallery', 'caption'],
	"post-formats" => ['aside', 'image', 'video', 'quote', 'link', 'gallery', 'audio']
];
