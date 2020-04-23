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

class Frontpage extends \Contexis\Core\Controller {

    
    public function __construct($site, $template = false) {
        parent::__construct($site);
        $this->setTemplate('pages/frontpage.twig');
    }

}