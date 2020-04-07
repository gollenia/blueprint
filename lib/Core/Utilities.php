<?php
namespace Contexis\Core;

/**
 * Utility Class with various static functions
 * 
 * @since 1.0.0
 */

class Utilities {

    /**
     *  Cast any variable into the Browser Javascript Console. Better way to analyze arrays than var_dump.
     * 
     * @since 1.0.0
     * 
     * @param $value array or variable to log
     * 
     */
    public static function debug($value = "nothing to debug") {
        if(!\wp_is_json_request()) {
            echo "<script>console.log(" . json_encode($value) . ");</script>";
        } 
    }

    public static function render($context) {
        var_dump($context);
        echo "Hihi";
    }
}