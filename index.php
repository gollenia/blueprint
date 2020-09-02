<?php

/**
 * Normalerweise werden Controller in Wordpress mit einzelnen PHP-Dateien im Root-Verzeichnis ermittelt.
 * Diese werden hier funktional gesteuert. Die einzelnen Controller sammeln dann die Informationen (News,
 * Events, etc.), die für den Aufbaiu der Seite benötigt werden.
 */

// either set choose config files manually or scan whole directory
// $config_array = ["site", "theme_support", "fields", "mimes", "assets", "routes", "widgets"];

$config = new \Contexis\Core\Config(get_template_directory() . "/config/");

// the site-object stores information about the whole site. It is later passed to twig.
$site = new Contexis\Core\Site($config);

$route = new \Contexis\Core\Router($config->get('routes'));

$controller = 'Contexis\\Controllers\\' . $route->get();

if (class_exists($controller)) {
    $pageObject = new $controller($site);
    $pageObject->render();
}
else {
    echo "No Controller found";
}
