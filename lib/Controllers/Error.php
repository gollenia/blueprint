<?php
/**
 * Error-Controller
 * 
 * Simple rendering function for a twig-powered 404 page.
 * 
 * @since 1.0.0
 */

namespace Contexis\Controllers;

class Error extends \Contexis\Core\Controller{

    public function __construct($site, $template = "pages/405.twig") { 
        parent::__construct($site);
        $this->setTemplate('pages/404.twig');
    }

}