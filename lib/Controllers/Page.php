<?php
/**
 * Page-Controller to render regular pages.
 * 
 * @since 1.0.0
 */

namespace Contexis\Controllers;


class Page extends \Contexis\Core\Controller{

    public function __construct($site, $template = false) {

        parent::__construct($site);
        $this->addToContext([
            "breadcrumbs" => \Contexis\Wordpress\Breadcrumbs::generate(),
        ]);

    }
    
}