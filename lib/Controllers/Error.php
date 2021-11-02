<?php
/**
 * Error-Controller
 * 
 * Simple rendering function for a twig-powered 404 page.
 * 
 * @since 1.0.0
 */

namespace Contexis\Controllers;

use Timber\Timber;

class Error extends \Contexis\Core\Controller {

    public string $template = "pages/404.twig";

    public function __construct() { 
        parent::__construct();
        $this->add_to_context([
            "error_page" => $this->get_error_page()
        ]);
        
    }

    private function get_error_page($page = "error") {
        $field = false;
        
        if($field) {
            $page = Timber::get_post($field->ID);
            return $page;
        }
        
        return false;
    }

}