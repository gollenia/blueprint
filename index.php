<?php

/**
 * Normalerweise werden Controller in Wordpress mit einzelnen PHP-Dateien im Root-Verzeichnis ermittelt.
 * Diese werden hier funktional gesteuert. Die einzelnen Controller sammeln dann die Informationen (News,
 * Events, etc.), die für den Aufbaiu der Seite benötigt werden.
 */


$route = new \Contexis\Core\Router($config->get('router'));

$controller = 'Contexis\\Controllers\\' . $route->get();

if (class_exists($controller)) {
    $pageObject = new $controller($site);
    $pageObject->render();
}
else {
    echo "No Controller found.";
}


