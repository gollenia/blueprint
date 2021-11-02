<?php
/**
 * Class to generate a custom post type for colors
 * 
 * @since 1.5.0
 */

namespace Contexis\Core\Color;

class Helper {

    /*
    *   Set of standard colors that can be set if not options exist
    *
    */
    static $color_array = [
        'primary' => '#2196f3', 
        'secondary' => '#607d8b', 
        'error' => "#f44336 ", 
        'warning' => "#ff9800", 
        'success' => "#8bc34a",
        'black' => "#000000",
        'white' => "#ffffff",
        'gray' => "#999999"
    ];

    public static function get_brightness($hex) { 
        if(!preg_match('/#(?:[0-9a-fA-F]{6})/', $hex)) {
            return false;
        }
        $hex = str_replace('#', '', $hex); 
        $c_r = hexdec(substr($hex, 0, 2)); 
        $c_g = hexdec(substr($hex, 2, 2)); 
        $c_b = hexdec(substr($hex, 4, 2)); 
        
        return intval((($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000);
    }

    
	
}