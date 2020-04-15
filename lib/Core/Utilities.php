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
     * @param array $value or variable to log
     * @param bool $in_header put output into header to prevent multiple header-difinitions 
     * 
     */
    public static function debug($value = "nothing to debug", $in_header = true) {

        if( WP_DEBUG !== true || wp_is_json_request() ) { 
            return; 
        }

        if (!$in_header) {
            echo "<script>console.log(" . json_encode($value) . ");</script>";
            return;
        }

        add_action ('wp_head', function() use (&$value) {
            echo "<script>console.log(" . json_encode($value) . ");</script>";
        });

        add_action ('admin_head', function() use (&$value) {
            echo "<script>console.log(" . json_encode($value) . ");</script>";
        });

    }
    

    public static function render($context) {
        var_dump($context);
        echo "Hihi";
    }
}