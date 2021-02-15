<?php
/**
 * Error-Controller
 * 
 * Simple rendering function for a twig-powered 404 page.
 * 
 * @since 1.0.0
 */

namespace Contexis\Controllers;

use Timber\{
    Timber,
    Post,
    PostQuery
};

class Error extends \Contexis\Core\Controller{

    public function __construct($site, $template = "pages/405.twig") { 
        parent::__construct($site);
        $this->setTemplate('pages/404.twig');
        $this->addToContext([
            "error_page" => $this->getErrorPage()
        ]);
        
    }


    private function getErrorPage($page = "error") {
        $field = get_field("error_page", "options");
        
        if($field) {
            $page = Timber::get_post($field->ID);
            return $page;
        }
        
        return false;
    }

}