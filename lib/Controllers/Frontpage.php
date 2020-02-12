<?php
namespace Contexis\Controllers;

use \Timber\URLHelper;
use \Timber\Helper;
use \Timber\User;

/**
 * Der Seiten-Controller erstellt einen PHP-Array (Context), in dem alle für den Aufbau der Seite benötigten
 * Informationen gespeichert werden. 
 * 
 * @since 1.0.0
 */

class Frontpage extends Page {

    
    public function __construct($site, $template = false) {
        
        parent::__construct($site);
        $this->context["welcome"] = "Herzlich Willkommen!!! Diesen Text findes du im Frontpage-Controller";
        
    }

    protected function setTemplate() {
        return array( 'pages/frontpage.twig' );
    }

}