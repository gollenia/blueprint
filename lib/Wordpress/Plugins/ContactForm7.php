<?php

namespace Contexis\Wordpress\Plugins;

/**
 * Add custom Shortcode attribute supporting default values for Contactform7
 * 
 * @param array $post_types 
 * @since 1.0.0
 * @link https://contactform7.com/getting-default-values-from-shortcode-attributes/
 */
Class ContactForm7 {

    public static function addCustiomAttribute($attribute) {

        add_filter( 'shortcode_atts_wpcf7', function($out, $pairs, $atts) use (&$attribute) {
	
            if ( isset( $atts[$attribute] ) ) {
                $out[$attribute] = $atts[$attribute];
            }
            
            return $out;
            
        }, 10, 3 );
		
    }
    
}