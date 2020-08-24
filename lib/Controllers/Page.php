<?php

namespace Contexis\Controllers;

/**
 * Der Seiten-Controller erstellt einen PHP-Array (Context), in dem alle für den Aufbau der Seite benötigten
 * Informationen gespeichert werden. 
 * 
 * @since 1.0.0
 */

class Page extends \Contexis\Core\Controller{

    public function __construct($site, $template = false) {

        parent::__construct($site);
        $this->addToContext([
            "breadcrumbs" => \Contexis\Wordpress\Breadcrumbs::generate(),
        ]);

    }
    
}