<?php
namespace Contexis\Core;

/**
 * Utility Class with various static functions
 * 
 * @since 1.0.0
 */

class Utilities {

    /**
     *  Print any variable into the Browser's Javascript Console. Better way to analyze arrays than var_dump.
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

    /**
     *  Print any variable into the log directory
     * 
     * @since 1.0.0
     * 
     * @param array $value or variable to log
     * 
     */
    public static function debug_to_log($value = "nothing to debug") {

        file_put_contents(ABSPATH . "../log/debug.log", json_encode($value), FILE_APPEND);

    }

    public static function array_get(array $array, string $key, $default = false) {

          if (isset($array[$key])) return $array[$key];
  
          foreach (explode('.', $key) as $segment)
          {
              if ( ! is_array($array) || ! array_key_exists($segment, $array))
              {
                  return $default;
              }
 
              $array = $array[$segment];
          }
  
          return $array;
      }
    
}