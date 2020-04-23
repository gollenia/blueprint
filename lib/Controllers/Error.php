<?php

namespace Contexis\Controllers;

/**
 * Error-Controller
 * 
 * Wird geladen, wenn zB ein 404 Fehler auftaucht.
 * 
 * @since 1.0.0
 */

class Error extends \Contexis\Core\Controller{


    public function __construct($site, $template = "pages/405.twig") { 
        parent::__construct($site);
        $this->setTemplate('pages/404.twig');
    }

}