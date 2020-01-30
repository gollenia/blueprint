
<?php

namespace Contexis\Controllers;

use \Timber\URLHelper;
use \Timber\Helper;
use \Timber\Request;
use \Timber\User;

/**
 * Der Seiten-Controller erstellt einen PHP-Array (Context), in dem alle für den Aufbau der Seite benötigten
 * Informationen gespeichert werden. 
 * 
 * @since 1.0.0
 */

class Home extends Page {

    private $context = [];
    private $templates = [];

}