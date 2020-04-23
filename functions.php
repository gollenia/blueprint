<?php

/**
 * First we need to load the Composer Autoload which is responsinble for making Classes available
 * 
 * @link https://getcomposer.org/
 */
require_once( __DIR__ . '/vendor/autoload.php' );

// either set choose config files manually or scan whole directory
// $config_array = ["site", "theme_support", "fields", "mimes", "assets", "routes", "widgets"];

$config = new \Contexis\Core\Config(
    get_template_directory() . "/config/", 
    /* $config_array */ false
);

// the site-object stores information about the whole site. It is later passed to twig.

$site = new Contexis\Core\Site($config);



add_action("emp_forms_output_field", "print_field");

function print_field($field) {
    if ($field=="") {return;}
    $html = new \Wa72\HtmlPageDom\HtmlPageCrawler($field);
    $input = $html->filter('input');
    $label = $html->filter('label');
    $select = $html->filter('select');
    $textarea = $html->filter('textarea');

    if($html->filter('select')->count()) {
        $select->addClass("uk-select");
    }

    if($html->filter('textarea')->count()) {
        $select->addClass("uk-textarea");
    }
    
    if($html->filter('input')->count()) {
        switch ($input->getAttribute('type')) {
            case "text":
                $input->addClass("uk-input");
                break;
            default: 
                break;
        }
    }

    echo $html->saveHTML();
    
}