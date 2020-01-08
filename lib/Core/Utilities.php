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
     * @param $value Which content should be fetched?
     * 
     * @return mixed whatever is stored in the key
     * 
     */
    public static function debug($value = "nothing to debug") {
        echo "<script>console.log(" . json_encode($value) . ");</script>";
    }

}