<?php

/**
 * Hier wird der Autoloader von Composer geladen. Composer ist ein PHP-Paketmanager,
 * mit dem Abhängigkeiten installiert, aktualisiert und zur Laufzeit je nach Nutzung
 * eingehängt werden können. Weitere Informationen:
 * 
 * @link https://getcomposer.org/
 */
require_once( __DIR__ . '/vendor/autoload.php' );



$config = new \Contexis\Core\Config(get_template_directory() . "/config/");

$site = new Contexis\Core\Site($config);



// $template = '
// 	<a href={{hello}}>{{hello}}</a>
// ';

//  echo \Timber\Timber::compile_string($template, array("hello" => "Hallo"));



