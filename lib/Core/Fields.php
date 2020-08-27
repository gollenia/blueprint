<?php
namespace Contexis\Core;

/**
 * This Class adds custom fields via Advanced Custom Fields Plugin
 * 
 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
 * 
 * @since 1.0.0
 */

Class Fields {

    /**
     * Register an array of fields
     * 
     * @param array $options Array with ACF Fields and Pages
     * @since 1.0.0
     */
    public static function register($options) {
      
      if ($options === null) { return; }
      if ($options['fields'] !== null) { self::registerFields($options['fields']); }   
      if ($options['pages'] !== null) { self::registerPages($options['pages']); }   
		
    }

    /**
     * Callback function to register fields
     * 
     * @param array $options Array with ACF Fields
     * @since 1.0.0
     */
    private static function registerFields($fields) {
      if (!function_exists ( "acf_add_local_field_group" )) {
        return;
      }
      add_action('acf/init', function() use (&$fields){
        foreach ($fields as $field) {
                  acf_add_local_field_group($field);	
              }	
      });
    }

    /**
     * Callback function to register pages
     * 
     * @param array $options Array with ACF Pages
     * @since 1.0.0
     */
    private static function registerPages($pages) {
      if (!function_exists ( "acf_add_options_page" )) {
          return;
      }
      add_action('acf/init', function() use (&$pages){
        foreach ($pages as $page) {
          acf_add_options_page($page);	
              }	
      });
    }
    
}