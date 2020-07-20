<?php

namespace Contexis\Controllers;

/**
 * Der Seiten-Controller erstellt einen PHP-Array (Context), in dem alle für den Aufbau der Seite benötigten
 * Informationen gespeichert werden. 
 * 
 * @since 1.0.0
 */

class Categories extends \Contexis\Core\Controller{

    public function __construct($site, $template = false) {

        parent::__construct($site);
        $this->addToContext([
            'posts' => new \Timber\PostQuery(),
            'category' => single_cat_title('', false)
        ]);
        
        $this->setTemplate('pages/categories.twig');
        
    }
    
}