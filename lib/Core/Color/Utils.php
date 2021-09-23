<?php
/**
 * Class to generate a custom post type for colors
 * 
 * @since 1.5.0
 */

namespace Contexis\Core\Color;

class Utils {

    public static $color_array = [
        'primary' => '#3066BE', 
        'secondary' => '#BFD7FF', 
        'error' => "F72C25", 
        'warning' => "#F2AF29", 
        'success' => "#1EFFBC",
        'black' => "#000000",
        'white' => "#ffffff",
        'darkgray' => "333333",
        'gray' => "#999999",
        'lightgray' => "#cccccc"
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
    

    
	

