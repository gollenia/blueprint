<?php
namespace Contexis\Core;

/**
 * Advanced Custom Fields
 * 
 * @link https://www.advancedcustomfields.com/resources/register-fields-via-php/
 * 
 * @since 1.0.0
 */

Class Fields {

    public static function register($options) {
      
      if ($options === null) { return; }
      if ($options['fields'] !== null) { self::registerFields($options['fields']); }   
      if ($options['pages'] !== null) { self::registerPages($options['pages']); }   
		
    }

    private static function registerFields($fields) {
      add_action('acf/init', function() use (&$fields){
        foreach ($fields as $field) {
                  acf_add_local_field_group($field);	
              }	
      });
    }

    private static function registerPages($pages) {
      add_action('acf/init', function() use (&$pages){
        foreach ($pages as $page) {
          acf_add_options_page($page);	
              }	
      });
    }
    
}