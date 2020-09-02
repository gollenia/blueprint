<?php
/**
 * Controller for the front-page. Could be obsolete, if template name was given to Page-Controller
 * 
 * @since 1.0.0
 */

namespace Contexis\Controllers;

class Frontpage extends \Contexis\Core\Controller {

    
    public function __construct($site, $template = false) {
        parent::__construct($site);
        $this->setTemplate('pages/frontpage.twig');
    }

}