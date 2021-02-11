<?php

// BETA Code. This Code will be removed, when Site is complete
// Debug-Hack. Kommt später weg
$url =  'http://' . $_SERVER['SERVER_NAME'];
$url = explode(".", parse_url($url, PHP_URL_HOST));
$url = end($url);
if (isset($_GET['dev']) ) {
    set_transient( $_SERVER['REMOTE_ADDR'], "yes", 60*60*12 );
}

if($url === "ch") {
    $url = "ch-de";
}

if(!get_transient( $_SERVER['REMOTE_ADDR']) && ( $url == "de" || $url == "at")) {
    header("Location: http://www.kids-team.com/" . $url);
    exit();
}

/**
 * First we need to load the Composer Autoload which is responsinble for making Classes available
 * 
 * @link https://getcomposer.org/
 */

require_once( __DIR__ . '/vendor/autoload.php' );

$config = new \Contexis\Core\Config(get_template_directory() . "/config/");

// the site-object stores information about the whole site. It is later passed to twig.
$site = new Contexis\Core\Site($config);
