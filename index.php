<?php

/**
 * Normalerweise werden Controller in Wordpress mit einzelnen PHP-Dateien im Root-Verzeichnis ermittelt.
 * Diese werden hier funktional gesteuert. Die einzelnen Controller sammeln dann die Informationen (News,
 * Events, etc.), die für den Aufbaiu der Seite benötigt werden.
 */

if(is_front_page()) {
    $page = new Contexis\Controllers\Frontpage($site);
}

if(is_404()) {
    return 'pages/404.twig';
}

else {
    $page = new Contexis\Controllers\Page($site);
}
        
/**
 * Zum Schluss wird die Seite gerendert.
 */
$page->render();
   
        
