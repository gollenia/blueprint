<?php

namespace Contexis\Wordpress;

/**
 * Load Taxonomies from Array and add them to Wordpress
 * 
 * @since 1.0.0
 */
Class Taxonomy {

    public static function register($taxonomies) {

      if($taxonomies === null) { return; }
        
		add_action('init', function() use (&$taxonomies){
			foreach ($taxonomies as $taxonomy => $options) {
                register_taxonomy($taxonomy, $options['object_type'], $options['options']);	
            }	
		});
    }
    
}