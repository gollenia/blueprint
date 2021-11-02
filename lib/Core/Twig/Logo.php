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
Class Logo {

    public $twig_function_name = "logo";

    public static function init($twig) {
        
        $twig->addFunction( new \Twig\TwigFunction( 'logo', [__CLASS__,'get'] ) );
        return $twig;
    }

    public static function get() {

        $custom_logo_id = get_theme_mod( 'custom_logo' );

        if(!$custom_logo_id) {
            return false;
        }
        
        $arr = get_attached_file($custom_logo_id);
        return $arr;
    } 

}




