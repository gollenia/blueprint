<?php
// Abhängigkeiten werden mittls PSR-4 Autoload geladen
require_once( __DIR__ . '/vendor/autoload.php' );

// Timber ist ine Twig-Implementierung für Wordpress
// Aber brauchen wir hier das Timber.Objekt überhaupt?
$timber = new Timber\Timber();

$options = new Contexis\Core\Options;

// Das Site-Objekt enthält alle Daten, die später an Twig übergeben werden
$site = new Contexis\Core\Site;
