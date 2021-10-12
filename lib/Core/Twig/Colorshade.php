<?php 

namespace Contexis\Core\Twig;

use Timber\{
    Term,
    Timber
};

use OzdemirBurak\Iris\Color\Hex;

/**
 * Generates an Array with parent Pages
 * 
 * @since 1.0.0
 */
Class Colorshade {

    public $twig_function_name = "breadcrumbs";

    public static function init($twig) {
        
        $twig->addFilter( new \Twig\TwigFilter( 'darkenColor', function( $color, $percent ) {
            if(!$color) {return;}
            $hex = new Hex($color);
            return $hex->darken($percent);
        } ) );
        $twig->addFilter( new \Twig\TwigFilter( 'lightenColor', function( $color, $percent ) {
            if(!$color) {return;}
            $hex = new Hex($color);
            return $hex->lighten($percent);
        } ) );
        $twig->addFilter( new \Twig\TwigFilter( 'tintColor', function( $color, $percent ) {
            if(!$color) {return;}
            $hex = new Hex($color);
            return $hex->tint($percent);
        } ) );
        $twig->addFilter( new \Twig\TwigFilter( 'shadeColor', function( $color, $percent ) {
            if(!$color) {return;}
            $hex = new Hex($color);
            return $hex->shade($percent);
        } ) );
        return $twig;
    }

}

