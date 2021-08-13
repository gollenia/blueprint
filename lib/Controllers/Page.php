<?php
/**
 * Page-Controller to render regular pages.
 * 
 * @since 1.0.0
 */

namespace Contexis\Controllers;


class Page extends \Contexis\Core\Controller{

    public string $template = "pages/page.twig";

    public function __construct() {

        parent::__construct();

    }
    
}