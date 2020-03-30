<?php

/**
 * Hier wird der Autoloader von Composer geladen. Composer ist ein PHP-Paketmanager,
 * mit dem Abhängigkeiten installiert, aktualisiert und zur Laufzeit je nach Nutzung
 * eingehängt werden können. Weitere Informationen:
 * 
 * @link https://getcomposer.org/
 */
require_once( __DIR__ . '/vendor/autoload.php' );

define('EM_GUTENBERG', true);


function kb_svg ( $svg_mime ){
	$svg_mime['svg'] = 'image/svg+xml';
	return $svg_mime;
}

add_filter( 'upload_mimes', 'kb_svg' );
/**
 * Das Site-Objekt sucht alle Daten zusammen, die für den generellen Betrieb der
 * Seite wichtig sind. Hier werden Wordpress-Funktionen, Filter und Hooks eingebunden
 * und die Konfigurationsdatei geladen. Das Site-Objekt wird später an das Page-Objekt
 * weitergegeben (siehe index.php)
 */ 
$site = new Contexis\Core\Site;
$fields = new \Contexis\Core\Fields;


