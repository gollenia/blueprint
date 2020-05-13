<?php

namespace Contexis\Wordpress;

/**
 * Load Widgets from Array and add them to Wordpress
 * 
 * @since 1.0.0
 */
Class Widgets {

    public static function register($widgets) {
      if ($widgets === null) { return ; }
        
      add_action('widgets_init', function() use (&$widgets){
        foreach ($widgets as $area) {
                  register_sidebar($area);	
              }	
      });
    }
    
}