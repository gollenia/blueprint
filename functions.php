<?php



/**
 * First we need to load the Composer Autoload which is responsinble for making Classes available
 * 
 * @link https://getcomposer.org/
 */

require_once( __DIR__ . '/vendor/autoload.php' );

$config = new \Contexis\Core\Config(get_template_directory() . "/config/");

// the site-object stores information about the whole site. It is later passed to twig.
$site = new Contexis\Core\Site($config);
