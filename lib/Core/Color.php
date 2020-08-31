<?php
/**
 * Additional twig-functions for working with colors. Utilizes OzdemirBuraks Color-Tools
 * 
 * @since 1.0.0
 * @link https://github.com/ozdemirburak/iris
 */

namespace Contexis\Core;
use OzdemirBurak\Iris\Color\Hex;

class Color {
    public static function add_twig_filter($twig)
    {
        $twig->addFilter( new \Timber\Twig_Filter( 'darken', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->darken($percent);
        } ) );
        $twig->addFilter( new \Timber\Twig_Filter( 'lighten', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->lighten($percent);
        } ) );
        $twig->addFilter( new \Timber\Twig_Filter( 'tint', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->tint($percent);
        } ) );
        $twig->addFilter( new \Timber\Twig_Filter( 'shade', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->shade($percent);
        } ) );
        $twig->addFunction( new \Timber\Twig_Function( 'isLight', function( $color ) {
            $hex = new Hex($color);
            return $hex->isLight();
        } ) );
        $twig->addFunction( new \Timber\Twig_Function( 'isDark', function( $color ) {
            $hex = new Hex($color);
            return $hex->isDark();
        } ) );

        return $twig;
    }
}