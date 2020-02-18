<?php

/**
 * Normalerweise werden Controller in Wordpress mit einzelnen PHP-Dateien im Root-Verzeichnis ermittelt.
 * Diese werden hier funktional gesteuert. Die einzelnen Controller sammeln dann die Informationen (News,
 * Events, etc.), die für den Aufbaiu der Seite benötigt werden.
 */


$router = new \Contexis\Core\Router();

$controller = 'Contexis\Controllers\\' . $router->get();

if (class_exists($controller)) {
    $page = new $controller($site);
    $page->render();
}
else {
    echo "Es konnte kein Controller geladen werden.";
}


