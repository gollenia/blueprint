<?php

namespace Contexis\Core\Twig;

use Timber\{
    Term,
    Timber
};

/**
 * Generates an Array with parent Pages
 * 
 * @since 1.0.0
 */
Class Breadcrumbs {

    public $twig_function_name = "breadcrumbs";

    public static function init($twig) {
        
        $twig->addFunction( new \Twig\TwigFunction( 'breadcrumbs', [__CLASS__,'get'] ) );
        return $twig;
    }

    public static function get() {
        return \Contexis\Wordpress\Breadcrumbs::generate();
    } 

}

