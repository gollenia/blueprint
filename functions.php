<?php
// Abhängigkeiten werden mittls PSR-4 Autoload geladen
        require_once( __DIR__ . '/vendor/autoload.php' );
        
        // Timber ist ine Twig-Implementierung für Wordpress
        $timber = new Timber\Timber();
        
        // Theme-Support und viele weitere Dinge können über die Config-Files erledigt werden
        // Siehe config-Verzeichnis
        $options = new Contexis\Core\Options;
        
        // Das Site-Objekt enthält alle Daten, die später an Twig übergeben werden
        $site = new Contexis\Core\Site;